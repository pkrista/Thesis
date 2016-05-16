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

