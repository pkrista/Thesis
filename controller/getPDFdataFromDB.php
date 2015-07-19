<?php
session_start(); 
unset($_SESSION['filename']);
unset($_SESSION['fileId']);
unset($_SESSION['pageinfo']);
unset($_SESSION['direction']);
unset($_SESSION['pages_count']);
unset($_SESSION['cur_page']);

/* 
 * 
 * 
 * 
 */

//$_SESSION['pdf_array'] = $pdf_array;
//Get variables from 
$fileName = $_POST['fName'];
$fileId = $_POST['fileId'];

$_SESSION['filename'] = $fileName;
$_SESSION['fileId'] = $fileId;

/**
 * Connect to db
 */
include_once '../config/theasisDB.php';
$db = new theasisDB();


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

$query1 = 'select p.Page_ID, p.Name, e.Exercise_ID , e.Question, e.Solution, e.Explanation, '
        . 'IFNULL(i.src, 0) src FROM exercise e '
        . 'LEFT JOIN image i on i.Exercise_ID = e.Exercise_ID '
        . 'LEFT JOIN page p on p.Page_ID = e.PAGE_ID '
        . 'LEFT JOIN file f on p.File_ID = f.File_ID '
        . 'Where f.File_ID = '.$fileId;

$result1 = $db->query($query1);
$PrePageID = '';
$page = 0;

foreach ($result1 as $value) {
    
    if($PrePageID != '' && ($value[0] != $PrePageID)){

        $page++;
        $page_array = array();
    }
       
       array_push($exercise_array, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5], 'false', $value[6]);
       array_push($page_array, $exercise_array);
       $exercise_array = array();
       
       $PDF_array[$page] = $page_array;
       
       $PrePageID = $value[0];
}

//Set session variable (2d array)
$_SESSION['pdf_array'] = $PDF_array;

print_r($PDF_array);
echo 'get saved pdf data';
