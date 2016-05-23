<?php
/* 
 * Display on screen Uploaded PDF content
 * 
 * 
 */

session_start();
$cur_page = $_SESSION['cur_page'];
$page_count = $_SESSION['pages_count'];

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

/**
 * Saved PDF content (in Object File-Page-Exercise)
 */
$pages_obj_upload = unserialize($_SESSION['obj_pages_upload']); 

?>

<script type="text/javascript" src="js/manageSavePDFpageContent.js"></script>
<script type="text/javascript" src="js/saveChangedContent.js"></script>

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
        
        // To add content as first object
        echo '<div id="btnaddContentHere" class="button expand tiny info hideDiv" onclick= "addContentToPage(-1)">add here</div>';
        
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
                foreach ($exsList as $key=>$ex){
                    
                    /**
                     * Create exercise id
                     */
                    $exercise_id = $ex->getEx_ID().'_'.$page->getPage_nr().'_'.$_SESSION['filename'];                  

                    $solution = '<textarea id="aid" '
                            . 'class="large-4 medium-4 columns right callout panel disabled" '
                            . 'data-id="A' . $exercise_id . '"'
                            . 'cols="40" rows="1">'
                            . $ex->getSolution()
                        . '</textarea>';

                    $explanationSimbol = '<a id="explanationSimbol"'
                            . 'class = "class="large-4 medium-4 columns right" '
                            . 'data-dropdown="drop2" contenteditable="false" '
                            . 'onclick="openExplDiv(this)">'
                            . 'Explanation '
                            . '<i class="fi-arrow-down"></i>'
                        . '</a>';

                    $explanationArray = '<textarea id="dropExplanation" '
                            . 'class="large-4 medium-4 columns right panel" '
                            . 'contenteditable="false"'
                            . 'placeholder="Explanatin" cols="40" rows="3">'
                            . $ex->getExplanation()
                        . '</textarea>';

                    $removeExe = '<a id="delDiv" onclick="deleteDiv(this,'.$key.')"'
                                . 'style="right: 0.25rem; font-size: 1.375rem; position: absolute; right: -20px; top: -20px"'
                                . 'contenteditable="false"> × '
                            . '</a>';
                    $question = '<br><div id="qid" class="large-12 columns callout panel" '
                            . 'data-id="' . $ex->getEx_ID() . '" '
                            . 'contenteditable="true" data-combined="' . $ex->getCombined() . '" '
                            . 'oninput="questionChanged(this, ' . $page->getPage_nr() . ')" '
                            . 'data-changed="' . $ex->getChanged() . '">'
                            . $ex->getQuestion()
                            . $removeExe
                            . $solution
                            . $explanationSimbol
                            . $explanationArray
                        . '</div> ';

                    echo $question;
                    
                    foreach ($ex->getImages() as $img){
                            echo (string) $img
                            .' data-id ="P'.$exercise_id.'" onclick="myFunction(this)"'
                            .' class="columns" id="pid" />';
                    }
                    echo '<div id="btnaddContentHere" class="button expand tiny info hideDiv" onclick= "addContentToPage('.$key.')">add here</div>';
                    
                }
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="large-12 columns">
        <?php
        
        $nextPreBtn = '<br>';
        
        if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
            $nextPreBtn .= '<button type="submit" id="but" onclick= "nextPageUploaded()" > next </button> ';
        }
        if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
            $nextPreBtn .=  '<button type="submit" id="but" onclick= "return prePageUploaded()" > previous </button> '
                . '<button type="submit" id="but" onclick= "return nextPageUploaded()" > next </button> ';
        }
        if(($_SESSION['cur_page'] == $_SESSION['pages_count']-1) && $_SESSION['cur_page'] != 0){
            $nextPreBtn .=  '<button type="submit" id="but" onclick= "return prePageUploaded()" > previous </button> ';
        }
        
        echo $nextPreBtn;
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