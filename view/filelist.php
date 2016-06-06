<?php
$_SESSION['coursesList'] = $coursesList;
/* 
 * 
 * 
 * 
 */
?>

<!--import jQuery for calling AJAX in javascript file-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/filelist.js"></script>
<script type="text/javascript" src="js/convertEPS.js"></script>
<script type="text/javascript" src="js/dragDropMergeExercises.js"></script>

<script type="text/javascript" src="js/spin.js"></script>


<!--link to css-->
<link rel="stylesheet" href="css/foundation.css" type="text/css"> 

<div class="row">
    <div id="filesListandupload">
    <div class="large-8 medium-8 columns" > 
        <div class="filelist" id="filelist">

            <h5 class="subheader">Unsaved Files</h4>
            <table>  
                <tbody>
                    <tr>
                        <td>Title</td>
                        <td>Date</td>
                        <td>ID</td>
                    </tr>
                </tbody>  
                <?php   
                    /**
                     * Present in screen all files that are uploaded (not saved in the db)
                     */
                    foreach ($filesNew as $title => $file)  
                    {  

                        echo '<tr>'
                                . '<td><a onclick="setExerciseSeperator(\''.$file->title.'\',\''.$file->id.'\')">'
                                        .$file->title.'</a></td>'
                                . '<td>'.$file->date.'</td>'
                                . '<td>'.$file->id.'</td>'
                            . '</tr>';

                    }
                ?>  
            </table> 

            <h5 class="subheader">Saved Files</h5>
            <table>  
                <tbody>
                    <tr>
                        <td>Title</td>
                        <td>Date</td>
                        <td>ID</td>
                        <td>EPS</td>
                    </tr>
                </tbody>  
                <?php   
                /**
                 * Present in screen all saved files (saved in db)
                 */
                    foreach ($filesSaved as $title => $file)  
                    {  

                        echo '<tr>'
                                . '<td><a onclick="openSavedPDF(\''.$file->title.'\',\''.$file->id.'\')">'
                                        .$file->title.'</a></td>'
                                . '<td>'.$file->date.'</td>'
                                . '<td>'.$file->id.'</td>'
                                . '<td><a onclick="doMagic(\''.$file->title.'\')">EPS</a></td>'
                            . '</tr>';

                    }
                ?>  
            </table>

        </div>

        </div>               
        <!-- File upload form -->
        <div class="large-4 medium-4 columns" id="fileupload">
            <div class="panel" id="upload">
                <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data" >
                    <!--<a class="tiny button" style="margin-top:12px;">Browse</a>-->
                    <!--<input type="file" name="upl" multiple />-->
                    <input type="file" name="file" id=”file” />
                    <input type="submit" name="submit" value="Submit" class="tiny button"/>
                </form>
            </div>
        </div>

        <div class="large-4 medium-4 columns" id="folder">
            <div class="panel" id="upload">
                <?php
                    if (isset($_SESSION['eps_dir']))
                    {
                        echo 'See Converted <i>(EPS)</i> files here : </br>';
                        echo $_SESSION['eps_dir'];
                    }
                    else{
                        echo 'EPS images folder not created!';
                    }
                ?>
            </div>
        </div>

    </div>
</div>
