<?php
session_start(); 
/* 
 * Update alreadu stored PDF
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

print 'In file (updateChangesDB.php) to save changed content of saved PDF ';

/**
 * Current page object taken from screen
 */
$pages_obj = unserialize($_SESSION['obj_pages']);

foreach ($pages_obj as $page){
    $exsList = $page->getExercisesListObj();
    $pageNR = $page->getPage_nr();
    $pageID = $page->getPage_ID();
    
    //update page info
    $PageUpdateQuery = 'UPDATE page'
            . ' SET Name = "'.$page->getPage_name().'"'
            . ' WHERE Page_ID ='.$page->getPage_ID() ;
    updateDB($PageUpdateQuery);

    $exsListWithDeletes = removeExerciseDB($exsList);
    
    if(count($exsListWithDeletes) < count($exsList)){
        foreach ($exsListWithDeletes as $key=>$exe){
            $exe->setChanged('yes');
        }
    }
    $exsListWithDeletes = array_values($exsListWithDeletes);

    updateChangedExercises($exsListWithDeletes, $pageID);
} 

function updateChangedExercises($exsListWithDeletes, $pageID){
        foreach ($exsListWithDeletes as $key=>$exe){
        $pagePaperNr = $exe->getPage()+1;
        $PaperFieldID = $pagePaperNr.$key+1;
        
        //check if exercise is changed
        if($exe->getChanged() == 'yes'){
            //update changed exercises query
            $ExerciseUpdateQuery = 'UPDATE exercise '
                    . ' SET Question="'.$exe->getQuestion().'",'
                    . ' Solution="'.$exe->getSolution().'",'
                    . ' Explanation="'.$exe->getExplanation().'",'
                    . ' PaperFieldID="'.$PaperFieldID.'",'
                    . ' Number="'.$key.'"'
                    . ' WHERE Page_ID = '.$pageID
                    . ' AND Exercise_ID = '.$exe->getEx_ID();
            
            updateDB($ExerciseUpdateQuery);
        }
    }
}

function removeExerciseDB($exsList){
    foreach ($exsList as $key=>$exe){
        //remove or delete exercise if removed
        if($exe->getIsRemoved() == 'yes'){
            //deleate images
            $images = $exe->getImages();
            
            deleteExerciseRelatedimages($images, $exe->getEx_ID());
            
            //1 deleate from db
            $exeRemoveQuery = 'DELETE FROM exercise '
                            . ' WHERE Exercise_ID = '.$exe->getEx_ID();
            updateDB($exeRemoveQuery);

            //2 remove from array
            unset($exsList[$key]);
        }
    }
    return $exsList;
}

function deleteExerciseRelatedimages($images, $exeId){
    foreach($images as $img){
         $exeRemoveQuery = 'DELETE FROM image '
                         . ' WHERE Exercise_ID = '.$exeId;
         updateDB($exeRemoveQuery);
    } 
}

function updateDB($query){   
    try {
        $db = new theasisDB();
        $db->query($query);
        print "File successfully updated (updateChangesDB.php)";

    }
    catch (PDOException $e) {
        print "error updating file in DB (updateChangesDB.php) - " . $e->getMessage();
    }

}