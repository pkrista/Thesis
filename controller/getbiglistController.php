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
//        echo "Print :".$obj->display();
$pdf_array = $obj->display();

require_once('../controller/mergeExIFromPDFPYtoObjects.php');
//Call fileedit controller. send it 
$obj = new fileeditController($big_string);
//        echo "Print :".$obj->display();
$pdfObjectArrray = $obj->display();



//to test
//echo 'array';
//print_r($pdf_array);
//echo 'Big string';
//print_r($big_string);

//How many pages (start from 0)
$pages_count = substr_count($big_string, '**NEWPAGE**');


//Set session variable (2d array)
$_SESSION['pdf_array'] = $pdf_array;

$_SESSION['pages_count'] = $pages_count;

$_SESSION['cur_page'] = 0;

