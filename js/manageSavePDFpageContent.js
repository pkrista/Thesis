/* 
 * 
 */

/**
 * Return to Home page
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
    })
    .fail(function ( data ) {
        $.notify("Error chaning pages", "error");
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
    })
    .fail(function ( data ) {
        $.notify("Error chaning pages", "error");
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
    url: 'controller/exercisesUpdateDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("Successfuly saved changes in DB", "success");
    })
    .fail(function ( data ) {
        $.notify("Error saving changes in DB", "error");
    });
}

//To save data in the db
function saveUploadedPdfInDB(){
    alert('start saving changes');
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/exercisesInsertDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("Successfuly saved in DB", "success");
    })
    .fail(function ( data ) {
           $.notify("Error saving file in DB", "error");
    });
}

/**
 * Load content of Next or Pre page
 * @param {type} file the name of the file to load
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
 function deleteDiv(elem, exercise) {
   var parent = elem.parentNode;
   
   // if the ok button is clicked, result will be true (boolean)
    var result = confirm( "Delete?" );
    if ( result ) {
        console.log('delete this');
        console.log(parent);
        
        $.ajax({
            async: true,
            method: 'post',
            url: 'controller/deleteExerciseController.php',
            data: {exercise: exercise}
        })
        .success(function( msg ) {
            console.log(msg);
            $.notify("Successfuly removed", "success");
            loadFileContent('printUploadedDivContent.php');
        })
        .fail(function ( data ) {
           $.notify("Error deleating the exercise", "error");
        });
    } 
}

function deleteDivStored(elem, exercise){
    var parent = elem.parentNode;
    // if the ok button is clicked, result will be true (boolean)
    var result = confirm( "Delete?" );
    if ( result ) {
        console.log('delete this');
        console.log(parent); 
        $.ajax({
            async: true,
            method: 'post',
            url: 'controller/deleteStoredExerciseController.php',
            data: {exercise: exercise}
        })
        .success(function( msg ) {
            console.log(msg);
            $.notify("Successfuly removed", "success");
            loadFileContent('printStoredDivController.php');
        })
        .fail(function ( data ) {
           $.notify("Error deleating the exercise", "error");
        });
    }
}

/**
 * Show all places where it is possible to add exercise content
 */
function addContentShow(){ 
    /**
     * Show all places where to add content
     */
    $('[id=btnaddContentHere]').each(function() {
     $( this ).toggleClass( "hideDiv" );
   });
}

/**
 * To insert new exercise (Uploaded PDF)
 * 
 * @param {type} exerciseIndex (index of the exercise above)
 */
function addContentToPage(exerciseIndex){
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/addExerciseController.php',
        data: {exercise: exerciseIndex}
    })
    .success(function( msg ) {
        console.log(msg);

        $.notify("Content added successfily", "success");
        loadFileContent('printUploadedDivContent.php');
    })
    .fail(function ( data ) {
       $.notify("Error adding content", "error");
    });

}

/**
 * To insert new exercise (Stored PDF)
 * 
 * @param {type} exerciseIndex (index of the exercise above)
 */
function addContentToStoredPage(exerciseIndex){
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/addExerciseStoredController.php',
        data: {exercise: exerciseIndex}
    })
    .success(function( msg ) {
        console.log(msg);

        $.notify("Content added successfily", "success");
        loadFileContent('printStoredDivController.php');
    })
    .fail(function ( data ) {
       $.notify("Error adding content", "error");
    });
}

/**
 * Function to add image to stored exercise
 */
function addImageStoredExercise(elem, exerciseIndex){
    $.notify("Not implemented", "error");
}

/**
 * Function to add image to uploaded exercise
 */
function addImageExercise(elem, exerciseIndex){
    $.notify("Not implemented", "error");
}