<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../controller/savefileController.php');
require_once('../controller/fileeditController.php');

?>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
//    var parnode = ev.target.parentNode;
    if(ev.target.id == 'pid'){
        ev.dataTransfer.effectAllowed='move';
        ev.target.style.opacity = "0.4";
//        ev.target.parentNode.style.opacity = "0.4";
//        ev.dataTransfer.setData("Text", ev.target.id); 
        var dt = ev.dataTransfer;
        dt.mozSetDataAt("image/png", stream, 0);
        dt.mozSetDataAt("application/x-moz-file", file, 0);
        dt.setData("Text", ev.target.id); 
        dt.setData("text/uri-list", imageurl);
        dt.setData("text/plain", imageurl);
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
//    var parnode = ev.target.parentNode;
    if(ev.target.id == 'pid'){
        ev.target.style.visibility='hidden';
     }
    
    
    
}

function drop(ev) {
    ev.target.style.background = "";
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
    

//    dragged.parentNode.removeChild( dragged );
//    ev.target.appendChild( dragged );
//    
//    
//   ev.target.style.border = "";
//   ev.preventDefault();
//   var data = ev.dataTransfer.getData('Text');
//   ev.target.appendChild(document.getElementById(data));
//   ev.stopPropagation();
}

function allowDrop(ev) {
    ev.preventDefault();
}

function dragEnter(event) {
    if ( event.target.className == "ddd" ) {
        event.target.style.border = "3px dotted red";
    }
}

function dragLeave(event) {
    if ( event.target.className == "ddd" ) {
        event.target.style.border = "";
    }
}

//
//test tes tes
//
function getalldataTosend(){
    var myDivUL = document.getElementById("divi").getElementsByTagName('div');
    for (var i = 0; i < myDivUL.length; i++) { 
        var status = myDivUL[i].getAttribute("data-id"); 
        console.log(status);
    }   
    console.log("______________");
    alert("Yo first");
    
    
    $('#divi').find("div").each(function( index ) {
        var element = $( this );
        if(element.is('div')){
           console.log( index + ": " + $( this ).attr('data-id'));
           console.log( index + ": " + $( this ).text()); 
        
            var $id = element.attr('class');
            console.log($id);
        }        
    });
}

</script>
</head>


<!-- tes tes tes -->
<button type="submit" id="but" onclick= "return getalldataTosend()"
        >Click Me!</button> 

<?php
        
//file name
$filename = $_GET['name']; 
echo "File name: ".$filename."\n";
//set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);

?>

<!--link to css-->
<link rel="stylesheet" href="../css/fileedit.css" type="text/css"> 

<!--<div >
    <textarea id="1" rows="10" cols="100" class="filedisplay" id="filedisplay">
-->         <?php 
            #http://bytes.com/topic/python/answers/801623-calling-python-code-inside-php
//            #http://blog.idealmind.com.br/desenvolvimento-web/php/how-to-execute-python-script-from-php-and-show-output-on-browser/

//            $path = "../uploads/".$filename;
//            $command = "hi.py $path";
//            $pid = popen($command,"r");

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
        
//        $path = "../uploads/".$filename;
//        $command = "i.py $path";
//         
//        $pid = popen($command,"r");
//
//        $big_string = '';
//
//        while( !feof( $pid ) )
//            {
//                $big_string .= fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//        
////        require_once('../controller/fileeditController.php');
////        func1('Hello', 'world');
//        
//        //Call fileedit controller. send it 
//        $obj = new fileeditController($big_string);
////        echo "Print :".$obj->display();
//        $pdf_array = $obj->display();
//       
//        //How many pages (start from 0)
//        $pages_count = substr_count($big_string, '**NEWPAGE**');
        
    include_once("../controller/getbiglistController.php"); 

    $curr_page = 0;
        
        //For getting page number
        if(!isset($_GET['page'])) { 
            //If the page is first one then allow just go to next page
            $curr_page = 0;
            $next_page = 1;
            echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
        } 
        else { 
            $curr_page = $_GET['page'];
            $pre_page = $_GET['page']-1; 
            $next_page = $_GET['page']+1;  
            
            $ar = array("one", "Two");
            //test
            
            
            if($curr_page > 0 && $curr_page != $pages_count){
                //If the current page is not the last one and the first one
                echo "<a href='?name=$filename&page=$pre_page' ><<<</a> "; 
                echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
//                echo count($pdf_array[$curr_page-1]);
                echo "11<br>";
//                print_r($pdf_array[$curr_page-1]) ;
                echo "22<br> ";
//                $pdf_array[$curr_page-1] = array_splice($pdf_array[$curr_page-1], 4);
                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
                echo "33<br>";
//                echo count($pdf_array[$curr_page-1]);
//                print_r($pdf_array[$curr_page-1]) ;

            }
            elseif ($curr_page > 0 && $curr_page == $pages_count) {
                //If current page is the last one
                echo "<a href='?name=$filename&page=$pre_page' onclick='loadXMLDoc()'><<<</a> <br>"; 
//                echo count($pdf_array[$curr_page-1]);
                echo "111<br>";
//                print_r($pdf_array[$curr_page-1]) ;
                echo "222<br>";
//                $pdf_array[$curr_page-1] = array_splice($pdf_array[$curr_page-1], 4);
                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
                echo "33<br> <br>";
//                echo count($pdf_array[$curr_page-1]);
//                print_r($pdf_array[$curr_page-1]) ;
                
                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
                echo "44<br> <br>";
            }
            else{
                echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
            }
        }
        
        echo "<div> Page number: ".$curr_page."</div>";
//        print_r($pdf_array);
        
        
        //Print page by page
        $p=0;
        while(!empty($pdf_array[$curr_page][$p]) ){ 
            $id = $p.'_'.$curr_page.'_'.$filename;
            
            if((substr_count($pdf_array[$curr_page][$p], '<img src='))>0){
//            if(startsWith($pdf_array[$curr_page][$p], '<img src=')){
                echo $pdf_array[$curr_page][$p]
                . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
                . 'ondragstart="dragStart(event)" ondragend="dragEnd(event)" '
                        . 'class="dddP" id="pid" />';
                $p++;
            }
            else{
                echo '<br> <div class="ddd" id="qid" data-id="Q'.$id.'" '
                        . 'contenteditable="true" id="I'.$p.' ondrop="drop(event)" '
                        . 'onclick="myFunction(this)"'
                        . 'ondragover="allowDrop(event)" '
                        . 'ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"> '
                        . '<br>'
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
?>