<?php

/**
 * Description of Page
 *
 * @author krista
 */
class Page {
    public $Page_ID;
    private $Page_name;
    private $page_nr;
    private $course;
    private $category;
    private $exercisesListObj = array();
    
    public function __construct($Page_ID, $Page_name, $page_nr, $exercisesListObj, $category, $course) {
        $this->Page_ID = $Page_ID;
        $this->Page_name = $Page_name;
        $this->page_nr = $page_nr;
        $this->exercisesListObj = $exercisesListObj;
        $this->category = $category;
        $this->course = $course;
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
    
    public function setCourse($course) {
        $this->course = $course;
    }
    
    public function getCourse(){
        return $this->course;
    }
    
    public function setCategory($category) {
        $this->category = $category;
    }
    
    public function getCategory(){
        return $this->category;
    }
    
    public function addExerciseToList($Exercise){
        array_push($this->exercisesListObj, $Exercise);
    }
}
