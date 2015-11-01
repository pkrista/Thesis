<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$pages_obj = unserialize($_SESSION['obj_pages']);

$pageName = '';

foreach ($pages_obj as $page){
    if($page->getPage_nr() == $_SESSION['cur_page']){
       $pageName = $page->getPage_name(); 
       
    }
}

?>
<div class="right">
    
    <a href="#" id="btnAddCont" class="button secondary tiny has-tip" title="Click to add content" aria-haspopup="true"
       data-tooltip data-options="disable-for-touch:true" onclick="addContentShow()"
       data-clicked = "false" >Add content <i class="fi-plus"></i></a>

</div>
<h5 class="subheader">File Name: <?php echo $_SESSION['filename']; ?></h5>
<div class="large-4 medium-4 small-4 columns">
    <h5 class="subheader">Page Name</h5>
    <div id="pName" class="panel" contentEditable=true data-ph="Insert Page Name"  oninput="chagePageName(this, <?php echo $_SESSION['cur_page']; ?> )"
         style="padding: 0px; height: 30px"><?php
//            if(isset($_SESSION['pageinfo'][$cur_page])){
//                echo($_SESSION['pageinfo'][$cur_page]);
            echo $pageName;?></div>
</div>
<hr />



<!--Save /change page name-->