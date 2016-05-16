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

print 'In file (updateChangesDB.php) to save changed content of saved PDF ';

/**
 * Current page object taken from screen
 */
$pages_obj = unserialize($_SESSION['obj_pages']);

foreach ($pages_obj as $page){
    //update page info
    $PageUpdateQuery = 'UPDATE page'
            . ' SET Name = "'.$page->getPage_name().'"'
            . ' WHERE Page_ID ='.$page->getPage_ID() ;
    updateDB($PageUpdateQuery);

//    print $PageUpdateQuery . "\n";

    $exsList = $page->getExercisesListObj();
    
    foreach ($exsList as $exe){
        //check if exercise is changed
        if($exe->getChanged() == 'yes'){
            //update changed exercises query
            $ExerciseUpdateQuery = 'UPDATE exercise '
                    . ' SET Question="'.$exe->getQuestion().'",'
                    . ' Solution="'.$exe->getSolution().'",'
                    . ' Explanation="'.$exe->getExplanation().'"'
                    . ' WHERE Page_ID = '.$page->getPage_ID()
                    . ' AND Exercise_ID = '.$exe->getEx_ID();
            
//            $db->query($ExerciseUpdateQuery);
            updateDB($ExerciseUpdateQuery);
            print $ExerciseUpdateQuery. "\n";
            
        }
        
    }
    
}
//INSERT INTO `exercise`(`Exercise_ID`, `PaperFieldID`, `Number`, `Question`, `Solution`, `Explanation`, `Page_ID`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
//INSERT INTO `page`(`Page_ID`, `Name`, `PagePaper`, `PagePen`, `File_ID`, `Course_ID`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])


function updateDB($query){   
    try {
        $db = new theasisDB();
        $db->query($query);
        print "File successfully updated (updateChangesDB.php)";

    }
    catch (PDOException $e) {
        print "error updating file in DB (updateChangesDB.php) - " . $e->getMessage();
    }
      
//    $db = new theasisDB();
//    //Update changed exercises                
//    if ($db->query($query)) {
//        echo "Exercise Updated Sucessfuly";    
//    } else {
//        echo "Error while updateing Exercise";
//    }

}