<?php
session_start();

$title = $_POST['title'];
$EPSpath = $_SESSION['eps_dir'];
$title = 'Joga.pdf';

print $title;

$pdf_file = '../uploads/'.$title;
print $pdf_file;

//make sure that apache has permissions to write in this folder! (common problem)
//$save_to_jpg  = '../uploads/'.$title.'.jpg';
//$save_to_eps  = '../uploads/'.$title.'.eps';

$save_to_jpg  = $EPSpath.'/'.$title.'.jpg';
$save_to_eps  = $EPSpath.'/'.$title.'.eps';

/**
 * Find a number of pages in PDF file
 */
exec('identify  '.$pdf_file, $IdentofyOutput);
print count($IdentofyOutput);

//foreach ($IdentofyOutput as $key => $value) {
    //print $pdf_file[$key];
    exec('convert -density 250 '.$pdf_file.' '.$save_to_jpg, $output, $return_var);
    exec('convert -density 250 '.$pdf_file.' '.$save_to_eps, $output, $return_var);
//}

if($return_var == 0) { //if exec successfuly converted pdf to jpg
    print "Conversion OK ";
    print $save_to_jpg;
    print_r($output);
}
else{ 
    print "Conversion failed.<br />";
    print_r($output);
}