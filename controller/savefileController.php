<?php
session_start(); 
/* 
 * 
 * 
 * 
 */

include_once '../config/theasisDB.php';
$filename = $_SESSION['filename'];
$pdf_arrey = $_SESSION['pdf_array'];
$page_nr = 0;


$o = 0; //Obejct
while(!empty($pdf_arrey[$page_nr][$o])){
    print $o;
    $object = $pdf_arrey[$page_nr][$o];
    $o++;

    //Get all elements out of object
    generateQuery($page_nr, $object);
}
    
function generateQuery($page_nr, $object){
    
//    print $object;
    print '____';
    
    $answMatch = array();
    $questMatch = array();
    $imgMatch = array();
    preg_match_all('/(.*?)<div class="dddA"[^>]*>(.*?)</div>/', $object, $answMatch);
//    preg_match_all('#(.*?)<<div class="dddA"[^>]*>#', $object, $questMatch);
//    preg_match_all('#(.*?)<<div class="dddA"[^>]*>#', $object, $questMatch);
    print_r($answMatch);
//    print_r($questMatch);
    
    
    preg_match_all('#<div class="dddA" id="aid"[^>]*>(.*?)</div>#', $object, $matches);
    
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
    
    print 'TTT';
    }
    
    ###
    ### Generate inserts and insert data into database
    ###
    
    // 1 - insert into db when upload file
    //