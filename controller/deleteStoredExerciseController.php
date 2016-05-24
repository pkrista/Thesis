<?php
session_start();
/* 
 * 
 */

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

$cur_page = $_SESSION['cur_page'];
/**
 * Saved PDF content (in Object File-Page-Exercise)
 */
$pages_obj = unserialize($_SESSION['obj_pages']); 
$exeIndex = $_POST['exercise'];

//get page array
$page = $pages_obj[$cur_page];
$pageArray = $page->getExercisesListObj();

foreach($pageArray as $key => $exercise) {
    if($key == $exeIndex){
        //marck as deleated
        $exercise->setIsRemoved('yes');
        $pageArray[$key] = $exercise;
    } 
}

$page->setExercisesListObj($pageArray);
$pages_obj[$cur_page] = $page;
$_SESSION['obj_pages'] = serialize($pages_obj);
