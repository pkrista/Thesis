<?php
session_start(); 
/* 
 * 
 */

/**
 * Include models: Exercise and Page
 */
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

/**
 * Conection to the database
 */
include_once '../config/theasisDB.php';
$db = new theasisDB();
$lastInsertedPageId = -1;
$lastInsertedExeId = -1;

print 'In file (saveChangesDB.php) to save changed content of uploaded PDF ';

/**
 * Current page object taken from screen
 */
$pages_obj = unserialize($_SESSION['obj_pages_upload']);
$fileId = $_SESSION['fileId'];

foreach ($pages_obj as $page){
    /**
     * get Paper page nr
     */
    $paperPageNr = $page->getPage_nr() + 1;
    /**
     * prepare insert query
     */
    $sqlInsertPage = "INSERT INTO Page(Name, PagePaper, PagePen, File_ID, Course_ID) "
            . "VALUES "
            . "('".$page->getPage_name()."' "
            . ", ".$page->getPage_nr()." "
            . ", ".$paperPageNr." "
            . ", ".$fileId." "
            . ", 2)"; //2 for Math TODO make courses un UI
    
    /**
     * insert in db and get back page id / or -1 if was errer
     */
    $lastInsertedPageId = insertDB($sqlInsertPage);
    $exsList = $page->getExercisesListObj();
    if ($lastInsertedPageId !== -1 && count($exsList) > 0) {

        foreach ($exsList as $exe) {
            $lastInsertedExeId = insertDB(generateQueryExercise($exe, $lastInsertedPageId,$paperPageNr));
            $imgList = $exe->getImages();
            if($lastInsertedExeId !== -1 && count($imgList)>0 ){
                foreach ($imgList as $img) {
                    insertDB(generateQueryImg($img, $lastInsertedExeId));
                }
            }
        }
    }
}

/*
 * Generates insert query for Exercise
 */
function generateQueryExercise($exercise, $pageID,$paperPageNr){
   $PaperFieldID = $paperPageNr.$exercise->getEx_ID()+1;
    $query = "INSERT INTO exercise(Page_ID,PaperFieldID,Number,Question,Solution,Explanation)"
            . "VALUES(".$pageID
            . ",".$PaperFieldID
            . ",'".$exercise->getEx_ID()."'"
            . ",'".$exercise->getQuestion()."'"
            . ",'".$exercise->getSolution()."'"
            . ",'".$exercise->getExplanation()."')";
    
    //TODO what with combined exercises?
    
    return $query;
}

function generateQueryImg($img, $lastExeID){
    return "INSERT INTO image(src, Exercise_ID) VALUES('".$img."',".$lastExeID.")";
}

function insertDB($query){   
    try {
        $db = new theasisDB();
        $db->query($query);
        $lastPageID = $db->lastInsertId(); //Last insert id -> Id for current page
        print "File successfully saved (saveChangesDB.php)";
        return $lastPageID;
    }
    catch (PDOException $e) {
        print "error saving file in DB (saveChangesDB.php) - " . $e->getMessage();
        return -1;
    }
}