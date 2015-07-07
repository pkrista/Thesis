<?php 
session_start(); 
 unset($_SESSION['exSeperator']);
 unset($_SESSION['filename']);
 unset($_SESSION['direction']);

/* 
 * 
 * 
 * 
 */    

$fileName = $_POST['fName'];
$exerSeperator = $_POST['exSep'];
    
    //$pdf_array = $_SESSION['pdf_array'];
    //$pages_count = $_SESSION['pages_count'];
//    $_SESSION['cur_page'] = 0;
//    $cur_page = $_SESSION['cur_page'];
    //$_SESSION['filename'] = $_GET['name'];
    
$_SESSION['print']='combined';
$_SESSION['direction']='next';
    
    //From filelist.php when the file is open
$_SESSION['filename'] = $_POST['fName'];
$_SESSION['exSeperator']= $_POST['exSep'];

?>
<!--<head>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js/one.js" type="text/javascript"></script>
</head>-->

<link rel="stylesheet" href="css/foundation.css" type="text/css">


<?php
  
    //file name
    echo "File name: ".$fileName."\n";

    //set maximum execution time to 5 min (from 30 seconds default)
    ini_set('max_execution_time', 300);

    include_once('../controller/getbiglistController.php');
        
//echo '<div id="divi" class="large-12 columns">';
//echo '<div class="panel">';
//    $pdf_array = $_SESSION['pdf_array'];
//    $cur_page = $_SESSION['cur_page'];
//    $filename = $_GET['name'];

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
////        func1('Hello', 'world');
//        
//        //Call fileedit controller. send it 
//        $obj = new fileeditController($big_string);
////        echo "Print :".$obj->display();
//        $pdf_array = $obj->display();
//       
//        //How many pages (start from 0)
//        $pages_count = substr_count($big_string, '**NEWPAGE**');
        
//    $curr_page = 0;
//        
//        //For getting page number
//        if(!isset($_GET['page'])) { 
//            //If the page is first one then allow just go to next page
//            $cur_page = 0;
//            $next_page = 1;
//            echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
//        } 
//        else { 
//            $curr_page = $_GET['page'];
//            $pre_page = $_GET['page']-1; 
//            $next_page = $_GET['page']+1;  
//            
//            $ar = array("one", "Two");
//            //test
//            
//            
//            if($curr_page > 0 && $curr_page != $pages_count){
//                //If the current page is not the last one and the first one
//                echo "<a href='?name=$filename&page=$pre_page' ><<<</a> "; 
//                echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
////                echo count($pdf_array[$curr_page-1]);
//                echo "11<br>";
////                print_r($pdf_array[$curr_page-1]) ;
//                echo "22<br> ";
////                $pdf_array[$curr_page-1] = array_splice($pdf_array[$curr_page-1], 4);
//                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
//                echo "33<br>";
////                echo count($pdf_array[$curr_page-1]);
////                print_r($pdf_array[$curr_page-1]) ;
//
//            }
//            elseif ($curr_page > 0 && $curr_page == $pages_count) {
//                //If current page is the last one
//                echo "<a href='?name=$filename&page=$pre_page' onclick='loadXMLDoc()'><<<</a> <br>"; 
////                echo count($pdf_array[$curr_page-1]);
//                echo "111<br>";
////                print_r($pdf_array[$curr_page-1]) ;
//                echo "222<br>";
////                $pdf_array[$curr_page-1] = array_splice($pdf_array[$curr_page-1], 4);
//                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
//                echo "33<br> <br>";
////                echo count($pdf_array[$curr_page-1]);
////                print_r($pdf_array[$curr_page-1]) ;
//                
//                print_r(array_replace($pdf_array[$curr_page-1],array_splice($pdf_array[$curr_page-1], 4)));
//                echo "44<br> <br>";
//            }
//            else{
//                echo "<a href='?name=$filename&page=$next_page' onclick='loadXMLDoc()'>>>></a> <br>";
//            }
//        }
//        
        
//        //Print page by page
//        $p=0;
//        while(!empty($_SESSION['pdf_array'][$_SESSION['cur_page']][$p]) ){ 
//            $id = $p.'_'.$_SESSION['cur_page'].'_'.$_SESSION['filename'];
//            
//            if((substr_count($_SESSION['pdf_array'][$_SESSION['cur_page']][$p], '<img src='))>0){
//                echo $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
//                . ' data-id ="P'.$id.'" onclick="myFunction(this)"'
//                . ' draggable="true" ondragstart="drag(event)"'
//                        . 'class="dddP" id="pid" />';
//                $p++;
//            }
//            else{
//                echo '<div class="ddd" id="qid" data-id="Q'.$id.'" '
//                        . 'contenteditable="true" id="I'.$p.'" '
//                        . 'onclick="myFunction(this)"'
//                        . 'ondragenter="dragEnter(event, this)" ondragleave="dragLeave(event)"'
//                        . 'ondrop="drop(event)" ondragover="allowDrop(event)"> '
//
//                  . $_SESSION['pdf_array'][$_SESSION['cur_page']][$p]
//                  . '<div class="dddA" id="aid" data-id="A'.$id.'" '
//                        . 'onclick="myFunction(this)"'
//                        . 'contenteditable="true"> Answer div </div>'
//                        . '<div id="div1" class="dddI" '
////                        . 'ondrop="drop(event)" ondragover="allowDrop(event)"'
//                            . 'ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"'
//                            . '></div>'
//                        . '</div> <br>';
//                $p++;
//            }
//        }
        
 

//// To change pages
//
//if($_SESSION['cur_page'] == 0 && $_SESSION['cur_page'] < $pages_count){
//    echo '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
//}
//if($_SESSION['cur_page'] !=0 && $_SESSION['cur_page'] < $pages_count){
//    echo '<button type="submit" id="but" onclick= "return prePage()" > << </button> '
//    . '<button type="submit" id="but" onclick= "return nextPage()" > >> </button> ';
//}
//if($_SESSION['cur_page'] == $pages_count){
//    echo '<button type="submit" id="but" onclick= "return prePage()" > >> </button> ';
//}
//
//include_once('../controller/printdivController.php');
//echo '</div>';

###
### To save data
###

//echo '<button type="submit" class="btnSave" id="btnSave" onclick= "return saveData()" > Save </button> ';
//echo '</div>';
?>
