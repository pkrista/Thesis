<?php
/* 
 * 
 * 
 * 
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
                    echo '<tr><td><a href="view/fileedit.php?name='.$file->title.'">'
                            .$file->title.'</a></td><td>'.$file->author.'</td><td>'
                            .$file->date.'</td></tr>';  
                   
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
</div>