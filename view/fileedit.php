<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../controller/fileeditController.php');

//file name
$filename = $_GET['name']; 
echo "File name: ".$filename."\n";

//set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);

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
        
        //Print 2d array
        foreach ($pdf_array as $id){
            echo '</br> NEW page </br>';
            foreach($id as $key => $val){
                echo '</br> </br>'.$val;
            }
        }
        
        
echo '</div>';
