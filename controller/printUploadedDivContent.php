<?php
/* 
 * Display on screen Uploaded PDF content
 * 
 * 
 */

session_start();
$cur_page = $_SESSION['cur_page'];
//$pdf_array = $_SESSION['pdf_array'];
$page_count = $_SESSION['pages_count'];

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

/**
 * Saved PDF content (in Object File-Page-Exercise)
 */
$pages_obj_upload = unserialize($_SESSION['obj_pages_upload']); 

/// ?????  ALl the JS file

?>

<script type="text/javascript" src="js/print_edit.js"></script>
<script type="text/javascript" src="js/editSavedContent.js"></script>

<script type="text/javascript" src="js/addCont.js"></script> 
<link rel="stylesheet" href="css/fileedit.css" type="text/css">

<!--Css for foundation icons-->
<link rel="stylesheet" href="css/icons/foundation-icons.css" />
<!--Foundation scripts-->
<script src="js/foundation/foundation.js"></script>
<script src="js/foundation/foundation.tooltip.js"></script>

<!--
    Show Saved File content on Screen
    @see ../model/file
    @see ../model/Page
    @see ../model/Exercise
-->
<div class="large-12 panel" style="background-color: white">
    <div id="divi" class="large-12">
        <?php
        //Page Name, File name , add content button
        include_once '../view/fileHeaderContent.php';
        
        /**
         * Iterate through all pages/exercises and show content on screen
         */
        foreach ($pages_obj_upload as $page) { 
            //All exercises 
            $exsList = $page->getExercisesListObj();
            
            /**
             * Show content on screen from current page
             */
            if($page->getPage_nr() === $_SESSION['cur_page']){
                
                /**
                 * Iterate through exercises and display them on the screen
                 */
                foreach ($exsList as $ex){
                    
                    /**
                     * Create exercise id
                     */
                    $exercise_id = $ex->getEx_ID().'_'.$page->getPage_nr().'_'.$_SESSION['filename'];
                    
                    //Combined exercises ??
//                    if (combinedEx($ex->getQuestion()) != $ex->getCombined()) {
//                        $ex->setCombined(combinedEx($ex->getQuestion()));
//
//                        if ($ex->getCombined() == 'yes') {
//                            $ex->setQuestion(cutExercise($ex->getQuestion()));
//                        }
//                    }
                    
                    //Add content
                    //Edit content
                    
                    echo '<br><div id="qid" class="large-12 columns callout panel" '
                           .'data-id="'.$ex->getEx_ID().'" '
                           .'contenteditable="true" data-combined="'.$ex->getCombined().'" '
                           .'oninput="questionChanged(this, '.$page->getPage_nr().')" '
                           .'data-changed="'.$ex->getChanged().'"'
                           .'style="" >'
                               . $ex->getQuestion()
                           .'<div id="aid" class="large-4 medium-4 columns right callout panel" data-id="A'.$exercise_id.'">'
                               .$ex->getSolution()
                           .'</div>'
                           .'<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"'
                                 .'style="position:absolute; bottom:0; right: 0;">Explanation <i class="fi-arrow-down"></i>'
                           .'</a>' 
                           .'<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" '
                               .'style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;">'
                               .'<p>'.$ex->getExplanation().'</p>'
                            . '<textarea placeholder="Explanatin" cols="40" rows="3" name="textarea" id="textarea"></textarea> '
                           .'</div>'
                        .'</div> ';

                    foreach ($ex->getImages() as $img){
                        echo (string) $img
                        .' data-id ="P'.$exercise_id.'" onclick="myFunction(this)"'
                        .' class="columns" id="pid"  '
                        .' style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
                    }
                    
                }
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="large-12 columns">
        <?php

        // To change pages
        echo '<br>';

        if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
            echo '<button type="submit" id="but" onclick= "nextPageUploaded()" > next </button> ';
        }
        if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
            echo '<button type="submit" id="but" onclick= "return prePageUploaded()" > previous </button> '
            . '<button type="submit" id="but" onclick= "return nextPageUploaded()" > next </button> ';
        }
        if(($_SESSION['cur_page'] == $_SESSION['pages_count']-1) && $_SESSION['cur_page'] != 0){
            echo '<button type="submit" id="but" onclick= "return prePageUploaded()" > previous </button> ';
        }
        ?>
        
        </div>
    </div>
</div>

<div class="row">
    <div class="large-12 columns">
        <a id="btnSave" class="button success medium" onclick= "saveUploadedPdfInDB()">Save</a>
        <a id="toHome" class="button secondary medium has-tip" data-options="disable-for-touch:true" aria-haspopup="true" 
        title="Click to cancel" onclick="backToHomePage()">Cancel</a>
    </div>
</div>