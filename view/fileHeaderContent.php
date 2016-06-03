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
$category_id = -1;

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
            $category_id = $page->getCourse();
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
            $category_id = $page->getCourse();
            echo 'page ID ' . $page->getPage_ID();
        }
    }
}    

?>

<div class="medium-12">
    <h5 class="subheader">File Name: <?php echo $_SESSION['filename']; ?></h5>
    <div class="medium-4 columns">
        <h5 class="subheader">Page Name</h5>
        <div id="pName" class="select panel" contentEditable=true data-ph="Insert Page Name"  
             oninput="chagePageName(this, <?php echo $_SESSION['cur_page']; ?> , <?php echo $pageId; ?>)"
             ><?php

                if(isset($_SESSION['obj_pages'])){
                   echo $pageName;
                }
                elseif (isset($_SESSION['obj_pages_upload'])) {
                    echo $pageName;
                }
                ?>
        </div>
    </div>
    <div class="medium-4 columns">
        <h5 class="subheader">Category</h5>
        <select id="categorySelect" onchange="onCategorySelected(this, <?php echo $_SESSION['cur_page']; ?> , <?php echo $pageId; ?>)">
        <?php
            foreach ($_SESSION['coursesList'] as $key => $course) {
                echo '<option class="placeholder" selected disabled value="">Select categry</option>';
                if($course->id == $category_id){
                   echo '<option id='.$course->id.' value="'.$course->name.'" selected>'.$course->name.'</option>'; 
                }
                else{
                    echo '<option id='.$course->id.' value="'.$course->name.'">'.$course->name.'</option>';
                }
                
            }
        ?>
        </select>

    </div>
    <div class="right">
    
    <a href="#" id="btnAddCont" class="button secondary tiny has-tip" title="Click to add content" aria-haspopup="true"
       data-tooltip data-options="disable-for-touch:true" onclick="addContentShow()"
       data-clicked = "false" >Add content <i class="fi-plus"></i></a>

    </div>
</div>
<hr />
