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
    if(substr_count(end($_SESSION['pdf_array'][$cur_page]), '**RENEW**') >0){
        print_r('RENEW YES');
            //replace array with array
            array_splice($_SESSION['pdf_array'][$cur_page], 0, (count($_SESSION['pdf_array'][$cur_page])-count($pageArray)));
    
        $i = 0;
        while(!empty($_SESSION['pdf_array'][$cur_page][$i])){
            $_SESSION['pdf_array'][$cur_page][$i] = $pageArray[$i];
            $i++;
        }
    }
    else{
        print_r('RENEW NO');
        
//        $_SESSION['pdf_array'][$cur_page][0] = 'RENEW';
        //replace array with array
        array_splice($_SESSION['pdf_array'][$cur_page], 0, (count($_SESSION['pdf_array'][$cur_page])-count($pageArray)));
    
        $i = 0;
        while(!empty($_SESSION['pdf_array'][$cur_page][$i])){
            $_SESSION['pdf_array'][$cur_page][$i] = $pageArray[$i];
            $i++;
        }
        //Add last element to know that this array is changed
        array_push($_SESSION['pdf_array'][$cur_page], "**RENEW**");   
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

