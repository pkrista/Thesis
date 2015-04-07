<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../config/theasisDB.php';

class savefileController { 
    
    private $big_string;
    private $filename;
    private $pages_count;
    
    function __construct($big_string, $filename, $pages_count) {
        
    $this->big_string = $big_string;
    $this->filename = $filename;
    $this->pages_count = $pages_count;
    
    
    }
    
    function save_in_db(){
        $bstring = $this->big_string;
         
                 //Print page by page
        $p=0;
        $curr_page = 0;
        while(!empty($bstring[$curr_page][$p]) ){ 
            $p=0;
            while(!empty($bstring[$curr_page][$p]) ){ 
               echo '<br> <div class="ddd"> <br>'
                 . $bstring[$curr_page][$p]
                 . '<div class="dddA" contenteditable="true"> Answer div </div>'
                 . '<br> </div> <br>';
               $p++;
            }
        $p=0;
        $curr_page++;
        }
        
        
            $db = new theasisDB();
            $sql = "SELECT * FROM course";
            foreach ($db->query($sql) as $row)
                {
                echo $row["course_id"] ." - ". $row["name"] ."<br/>";
                }
                
            $sql1 = "SELECT * FROM file";
            foreach ($db->query($sql1) as $row)
                {
                echo $row["file_id"] ." - ". $row["name"] ."<br/>";
                }
    }
    
    
}