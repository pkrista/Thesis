<?php 
session_start();

/* 
 * This file is called from javascript when pages are changes
 * the content of current page are saved and next page is opened
 * 
 */


$pageArray = $_POST['page'];
$direction = $_POST['direction'];

 
$cur_page = $_SESSION['cur_page'];


if(!$pageArray){
    print 'Empty';
    
}
else{
    //replace array with array
    array_splice($_SESSION['pdf_array'][$cur_page], 0, count($_SESSION['pdf_array'][$cur_page])-count($pageArray));
   
    $p = count($_SESSION['pdf_array'][$cur_page]);
    $i = 0;
    while($i<$p){
        $_SESSION['pdf_array'][$cur_page][$i] = $pageArray[$i];
        $i++;
    }
    
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

