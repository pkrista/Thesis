<?php

//include_once '../config/theasisDB.php';
//$db = new theasisDB();
//$countFiles = 0;
//$sql = "SELECT * FROM file WHERE Name='".$_FILES['upl']['name']."' ";
//    foreach ($db->query($sql) as $row)
//    {
//        $countFiles++;
//    }


// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip', 'pdf');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$_FILES['upl']['name'])){
		echo '{"status":"sucess"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;