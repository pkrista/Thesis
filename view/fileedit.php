<?php 
session_start(); 
 unset($_SESSION['exSeperator']);
 unset($_SESSION['filename']);
 unset($_SESSION['direction']);
 unset($_SESSION['pageinfo']);
 unset($_SESSION['fileId']);
 
 unset($_SESSION['pages_count']);
 unset($_SESSION['cur_page']);

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

$_SESSION['pageinfo'] = '';

?>

<link rel="stylesheet" href="css/foundation.css" type="text/css">


<?php
  
    //file name
    echo "File name: ".$fileName."\n";

    //set maximum execution time to 5 min (from 30 seconds default)
    ini_set('max_execution_time', 300);

    include_once('../controller/getbiglistController.php');
        
?>
