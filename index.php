<?php 
session_unset();
session_start();

/* 
 *
 */
?>
  <head>     
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">  
  </head>
  <body>
      <div class="row">
          <div class="panel">
              <h3>Welcome!</h3>
          </div>
      </div>

      <div class="row" id="eeee"></div>

      <?php
      include_once("controller/controller.php");

      $controller = new Controller();
      $controller->invoke();
      
      ?>

    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script type="text/javascript" src="js/addCont.js"></script> 
    <script src="js/app.js"></script>
  </body>
