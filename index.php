<?php 
session_start();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div> Yes it is here the div header is here </div><br>';


include_once("controller/controller.php");  
  
$controller = new Controller();  
$controller->invoke();
