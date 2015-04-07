<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../controller/savefileController.php');
require_once('../controller/fileeditController.php');

//file name
$filename = $_GET['name']; 
echo "File name: ".$filename."\n";
//set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);


//Chack 
?>

<!--link to css-->
<link rel="stylesheet" href="../css/fileedit.css" type="text/css"> 

<!--<div >
    <textarea id="1" rows="10" cols="100" class="filedisplay" id="filedisplay">
-->         <?php 
            #http://bytes.com/topic/python/answers/801623-calling-python-code-inside-php
//            #http://blog.idealmind.com.br/desenvolvimento-web/php/how-to-execute-python-script-from-php-and-show-output-on-browser/
//               
//            
//            $path = "../uploads/".$filename;
//            
//            $command = "hi.py $path";
//         
//            $pid = popen($command,"r");
// 
//
//            
//            while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000); //milions os a second
//            }
//            pclose($pid);

         ?> <!--
    </textarea>
</div>-->

<!--test-->

<?php
//echo '<div>';
//  
//    echo 'second';
//        $path = "../uploads/".$filename;
//            
//        $command = "test.py $path";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';


//echo '<div>';
//       echo 'third '  ;   
//        $command = "tt.py";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';

echo '<div id="divi" class="divi">';
        
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
        
        
        //For getting page number
        if(isset($_GET['page'])) { 
            $curr_page = $_GET['page'];
            $pre_page = $_GET['page']-1; 
            $next_page = $_GET['page']+1;  
            if($curr_page > 0 && $curr_page != $pages_count){
                //If the current page is not the last one and the first one
                echo "<a href='?name=$filename&page=$pre_page' ><<<</a> "; 
                echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
            }
            elseif ($curr_page > 0 && $curr_page == $pages_count) {
                //If current page is the last one
                echo "<a href='?name=$filename&page=$pre_page' ><<<</a> <br>"; 
            }
            else{
                echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
            }
        } 
        else { 
            //If the page is first one then allow just go to next page
            $curr_page = 0;
            $next_page = 1; 
            
            echo "<a href='?name=$filename&page=$next_page' >>>></a> <br>";
        }
        

        
        //Print page by page
        $p=0;
        while(!empty($pdf_array[$curr_page][$p]) ){ 
           echo '<br> <div class="ddd"> <br>'
             . $pdf_array[$curr_page][$p]
             . '<div class="dddA" contenteditable="true"> Answer div </div>'
             . '<br> </div> <br>';
           $p++;
        }
        
        
//            //Print 2d array
//            foreach ($pdf_array as $id){                    
//                    
//                foreach($id as $key => $val){
//                    echo $val;
//                }
//
//            }
        
echo '</div>';

?>

<div>
    <form method="post">
    <input value="Save" type="submit" name="save_data"/>
    </form>
</div>
<?php


if($_GET){
    if(isset($_GET['save_data'])){
        echo 'ONE';
    }
}


if(isset($_POST['save_data'])){
    echo 'YYESSS <br>';
    //Call fileedit controller. send it 
    $obj = new savefileController($pdf_array, $filename, $pages_count);
    // echo "Print :".$obj->display();
    $pdf_array = $obj->save_in_db();
}
?>