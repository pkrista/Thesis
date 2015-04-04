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
 
class fileeditController { 
 
    private $big_string;
    
    function __construct($big_string) {
    $this->big_string = $big_string;
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

        echo 'First </br>'.$pages_array[0];
        echo '</br> Second </br>'.$pages_array[1];
        
        return $pages_array;
    }
    
    
    function found_data($pages_count, $bstring){
        $pages_array = array();
        for($i=0;$i<=$pages_count;$i++){
            
            if($i <> $pages_count){
                //cutted part
                $part = strchr($bstring,'**NEWPAGE**',true);
                //the leght of cutted string
                $len = strlen($part);
                //put all page in array if the string is longer than 4
//                $len > 4 ? $pages_array[$i] = $part: 
                if($len>4)$pages_array[$i] = $part;
                
                //cut off the tacken string and page seperator
                $bstring = substr($bstring, $len+11); //11 = **NEWPAGE**
            }
            else{
                if($len>4) $pages_array[$i] = $bstring;
            }
        }
        
        return $pages_array;
    }
} 
