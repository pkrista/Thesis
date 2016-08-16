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
    loadPageContentStored('next');
}
//To change pages
function prePageStored(){
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

    var spinner = createSpinner();
    showOverlay();
    
    $.ajax({
    async: false,
    method: 'post',
    url: 'controller/exercisesUpdateDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("Successfuly saved changes in DB", "success");
        spinner.stop();
        hideOverlay();
        window.location.replace("http://localhost/ThesisProject/");
    })
    .fail(function ( data ) {
        $.notify("Error saving changes in DB", "error");
        spinner.stop();
        hideOverlay();
        window.location.replace("http://localhost/ThesisProject/");
    });
}

//To save data in the db
function saveUploadedPdfInDB(){
    var spinner = createSpinner();
    showOverlay();

    $.ajax({
    async: false,
    method: 'post',
    url: 'controller/exercisesInsertDB.php'
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("Successfuly saved in DB", "success");
        spinner.stop();
        hideOverlay();
        window.location.replace("http://localhost/ThesisProject/");
    })
    .fail(function ( data ) {
        $.notify("Error saving file in DB", "error");
        spinner.stop();
        hideOverlay();
        window.location.replace("http://localhost/ThesisProject/");
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
 function deleteDiv(elem, exercise, drag) {
   
     if(!drag){
        var result = confirm("Delete?" );
        if ( result ) {
            deleteUploaded(exercise);
        } 
     }
     else{
         deleteUploaded(exercise);
     }
}

function deleteUploaded(exercise){
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

function deleteDivStored(elem, exercise, drag){  
    
    if(!drag){
        var result = confirm( "Delete?" );
        if ( result ) {
            deleteStored(exercise);
        }
    }
    else{
        deleteStored(exercise);
    }
}

function deleteStored(exercise){
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/deleteStoredExerciseController.php',
        data: {exercise: exercise}
    })
    .success(function( msg ) {
        $.notify("Successfuly removed", "success");
        loadFileContent('printStoredDivController.php');
    })
    .fail(function ( data ) {
       $.notify("Error deleating the exercise", "error");
    });
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
 * Function to add image to uploaded exercise
 */
function addImageExercise(elem, exerciseIndex){
    $.notify("Not implemented", "error");
}