<?php 
session_start(); 
 unset($_SESSION['exSeperator']);
 unset($_SESSION['filename']);
 unset($_SESSION['direction']);
 unset($_SESSION['fileId']);
 
 unset($_SESSION['con']);
 
 unset($_SESSION['pages_count']);
 unset($_SESSION['cur_page']);
 
 //DB object Session variable
 unset($_SESSION['obj_pages']);

/* 
 * 
 * 
 * 
 */    
 
$fileName = $_POST['fName'];
$exerSeperator = $_POST['exSep'];
$fileId = $_POST['fileId'];
    
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
$_SESSION['fileId'] = $_POST['fileId'];

$_SESSION['cur_page'] = 0;

?>

<link rel="stylesheet" href="css/foundation.css" type="text/css">


<?php
  
    //file name
    echo "File name: ".$fileName."\n";

    //set maximum execution time to 5 min (from 30 seconds default)
    ini_set('max_execution_time', 300);
        
    include_once('../controller/getbiglistController.php');

    require_once('../controller/setFileObectUploadedPDF.php');

    //Call fileedit controller. send it 
    $obj = new setFileObectUploadedPDF($big_string);
    $pdf_object_array = $obj->display();
    $_SESSION['obj_pages_upload'] = serialize($pdf_object_array);

    //How many pages (start from 0)
    $_SESSION['pages_count'] = count($pdf_object_array);

    $_SESSION['cur_page'] = 0;
?>
