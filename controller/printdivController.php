<?php
session_start();
$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
/*
 *
 *
 *
 */
//echo 'Current page: ' . $cur_page;
//echo 'Pages count: '. $_SESSION['pages_count'];
?>
<script type="text/javascript" src="js/print_edit.js"></script>  
<script type="text/javascript" src="js/addCont.js"></script> 
<link rel="stylesheet" href="css/fileedit.css" type="text/css">
<!--Css for foundation icons-->
<link rel="stylesheet" href="css/icons/foundation-icons.css" />
<script src="js/foundation/foundation.js"></script>
<script src="js/foundation/foundation.tooltip.js"></script>

<div class="large-12 panel" style="background-color: white">
    <div id="divi" class="large-12 ">

        <?php
        //Page Name, File name , add content button
        include_once '../view/fileName_addContent.php';
        
        if(substr_count(end($_SESSION['pdf_array'][$cur_page]), '**RENEW**') == 0){
            //Print page by page
            $p=0;
            while(!empty($_SESSION['pdf_array'][$_SESSION['cur_page']][$p]) ){
                $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];

                if(substr_startswith($pdf_array[$_SESSION['cur_page']][$p], '<img src=')){

                    echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                    . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                            . 'class="columns" id="pid"  '
                            . 'style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
                    $p++;
                }
                else{
                    if(substr_startswith($pdf_array[$_SESSION['cur_page']][$p], '**PREpage**')){
                        $combined = 'yes';
                        // cut the **PREpage** off
                        $_SESSION['pdf_array'][$_SESSION['cur_page']][$p] = substr($pdf_array[$_SESSION['cur_page']][$p], 11); // **PREpage**
                    }
                    else{
                        $combined = 'no';
                    }
                    //Option to add content before this question
                    addContent();
                    
                    echo '<br><div id="qid" class="large-12 columns callout panel" data-id="Q'.$id.'" '
                            . 'contenteditable="true" data-combined="'.$combined.'" id="I'.$p.'" '
                            . 'style="padding-right: 0.2rem; padding-bottom: 0rem;"> '
                            . '<a id="delDiv" onclick="deleteDiv(this)"
                                style="right: 0.25rem; font-size: 1.375rem; position: absolute; right: -20px; top: -20px"
                                contenteditable="false"> × '
                            . '</a>'

                            . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                            . '<div id="aid" class="large-4 medium-4 columns callout panel" data-id="A'.$id.'" '
                                . 'style="float: right;"> Answer div '
                                .'<p>&nbsp</p>'
                            . '</div>'
                            . '<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"
                                    style="position:absolute; bottom:0; right: 0;">Explanation <i class="fi-arrow-down"></i>'
                            . '</a>'
                            . '<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" 
                                    style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;" >'
                                    .'<p>Explanation...</p>'
                                    .'<p>&nbsp</p>'
                            . '</div>'
                        . '</div> ';

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
                    echo '<div class="ddh" data-combined="" id="qid"'
                            . ' data-id="Q'.$id.'" id="I'.$p.'" >'
                            .$_SESSION['pdf_array'][$_SESSION['cur_page']][$p].'</div>';
                    $p++;
                }
                else{
    //                if(substr($pdf_array[$_SESSION['cur_page']][$p], 0, 9) === '<img src='){
                    if(substr_startswith($pdf_array[$_SESSION['cur_page']][$p], '<img src=')){
                        echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                        . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                                . 'class="large-6 columns" id="pid"  '
                                . 'style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
                        $p++;
                    }
                    else{

                        if(substr_startswith($pdf_array[$_SESSION['cur_page']][$p], '**PREpage**')){
                            $combined = 'yes';
                            // cut the **PREpage** off
                            $_SESSION['pdf_array'][$_SESSION['cur_page']][$p] = substr($pdf_array[$_SESSION['cur_page']][$p], 11); // **PREpage**
                        }
                        else{
                            $combined = 'no';
                        }
                        //Option to add content before this question
                        addContent();
                        echo '<br><div id="qid" class="large-12 columns callout panel" data-id="Q'.$id.'" '
                            . 'contenteditable="true" data-combined="'.$combined.'" id="I'.$p.'"> '
                                . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
                            . '</div>';

                    $p++;
                    }
                }
            }
        }
        //Option to add content before this question
        addContent();

    
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
            if(($_SESSION['cur_page'] == $_SESSION['pages_count']) && $_SESSION['cur_page'] != 0){
                echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> ';
            }
            ?>
        </div>
    </div>

</div>

<div class="row">
    <div class="large-12 columns">
        <a id="btnSave" class="button success medium" onclick= "saveData()">Save</a>
        <a id="toHome" class="button secondary medium has-tip" data-options="disable-for-touch:true" aria-haspopup="true" 
        title="Click to cancel" onclick="backToHomePage()">Cancel</a>
    </div>
</div>

<?php

//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function addContent(){
    //Option to add content
    echo '<div id="addNewDiv" class="large-12 columns" '
        . 'style="border-color: #008CBA; border-width: 1px; border-style: solid; '
            . 'margin-top: 1.25rem; margin-bottom: 1.25rem; display: none"> ' //
        . '<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="addContHere(this)"
                style="position:absolute; bottom:0; right: 0;"><i class="fi-plus"></i>'
        . '</a>'    
        . '</div>';
}

?>


