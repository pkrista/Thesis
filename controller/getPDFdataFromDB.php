<?php
session_start(); 
unset($_SESSION['filename']);
unset($_SESSION['fileId']);
unset($_SESSION['pageinfo']);
unset($_SESSION['direction']);
unset($_SESSION['pages_count']);
unset($_SESSION['cur_page']);

/* 
 * For Saved PDf files
 * 
 * To get all data about PDF from db
 */

//to test Object model exercise
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

/**
 * Connect to db
 */
include_once '../config/theasisDB.php';
$db = new theasisDB();

//$_SESSION['pdf_array'] = $pdf_array;
//Get variables from 
$fileName = $_POST['fName'];
$fileId = $_POST['fileId'];

$_SESSION['filename'] = $fileName;
$_SESSION['fileId'] = $fileId;


/**
 * Fill the page info (Name of each page)
 */
$pageInfo = array();
$query = 'select p.Name from page p, file f where p.File_ID = f.File_ID and f.File_ID = '.$fileId.'  '
        . 'ORDER BY p.Page_ID ASC';
$result = $db ->query($query);

foreach ($result as $value) {
    array_push($pageInfo, $value[0]);
}

$_SESSION['pageinfo'] = $pageInfo;
//print_r($pageInfo);

/*
 * Count pages 
 * Set current page
 * set direction at the begining
 */
$_SESSION['pages_count'] = count($pageInfo);
$_SESSION['cur_page'] = 0;
$_SESSION['direction']='next';

/*
 * Select all exercises and images from the db
 * 
 * Select All details for one exercise
 * And have one big array
 * Page (Page_ID, Page_name)
 * -ex (Ex_ID, Question, Solution, Explanation, Images)
 * 
 */
$exercise_array = array();
$page_array = array();
$PDF_array = array();
//[0] Page_ID
//[1] Page_name
//[2] Ex_ID
//[3] Question
//[4] Solution
//[5] Explanation
//[6] Changed - by default false ,if changed then true
//[7] Images

$query1 = 'select '
            . 'p.Page_ID, '
            . 'p.Name, '
            . 'e.Exercise_ID , '
            . 'e.Question, '
            . 'e.Solution, '
            . 'e.Explanation, '
        . 'IFNULL(i.src, 0) src FROM exercise e '
        . 'LEFT JOIN image i on i.Exercise_ID = e.Exercise_ID '
        . 'LEFT JOIN page p on p.Page_ID = e.PAGE_ID '
        . 'LEFT JOIN file f on p.File_ID = f.File_ID '
        . 'Where f.File_ID = '.$fileId;

$result1 = $db->query($query1);
$PrePageID = '';
$page = 0;
$page_nr = 0;

//To test exercise model
$ExercisesArray = [];

//To test Exercise object
$ExObjArray = array();
$PageObjArray = array();
$curPageObj;
$preExeID = -1;

foreach ($result1 as $value) {
    //Create images array
    
    //create Pagge and exercise object array
    if($PrePageID != '' && ($value[0] != $PrePageID)){      
        $page_array = array();
        
        //Make ++ to page
        $page++;
        
        //New Page Object
        $curPageObj = new Page($value[0], $value[1], $page, array());
        array_push($PageObjArray, $curPageObj);

    }
    elseif ($PrePageID == '') {
    //At the begining create first page
        $curPageObj = new Page($value[0], $value[1], $page, array());
        array_push($PageObjArray, $curPageObj);
    }
       
    array_push($exercise_array, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5], 'false', $value[6]);
    array_push($page_array, $exercise_array);
    $exercise_array = array();

    $PDF_array[$page] = $page_array;
       
       
    if($preExeID == $value[2]){
        //If the next ex is the same
        //This means it has multiple pictures
        
        //Add picture to exercise
        $ex->addImage($value[6]);
    }
    else{
        //create new exe
        $ex = new Exercise($value[0], $value[1], $value[2], $value[3], $value[4], $value[5], 'no', 'no' , array(), $page);
//        new Exercise($Page_ID, $Page_name, $Ex_ID, $Question, $Solution, $Explanation, $Changes, $Combined, $Images, $Page)
        //Add image, if exercise have image
        if(!empty($value[6])){
            $ex->addImage($value[6]);
        }
        
        
        //Add exercise to page
        $curPageObj->addExerciseToList($ex);
    }

    //Set pre Exeriise id
    $preExeID = $ex->getEx_ID();
       
    //Set current page nr as old one to compare in with page we are
    $PrePageID = $value[0];
}

//Set session variable (2d array)
$_SESSION['pdf_array'] = $PDF_array;

print_r($PDF_array);

echo 'get saved pdf data (getPDFdataFromDB.php)';

print_r($PageObjArray);

//Set session variable Object $PageObjArray
$_SESSION['obj_pages'] = serialize($PageObjArray);
