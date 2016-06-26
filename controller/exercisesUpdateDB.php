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

print 'In file (exercisesUpdateDB.php) to save changed content of saved PDF ';

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
            . ' , Category_ID = "'.$page->getCategory().'"'
            . ' , Course_ID = "'.$page->getCourse().'"'
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
        
        //check is is new exercise
        if($exe->getIsNew() == 'yes'){
            $paperPageNr = $exe->getPage()+1;
            $PaperFieldID = $paperPageNr.$key+1;
            //Insert new exercise 
            $ExerciseInsertQuery = "INSERT INTO exercise(Page_ID,PaperFieldID,Number,Question,Solution,Explanation)"
                    . "VALUES(".$exe->getPage_ID()
                    . ",". $PaperFieldID
                    . ",". $key
                    . ",'".$exe->getQuestion()."'"
                    . ",'".$exe->getSolution()."'"
                    . ",'".$exe->getExplanation()."')";
            
            updateDB($ExerciseInsertQuery);
            $exe->setIsNew('no');
        }
        //check if exercise is changed
        else if($exe->getChanged() == 'yes' && $exe->getIsNew() == 'no'){
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
            
            storeExerciseImages($exe, $pageID);
        }
    }
}

function storeExerciseImages($exe, $pageID){
    //get count of existing images
    $dbImgArray = [];
    $imagesList = $exe->getImages();
    
    $query = 'SELECT * from image'
            . ' WHERE Exercise_ID = '.$exe->getEx_ID();
    
    foreach (selectDB($query) as $row){
        $dbImgArray[] = $row['src'];
    }
    
    if(count($dbImgArray) < count($imagesList)){
        foreach ($imagesList as $image){
            foreach ($dbImgArray as $storedImg){
                if($image != $storedImg){
                    $query = "INSERT INTO image(src, Exercise_ID) VALUES('".$image."',".$exe->getEx_ID().")";
                    updateDB($query);
                    break;
                }
            }
        }
    }
}

function removeExerciseDB($exsList){
    foreach ($exsList as $key=>$exe){
        //remove or delete exercise if removed
        if($exe->getIsRemoved() == 'yes'){
            //deleate images
            $images = $exe->getImages();
            
            //deleate images related to exercise
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

function selectDB($query){
   try {
        $db = new theasisDB();
        return $db->query($query);
    }
    catch (PDOException $e) {
        print "error querying DB (exercisesUpdateDB.php) - " . $e->getMessage();
    }  
}

function updateDB($query){   
    try {
        $db = new theasisDB();
        $db->query($query);
        print "File successfully updated (exercisesUpdateDB.php)";

    }
    catch (PDOException $e) {
        print "error updating file in DB (exercisesUpdateDB.php) - " . $e->getMessage();
    }

}