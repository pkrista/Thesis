<?php

/*
 * Model Exercise
 */

/**
 * Description of Exercise
                //[0] Page_ID
                //[1] Page_name
                //[2] Ex_ID
                //[3] Question
                //[4] Solution
                //[5] Explanation
                //[6] Changed
                //[7] Images
 * 
               //[0] Page_ID
               //[1] Page_name
               //[2] Ex_ID
               //[3] Question
               //[4] Solution
               //[5] Explanation
               //[6] Changed - by default false ,if changed then true
               //[7] Images
 */
class Exercise {
    private $Page_ID;
    private $Page_name;
    private $Ex_ID;
    private $Question;
    private $Solution;
    private $Explanation;
    private $Changed = 'no';
    private $Combined = 'no';
    private $IsRemoved = 'no';
    private $IsNew = 'no';
    private $Images = array();
    
//    private $Images = [];
    
    //private $Number;
    //? page nr
    private $Page;
    
    public function __construct($Page_ID,$Page_name,$Ex_ID,$Question,$Solution,$Explanation,$Combined,$Images,$Page) {
        
        $this->Page_ID = $Page_ID;
        $this->Page_name = $Page_name;
        $this->Ex_ID = $Ex_ID;
        $this->Question = $Question;
        $this->Solution = $Solution;
        $this->Explanation = $Explanation;
        $this->Combined = $Combined;
        $this->Images = $Images;
        $this->Page = $Page; 
        
    }
    
    public function getPage_ID(){
        return $this->Page_ID;
    }
    
    public function getPage_name(){
        return $this->Page_name;
    }
    
    public function getEx_ID(){
        return $this->Ex_ID;
    }
    
    public function getChanged(){
        return $this->Changed;
    }
    
    public function getCombined(){
        return $this->Combined;
    }
    
//    public function getNumber(){
//        return $this->Number;
//    }
    
    public function getQuestion(){
        return $this->Question;
    }
    
    public function getSolution(){
        return $this->Solution;
    }
    
    public function getExplanation(){
        return $this->Explanation;
    }
    
    public function getImages(){
        return $this->Images;
    }
    //paperPage nr
    public function getPage(){
        return $this->Page;
    }      
    
    public function getIsRemoved(){
        return $this->IsRemoved;
    }
    
    public function getIsNew(){
        return $this->IsNew;
    }
    
    //SET
    
    public function setChanged($changed){
        $this->Changed = $changed;
    }
    
    public function setQuestion($question){
        $this->Question = $question;
    }
    
    public function setSolution($solution){
        $this->Solution = $solution;
    }
    
    public function setExplanation($explanation){
        $this->Explanation = $explanation;
    }
    
    public function setCombined($combined){
        $this->Combined = $combined;
    }
    
    public function setIsRemoved($isRemoved){
        $this->IsRemoved = $isRemoved;
    }
    
    public function setIsNew($isNew){
        $this->IsNew = $isNew;
    }
    
    public function setImages($images){
        $this->Images = $images;
    }
    
    public function addImage($img){
        array_push($this->Images, $img);
    }
}
