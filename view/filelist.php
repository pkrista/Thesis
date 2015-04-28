<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include_once("controller/pdf.php");

?>
<head>
<script></script>   
</head>


<!--link to css-->
<link rel="stylesheet" href="css/filelist.css" type="text/css"> 

<div class="filesListandupload" id="filesListandupload"> 
    <div class="filelist" id="filelist">
        <table>  
            <tbody><tr><td>Title</td><td>Author</td><td>Description</td></tr></tbody>  
            <?php   
      
                foreach ($files as $title => $file)  
                {  
                    echo '<tr><td><a href="view/fileedit.php?name='.$file->title.'">'.$file->title.'</a></td><td>'.$file->author.'</td><td>'.$file->date.'</td></tr>';  
                   
                }  
      
            ?>  
        </table> 
    </div>
    <div class="fileupload" id="fileupload">
        
        <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id=”file” />
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
    <br/>
<!--    <div>
        <textarea id="1" rows="20" cols="100">
         <?php 
            #http://bytes.com/topic/python/answers/801623-calling-python-code-inside-php
            #http://blog.idealmind.com.br/desenvolvimento-web/php/how-to-execute-python-script-from-php-and-show-output-on-browser/
         
//            $path = "uploads/sessionSimonSays.pdf";
//            $command = "codePY.py $path";
//            $pid = popen($command,"r");
// 
//            while( !feof( $pid ) )
//            {
//             echo fread($pid, 256);
//             flush();
//             ob_flush();
//             usleep(100000);
//            }
//            pclose($pid);
         ?> 
        </textarea>
    </div>-->
    
</div>