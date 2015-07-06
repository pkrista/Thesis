<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

#http://php.net/manual/en/features.file-upload.post-method.php
#http://www.w3schools.com/php/php_file_upload.asp

include_once '../config/theasisDB.php';

$my_folder = "C:/xampp/htdocs/ThesisProject/uploads/";

if($_FILES["file"]["tmp_name"] != null){
    copy($_FILES["file"]["tmp_name"],$my_folder.$_FILES["file"]["name"]);
    
    echo "File uploaded.";
    
    $db = new theasisDB();
    $sql = "SELECT * FROM Course";
    foreach ($db->query($sql) as $row)
    {
        echo $row["Course_ID"] ." - ". $row["Name"] ."<br/>";
    }
    
    $sqlInsertFile = "INSERT INTO File(Name) VALUES ('".$_FILES["file"]["name"]."')";
    if ($db->query($sqlInsertFile)) {
        echo "New record created successfully";
    } else {
        echo "Error while uploading file";
    }
    
    
    
}
else
    echo "Error uploading file.";
