<?php 
session_start();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartStudy | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  
<link rel="stylesheet" href="css/foundation.css" type="text/css"> 
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <div class="row">
      <div class="large-12 columns">
      	<div class="panel">
	        <h3>Welcome!</h3>
      	</div>
      </div>
    </div>

<div class="large-12 columns" id="eeee">
</div>

<?php
include_once("controller/controller.php");  
  
$controller = new Controller();  
$controller->invoke();
