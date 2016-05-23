<?php
session_start();

/**
 * Delete from session PDF object selected exercise
 */

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

$cur_page = $_SESSION['cur_page'];
/**
 * Saved PDF content (in Object File-Page-Exercise)
 */
$pages_obj_upload = unserialize($_SESSION['obj_pages_upload']); 
$exeIndex = $_POST['exercise'];

//get page array
$page = $pages_obj_upload[$cur_page];
$pageArray = $page->getExercisesListObj();

foreach($pageArray as $key => $exercise) {
    if($key == $exeIndex){
        //delete this particular object from the $array
        unset($pageArray[$key]);
    } 
}

$page->setExercisesListObj($pageArray);
$pages_obj_upload[$cur_page] = $page;
$_SESSION['obj_pages_upload'] = serialize($pages_obj_upload);
