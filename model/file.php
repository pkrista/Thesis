<?php

//Things to store about 
    class File {  
        public $title;  
        public $author;  
        public $date;  
          
        public function __construct($title, $author, $date)    
        {    
            $this->title = $title;  
            $this->author = $author;  
            $this->date = $date;  
        }   
    }  