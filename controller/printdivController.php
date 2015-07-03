<?php 
session_start();
$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
/* 
 * 
 * 
 *
 */
?>
<link rel="stylesheet" href="css/fileedit.css" type="text/css">

<div id="divi" class="large-12 columns">

    <?php
    if(substr_count(end($_SESSION['pdf_array'][$cur_page]), '**RENEW**') == 0){
        //Print page by page
        $p=0;
        while(!empty($_SESSION['pdf_array'][$_SESSION['cur_page']][$p]) ){ 
            $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];

    //        if((substr_count($_SESSION['pdf_array'][$_SESSION['cur_page']][$p], '<img src='))>0){
            if(substr($pdf_array[$_SESSION['cur_page']][$p], 0, 9) === '<img src='){

                echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                . ' draggable="true" ondragstart="drag(event)"'
                        . 'class="large-6 medium-6 columns" id="pid"  style="background: #000080"/>';
                $p++;
            }
            else{
                echo '<div class="large-12 columns callout panel" id="qid" data-id="Q'.$id.'" '
                        . 'contenteditable="true" id="I'.$p.'" '
                        . 'onclick="myFunction(this)"'
                        . 'ondragenter="dragEnter(event, this)" ondragleave="dragLeave(event)"'
                        . 'ondrop="drop(event)" ondragover="allowDrop(event)"> '

                  . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                  . '<div class="large-12 columns callout panel" id="aid" data-id="A'.$id.'" '
                        . 'onclick="myFunction(this)"'
                        . 'contenteditable="true"> Answer div </div>'
                        . '<div id="div1" class="dddI" '
                            . 'ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"'
                            . '></div>'
                        . '</div> <br>';
                $p++;
                //Picture's element in div1/dddI class is changed in one.js (id=pic1 class=dddI)
            }
        }
    }
    else{
        $p=0;
        while(!empty($_SESSION['pdf_array'][$_SESSION['cur_page']][$p])){ 
            $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];

            if(substr_count(($_SESSION['pdf_array'][$cur_page][$p]), '**RENEW**') > 0){
                echo '<div class="ddh" id="qid"'
                        . ' data-id="Q'.$id.'" id="I'.$p.'" >'
                        .$_SESSION['pdf_array'][$_SESSION['cur_page']][$p].'</div>';
    //            echo '<div class="ddh" id="qid" data-id="Q'.$id.'" id="I'.$p.'" > '
    //                . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
    //                . '</div> <br>';

                $p++;
            }
            else{
    //            if((substr_count($_SESSION['pdf_array'][$_SESSION['cur_page']][$p], '<img src='))>0){
                if(substr($pdf_array[$_SESSION['cur_page']][$p], 0, 9) === '<img src='){
                    echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                    . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                    . ' draggable="true" ondragstart="drag(event)"'
                            . 'class="large-6 medium-6 columns" id="pid"  style="background: #000080"/>';
                    $p++;
                }      
                else{
                    echo '<div class="large-12 columns callout panel" id="qid" data-id="Q'.$id.'" '
                        . 'contenteditable="true" id="I'.$p.'" '
                        . 'onclick="myFunction(this)"'
                        . 'ondragenter="dragEnter(event, this)" ondragleave="dragLeave(event)"'
                        . 'ondrop="drop(event)" ondragover="allowDrop(event)"> '

                    . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                    . '</div> <br>';
                $p++;
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
        if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
            echo '<button type="submit" id="but" onclick= "nextPage()" > >> </button> ';
        }
        if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
            echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> '
            . '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
        }
        if($_SESSION['cur_page'] == $_SESSION['pages_count']){
            echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> ';
        }
        ?>
    </div>
</div>


<div class="row">
    <div class="large-12 columns">
        <?php
        echo '<button type="submit" class="btnSave" id="btnSave" onclick= "return saveData()" > Save </button> ';
        ?>
    </div>
</div>

