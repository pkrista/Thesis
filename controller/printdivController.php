<?php 
session_start();

/* 
 * 
 * 
 *
 */


if($_SESSION['print']=='combined'){
        //Print page by page
    $p=0;
    while(!empty($_SESSION['pdf_array'][$_SESSION['cur_page']][$p]) ){ 
        $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];

        if((substr_count($_SESSION['pdf_array'][$_SESSION['cur_page']][$p], '<img src='))>0){
            echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
            . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
            . ' draggable="true" ondragstart="drag(event)"'
                    . 'class="dddP" id="pid" />';
            $p++;
        }
        else{
            echo '<div class="ddd" id="qid" data-id="Q'.$id.'" '
                    . 'contenteditable="true" id="I'.$p.'" '
                    . 'onclick="myFunction(this)"'
                    . 'ondragenter="dragEnter(event, this)" ondragleave="dragLeave(event)"'
                    . 'ondrop="drop(event)" ondragover="allowDrop(event)"> '

              . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
              . '<div class="dddA" id="aid" data-id="A'.$id.'" '
                    . 'onclick="myFunction(this)"'
                    . 'contenteditable="true"> Answer div </div>'
                    . '<div id="div1" class="dddI" '
    //                        . 'ondrop="drop(event)" ondragover="allowDrop(event)"'
                        . 'ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"'
                        . '></div>'
                    . '</div> <br>';
            $p++;
        }
    }
}



// To change pages

if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
    echo '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
}
if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $_SESSION['pages_count']){
    echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> '
    . '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
}
if($_SESSION['cur_page'] == $_SESSION['pages_count']){
    echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> ';
}
