<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

#http://php.net/manual/en/features.file-upload.post-method.php
#http://www.w3schools.com/php/php_file_upload.asp

$my_folder = "C:/xampp/htdocs/ThesisProject/uploads/";

if($_FILES["file"]["tmp_name"] != null){
    copy($_FILES["file"]["tmp_name"],$my_folder.$_FILES["file"]["name"]);

    echo "File uploaded.";
}
else
    echo "Error uploading file.";
