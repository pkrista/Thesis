<?php

/**
 * Description of mergeExIFromPDFPYtoObjects
 *
 * @author krista
 */

//to test Object model exercise
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

class mergeExIFromPDFPYtoObjects {
    private $big_string;
    private $exSep;
    private $PdfObject;
    private $ex;
    private $pg;
    private $pages_count;
    
    function __construct($big_string) {
    $this->big_string = $big_string;
    $this->exSep = $_SESSION['exSeperator'];
    $this->PdfObject = array();
    $this->ex = null;
    $this->pg = null;
    //count how meny times **NEWPAGE** appears
    $this->pages_count = substr_count($big_string, '**NEWPAGE**');
    }
    
    function display() {   
        return $this->getPDFObject();  
    }
    
    function getPDFObject(){
        //Big string
        $bstring = $this->big_string;
        
        //Return one full page
        $this->seperatePages($bstring);
    }
    
    function seperatePages($bstring){
        
        for($i=0;$i<=$this->pages_count;$i++){
            
            // Not the last element
            if($i <> $this->pages_count){
                //cut page
                $part = strchr($bstring,'**NEWPAGE**',true);
                //the lenght of cutted string
                $len = strlen($part);
                
                $this->createPage($len, $part, $i);
                
                //cut off the artificial string "page seperator"
                $bstring = substr($bstring, $len+11); //11 = **NEWPAGE**
            }
            //Last element
            else{
                //lenght 
                $len = strlen($bstring);
                
                $this->createPage($len, $bstring, $i);
            }
        }
    }
    
    function createPage($len, $page, $pageNr){
        //Create new Page object
        $this->pg = new Page(null, '', $pageNr, array());

        //Seperate exercises
        $len > 3 ? $this->seperateExercises($page, $pageNr): false;
    }
    
    function seperateExercises($part, $pageNr){
        $block_count = substr_count($part, '**OBJECT**');
        
        //iterate through bloks
        for($k=0; $k<=$block_count; $k++){
            //cut the object
            $object = strchr($part,'**OBJECT**',true);
            //the leght of cutted string
            $len = strlen($object);
            
            //Not the last element
            if($k != $block_count){
                $this->createExercise($object);
            }
            //the last element
            else{
                
            }
        }
    }
    
    function createExercise($object){
        //Check if seperator is set
        if(strlen($this->exSep)!=0 && $this->exSep != ' '){
            
        }
        else {

        }
        
    }
    
    function storeExercise(){
        
    }
    
    function storeImage(){
        
    }
    
}
