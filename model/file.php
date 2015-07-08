<?php

//Things to store about 
    class File {  
        public $title;   
        public $date; 
        public $id;
          
        public function __construct($title, $date, $id)    
        {    
            $this->title = $title;  
            $this->date = $date;  
            $this->id = $id;
        }   
    }  