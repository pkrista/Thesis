<?php

/* 
 * 
 * 
 * 
 */
//include_once("controller/pdf.php");
?>
<head>
    <!--import jQuery for calling AJAX in javascript file-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/filelist.js"></script>
    
</head>

<!--link to css-->
<link rel="stylesheet" href="css/foundation.css" type="text/css"> 

    <div class="row">
        <div id="filesListandupload">
        <div class="large-8 medium-8 columns" > 
            <div class="filelist" id="filelist">
                <table>  
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>Author</td>
                            <td>Description</td>
                        </tr>
                    </tbody>  
                    <?php   

//                        foreach ($files as $title => $file)  
//                        {  
//                            echo '<tr><td><a href="view/fileedit.php?name='.$file->title.'">'
//                                    .$file->title.'</a></td><td>'.$file->author.'</td><td>'
//                                    .$file->date.'</td></tr>';  
//
//                        }  

                        foreach ($files as $title => $file)  
                        {  

                            echo '<tr><td><a onclick="setExerciseSeperator(\''.$file->title.'\')">'
                                    .$file->title.'</a></td><td>'.$file->author.'</td><td>'
                                    .$file->date.'</td></tr>';

                        }
                    ?>  
                </table> 
                
            </div>
            
            </div> 
            <div class="large-4 medium-4 columns" id="fileupload">
                <div class="panel">
                    <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data" >
                        <input type="file" name="file" id=”file” />
                        <input type="submit" name="submit" value="Submit" class="tiny button"/>
                    </form>
                </div>
            </div> 
        </div>
    </div>

