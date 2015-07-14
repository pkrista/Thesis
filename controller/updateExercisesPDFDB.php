<?php
session_start(); 
/* 
 * 
 * 
 * 
 */

include_once '../config/theasisDB.php';
$db = new theasisDB();
    
$filename = $_SESSION['filename'];
$pdf_array = $_SESSION['pdf_array'];
$pageInfoName = $_SESSION['pageinfo'];

echo 'updating changed exercises in DB';

for($p=0;$p<(count($_SESSION['pdf_array']));$p++){ //page $p
    if(isset($pdf_array[$_SESSION['cur_page']])){
        for($e=0;$e<(count($_SESSION['pdf_array'][$p]));$e++){ //$e exercise
            //[0] Page_ID
            //[1] Page_name
            //[2] Ex_ID
            //[3] Question
            //[4] Solution
            //[5] Explanation
            //[6] Changed
            //[7] Images

            //update just those exercises that was change
            if($pdf_array[$p][$e][6]=='true'){
                echo 'changed ';
                
                //Build updating query
                
                //Update changed exercises
            }
        }
    }
}