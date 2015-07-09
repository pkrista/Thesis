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

//print_r($pdf_arrey);
echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';

//First store all pages in page entity
//Second store exercises

for($p=0;$p<$pages;$p++){ //Page $p
    echo ' Pages count = '.$pages;
    echo ' NR current = '.$p;
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
 
    //Count how many exercises is in current page
    $exeCountInPage = count($pdf_arrey[$p]);
    
    $ExeNumberOnPage = 1;
    
    for($object=0;$object<$exeCountInPage;$object++){
    //First I select all information about current exercise
    //Next I insert current exercisee
    //Then current exercises images if they exist

        //Array to store all exercises details
        //[0] - PageID
        //[1] - PaperFieldId
        //[2] - number
        //[3] - question
        //[4] - solution
        //[5] - explanation
        //[6..] - images
        $exercise = array();
        
        $output = NULL;
        preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>/", $pdf_arrey[$p][$object], $output);
        if($output != NULL){
            echo '<br/> YES';
            preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
            array_push($exercise, $lastPageID, $p.$ExeNumberOnPage, $ExeNumberOnPage, $QA[3], $QA[5],'');
            
            
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
                //check images
            }

        }
        
        //Generate query for exercise
        $queryInsertExercise = generateQueryExercise($exercise);
        
        //Insert in db exercise
        if ($db->query($queryInsertExercise)) {
            $lastExeID = $db->lastInsertId(); //Last insert id -> Id for current page
            echo "New Exercise created successfully ".$lastExeID;  
            
            //Generate query for images if they are
            $countObjectsInExercise = count($exercise);
            if($countObjectsInExercise > 6){
                //Insert images
                insertImage($exercise, $lastExeID);
            }
            //Insert images
            
        } else {
            echo "Error while uploading Exercise";
        }

        
        //Make exercise variable +1
        $ExeNumberOnPage++;
    }
}

/*
 * Generates insert query for Exercise
 */
function generateQueryExercise($exercise){
//    INSERT INTO `exercise`(`Exercise_ID`, `PaperFieldID`, `Number`, `Question`, `Solution`, `Explanation`, `Page_ID`) 
//VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
    
    $query = "INSERT INTO exercise(Page_ID,PaperFieldID,Number,Question,Solution,Explanation)"
            . "VALUES(".$exercise[0].",".$exercise[1].",'".$exercise[2]."','".$exercise[3]."','".$exercise[4]."','')";
    
    return $query;
}

function insertImage($exercise, $exercise_ID){
    //INSERT INTO `image`(`Image_ID`, `src`, `Exercise_ID`) VALUES ([value-1],[value-2],[value-3])
    $query = "INSERT INTO image(src, Exercise_ID) VALUES('',$exercise_ID)";
}

function insertInDB(){
    if ($db->query($sqlInsertPage)) {
        $lastPageID = $db->lastInsertId(); //Last insert id -> Id for current page
        echo "New Page created successfully ".$lastPageID;    
    } else {
        echo "Error while uploading Page = ".$pageInfo[0];
    }
}
    


/**
 * 
 * OLD
 * 
 */
function generateQuery($page_nr, $object){
    
//    print $object;
//    print '____';
    
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