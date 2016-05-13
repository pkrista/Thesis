<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$cur_page = $_SESSION['cur_page'];
$pdf_array = $_SESSION['pdf_array'];
$direction = $_POST['direction'];

//Dont need 13.05
if(isset($_POST['page'])){
    $pageArray = $_POST['page'];
    
    //If exercises were changed then change also in session pdf array
    for($i=0;$i<(count($pageArray));$i++){
        for($e=0;$e<(count($pdf_array[$cur_page]));$e++){
            if($pdf_array[$cur_page][$e][2]==$pageArray[$i][0]){
                
                echo 'Ex';
                print_r($pageArray[$i][1]);
                echo 'End';
                $result;
                preg_match('/\s*(.*)<div.*id=\"aid\"/', $pageArray[$i][1], $result);
                
                $_SESSION['pdf_array'][$cur_page][$e][3] = $result[1];//$pageArray[$i][1];
                $_SESSION['pdf_array'][$cur_page][$e][4] = $pageArray[$i][2];
                $_SESSION['pdf_array'][$cur_page][$e][5] = $pageArray[$i][3];
                $_SESSION['pdf_array'][$cur_page][$e][6] = 'true';
            
                echo 'Changed';
            }
        }
    }
}
//dont need 13.05
if(isset($_POST['pageinfo'])){
    $pageInfoName = $_POST['pageinfo'];
    
    //If the name of the page were changed then change it also in the session variable pdf array
    $e=0;
    while(isset($pdf_array[$cur_page][$e])){
        $pdf_array[$cur_page][$e][1] = $pageInfoName;
        $e++;
    }
    
}

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



//change changed values in the session variable pdf_array

print_r($_SESSION['pdf_array']);
