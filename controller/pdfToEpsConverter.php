<?php
session_start();

//set maximum execution time to 5 min (from 30 seconds default)
ini_set('max_execution_time', 300);

$title = $_POST['fileTitle'];
$EPSpath = $_SESSION['eps_dir'];

$pdf_file = '../uploads/'.$title;

//make sure that apache has permissions to write in this folder! (common problem)
$save_to_jpg  = $EPSpath.'/'.$title.'.jpg';
$save_to_eps  = $EPSpath.'/'.$title.'.eps';

/**
 * Find a number of pages in PDF file
 */
exec('identify  '.$pdf_file, $IdentofyOutput);

/**
 * Convert images
 */
exec('convert -density 250  -unsharp 10x4+1+0 '.$pdf_file.' '.$save_to_eps, $output, $return_var);
//exec('convert -density 250 -resize 2480x3508 '.$pdf_file.' '.$save_to_eps, $output, $return_var);

        //exec('convert -density 250 -quality 100  -unsharp 10x4+1+0 '.$pdf_file .' '.$save_to_eps, $output, $return_var);
        //exec('composite -gravity South footbtn.png  -quality 100 -density 250 ../files/d15.eps ../files/result14.eps');

/**
 * Get saved files in list
 * http://php.net/manual/en/function.scandir.php
 */
$dh  = opendir($EPSpath);
while (false !== ($filename = readdir($dh))) {
    if(preg_match('/'.$title.'/',$filename)){
         $files[] = $filename;
    }
}
closedir($EPSpath);
/**
 * Add footer to each page
 */
foreach ($files as $name) {
    exec('composite -gravity South footbtn.png -density 250 tmp/'.$name.' tmp/'.$name);
}


/**
 * Make archive
 * http://php.net/manual/en/ziparchive.addfile.php
 */
$name = substr($title,0,-4).'.zip';
$zipname = $EPSpath.'/'.$name;

/**
 * Crate archve of zipped files
 */
$zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($files as $file) {
        $zip->addFile($EPSpath.'/'.$file, $file);
    }   
    $zip->close();
    
/**
 * Download zip file to user directory
 * http://stackoverflow.com/questions/1754352/download-multiple-files-as-zip-in-php
 */   
/**
 * Get path and replace backslashe with forwardslashe
 */
$fileName = substr($_GET["fileTitle"], 0, -4);
$path = str_replace('\\', '/', getcwd());
$path = $path.'/'.$EPSpath.'/'.$fileName.'.zip';

    header('Content-type: application/zip');
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-length: " . filesize($path));
    header("Pragma: no-cache");
    header("Expires: 0");
    ob_clean();
    flush();
    readfile($path);
    exit;  
?>
