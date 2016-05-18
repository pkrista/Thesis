<?php

/**
 * Description of seperateExercisesInPdfObject
 *
 * @author krista
 */

//to test Object model exercise
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

class seperateExercisesInPdfObject {
    private $defaultFileObject;
    private $exSep;
    private $PdfObjectt;
    private $ex;
    private $pg;
    
    private $preExercise = -1;
    
    
    function __construct($PdfObjectt, $exSep) {
    $this->defaultFileObject = $PdfObjectt;
    $this->exSep = $_SESSION['exSeperator'];
    $this->PdfObjectt = array();
    $this->ex = null;
    $this->pg = null;
    }
    
    function display() {  
        $objectPagesAll = $this->varifyExercisesInPage($this->defaultFileObject); 
        print_r($this->defaultFileObject);
        return $objectPagesAll;
       
    }
    
    function varifyExercisesInPage($pages_obj){
        foreach ($pages_obj as $page){
            
            $exsList = $page->getExercisesListObj();
            $page->setExercisesListObj(array());
            $this->storeExercise($this->ex);
            /**
             * Create New Page Object
             */
            
            $this->pg = $page;
            
            foreach ($exsList as $exe) {
                //1.veriify regex
                //2. if no - 
                    // if exist pre ex - > combine text
                    // if not exists pre ex -> make new ex 
                //2. if yes
                    // cut patern and store exercise
                
                $exeText = $exe->getQuestion();
                
                $this->seperatorRegexVerify($this->exSep, $exeText, $exe);
                
                $this->preExercise = $this->ex;
            }
            //3. Store page
        }
    }
    
    
    function seperatorRegexVerify($exeSeparator, $exercise, $exe){
        $output=array();
        $cutedExercise = -1;
        print_r($exe);
        preg_match('/^'.$exeSeparator.'(_|.|\s{0,}|\w)\d{0,100}\s{0,}(.*)/i', $exercise, $output);
        
        if(!empty($output)){
          $cutedExercise = $output[2]; 
          
            if(strlen($cutedExercise) > 0){

              $this->storeExercise($this->ex);

              $exe->setQuestion($cutedExercise);
              $this->ex = $exe;
            }
            else {
                $this->ex = new Exercise(null, '', 0, '', '', '', 'no', 'no', array(), $this->pg->getPage_nr());
            }
        }
        else{
            if(isset($this->ex)){
                $concatenateQuestion = $this->ex->getQuestion().'<br>'.$exe->getQuestion();
                $this->ex->setQuestion($concatenateQuestion);
                if(count($exe->getImages())>0){
                    foreach ($exe->getImages() as $img) {
                        $this->storeImg($img);
                    }
                }
            }
            else{
                $this->ex = $exe;
            }

        }
        print'---------------NEW----------------';
        print $exercise;
        print_r($this->ex) ;

    }
    
    public function storeExercise(){
        if(isset($this->ex)){
            $this->pg->addExerciseToList($this->ex);
            
            //Object Exercise set to null
            $this->ex = null;
        }
    }
    
    public function storePage(){
        array_push($this->PdfObjectt,$this->pg);
    }
    
    public function storeImg($img){
        if(isset($this->ex)){
            $this->ex->addImage($img);
        }
    }
}
