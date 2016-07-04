<?php
session_start();

/* 
 * Add new exercise to the current page in given index (stored PDF)
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

/**
 * if index of exercise is given as -1 
 * add element at the begining
 */
$exerciseFirst = reset($pageArray);

$exercise = new Exercise($exerciseFirst->getPage_ID(), '', $exeIndex+1, 'Exercises question...', '', '', array(), $exerciseFirst->getPage());
$exercise->setIsNew('yes');
$exercise->setIsRemoved('no');

array_splice($pageArray, $exeIndex+1, 0, array($exercise));

foreach ($pageArray as $key=>$exe){
    $exe->setChanged('yes');
}

print_r($pageArray);

$page->setExercisesListObj(array_values($pageArray));
$pages_obj[$cur_page] = $page;
$_SESSION['obj_pages'] = serialize($pages_obj);