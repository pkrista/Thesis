<?php
session_start();
/* 
 * Change question, solution, explanation
 */

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

//$_POST['question'];
//$_POST['exId'];
//$_POST['page_nr'];
//$_POST['solution'];
//$_POST['explanation'];

$pages_obj = unserialize($_SESSION['obj_pages']);

if($_POST['type'] == 'exercise'){
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_POST['page_nr']){

            $exsList = $page->getExercisesListObj();

            foreach ($exsList as $ex){
               if($ex->getEx_ID() == (integer) $_POST['exId']){
                   //set question
                   $ex->setQuestion($_POST['question']);

                   //set answer
                   $ex->setSolution($_POST['solution']);

                   //set explanation
                   $ex->setExplanation($_POST['explanation']);

                   //set changed
                   $ex->setChanged('yes');
               }
            }
        }
    }
    //set new Session object
    $_SESSION['obj_pages'] = serialize($pages_obj);
}
if($_POST['type'] == 'page'){
    foreach ($pages_obj as $page){
        print 'PAGE';
        if($page->getPage_nr() == $_POST['page_nr']){
            $page->setPage_name($_POST['page_name']);
            print 'paGE ,aME';
            print $_POST['page_name'];
        }
    }
    //set new Session object
    $_SESSION['obj_pages'] = serialize($pages_obj);
}
