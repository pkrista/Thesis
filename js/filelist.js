/* 
 * To open Uploaded or Saved PDF file
 * 
 * 
 */
function setExerciseSeperator(fileName, fileId) {
    
    var exerSeperator = prompt("Please enter exercise seperator", "Exercise");
    openUploadedPDF(exerSeperator, fileName, fileId);
}

/**
 * Open Uploaded file
 * @param {type} exerSeperator
 * @param {type} fileName
 * @param {type} fileId
 */
function openUploadedPDF(exerSeperator, fileName, fileId){
    hideFileListCont();
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/getPDFdataFromPY.php',
        data: { fName: fileName, exSep: exerSeperator, fileId: fileId}
      })
        .success(function( msg ) {
            var result = msg;
            console.log(result);
            loadFileContent('printUploadedDivContent.php');
        });
}

/**
 * Open Saved file
 * @param {type} fileName
 * @param {type} fileId
 */
function openSavedPDF(fileName, fileId){
    hideFileListCont();
    
        $.ajax({
        async: true,
        method: 'post',
        url: 'controller/getPDFdataFromDB.php',
        data: { fName: fileName, fileId: fileId}
      })
        .success(function( msg ) {
            //To test print in console
            console.log(msg);
            
            loadFileContent('printStoredDivController.php');            
        });
}

/**
 * load PDF exercises and images into page
 * @param {type} file (file name with extention)
 */
function loadFileContent(file){
    $("#eeee").load('controller/'+file);
}


/**
 * Hide the file list and file upload content
 * 
 */
function hideFileListCont(){
    var elem = document.getElementById('filesListandupload');
    $(elem).hide();
}


/**
 * To get id of div P - picture A - answer Q - question
 * @param {type} - P or A or Q
 * @param {id} the id of the div
 */
function myFunction(object) {
    var id = object.getAttribute("data-id");
    var type = id.charAt(0);
    
    if(type === 'P'){
           alert('Image id - '+id); 
    }
    else if(type === 'A'){
        alert('Answer id - '+id); 
    }
    else if(type === 'Q'){
        alert('Question id - '+id); 
    }
    
}

/*
 * For screen resizing
 *  if screen is small make pictures bigger
 */
$(window).resize(function() {

var width = $(window).width();
//console.log(width);    
    if (width < 600) {
        $("#divi").find( "img" ).css({
//          "background-color": "red",
          "max-width": "100%"
        });
    }
    else {
        $( '#divi').find( "img" ).css({
//        "background-color": "blue",
        "max-width": "50%"
        });
    }
});