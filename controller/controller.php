<?php

include_once("model/model.php");  
      
class Controller {  
    public $model;   
      
    public function __construct()    
    {    
        $this->model = new Model();  
    }   
     
    /**
     * Return List of saved and uploaded {@link File()}
     */
    public function invoke()  
    {   
        /**
         * Return list of uploaded files
         */
        $filesNew = $this->model->getFileList();
        /**
         * Return list of saved files
         */
        $filesSaved = $this->model->getFileListSaved();
        
        /**
         * Return list of courses
         */
        $coursesList = $this->model->getCategories();
        
        include 'view/filelist.php';
        
    }  
}  