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

    /**
    * For Uploaded Files
    * 
    * Get data out of PDF file
    * using Python project pdfminer
    */


    //set maximum execution time to 5 min (from 30 seconds default)
    ini_set('max_execution_time', 300);

    $filename = $_SESSION['filename'];

    $path = "../uploads/".$filename;
    //$command = "i.py $path";
    $command = "itest.py $path $filename";

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
    
    
if(strlen($big_string) > 0){
    require_once('setFileObectUploadedPDF.php');

    //Call fileedit controller. send it 
    $obj = new setFileObectUploadedPDF($big_string);
    //print_r($obj);
    $pdf_object_array = $obj->display();
    $_SESSION['obj_pages_upload'] = serialize($pdf_object_array);

    //How many pages (start from 0)
    $_SESSION['pages_count'] = count($pdf_object_array);

    $_SESSION['cur_page'] = 0;
}
