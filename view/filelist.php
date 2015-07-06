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
    
    <!-- Google web fonts -->
    <link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />
    <!-- The main CSS file -->
    <link href="assets/css/style.css" rel="stylesheet" />

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
<!--            <div class="large-4 medium-4 columns" id="fileupload">
                <div class="panel">
                    <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data" >
                        <input type="file" name="file" id=”file” />
                        <input type="submit" name="submit" value="Submit" class="tiny button"/>
                    </form>
                </div>
            </div>-->
            <div class="large-4 medium-4 columns" id="fileupload">
                <form class="panel" id="upload" method="post" action="controller/upload.php" 
                      enctype="multipart/form-data" style=" padding:30px;">
                        <div class="callout panel" id="drop">
                                Drop Here
                                <a class="tiny button" style="margin-top:12px;">Browse</a>
                                <input type="file" name="upl" multiple/>
                        </div>
                        <ul>
                                <!-- The file uploads will be shown here -->
                        </ul>
                </form>
            </div>
        </div>
    </div>


<!--Mini AJAX from-->
<!--Form tacken from http://tutorialzine.com/2013/05/mini-ajax-file-upload-form/ --> 
    <!-- JavaScript Includes -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/js/jquery.knob.js"></script>

    <!-- jQuery File Upload Dependencies -->
    <script src="assets/js/jquery.ui.widget.js"></script>
    <script src="assets/js/jquery.iframe-transport.js"></script>
    <script src="assets/js/jquery.fileupload.js"></script>

    <!-- Our main JS file -->
    <script src="assets/js/script.js"></script>
