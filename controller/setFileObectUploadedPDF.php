<?php

/**
 * For Uploaded File
 */

//to test Object model exercise
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

?>
<link rel="stylesheet" href="css/fileedit.css" type="text/css"> 
<?php
class setFileObectUploadedPDF { 
 
    private $big_string;
    private $exSep;
    private $PdfObject;
    private $ex;
    private $pg;
    
    
    function __construct($big_string) {
    $this->big_string = $big_string;
    $this->exSep = $_SESSION['exSeperator'];
    $this->PdfObject = array();
    $this->ex = null;
    $this->pg = null;
    }
    
    function display() {  
        $objectPagesAll = $this->get_pages_info(); 
        return $objectPagesAll;
    }

    function get_pages_info(){
       
        $bstring = $this->big_string;
        
        //count how meny times **NEWPAGE** appears
        $pages_count = substr_count($bstring, '**NEWPAGE**');
  
        //array that stores content of all page        
//        $pages_array = $this->found_data($pages_count, $bstring);
        $this->found_data($pages_count, $bstring);
        
        //If exerice seperator variabe wasn't set then don't try to separate exercises
        if(strlen($this->exSep)!=0 && $this->exSep != ' '){
       
            //require_once('separateExerciseController.php');
            //$var = seperateExercises($this->PdfObject, $this->exSep);
//            $pages_array = $var;
        }
        return $this->PdfObject;
    }
    
    
    function found_data($pages_count, $bstring){
//        $pages_array = array();
        $allPagesObject = array();
        for($i=0;$i<=$pages_count;$i++){
            
            if($i <> $pages_count){
                //cut page
                $part1 = strchr($bstring,'**NEWPAGE**',true);
                $part2= strchr($bstring,'**NEWPAGE**',true);
                //the leght of cutted string
                $len = strlen($part1);
                //put all page in array if the string is longer than 4
//                $len > 3 ? $pages_array = $this->get_page_info($part1, $i, $pages_array): false;
                
                //Object Exercise set to null
                $this->ex = null;
                //TEST Object Page and Exercise
                $len > 3 ? $allPagesObject = $this->setPageObject($part2, $i): false;
                
                //cut off the tacken string and page seperator
                $bstring = substr($bstring, $len+11); //11 = **NEWPAGE**
            }
            else{
                //lenght 
                $len = strlen($bstring);
//                $len > 3 ? $pages_array = $this->get_page_info($bstring, $i, $pages_array): false;
                
                //TEST Object Page and Exercise
                $len > 3 ? $allPagesObject = $this->setPageObject($bstring, $i): false;
            }
        }
    }

    function setPageObject($page, $page_nr){
        $block_count = substr_count($page, '**OBJECT**');
        
        //Create New Page
        $this->pg = new Page($page_nr, '', $page_nr, array());
        
        for($k=0; $k<=$block_count; $k++){
            
            if($k != $block_count){
                //cut object
                $object = strchr($page,'**OBJECT**',true);
                
                //the leght of cutted string
                $len = strlen($object);
                
                 //if object is not empty
                if (($len > 3) && (substr_count($object, '<img src=')) == 0){
                    //Store Pre exercise
                    $this->storeExercise();

                    $this->ex = new Exercise(null, '', $k, $object, '', '', 'no', 'no', array(), $page_nr);
//                    //Exercise($Page_ID, $Page_name, $Ex_ID, $Question, $Solution, $Explanation, $Changed, $Combined, $Images, $Page)
                }
                
                //If object is image give diferent id
                else if((substr_count($object, '<img src='))>0){                   
                    $this->storeImg($object);
                }
            
                //cut off the tacken string and page seperator
                $page = substr($page, $len+10); //11 = **OBJECT**
            }
            else {
                //the leght of cutted string
                $len = strlen($page);
                if($len > 3){
                    //Store PRE exercise
                    $this->storeExercise();
                    //New Ex
                    $this->ex = new Exercise(null, '', $k, $page, '', '', 'no', 'no', array(), $page_nr);
                    //Add exercise to the page
                    $this->storeExercise();
                }
            }
        }
        $this->storePage();
    }
    
    public function storeExercise(){
        if(isset($this->ex)){
            $this->pg->addExerciseToList($this->ex);
            
            //Object Exercise set to null
            $this->ex = null;
        }
    }    
    
    public function storeImg($img){
        if(isset($this->ex)){
            $this->ex->addImage($img);
        }
    }
    
    public function storePage(){
        array_push($this->PdfObject,$this->pg);
    }
} 

