<?php
session_start();
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
$pages_obj = unserialize($_SESSION['obj_pages']);

if($_POST['type'] == 'exercise'){
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_POST['page_nr']){

            $exsList = $page->getExercisesListObj();

            foreach ($exsList as $ex){
               if($ex->getEx_ID() == (integer) $_POST['exId']){
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
    /**
     * Store new object on session
     */
    $_SESSION['obj_pages'] = serialize($pages_obj);
}

if($_POST['type'] == 'page'){
    foreach ($pages_obj as $page){
        print 'PAGE ';
        if($page->getPage_ID() == $_POST['page_id']){
            $page->setPage_name($_POST['page_name']);
            print 'Post page name 1 ';
            print $_POST['page_name'];
            print 'Post page name 2 ';
            print $page->getPage_name();
        }
    }
    /**
     * Store new object on session
     */
    $_SESSION['obj_pages'] = serialize($pages_obj);
}
