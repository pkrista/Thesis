<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../controller/savefileController.php');
require_once('../controller/fileeditController.php');

?>
<script type="text/javascript">

/**
 * To get id of div P - picture A - answer Q - question
 * @param {type} - P or A or Q
 * @param {id} the id of the div
 */
function myFunction(object) {
    var id = object.getAttribute("data-id");
    var type = id.charAt(0);
    
    if(type === 'P'){
           alert('Image id - '+id); 
    }
    else if(type === 'A'){
        alert('Answer id - '+id); 
    }
    else if(type === 'Q'){
        alert('Question id - '+id); 
    }
    
}

    
function loadXMLDoc() {
    //Thete needs to be function to store array everytime change pages
    document.write('PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP');
}

/**
 * For drag and Drop 
 *
 */
function dragStart(ev) {
    var parnode = ev.target.parentNode;
    if(parnode.id == 'pid'){
        ev.dataTransfer.effectAllowed='move';
        ev.target.style.opacity = "0.4";
        ev.target.parentNode.style.opacity = "0.4";
        ev.dataTransfer.setData("Text", ev.target.id); 
    }
    
    
//    ev.dataTransfer.effectAllowed='move';
//    ev.dataTransfer.setData("Text", ev.target.getAttribute('id'));   
//    // Change the opacity of the draggable element
//    ev.target.style.opacity = "0.4";
//    ev.dataTransfer.setDragImage(ev.target,0,0);
//    return true;
    
}

function dragEnd(ev){
//    ev.document.getElementById(ev.target.id).empty();
//    
//    // Change the opacity of the draggable element
//    ev.target.style.opacity = "1";
    
//    document.getElementById(ev.target.id).innerHTML = "";
//    document.getElementById(ev.target.id).style.visibility='hidden';
//    ev.target.id.parentNode.id;
    var parnode = ev.target.parentNode;
    if(parnode.id == 'pid'){
        parnode.style.visibility='hidden';
        ev.target.style.opacity = "1";
     }
    
    
    
}

function drop(ev) {
    
   ev.preventDefault();
   var data = ev.dataTransfer.getData("Text");
   ev.target.appendChild(document.getElementById(data));
 
   
//   var data=ev.originalEvent.dataTransfer.getData("Text");
//   ev.target.appendChild(document.getElementById(data));
//   ev.stopPropagation();
//   return false;
}

function allowDrop(ev) {
    ev.preventDefault();
    ev.target.style.border = "4px dotted green";
}

function mouseDown(object) {
       object.style.border = "4px dotted green";
}

function mouseUp(object) {
      object.style.border = "2px solid #a1a1a1";
}



</script>

<?php
        
//file name
$filename = $_GET['name']; 
echo "File name: ".$filename."\n";
//set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);


//Chack 
?>

<!--link to css-->
<link rel="stylesheet" href="../css/fileedit.css" type="text/css"> 

<!--<div >
    <textarea id="1" rows="10" cols="100" class="filedisplay" id="filedisplay">
-->         <?php 
            #http://bytes.com/topic/python/answers/801623-calling-python-code-inside-php
//            #http://blog.idealmind.com.br/desenvolvimento-web/php/how-to-execute-python-script-from-php-and-show-output-on-browser/
//               
//            
//            $path = "../uploads/".$filename;
//            
//            $command = "hi.py $path";
//         
//            $pid = popen($command,"r");
// 
//
//            
//            while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000); //milions os a second
//            }
//            pclose($pid);

         ?> <!--
    </textarea>
</div>-->

<!--test-->

<?php

echo '<div id="divi" class="divi">';
        
        $path = "../uploads/".$filename;
        $command = "i.py $path";
         
        $pid = popen($command,"r");

        $big_string = '';

        while( !feof( $pid ) )
            {
                $big_string .= fread($pid, 256);
                flush();
                ob_flush();
                usleep(100000);
            }
        pclose($pid);
        
//        require_once('../controller/fileeditController.php');
//        func1('Hello', 'world');
        
        //Call fileedit controller. send it 
        $obj = new fileeditController($big_string);
//        echo "Print :".$obj->display();
        $pdf_array = $obj->display();
        
        //How many pages (start from 0)
        $pages_count = substr_count($big_string, '**NEWPAGE**');
        
        $curr_page = 0;
        
        //For getting page number
        if(isset($_GET['page'])) { 
            $curr_page = $_GET['page'];
            $pre_page = $_GET['page']-1; 
            $next_page = $_GET['page']+1;  
            if($curr_page > 0 && $curr_page != $pages_count){
                //If the current page is not the last one and the first one
                echo "<a href='?name=$filename&page=$pre_page' ><<<</a> "; 
                echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
            }
            elseif ($curr_page > 0 && $curr_page == $pages_count) {
                //If current page is the last one
                echo "<a href='?name=$filename&page=$pre_page' onclick='loadXMLDoc()'><<<</a> <br>"; 
            }
            else{
                echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
            }
        } 
        else { 
            //If the page is first one then allow just go to next page
            $curr_page = 0;
            $next_page = 1;
            echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
        }
        
   
    
        //Print page by page
        $p=0;
        while(!empty($pdf_array[$curr_page][$p]) ){ 
            $id = $p.'_'.$curr_page.'_'.$filename;
            
            if((substr_count($pdf_array[$curr_page][$p], '<img src='))>0){
//            if(startsWith($pdf_array[$curr_page][$p], '<img src=')){
                echo '<div class="dddP" id="pid" data-id ="P'.$id.'" onclick="myFunction(this)"'
                        . 'draggable="true" '
                        . 'ondragstart="dragStart(event)" ondragend="dragEnd(event)">' 
                .$pdf_array[$curr_page][$p]
                . '</div>';
                $p++;
            }
            else{
                echo '<br> <div class="ddd" id="qid" data-id="Q'.$id.'" '
                        . 'contenteditable="true" id="I'.$p.' ondrop="drop(event)" '
                        . 'onclick="myFunction(this)"'
                        . 'onmousedown="mouseDown(this)" onmouseup="mouseUp(this)"'
                        . 'ondragover="allowDrop(event)"> <br>'
                  . $pdf_array[$curr_page][$p]
                  . '<div class="dddA" id="aid" data-id="A'.$id.'" '
                        . 'onclick="myFunction(this)"'
                        . 'contenteditable="true"> Answer div </div>'
                  . '<br> </div> <br>';
                $p++;
            }
        }
        
        
//            //Print 2d array
//            foreach ($pdf_array as $id){                    
//                    
//                foreach($id as $key => $val){
//                    echo $val;
//                }
//
//            }
        
echo '</div>';

###
### To save data
###

echo '<div>
        <form method="post">
            <input value="Save" type="submit" name="save_data"/>
        </form>
    </div>';


if(isset($_POST['save_data'])){
    echo 'YYESSS <br>';
    //Call fileedit controller. send it 
    $obj = new savefileController($pdf_array, $filename, $pages_count);
    // echo "Print :".$obj->display();
    $pdf_array = $obj->save_in_db();
}

//echo '<div>';
//  
//    echo 'second';
//        $path = "../uploads/".$filename;
//            
//        $command = "test.py $path";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';


//echo '<div>';
//       echo 'third '  ;   
//        $command = "tt.py";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';
?>