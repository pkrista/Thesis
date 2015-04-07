<?php

/* 
 * Connection to db
 */

class theasisDB extends PDO{
    
    public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=theasis', 'root', '', 
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        
        try {
            $conn = new PDO('mysql:host=localhost;dbname=theasis', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            print 'connected to db <br>';
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        
    }
}

