<?php

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

//echo $big_string;

require_once('../controller/fileeditController.php');
//Call fileedit controller. send it 
$obj = new fileeditController($big_string);
$pdf_object_array = $obj->display();
print "Print fileeditController :";
print_r($pdf_object_array);
print "Print fileeditController : end";
$_SESSION['obj_pages_upload'] = serialize($pdf_object_array);

//How many pages (start from 0)
//$pages_count = substr_count($big_string, '**NEWPAGE**');
$_SESSION['pages_count'] = count($pdf_object_array);
//Set session variable (2d array)
//$_SESSION['pdf_array'] = $pdf_object_array;

//$_SESSION['pages_count'] = $pages_count;

$_SESSION['cur_page'] = 0;

//require_once('../controller/mergeExIFromPDFPYtoObjects.php');
////Call fileedit controller. send it 
//$obj = new mergeExIFromPDFPYtoObjects($big_string);
////echo "Print mergeExIFromPDFPYtoObjects :".$obj->display();
//$pdfObjectArrray = $obj->display();