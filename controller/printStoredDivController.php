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
//echo 'Current page: ' . $cur_page;
//echo 'Pages count: '. $page_count;
?>

<script type="text/javascript" src="js/print_edit.js"></script>
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
    <div id="divi" class="large-12">
        <h5 class="subheader">File Name: <?php echo $_SESSION['filename']; ?></h5>
        <div class="large-4 medium-4 small-4 columns">
            <h5 class="subheader">Page Name</h5>
            <div id="pName" class="panel" contentEditable=true 
                 data-changed="false" oninput="dataChganged(this)"
                 style="padding: 0px; height: 30px"><?php
                    if(isset($_SESSION['pdf_array'][$_SESSION['cur_page']][0][1])){
                        echo($_SESSION['pdf_array'][$_SESSION['cur_page']][0][1]);
                    }
                ?></div>

        </div>
    <?php
        if(isset($pdf_array[$_SESSION['cur_page']])){
            $exeInPage = count($pdf_array[$_SESSION['cur_page']]);
            $preExerciseID = 0;
            for($e=0;$e<$exeInPage;$e++){
                //[0] Page_ID
                //[1] Page_name
                //[2] Ex_ID
                //[3] Question
                //[4] Solution
                //[5] Explanation
                //[6] Changed
                //[7] Images

                //If current ex id is the same as previous then it means that exercise has two or more images
                if($preExerciseID == 0 || $preExerciseID != $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2]){
                    $id = $e.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];
                    
                    if(substr_startswith($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3], '**PREpage**')){
                        $combined = 'yes';
                        // cut the **PREpage** off
                        $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3] = substr($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3], 11); // **PREpage**
                    }
                    else{
                        $combined = 'no';
                    }
                    
                    echo '<br><div id="qid" class="large-12 columns callout panel" '
                                .'data-id="'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2].'" '
                                .'contenteditable="true" data-combined="'.$combined.'" '
                                .'oninput="dataChganged(this)" '
                                .'data-changed="'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][6].'"'
                                .'style="padding-right: 0.2rem; padding-bottom: 0rem;" > '
                                    . $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][3]
                                .'<div id="aid" class="large-4 medium-4 columns right callout panel" data-id="A'.$id.'">'
                                    .$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][4]
                                    .'<p>&nbsp</p>'
                                .'</div>'
                                .'<a class = "class="large-4 medium-4 columns right" data-dropdown="drop2" contenteditable="false" onclick="openExplDiv(this)"'
                                      .'style="position:absolute; bottom:0; right: 0;">Explanation <i class="fi-arrow-down"></i>'
                                .'</a>' 
                                .'<div id="dropExplanation" class="large-4 medium-4 columns right callout panel" '
                                    .'style="position:absolute; top:100%; right:0px; z-index: 1; visibility: hidden;">'
                                    .'<p>'.$_SESSION['pdf_array'][$_SESSION['cur_page']][$e][5].'</p>'
                                    . '<p>&nbsp</p>'
                                .'</div>'
                            .'</div> ';
                    
                    //If picture is 0 then there is no picture
                    if($_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7] != '0'){
                        echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7]
                                .' data-id ="P'.$id.'" onclick="myFunction(this)"'
                                .' class="columns" id="pid"  '
                                .' style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
                    }
                    
                    $preExerciseID = $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][2];
                    
                }
                else{
                    echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$e][7]
                                .' data-id ="P'.$id.'" onclick="myFunction(this)"'
                                .' class="columns" id="pid"  '
                                .' style=" margin-bottom: 1.25rem; float:left; max-width: 40%"/>'; //background: #000080;
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
                echo '<button type="submit" id="but" onclick= "nextPage1()" > >> </button> ';
            }
            if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']-1){
                echo '<button type="submit" id="but" onclick= "return prePage1()" > << </button> '
                . '<button type="submit" id="but" onclick= "return nextPage1()" > >> </button> ';
            }
            if(($_SESSION['cur_page'] == $_SESSION['pages_count']-1) && $_SESSION['cur_page'] != 0){
                echo '<button type="submit" id="but" onclick= "return prePage1()" > << </button> ';
            }
            ?>
        </div>
    </div>


</div>

<div class="row">
    <div class="large-12 columns">
        <?php
        echo '<button type="submit" class="medium success button" id="btnSave" onclick= "return saveChangesInDB()" > Save </button> ';
        ?>
    </div>
</div>

<?php

//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}
