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
$pages = count($pdf_arrey, 0);

//print_r($pdf_arrey);
echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';



for($p=0;$p<$pages;$p++){ //Page $p
    
    $exeCountInPage = count($pdf_arrey[$p]);
    for($object=0;$object<$exeCountInPage;$object++){
//        echo $pdf_arrey[$p][$object];
//        $cutObject = preg_split("/^<a(.*?)>(.*?)<\/a>/", $pdf_arrey[$p][$object]);
        
//        preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $cutObject);
//        preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>(.*)/", $input_line, $output_array);
        

        //Array tp store all exercises details
        // [0] - question
        // [1] - answer
        // [3] - explanation
        // [4..] - images
        $exercise = array();
        
        $output = NULL;
        preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>/", $pdf_arrey[$p][$object], $output);
        if($output != NULL){
            echo '<br/> YES';
            preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
            array_push($exercise, $QA[3], $QA[5]);
            
            print_r($exercise);
            //check images
        }
        else{
            echo '<br/> NO';
            preg_match("/^\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
//            array_push($exercise, $QA[3], $QA[5]);
            
            print_r($QA);
            //check images
        }
    }
}

function getExerciseDetails(){
    
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