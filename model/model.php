<?php

/* 
 * 
 */

    include_once'model/file.php'; 
    
    class Model { 
        
        function __construct() {}
        
        public function getFileList12()
        { 
            
            #http://php.net/manual/en/class.directoryiterator.php       
            $dir    = 'C:/xampp/htdocs/ThesisProject/uploads/';           
            $iterator = new DirectoryIterator($dir);
            
            
            foreach ($iterator as $fileinfo) {
                
                if ($fileinfo->isFile()) {
                    $name = $fileinfo->getFilename();
                    $date = date("d/m/Y", $fileinfo->getMTime());
                    $isreadable = $fileinfo->isReadable();
                    $arr[] = new File($name, $date, $isreadable);
                }
            }
            
            selectAllFiles();
            
            #http://php.net/manual/en/language.types.array.php
            return $arr;

            
        }  
         
        function getFileList(){
            include_once 'config/theasisDB.php';
            $db = new theasisDB();
            
            $sql = "SELECT f.* from file f where f.File_ID NOT IN (SELECT p.File_ID from page p) ORDER BY f.date"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($db->query($sql) as $row){
                    $name = $row['Name'];
                    $date = $row['Date'];
                    $id = $row['File_ID'];
                    
                    $arrFile[] = new File($name, $date, $id);
                }
                
                return $arrFile;
            
        }
            
        function getFileListSaved(){
            include_once 'config/theasisDB.php';
            $db = new theasisDB();
            
            $sql = "select DISTINCT file.* from file, page where file.File_ID = page.File_ID ORDER BY file.date"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($db->query($sql) as $row){
                    $name = $row['Name'];
                    $date = $row['Date'];
                    $id = $row['File_ID'];
                    
                    $arrFile[] = new File($name, $date, $id);
                }
                
                return $arrFile;
        }
        
        function getCategories(){
            include_once 'config/theasisDB.php';
            $db = new theasisDB();
            
            $sql = "select * from course";
            foreach ($db->query($sql) as $row){
                    $id = $row['Course_ID'];
                    $name = $row['Name'];
                    
                    $arrCourse[] = (object) array('name' => $name, 'id' => $id);
                }
            
                return $arrCourse;
        }
          
    } 