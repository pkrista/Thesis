<?php

/* 
 * 
 */

#http://php.net/manual/en/features.file-upload.post-method.php
#http://www.w3schools.com/php/php_file_upload.asp




$my_folder = "C:/xampp/htdocs/ThesisProject/uploads/";

if($_FILES["file"]["tmp_name"] && $_FILES["file"]["error"] === 0){
    
    copy($_FILES["file"]["tmp_name"],$my_folder.$_FILES["file"]["name"]);
    
    $countFiles = 0;
    include_once '../config/theasisDB.php';
    $db = new theasisDB();
    $sql = "SELECT * FROM File WHERE Name='".$_FILES["file"]["name"]."'";
    foreach ($db->query($sql) as $row)
    {
        $countFiles++;
    }
    if($countFiles==0){
        $date = date('Y-m-d H:i:s');
        $sqlInsertFile = "INSERT INTO File(Name) VALUES ('".$_FILES["file"]["name"]." ')";
        if ($db->query($sqlInsertFile)) {
            echo "New record created successfully";
        } else {
            echo "Error while uploading file";
        }
    }
    else{
        echo "File already exist";
    }
    redirect();
}
else{
    echo "Error uploading file.";
    redirect();
}
 
/**
 * Function redirects back to main page
 * @param type $status_code (302 Found)
 */
function redirect($status_code = 302)
{
   header('Location: http://localhost/ThesisProject/', TRUE, $status_code);
   die();
}