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
<link rel="stylesheet" href="css/filelist.css" type="text/css"> 

<div class="filesListandupload" id="filesListandupload"> 
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
      
                foreach ($files as $title => $file)  
                {  
                    echo '<tr><td><a href="view/fileedit.php?name='.$file->title.'">'
                            .$file->title.'</a></td><td>'.$file->author.'</td><td>'
                            .$file->date.'</td></tr>';  
                   
                }  
                
                foreach ($files as $title => $file)  
                {  
                    
                    echo '<tr><td><a onclick="setExerciseSeperator(\''.$file->title.'\')">'
                            .$file->title.'</a></td><td>'.$file->author.'</td><td>'
                            .$file->date.'</td></tr>';
                   
                }
                
            ?>  
                <button onclick="setExerciseSeperator()">Try it</button>
        </table> 
    </div>
    <div class="fileupload" id="fileupload">
        <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id=”file” />
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div> 
    
<!--    		<div>
		<select class="element select medium" id="element_3" name="element_3"> 
			<option value="" selected="selected"></option>
                                <option value="1" >Exercise</option>
                                <option value="2" >Oefening</option>
                                <option value="3" >Task</option>
                                <option value="4" >Taak</option>

		</select>
		</div> -->
</div>