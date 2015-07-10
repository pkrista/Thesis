<?php

include_once("model/model.php");  
      
class Controller {  
    public $model;   
      
    public function __construct()    
    {    
        $this->model = new Model();  
    }   
          
    public function invoke()  
    {          
        $filesNew = $this->model->getFileList();
        $filesSaved = $this->model->getFileListSaved();
        include 'view/filelist.php';
        
    }  


}  