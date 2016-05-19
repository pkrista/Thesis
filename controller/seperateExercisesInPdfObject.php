<?php

/**
 * This file is called if there is exercise seperator set.
 * Based on the value current objects are combined or deleated if empty
 *
 * @author krista
 */

include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

class seperateExercisesInPdfObject {
    private $defaultFileObject;
    private $exSep;
    private $PdfObject;
    private $ex;
    private $pg;
    
    private $preExercise = -1;
    
    
    function __construct($PdfObject, $exSep) {
    $this->defaultFileObject = $PdfObject;
    $this->exSep = $_SESSION['exSeperator'];
    $this->PdfObject = array();
    $this->ex = null;
    $this->pg = null;
    }
    
    function display() {  
        $objectPagesAll = $this->varifyExercisesInPage($this->defaultFileObject); 
        return $objectPagesAll;
       
    }
    
    function varifyExercisesInPage($pages_obj){
        foreach ($pages_obj as $page){
            
            $exsList = $page->getExercisesListObj();
            $page->setExercisesListObj(array());
            $this->storeExercise($this->ex);
            
            /**
             * Create a Page Object
             */
            $this->pg = $page;

            $lastElementExercise = end($exsList);
            
            foreach ($exsList as $exe) {
                //1.veriify regex
                //2. if no - 
                    // if exist pre ex - > combine text
                    // if not exists pre ex -> make new ex 
                //2. if yes
                    // cut patern and store exercise
                
                $exeText = $exe->getQuestion();
                
                /**
                 * verify regex and store exercises
                 */
                $this->seperatorRegexVerify($this->exSep, $exeText, $exe);
                
                $this->preExercise = $this->ex;
                
                /**
                 * If last element then save
                 */
                if($lastElementExercise == $exe){
                    $this->storeExercise($exe);
                }
            }
        }
    }
    
    /**
     * Gets regex or Question based on provided exercise seperator
     * 
     * @param type $exeSeparator User provided exercise seperator
     * @param type $exercise Exercise Question
     * @param type $exe Current exercise
     */
    function seperatorRegexVerify($exeSeparator, $exercise, $exe){
        $output=array();

        preg_match('/^'.$exeSeparator.'(_|.|\s{0,}|\w)\d{0,100}\s{0,}(.*)/i', $exercise, $output);
        $this->combineCrateExerciseDecision($output, $exe);
    }
    
    /**
     * Function based on what the decision of creating new exercise 
     * or exercise concatenation is made
     * 
     * @param type $output Regex output
     * @param type $exe Current exercise
     */
    function combineCrateExerciseDecision($output, $exe){
        $cutedExercise = -1;
        if(!empty($output)){
          $cutedExercise = $output[2]; 
          
            if(strlen($cutedExercise) > 0){
                //To store previous exercise
                $this->storeExercise($this->ex);

                $exe->setQuestion($cutedExercise);
                $this->ex = $exe;
            }
            else {
                //To store previous exercise
                $this->storeExercise($this->ex);
            }
        }
        else{
            if(isset($this->ex)){
                $this->concatenateExercise($exe);
            }
            else{
                $this->ex = $exe;
            }
        }
    }
    
    /**
     * Function that cincatenate previous with current exercise
     * @param type $exe Current exercise
     */
    function concatenateExercise($exe) {
        $concatenateQuestion = $this->ex->getQuestion() . '<br>' . $exe->getQuestion();
        $this->ex->setQuestion($concatenateQuestion);
        if (count($exe->getImages()) > 0) {
            foreach ($exe->getImages() as $img) {
                $this->storeImg($img);
            }
        }
    }
    
    public function storeExercise(){
        if(isset($this->ex)){
            $this->pg->addExerciseToList($this->ex);
            
            //Object Exercise set to null
            $this->ex = null;
        }
    }
    
    public function storePage(){
        array_push($this->PdfObject,$this->pg);
    }
    
    public function storeImg($img){
        if(isset($this->ex)){
            $this->ex->addImage($img);
        }
    }
}
