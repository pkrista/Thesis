<?php

/* 
 * For Uploaded and Saved PDF files
 * 
 * File header contains and sets values:
 * -File name 
 * -Page name
 * 
 */

$pageName = '';
$pageId = -1;

/**
 * For saved PDF file
 */
if(isset($_SESSION['obj_pages']) && !empty($_SESSION['obj_pages'])){
    //Set objet variable
    $pages_obj = unserialize($_SESSION['obj_pages']);
    
    /**
     * Set Page name and db id
     */
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_SESSION['cur_page']){
            $pageName = $page->getPage_name(); 
            $pageId = $page->getPage_ID();
        }
    }
}  
/**
 * Data comes from Pythong (Uploaded PDF file)
 */
else if(isset($_SESSION['obj_pages_upload']) && !empty($_SESSION['obj_pages_upload'])){
    //Set objet variable
    $pages_obj = unserialize($_SESSION['obj_pages_upload']); //obj_uploaded_pdf
    
//    $pageName = $_SESSION['filename'];
    echo 'Python file';
    
    
        /**
     * Set Page name and db id
     */
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_SESSION['cur_page']){
            $pageName = $page->getPage_name(); 
            $pageId = $page->getPage_ID();
            echo 'page ID ' . $page->getPage_ID();
        }
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
    <div id="pName" class="panel" contentEditable=true data-ph="Insert Page Name"  
         oninput="chagePageName(this, <?php echo $_SESSION['cur_page']; ?> , <?php echo $pageId; ?>)"
         style="padding: 0px; height: 30px"><?php

         if(isset($_SESSION['obj_pages'])){
            echo $pageName;
         }
         elseif (isset($_SESSION['obj_pages_upload'])) {
             echo $pageName;
         }
         else if (isset($_SESSION['pageinfo'][$cur_page])){ //What is this?
                echo($_SESSION['pageinfo'][$cur_page]); 
         }
            ?>
    </div>
</div>
<hr />
