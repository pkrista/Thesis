<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function test($pages_array, $exeSeparator){
    // Based on procided value I need to seperate exercse from exercise
    
    $arrayLongExeFix = exInOnePage($pages_array, $exeSeparator);
    
    print_r($pages_array);
    
    return $arrayLongExeFix;
}

/**
 * Function varifies if all exercises in one page are seperated correclty
 * based on the value that user set for exercise seperation
 *
 */
function exInOnePage($pages_array, $exeSeparator){
    
    $pages = count($pages_array, 0);
    
    $newArrayString = array();
    //To set marck to exercises that are in two pages
//    $newArrayString = exOnTwoPages($pages_array, $exeSeparator, $pages);
    
    for($p=0;$p<$pages;$p++){ //$p page
        $execountInPage = count($pages_array[$p]);
        $exerNR = 0;
        $e=0;
        for($e;$e<$execountInPage;$e++){ //$e exercise
            // cut the white spaces from the begining, if they are
            $pages_array[$p][$e] = ltrim($pages_array[$p][$e]);
            
            //check if it it fit the patern of exercise seperation value
            if(!substr_startswith($pages_array[$p][$e], $exeSeparator)){
//                echo 'No';
//                echo $pages_array[$p][$e];
                
                if((substr_count($pages_array[$p][$e], '<img src='))>0){
                    $newArrayString[$p][$exerNR] = $pages_array[$p][$e];
                    $exerNR++;
                }
                else if($e>0){
                    $exerText = $newArrayString[$p][$e-1];
                    $exerText = $exerText.'<br>'.$pages_array[$p][$e];
                    $newArrayString[$p][$exerNR-1] = $exerText;
                }
                else{
                    //exercise started in previous page
                    $newArrayString[$p][$exerNR] = $pages_array[$p][$e];
                    $exerNR++;
                }
            }
            /*
             * Combine exercises from multipla objects
             * Removes name exercise seperator and nr of exercise
             */
            else {
//                echo 'Yes';

                /* 
                 * This regex covers situations below
                 * excersise 23 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 * excersise 23Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc. 
                 * excersise23 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 * excersise:23 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 * excersise-23 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 * excersise_23 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 * excersise Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis efficitur nunc.
                 */
                $output = array();
                preg_match('/^'.$exeSeparator.'(_|.|\s{0,}|\w)\d{0,100}\s{0,}(.*)/i', $pages_array[$p][$e], $output);

//                $output = getExerText($exeSeparator, $pages_array[$p][$e]);
                
                // Check is exercise continius in this object or starts in next one
                if(strlen($output[2]) > 3){ //except seperator there is other text
                    $newArrayString[$p][$exerNR] = $output[2];
                    $exerNR++;
                }
                //check if next object is this exercise continuing or not
                else if(!substr_startswith($pages_array[$p][$e+1], $exeSeparator)){ 
                    //there was just separetor , so the exercise text is in next object
                    //To varify if this is not as well exercise next
                    $newArrayString[$p][$exerNR] = $pages_array[$p][$e+1];
                    $e++;
                    $exerNR++;
                }
            }  
        }
    }
    
    print_r($newArrayString);  
    
    return $newArrayString;
}

//More fast than regex
function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function getExerText($exeSeparator, $exercise){
    $output = array();
    preg_match('/^'.$exeSeparator.'(_|.|\s{0,}|\w)\d{0,100}\s{0,}(.*)/i', $exercise, $output);
    
    return $output;
}


/**
 * This function varifies if there is exercise that is on two pages
 * If yes it is made as one in one page
 * or something like that
 */
function exOnTwoPages($pages_array, $exeSeparator, $pages){
 
    for($p=1;$p<$pages;$p++){ //$p page
        //$p starts from 1 becouse I will check if the first exercise in all pages (except first)
        // starts with exercise seperator

        $e = 0;
        
        if($pages_array[$p][$e]){
            
        }
        
    }
    
    return $pages_array;
}