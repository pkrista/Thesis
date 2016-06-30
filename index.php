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
<body id="main"><div id="overlay" style="display: none;"></div>
  <div id="body">
      <div class="row panel" id="wrapperApp">
      <div class="row" id="welcome">
          <div class="panel">
              <h3>Welcome!</h3>
          </div>
      </div>

      
      
      <div class="row" id="eeee"></div>

      <?php
      
        /**
         * Create folder if dont exist
         */
        $EPSpath = 'tmp';
        if(!is_dir($EPSpath)){
            mkdir($EPSpath); 
        }
        $_SESSION['eps_dir'] = $EPSpath;
        

        include_once("controller/controller.php");

        $controller = new Controller();
        $controller->invoke();
             
      ?>

    </div>
      <div class="row panel">
        <div class="large-12 columns">
            <div class="large-2 columns text-left">
               <img src="view/VUBlogo.png"> 
            </div> 
            <div class="large-3 arge-offset-7 columns text-right" style="font-size: 14px;">
                Part of the master thesis of Krista Puke
            </div>

        </div>
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script src="js/notify.js"></script>
    <script type="text/javascript" src="js/addCont.js"></script> 
    <script src="js/app.js"></script>
    <script type="text/javascript" src="js/saveChangedContent.js"></script>
    <script type="text/javascript" src="js/filelist.js.js"></script>
  </div></div>
</body>
