<?php

/* 
 * Get data out of PDF file
 * using Python project pdfminer
 */

require_once('../controller/fileeditController.php');

$filename = $_SESSION['filename'];

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

//return $pdf_arrayy;

//Set session variable (2d array)
$_SESSION['pdf_array'] = $pdf_array;

$_SESSION['pages_count'] = $pages_count;

$_SESSION['cur_page'] = 0;