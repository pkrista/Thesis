<?php
session_start();

/* 
 * Add new exercise to the current page in given index
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

print 'INDEX .>.>' . $exeIndex;

/**
 * if index f exercise is given as -1 
 * add element at the begining
 */

print 'old';
print_r($pageArray);

$newExercise = array(new Exercise($cur_page, '', 0, 'Exercises question...', '', '', 'no', array(), $cur_page));
array_splice($pageArray, $exeIndex+1, 0, $newExercise);

print 'new';
print_r($pageArray);

$page->setExercisesListObj($pageArray);
$pages_obj_upload[$cur_page] = $page;
$_SESSION['obj_pages_upload'] = serialize($pages_obj_upload);
