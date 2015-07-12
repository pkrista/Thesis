<?php
session_start();
$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
$page_count = $_SESSION['pages_count'];
/* 
 * 
 * 
 * 
 */
?>

<script>
//    $('#qid').bind("DOMSubtreeModified",function(){
//  alert('changed');
//});

function test(){
    alert('YEs');
}
</script>
    

<link rel="stylesheet" href="css/fileedit.css" type="text/css">
<!--Css for foundation icons-->
<link rel="stylesheet" href="css/icons/foundation-icons.css" />



<div class="large-12">
    <?php
    for($p=0;$p<$page_count;$p++){ //$p page
        if(isset($pdf_array[$p])){
            $exeInPage = count($pdf_array[$p]);
            for($e=0;$e<$exeInPage;$e++){
                //[0] Page_ID
                //[1] Page_name
                //[2] Ex_ID
                //[3] Question
                //[4] Solution
                //[5] Explanation
                //[6] Images

                $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];
                echo '<br><div id="qid" class="large-12 columns callout panel" data-id="Q'.$id.'" '
                        . 'contenteditable="true" data-combined="" id="I'.$p.'" '
                        . 'style="padding-right: 0.2rem; padding-bottom: 0rem;"> '
                        . $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3]
                        . '<div id="aid" class="large-4 medium-4 columns callout panel" data-id="A'.$id.'" '
                              . 'style="float: right;"> Answer div </div>'
                              .    '<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"
                                      style="position:absolute; bottom:0; right: 0;">Explanation <i class="fi-arrow-down"></i></a>'
                                      .'<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" 
                                      style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;">'
                                      .'<p>Explanation...</p>'
                                      .'</div>'
                              . '<div id="div1" class="dddI" '
                                  . 'ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"'
                                  . '></div>'
                              . '</div> ';
                echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][6]
                . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                . ' draggable="true" ondragstart="drag(event)"'
                        . 'class="columns" id="pid"  '
                        . 'style="background: #000080; margin-bottom: 1.25rem; float:left; max-width: 40%"/>';
            } 
        }
    }
    
    
    
    ?>
    <div class="row">
        <div class="large-12 columns">
            <?php

            // To change pages
            echo '<br>';
            if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
                echo '<button type="submit" id="but" onclick= "nextPage()" > >> </button> ';
            }
            if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
                echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> '
                . '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
            }
            if(($_SESSION['cur_page'] == $_SESSION['pages_count']) && $_SESSION['cur_page'] != 0){
                echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> ';
            }
            ?>
        </div>
    </div>


</div>

<div class="row">
    <div class="large-12 columns">
        <?php
        echo '<button type="submit" class="medium success button" id="btnSave" onclick= "return saveData()" > Save </button> ';
        ?>
    </div>
</div>