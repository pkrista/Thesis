<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    include_once'model/file.php'; 
//    include_once 'config/database.php';
    
    class Model { 
//        protected $db;
        
        function __construct() {
            //start connection
//            $db = new database();
         
//            //select data from db
//            $stmt = $db->prepare("select * from course");
//            print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
//            
//            print $result;
//            
//                $sql = "SELECT * FROM course";
//                foreach ($db->query($sql) as $row)
//                    {
//                    echo $row["ID"] ." - ". $row["Name"] ."<br/>";
//                    }

        }
        
        public function getFileList12()
        {  
//            // here goes some hardcoded values to simulate the database  
//            return array(  
//                "First file" => new File("First file", "R. Kipling", "12.09.2014"),  
//                "Second file" => new File("Second file", "J. Walker", "03.03.2015"),  
//                "Third file" => new File("Rhird file", "Some Smart Guy", "02.02.2015"),
//            ); 
            
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
            
            $sql = "select DISTINCT file.* from file, page where file.File_ID != page.File_ID"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($db->query($sql) as $row)
                {
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
            
            $sql = "select DISTINCT file.* from file, page where file.File_ID = page.File_ID"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($db->query($sql) as $row)
                {
                    $name = $row['Name'];
                    $date = $row['Date'];
                    $id = $row['File_ID'];
                    
                    $arrFile[] = new File($name, $date, $id);
                }
                
                return $arrFile;
        }
          
    } 