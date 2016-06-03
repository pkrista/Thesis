<?php
session_start();
$_SESSION['cur_page'];
/* 
 * 
 * ex changeQuestionPage
 * 
 * Change question, solution, explanation
 */

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

//$_POST['question'];
//$_POST['exId'];
//$_POST['page_nr'];
//$_POST['solution'];
//$_POST['explanation'];
//$_POST['page_id'];

if (isset($_SESSION['obj_pages']) && !empty($_SESSION['obj_pages'])){
    /**
     * Saved PDF variable
     */
    $pages_obj = unserialize ($_SESSION['obj_pages']);
    echo 'SAVED';
    }
elseif (isset($_SESSION['obj_pages_upload']) && !empty($_SESSION['obj_pages_upload'])) {
    /**
     * Uploaded PDF variable
     */
    $pages_obj = unserialize($_SESSION['obj_pages_upload']);
    echo 'UPLOADED';
}

if($_POST['type'] == 'exercise'){
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_POST['page_nr']){

            $exsList = $page->getExercisesListObj();

            foreach ($exsList as $key=>$ex){
               if($key == (integer) $_POST['exId']){
                   /**
                    * set/edit question
                    */
                   $ex->setQuestion($_POST['question']);

                   /**
                    * set/edit answer
                    */
                   $ex->setSolution($_POST['solution']);

                   /**
                    * set/edit explanation
                    */
                   $ex->setExplanation($_POST['explanation']);

                   /**
                    * set/edit changed
                    */
                   $ex->setChanged('yes');
               }
            }
        }
    }
}

if ($_POST['type'] == 'page') {
    if ($pages_obj) {
        foreach ($pages_obj as $page) {

            if ($page->getPage_ID() == $_POST['page_id']) {
                $page->setPage_name($_POST['page_name']);
            }
        }
    }
}
if ($_POST['type'] == 'category') {
    if ($pages_obj[$_SESSION['cur_page']]) {
        
            if ($pages_obj[$_SESSION['cur_page']]->getPage_ID() == $_POST['page_id']) {
                $pages_obj[$_SESSION['cur_page']]->setCourse($_POST['category_id']);
            }
        
    }
}

/**
 * Store session variables
 */
if (isset($_SESSION['obj_pages']) && !empty($_SESSION['obj_pages'])) {
    $_SESSION['obj_pages'] = serialize($pages_obj);
} elseif (isset($_SESSION['obj_pages_upload']) && !empty($_SESSION['obj_pages_upload'])) {
    $_SESSION['obj_pages_upload'] = serialize($pages_obj);
}