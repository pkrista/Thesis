/* 
 * 
 */

/**
 * Return to Home page
 * 
 */
function backToHomePage(){
    window.location.reload();
}

/**
 * functions to navigate pages (object)
 * 
 */
//To change pages
function nextPageStored(){
    //getalldataTosendStored('next','page');
    loadPageContentStored('next');
}
//To change pages
function prePageStored(){
    //getalldataTosendStored('pre','page');
    loadPageContentStored('pre');
}

function loadPageContentStored(direction){
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/changePageController.php',
    data: {direction: direction}
  })
    .success(function( msg ) {
        console.log(msg);
        loadFileContent('printStoredDivController.php');
    });
}


//To change pages
function nextPageUploaded(){
    //getalldataTosendStored('next','page');
    loadPageContentUploaded('next');
}
//To change pages
function prePageUploaded(){
    //getalldataTosendStored('pre','page');
    loadPageContentUploaded('pre');
}

function loadPageContentUploaded(direction){
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/changePageController.php',
    data: {direction: direction}
  })
    .success(function( msg ) {
        console.log(msg);
        loadFileContent('printUploadedDivContent.php');
    });
}


/**
 * Function to save/upload changes in db
 * 
 * called from printStoredDivController btn save()
 */
function saveChangesDB(){

    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/updateChangesDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        alert('Successful');
    });
}

//To save data in the db
function saveUploadedPdfInDB(){
    alert('start saving changes');
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/saveChangesDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        alert('Successful');
    });
}

/**
 * Load content of Next or Pre page
 * @param {type} elem
 * @returns {undefined}
 */
function loadFileContent(file){ 
    $("#eeee").load('controller/'+file);
}


/*
 * For dropdowm explanation
 */

function openExplDiv(elem){
    var nextElement = elem.nextElementSibling;
    
    var visibility = nextElement.style.visibility; //visibility to explanation div
    
    var children = elem.childNodes[1]; //arrow down/up 
    
    if(visibility === 'visible'){
        nextElement.style.visibility = 'hidden';
        children.className = 'fi-arrow-down';
    }
    else{
        nextElement.style.visibility = 'visible';
        children.className = 'fi-arrow-up';
    }

}

/*
 * To delete DIV
 * 
 */

 function deleteDiv(elem) {
   var parent = elem.parentNode;
   
   // if the ok button is clicked, result will be true (boolean)
    var result = confirm( "Delete?" );
    if ( result ) {
        //if next element is image delete it also
        var nextElement = parent.nextElementSibling;
        
        while(nextElement !== null && nextElement.tagName === 'IMG'){
            nextElement.remove();
            
            nextElement = parent.nextElementSibling;
            console.log(nextElement);
        }
        
        // the user clicked ok
        parent.remove();
    } else {
        // the user clicked cancel or closed the confirm dialog.
    } 
}