<?php
session_start(); 
unset($_SESSION['filename']);
unset($_SESSION['fileId']);
unset($_SESSION['pageinfo']);
unset($_SESSION['direction']);
unset($_SESSION['pages_count']);
unset($_SESSION['cur_page']);

/* 
 * For Uploaded PDf files
 * 
 * To get all data about PDF from PY
 */

//to test Object model exercise
include_once'../model/Exercise.php'; 
//$Page_ID, $Page_name; $Ex_ID; $Question; $Solution; $Explanation; $Changed = 'no'; $Images = array(); $Page;
include_once'../model/Page.php';    
//$Page_ID , $Page_name, $page_nr, $exercisesListObj = array();

/**
 * Connect to db
 */
include_once '../config/theasisDB.php';
$db = new theasisDB();

/**
 * Get POST varibles
 */
$fileName = $_POST['fName'];
$fileId = $_POST['fileId'];
$exSep = $_POST['exSep'];

/**
 * Get all data of PY
 */
 //set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);

$path = "../uploads/".$fileName;
//$command = "i.py $path";
$command = "itest.py $path $fileName";

$pid = popen($command,"r");

$big_string = '';

while( !feof( $pid ) )
    {
        $big_string .= fread($pid, 256);
        flush();
        ob_flush();
        usleep(100000);
    }
pclose($pid);

echo $big_string;

$bstring = $big_string;
$prePage_nr = ''; //ex PrePageID
$page = 0;
$page_nr = 0;

//To test Exercise object
$ExObjArray = array();
$PageObjArray = array();
$curPageObj;
$preExeID = -1;


//count how meny times **NEWPAGE** appears
$pages_count = substr_count($bstring, '**NEWPAGE**');

$allPagesObject = array();

for($i=0;$i<=$pages_count;$i++){
    //cut page
    $cut_page_string = strchr($bstring,'**NEWPAGE**',true);
    
    //the leght of cutted string
    $len = strlen($cut_page_string);
    
    if($len > 3){
        //find all exercises
        $allExercisesFromPage = getAllExercises($i, $cut_page_string);
    }
       
}

function getAllExercises($pageNr, $cut_page_string){
    $allExercises = array();
    
    //How many objects are in page
    $block_count = substr_count($cut_page_string, '**OBJECT**');
    

    
    //Iterate through all objects
    for($b=0; $b<=$block_count; $b++){
        //cut object
        $object = strchr($cut_page_string,'**OBJECT**',true);
        
        
        //the leght of cutted string
        $len = strlen($object);
        //cut off the tacken string and page seperator
        $cut_page_string = substr($cut_page_string, $len+10); //11 = **OBJECT**
    }
    
}



if(true){
    /**
     * Other pages
     */
    if($i <> $pages_count){
        //cut page
        $part = strchr($bstring,'**NEWPAGE**',true);
        
        //the leght of cutted string
        $len = strlen($part);
        
        //Add page if its not empty
        $len > 3 ? $this->get_page_info($part, $i): false;
        
        if($prePage_nr != '' && ($page_nr != $prePage_nr)){
            
        }
        elseif ($PrePageID == '') {
            //Create first page
            $curPageObj = new Page(null, '', $i, array());
            array_push($PageObjArray, $curPageObj);
        }
    }
    /**
     * Last page
     */
    else{
         
    }
}

function get_page_info($page, $pageNr){
    //Count blocks in page
    $block_count = substr_count($page, '**OBJECT**');
    
    for($b=0; $b<=$block_count; $b++){
        //block can be
        //question
        //image
        
        //cut object
        $object = strchr($page,'**OBJECT**',true);
        //the leght of cutted string
        $len = strlen($object);
    }
}