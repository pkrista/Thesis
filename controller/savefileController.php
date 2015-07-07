<?php
session_start(); 
/* 
 * 
 * 
 * 
 */

include_once '../config/theasisDB.php';
$filename = $_SESSION['filename'];
$pdf_arrey = $_SESSION['pdf_array'];
$page_nr = 0;
$pages = count($pdf_arrey, 0);

print_r($pdf_arrey);
echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';



for($p=0;$p<$pages;$p++){ //Page $p

   $pageInfo = array();
   array_push($pageInfo, $p, $p+1);
    
    $exeCountInPage = count($pdf_arrey[$p]);
    for($object=0;$object<$exeCountInPage;$object++){
     

        //Array tp store all exercises details
        //[0] - PagePen
        //[1] - PagePaper
        //[2] - number
        //[3] - question
        //[4] - answer
        //[5] - explanation
        //[6..] - images
        $exercise = array();
        
        $output = NULL;
        preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>/", $pdf_arrey[$p][$object], $output);
        if($output != NULL){
            echo '<br/> YES';
            preg_match("/^\s{0,}<a(.*?)>(.*?)<\/a>\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
            array_push($exercise, $p, $p+1, $object, $object+1, $QA[3], $QA[5]);
            
            
            //check images and add them to exercise
            $img = NULL;
            $elem = $object; $elem++;
            preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
            
            while($img != NULL){
                $object = $elem;
                array_push($exercise, $pdf_arrey[$p][$elem]);
                $elem++;
                
                $img = NULL;
                if($elem < $exeCountInPage){
                    preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
                }
            }
           
            print_r($exercise);
        }
        else{
            $renew = substr_count($pdf_arrey[$p][$object], '**RENEW**');
            $img = substr_count($pdf_arrey[$p][$object], '<img src=');
            if($renew == 0 && $img == 0){
                echo '<br/> NO';
//              preg_match("/^\s{0,}(.*)<div id=\"aid\"(.*)>\s{0,}(.*)<\/div><div/", $pdf_arrey[$p][$object], $QA); //[3] - question [5] - answer
                array_push($exercise, $p, $p+1, $object, $object+1, $pdf_arrey[$p][$object], '');
            
                //check images and add them to exercise
                $img = NULL;
                $elem = $object; $elem++;
                preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);

                while($img != NULL){
                    $object = $elem;
                    array_push($exercise, $pdf_arrey[$p][$elem]);
                    $elem++;

                    $img = NULL;
                    if($elem < $exeCountInPage){
                        preg_match("/^\s{0,}<img src=(.*)/", $pdf_arrey[$p][$elem], $img);
                    }


                }
                
                print_r($exercise);
                //check images
            }

        }
    }
}

function getImages(){
    
}
    
function generateQuery($page_nr, $object){
    
//    print $object;
    print '____';
    
    $answMatch = array();
    $questMatch = array();
    $imgMatch = array();
    preg_match_all('/(.*?)<div class="dddA"[^>]*>(.*?)</div>/', $object, $answMatch);
//    preg_match_all('#(.*?)<<div class="dddA"[^>]*>#', $object, $questMatch);
//    preg_match_all('#(.*?)<<div class="dddA"[^>]*>#', $object, $questMatch);
    print_r($answMatch);
//    print_r($questMatch);
    
    
    preg_match_all('#<div class="dddA" id="aid"[^>]*>(.*?)</div>#', $object, $matches);
    
}

    function save_in_db(){
        $bstring = $this->big_string;
         
                 //Print page by page
        $p=0;
        $curr_page = 0;
        while(!empty($bstring[$curr_page][$p]) ){ 
            $p=0;
            while(!empty($bstring[$curr_page][$p]) ){ 
               echo '<br> <div class="ddd"> <br>'
                 . $bstring[$curr_page][$p]
                 . '<div class="dddA" contenteditable="true"> Answer div </div>'
                 . '<br> </div> <br>';
               $p++;
            }
        $p=0;
        $curr_page++;
        }
        
        
            $db = new theasisDB();
            $sql = "SELECT * FROM course";
            foreach ($db->query($sql) as $row)
                {
                echo $row["course_id"] ." - ". $row["name"] ."<br/>";
                }
                
            $sql1 = "SELECT * FROM file";
            foreach ($db->query($sql1) as $row)
                {
                echo $row["file_id"] ." - ". $row["name"] ."<br/>";
                }
    
    print 'TTT';
    }
    
    ###
    ### Generate inserts and insert data into database
    ###
    
    // 1 - insert into db when upload file
    //