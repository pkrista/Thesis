<?php

/* 
 * This class return 2 lists of files (upoaded, saved) 
 * as well as the courses and categories
 */

    include_once'model/file.php'; 
    
    class Model { 
        
        private $db;
        
        function __construct() {
            include_once 'config/theasisDB.php';
            $this->db = new theasisDB();
        }  
        
        /**
         * Returns the list of uploaded files
         * @return list
         */
        function getFileList(){
            $arrFile = [];
            $sql = "SELECT f.* from file f where f.File_ID NOT IN (SELECT p.File_ID from page p) ORDER BY f.date"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($this->db->query($sql) as $row){
                $name = $row['Name'];
                $date = date('F d, Y', strtotime($row['Date']));
                $id = $row['File_ID'];

                $arrFile[] = new File($name, $date, $id);
            }
            return $arrFile;
            
        }
        
        /**
         * Returns the list of saved files
         * @return list
         */
        function getFileListSaved(){
            $arrFile = [];
            $sql = "select DISTINCT file.* from file, page where file.File_ID = page.File_ID ORDER BY file.date"; //select DISTINCT file.* from file, page where file.File_ID != page.File_ID
            foreach ($this->db->query($sql) as $row){
                $name = $row['Name'];
                $date = date('F d, Y', strtotime($row['Date']));
                $id = $row['File_ID'];

                $arrFile[] = new File($name, $date, $id);
            }
            return $arrFile;
        }
        
        /**
         * Returns list of categories
         * @return list
         */
        function getCategories(){
            $sql = "select * from category";
            foreach ($this->db->query($sql) as $row){
                $id = $row['Category_ID'];
                $name = $row['Name'];

                $arrCategory[] = (object) array('name' => $name, 'id' => $id);
            }
            return $arrCategory;
        }
        
        /**
         * Returns list of courses
         * @return list
         */
        function getCourses(){
            $sql = "select * from course";
            foreach ($this->db->query($sql) as $row){
                $id = $row['Course_ID'];
                $name = $row['Name'];

                $arrCourse[] = (object) array('name' => $name, 'id' => $id);
            }
            return $arrCourse;
        }
    } 