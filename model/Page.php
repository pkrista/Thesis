<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page
 *
 * @author krista
 */
class Page {
    public $Page_ID;
    private $Page_name;
    private $page_nr;
    private $exercisesListObj = array();
    
    public function __construct($Page_ID,$Page_name,$page_nr, $exercisesListObj) {
        $this->Page_ID = $Page_ID;
        $this->Page_name = $Page_name;
        $this->page_nr = $page_nr;
        $this->exercisesListObj = $exercisesListObj;
    }
    
    public function setPage_ID($Page_Id) {
        $this->Page_ID = $Page_Id;
    }
    
    public function getPage_ID(){
        return $this->Page_ID;
    }
    
    public function setPage_name($Page_name) {
        $this->Page_name = $Page_name;
    }
    
    public function getPage_name(){
        return $this->Page_name;
    }
    
    public function setPage_nr($page_nr) {
        $this->Page_ID = $page_nr;
    }
    
    public function getPage_nr(){
        return $this->page_nr;
    }
    
    public function setExercisesListObj($exercisesListObj) {
        $this->exercisesListObj = $exercisesListObj;
    }
    
    public function getExercisesListObj(){
        return $this->exercisesListObj;
    }
    
    public function addExerciseToList($Exercise){
        array_push($this->exercisesListObj, $Exercise);
    }
}
