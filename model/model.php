<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    include_once'model/file.php'; 
    include_once 'config/database.php';
    
    class Model { 
//        protected $db;
        
        function __construct() {
            //start connection
            $db = new database();
         
//            //select data from db
//            $stmt = $db->prepare("select * from course");
//            print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
//            
//            print $result;
            
                $sql = "SELECT * FROM course";
                foreach ($db->query($sql) as $row)
                    {
                    echo $row["ID"] ." - ". $row["Name"] ."<br/>";
                    }

        }
        
        public function getFileList()
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
                    $date = date("M/D/Y", $fileinfo->getMTime());
                    $isreadable = $fileinfo->isReadable();
                    $arr[] = new File($name, $date, $isreadable);
                }
            }
            #http://php.net/manual/en/language.types.array.php
            return $arr;

            
        }  
         

            


//        public function getBook($title)  
//        {  
//            // we use the previous function to get all the books and then we return the requested one.  
//            // in a real life scenario this will be done through a db select command  
//            $allBooks = $this->getBookList();  
//            return $allBooks[$title];  
//        }  
          
          
    } 