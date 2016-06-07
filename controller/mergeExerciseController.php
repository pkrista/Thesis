<?php
session_start();
/* 
 * Controller responsibe to merge two exercises
 */

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

$savedPDF = false;

$cur_page = $_SESSION['cur_page'];
if (isset($_SESSION['obj_pages']) && !empty($_SESSION['obj_pages'])){
    /**
     * Saved PDF variable
     */
    $pages_obj = unserialize ($_SESSION['obj_pages']);
    $savedPDF = true;

    }
elseif (isset($_SESSION['obj_pages_upload']) && !empty($_SESSION['obj_pages_upload'])) {
    /**
     * Uploaded PDF variable
     */
    $pages_obj = unserialize($_SESSION['obj_pages_upload']);
    $savedPDF = false;

}

$exerciseIndex = $_POST['exerciseIndex'];
$targetExerciseIndex = $_POST['targetExerciseIndex'];

$page = $pages_obj[$cur_page];
$exercisesList = $page->getExercisesListObj();

$imagesArray = [];
$question = '';

/**
 * Get dragged exercise question and images
 */
foreach ($exercisesList as $key=>$ex){
    if($key == $exerciseIndex){
        $imagesArray = $ex->getImages();
        $question = $ex->getQuestion();
    }
}
/**
 * Merge target exercise with dragged one
 */
foreach ($exercisesList as $key=>$ex){
    if($key == $targetExerciseIndex){
        if($question && strlen($question)>0){
            $newQuestion = $ex->getQuestion(). ' '. $question;
            $ex->setQuestion($newQuestion);
        }
       
        if($imagesArray && count($imagesArray)>0){
            $newImagesList = array_merge($ex->getImages(),$imagesArray);
            $ex->setImages($newImagesList);
            $ex->setChanged('yes');
        }
    }
}

/**
 * To get in js where to go back
 */
echo $savedPDF;

if($savedPDF){
    $page->setExercisesListObj($exercisesList);
    $pages_obj[$cur_page] = $page;
    $_SESSION['obj_pages'] = serialize($pages_obj);
    
}
else{
    $page->setExercisesListObj($exercisesList);
    $pages_obj[$cur_page] = $page;
    $_SESSION['obj_pages_upload'] = serialize($pages_obj);
}
