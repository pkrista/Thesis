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
            $category_id = $page->getCategory();
            $course_id = $page->getCourse();
            echo '$course_id  ' . $page->getCourse();
        }
    }
}  
/**
 * Data comes from Pythong (Uploaded PDF file)
 */
else if(isset($_SESSION['obj_pages_upload']) && !empty($_SESSION['obj_pages_upload'])){
    //Set objet variable
    $pages_obj = unserialize($_SESSION['obj_pages_upload']); //obj_uploaded_pdf
    
    /**
     * Set Page name and db id
     */
    foreach ($pages_obj as $page){
        if($page->getPage_nr() == $_SESSION['cur_page']){
            $pageName = $page->getPage_name(); 
            $pageId = $page->getPage_ID();
            $category_id = $page->getCategory();
            $course_id = $page->getCourse();
            echo 'page ID ' . $page->getPage_ID();
        }
    }
}    

?>

<div class="medium-12">
    <h5 class="subheader">File Name: <?php echo $_SESSION['filename']; ?></h5>
    <div class="medium-4 columns">
        <h5 class="subheader">Course</h5>
        <select id="courseSelect" onchange="onCourseSelected(this, <?php echo $_SESSION['cur_page']; ?> , <?php echo $pageId; ?>)">
        <?php
            if($course_id == 0){
                echo '<option class="placeholder" selected default value="">Select course</option>';
            }
            foreach ($_SESSION['coursesList'] as $key => $course) {
                if($course->id == $course_id){
                   echo '<option id='.$course->id.' value="'.$course->id.'" selected>'.$course->name.'</option>'; 
                }
                else{
                    echo '<option id='.$course->id.' value="'.$course->id.'">'.$course->name.'</option>';
                }
                
            }
        ?>
        </select>

    </div>
    <div class="medium-4 columns">
        <h5 class="subheader">Category</h5>
        <select id="categorySelect" onchange="onCategorySelected(this, <?php echo $_SESSION['cur_page']; ?> , <?php echo $pageId; ?>)">
        <?php
            if($category_id == 0){
                echo '<option class="placeholder" selected default value="">Select category</option>';
            }
            foreach ($_SESSION['categoryList'] as $key => $category) {
                if($category->id == $category_id){
                   echo '<option id='.$category->id.' value="'.$category->id.'" selected>'.$category->name.'</option>'; 
                }
                else{
                    echo '<option id='.$category->id.' value="'.$category->id.'">'.$category->name.'</option>';
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
