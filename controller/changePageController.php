<?php
session_start();

/**
 * Coment me!
 */

$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
$direction = $_POST['direction'];

/**
 * Change page NEXT or PRE
 */
if($direction != ''){
    //Change page session variable
    if($direction === 'next'){
        $_SESSION['cur_page'] = $cur_page+1;
        print $_SESSION['cur_page'];
    }
    elseif($direction === 'pre'){
        $_SESSION['cur_page'] = $cur_page-1;
        print $_SESSION['cur_page'];
    }
}