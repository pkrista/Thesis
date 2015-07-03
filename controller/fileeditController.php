<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//    function func1($param1, $param2)
//    {
//        echo $param1 . ', ' . $param2;
//    }
?>
<link rel="stylesheet" href="css/fileedit.css" type="text/css"> 
<?php
class fileeditController { 
 
    private $big_string;
    private $exSep;
    
    
    function __construct($big_string) {
    $this->big_string = $big_string;
    $this->exSep = $_SESSION['exSeperator'];
    
    }
    
    function display() {        
        return $this->get_pages_info();  
    }
    
    function get_pages_info(){
        $bstring = $this->big_string;
        
        //count how meny times **NEWPAGE** appears
        $pages_count = substr_count($bstring, '**NEWPAGE**');
  
        //array that stores content of all page        
        $pages_array = $this->found_data($pages_count, $bstring);
        
        return $pages_array;
    }
    
    
    function found_data($pages_count, $bstring){
        $pages_array = array();
        for($i=0;$i<=$pages_count;$i++){
            
            if($i <> $pages_count){
                //cut page
                $part = strchr($bstring,'**NEWPAGE**',true);
                //the leght of cutted string
                $len = strlen($part);
                //put all page in array if the string is longer than 4
//                $len > 3 ? $pages_array[$i] = $part: false;
                $len > 3 ? $pages_array = $this->get_page_info($part, $i, $pages_array): false;
//                if($len > 3){
//                    $pages_array = $this->get_page_info($part, $i, $pages_array);
//                }
                
                //cut off the tacken string and page seperator
                $bstring = substr($bstring, $len+11); //11 = **NEWPAGE**
            }
            else{
                //lenght 
                $len = strlen($bstring);
                $len > 3 ? $pages_array = $this->get_page_info($bstring, $i, $pages_array): false;
                
            }
        }
        
        return $pages_array;
    }
    
    function get_page_info($page, $i, $pages_array){
        $block_count = substr_count($page, '**OBJECT**');
        
//        $page_array() = array();
        $column = 0;
        for($k=0; $k<=$block_count; $k++){
            
            if($k != $block_count){
                //cut object
                $object = strchr($page,'**OBJECT**',true);
                //the leght of cutted string
                $len = strlen($object);
                
                //If object is image give diferent id
                if((substr_count($object, '<img src='))>0){
                    $pages_array[$i][$column] = $object;
//                        '<div class="dddP" id="'.$k.'" contenteditable="true">'.$object.'</div> ';
                    $column++; 
                }
                //if object is not empty
                else if ($len > 3){
                    $pages_array[$i][$column] = $object;
                    $column++; 
                }
//                else{
//                    //put all page in array if the string is longer than 4
//                    $len > 1 ? $pages_array[$i][$k] = $object : false;
////                        '<div class="dddQ" id="'.$k.'" contenteditable="true">'.$object.'</div> ': false;
//                }

                //cut off the tacken string and page seperator
                $page = substr($page, $len+10); //11 = **OBJECT**
            }
            else {
                //the leght of cutted string
                $len = strlen($page);
                if($len > 3){
                    $pages_array[$i][$column] = $page;
                }
//                if($len > 3){
//                    $pages_array[$i][$k] = $page;
//                }
//                $len > 1 ? $pages_array[$i][$k] = $page: false;
            }
        }
        return $pages_array;
    }
} 
