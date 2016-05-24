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
$pdf_arrey = $_SESSION['pdf_array'];
$pageInfoName = $_SESSION['pageinfo'];
$fileId = $_SESSION['fileId'];

$page_nr = 0;
$pages = count($pdf_arrey, 0);

print_r($pdf_arrey);
echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';

//First store all pages in page entity
//Second store exercises

for($p=0;$p<$pages;$p++){ //Page $p
    //First I will insert current page
    
    //select Page Name if it is set
   if(isset($_SESSION['pageinfo'][$p])){
        $curPageName=($_SESSION['pageinfo'][$p]);
    }
    else{
        $curPageName = '';
    }
   $pageInfo = array();
   // array to store information about current page
   // [0] PageName
   // [1] PagePaper
   // [2] PagePen 
   // [3] FileID 
   // [4] CourseID
   
    array_push($pageInfo, $curPageName, $p+1, $p, $fileId, 2); 
    $lastPageID;
   
    $sqlInsertPage = "INSERT INTO Page(Name, PagePaper, PagePen, File_ID, Course_ID) VALUES ('".$pageInfo[0]."' , ".$pageInfo[1]." , ".$pageInfo[2]." , ".$pageInfo[3]." , ".$pageInfo[4].")";
    if ($db->query($sqlInsertPage)) {
        $lastPageID = $db->lastInsertId(); //Last insert id -> Id for current page
        echo "New Page created successfully ".$lastPageID;    
    } else {
        echo "Error while uploading Page = ".$pageInfo[0];
    }
 
    //Count how many exercises are in current page
    $exeCountInPage = count($pdf_arrey[$p]);
    
    $ExeNumberOnPage = 1;
    
    for($object=0;$object<$exeCountInPage;$object++){
    //First I select all information about current exercise
    //Next I insert current exercisee
    //Then current exercises images if they exist
        
        $exercise = array();
        //Array to store all exercises details
        //[0] - PageID
        //[1] - PaperFieldId
        //[2] - number
        //[3] - question
        //[4] - solution
        //[5] - explanation
        //[6..] - images
        
        
        $output = NULL;
        preg_match("/^\s*(.*)<a.*id=\"delDiv\".*<div id=\"aid\".*>(.*)<\/div><a.*>.*<\/a>.*<p>(.*)<\/p>/", $pdf_arrey[$p][$object], $output);
        echo 'EXEXEX';
        echo $pdf_arrey[$p][$object];
        if($output != NULL){
//            preg_match("/^\s{0,}<a(.*)>(.*)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><a(.*)<p>(.*)</p>/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
//            preg_match("/^\s{0,}<a(.*)>(.*)<\/a>\s{0,}(.*)<div id=\\"aid\\"(.*)>\s{0,}(.*)<\/div><a(.*)<p>(.*)<\/p>/", $input_line, $output_array);
            preg_match("/^\s{0,}<a(.*)>(.*)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><a(.*)<p>(.*)<\/p>/", $pdf_arrey[$p][$object], $QA);
            preg_match("/^\s*(.*)<a.*id=\"delDiv\".*<div id=\"aid\".*>\s{0,}(.*)<\/div><a.*>.*<\/a>.*<p>(.*)<\/p>/", $pdf_arrey[$p][$object], $QA);
            echo 'Te Jaskatasss';
            print_r($QA);
            echo 'Beigas';
            
            array_push($exercise, $lastPageID, $p.$ExeNumberOnPage, $ExeNumberOnPage, $QA[1], $QA[2], $QA[3]);
            
            
            //check images and add them to exercise
            $img = NULL;
            $elem = $object; $elem++;
            preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
            
            while($img != NULL){
                $object = $elem;
                array_push($exercise, $pdf_arrey[$p][$elem]);
                $elem++;
                
                $img = NULL;
                if($elem < $exeCountInPage){
                    preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
                }
            }
           
            print_r($exercise);
        }
        else{
            $renew = substr_count($pdf_arrey[$p][$object], '**RENEW**');
            $img = substr_count($pdf_arrey[$p][$object], '<img src=');
//            $img = substr_count($pdf_arrey[$p][$object], '****');
            if($renew == 0 && $img == 0){
                echo '<br/> NO';
//              preg_match("/^\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
                array_push($exercise, $lastPageID, $p.$ExeNumberOnPage, $ExeNumberOnPage, $pdf_arrey[$p][$object], '','');
            
                //check images and add them to exercise
                $img = NULL;
                $elem = $object; $elem++;
                preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);

                while($img != NULL){
                    $object = $elem;
                    array_push($exercise, $pdf_arrey[$p][$elem]);
                    $elem++;

                    $img = NULL;
                    if($elem < $exeCountInPage){
                        preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
                    }
                }
                
                print_r($exercise);

            }

        }
        
        if(count($exercise) >0){
            //Generate query for exercise
            $queryInsertExercise = generateQueryExercise($exercise);

    //        Insert in db exercise
            if ($db->query($queryInsertExercise)) {
                $lastExeID = $db->lastInsertId(); //Last insert id -> Id for current page
                echo "New Exercise created successfully ".$lastExeID;  

                //Insert images
                $imgObject = 6; // images starts from 6th element
                while(isset($exercise[$imgObject])){
                    $imgQuery = "INSERT INTO image(src, Exercise_ID) VALUES('".$exercise[$imgObject]."',".$lastExeID.")";

                    if ($db->query($imgQuery)) {
                        echo "New Image created successfully ";    
                    } else {
                        echo "Error while uploading Image";
                    }

                    //increase object search in exercise array
                    $imgObject++;
                }

            } else {
                echo "Error while uploading Exercise";
            }
        }
        
        //Make exercise variable +1
        $ExeNumberOnPage++;
    }
}

/*
 * Generates insert query for Exercise
 */
function generateQueryExercise($exercise){
  
    $query = "INSERT INTO exercise(Page_ID,PaperFieldID,Number,Question,Solution,Explanation)"
            . "VALUES(".$exercise[0].",".$exercise[1].",'".$exercise[2]."','".$exercise[3]."','".$exercise[4]."','".$exercise[5]."')";
    
    return $query;
}
