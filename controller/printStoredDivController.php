<?php
/* 
 * 
 * 
 * 
 */

session_start();
$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
$page_count = $_SESSION['pages_count'];

include_once'../model/Page.php'; 
include_once'../model/Exercise.php';

/**
 * Saved PDF content (in Object File-Page-Exercise)
 */
$pages_obj = unserialize($_SESSION['obj_pages']); 
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
    include_once '../view/fileName_addContent.php';
            //All files that are not yet saved in the db
        foreach ($pages_obj as $page)  
        {  
//                echo '<br> Page: ';
//                print_r($page->Page_ID);
//                print_r($page->getPage_ID());
//                print_r($page->getExercisesListObj());
                $exsList = $page->getExercisesListObj();
                
//                echo 'Page Nr = '.$page->getPage_nr();
//                echo 'Cur Page = '.$_SESSION['cur_page'];
                
                if($page->getPage_nr() === $_SESSION['cur_page']){
                    foreach ($exsList as $ex){
                        /**
                         * Create exercise id
                         */
                        $exercise_id = $ex->getEx_ID().'_'.$page->getPage_nr().'_'.$_SESSION['filename'];
                        
                        if(combinedEx($ex->getQuestion()) != $ex->getCombined()){
                            $ex->setCombined(combinedEx($ex->getQuestion()));
                               
                            if($ex->getCombined() == 'yes'){
                                $ex->setQuestion(cutExercise($ex->getQuestion()));
                            }
                            
                        }


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
                echo '<button type="submit" id="but" onclick= "nextPageStored()" > >> </button> ';
            }
            if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
                echo '<button type="submit" id="but" onclick= "return prePageStored()" > << </button> '
                . '<button type="submit" id="but" onclick= "return nextPageStored()" > >> </button> ';
            }
            if(($_SESSION['cur_page'] == $_SESSION['pages_count']-1) && $_SESSION['cur_page'] != 0){
                echo '<button type="submit" id="but" onclick= "return prePageStored()" > << </button> ';
            }
            ?>
        </div>
    </div>


</div>

<div class="row">
    <div class="large-12 columns">
        <a id="btnSave" class="button success medium" onclick= "saveChangesDB()">Save</a>
        <a id="toHome" class="button secondary medium has-tip" data-options="disable-for-touch:true" aria-haspopup="true" 
        title="Click to cancel" onclick="backToHomePage()">Cancel</a>
    </div>
</div>

<?php

//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function combinedEx($exercise){
    if(substr_startswith($exercise, '**PREpage**')){
        return 'yes';
    }
    return 'no';
}

function cutExercise($exercise){
    $exerciseN = substr($exercise, 11); // **PREpage**
    return $exerciseN;
}


/**
 * 
 * 
 * Old style with 2d array
 */
?>
<div class="large-12 panel" style="background-color: white">
    <div id="divi" class="large-12">

    <?php
    //Page Name, File name , add content button
//    include_once '../view/fileName_addContent.php';
    
//        if(isset($pdf_array[$_SESSION['cur_page']])){
//            $exeInPage = count($pdf_array[$_SESSION['cur_page']]);
//            $preExerciseID = 0;
//            
//            //Option to add content before this question
//            //addContent();
//            
//            for($e=0;$e<$exeInPage;$e++){
//                //[0] Page_ID
//                //[1] Page_name
//                //[2] Ex_ID
//                //[3] Question
//                //[4] Solution
//                //[5] Explanation
//                //[6] Changed
//                //[7] Images
//
//                //If current ex id is the same as previous then it means that exercise has two or more images
//                if($preExerciseID == 0 || $preExerciseID != $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2]){
//                    $id = $e.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];
//                    
//                    if(substr_startswith($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3], '**PREpage**')){
//                        $combined = 'yes';
//                        // cut the **PREpage** off
//                        $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3] = substr($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3], 11); // **PREpage**
//                    }
//                    else{
//                        $combined = 'no';
//                    }
//                    
//                    echo '<br><div id="qid" class="large-12 columns callout panel" '
//                                .'data-id="'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2].'" '
//                                .'contenteditable="true" data-combined="'.$combined.'" '
//                                .'oninput="dataChganged(this)" '
//                                .'data-changed="'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][6].'"'
//                                .'style="" > '
//                                    . $id //$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3]
//                                .'<div id="aid" class="large-4 medium-4 columns right callout panel" data-id="A'.$id.'">'
//                                    .$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][4]
//                                .'</div>'
//                                .'<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"'
//                                      .'style="position:absolute; bottom:0; right: 0;">Explanation <i class="fi-arrow-down"></i>'
//                                .'</a>' 
//                                .'<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" '
//                                    .'style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;">'
//                                    .'<p>'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][5].'</p>'
//                                .'</div>'
//                            .'</div> ';
//                    
//                    //If picture is 0 then there is no picture
//                    if($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7] != '0'){
//                        echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7]
//                                .' data-id ="P'.$id.'" onclick="myFunction(this)"'
//                                .' class="columns" id="pid"  '
//                                .' style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
//                    }
//                    
//                    $preExerciseID = $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2];
//                    
//                }
//                else{
//                    echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7]
//                                .' data-id ="P'.$id.'" onclick="myFunction(this)"'
//                                .' class="columns" id="pid"  '
//                                .' style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
//                }
//                
//                //Option to add content before this question
//                //addContent();
//            } 
//        }
    ?>
    </div>
    
    <div class="row">
        <div class="large-12 columns">
            <?php
       
    
            // To change pages
//            echo '<br>';
//            if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
//                echo '<button type="submit" id="but" onclick= "nextPageStored()" > >> </button> ';
//            }
//            if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
//                echo '<button type="submit" id="but" onclick= "return prePageStored()" > << </button> '
//                . '<button type="submit" id="but" onclick= "return nextPageStored()" > >> </button> ';
//            }
//            if(($_SESSION['cur_page'] == $_SESSION['pages_count']-1) && $_SESSION['cur_page'] != 0){
//                echo '<button type="submit" id="but" onclick= "return prePageStored()" > << </button> ';
//            }
            ?>
        </div>
    </div>


</div>

<!--<div class="row">
    <div class="large-12 columns">
        <a id="btnSave" class="button success medium" onclick= "saveChangesDB()">Save</a>
        <a id="toHome" class="button secondary medium has-tip" data-options="disable-for-touch:saveChangesInDBtrue" aria-haspopup="true" 
        title="Click to cancel" onclick="backToHomePage()">Cancel</a>
    </div>
</div>-->

<?php



//function addContent(){
//    //Option to add content
//    echo '<div id="addNewDiv" class="large-12 columns" contenteditable="true"'
//        . 'data-combined="no"'
//        . 'style="border-color: #008CBA; border-width: 1px; border-style: solid; '
//        . 'margin-top: 1.25rem; margin-bottom: 1.25rem; display: none"> '           
//            //Answer
//            . '<div id="aid" class="large-4 medium-4 columns callout panel"  ' //data-id="A'.$id.'"
//                . 'style="float: right; display: none;" > Answer div'
//            . '</div>'
//            //Explanation
//            . '<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"
//                    style="position:absolute; bottom:0; right: 0; display: none;" > Explanation <i class="fi-arrow-down"></i>'
//            . '</a>'
//            . '<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" 
//                    style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;" >'
//                    . '<p>Explanation...</p>'
//            . '</div>'
//            //Add here element
//            . '<a id ="addHere" class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="addContHere(this, event)"
//                    style="position:absolute; bottom:0; right: 0;"><i class="fi-plus has-tip" 
//                    title="Add here"></i>'
//            . '</a>'    
//        . '</div>';
//}

?>
