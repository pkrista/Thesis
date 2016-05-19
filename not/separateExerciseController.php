<?php

/* 
 * 
 */

/**
 * NEW 16.05.2016
 * @param type $pdf_object
 * @param type $exeSeparator
 * @return type new seperated exercises PDF object
 */
function seperateExercises($pdf_object, $exeSeparator){
    $seperateExercises_pdf = verifyExercisesInAllPages($pdf_object, $exeSeparator);
    return $seperateExercises_pdf;
}

function verifyExercisesInAllPages($pdf_object, $exeSeparator){
    $pages = count($pdf_object, 0);
    
    for($p=0;$p<$pages;$p++){ //$p page
        
        $exercisesInPage = count($pdf_object->getExercisesListObj());
        
        echo 'exercises in page = '.$exercisesInPage;
        
        for($e;$e<$exercisesInPage;$e++){ //$e exercise
            
        }
    }
}

/**
 * OLD 16.05.2016
*/
function test($pages_array, $exeSeparator){
    // Based on provided value I need to seperate exercse from exercise
    $arrayLongExeFix = exInOnePage($pages_array, $exeSeparator);
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
    //exOnTwoPages($pages_array, $exeSeparator, $pages);
    
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
                else if($e!=0){ //append exercises in one (from one page)
                    $newArrayString[$p][$exerNR-1] .= ' <br> ';
                    $newArrayString[$p][$exerNR-1] .= $pages_array[$p][$e];  
                }
                else{
                    //exercise started in previous page
                    $newArrayString[$p][$exerNR] = '**PREpage**'.$pages_array[$p][$e];
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
//                $output = array();
//                preg_match('/^'.$exeSeparator.'(_|.|\s{0,}|\w)\d{0,100}\s{0,}(.*)/i', $pages_array[$p][$e], $output);

                $output = getExerText($exeSeparator, $pages_array[$p][$e]);
                
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
