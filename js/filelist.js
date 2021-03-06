/* 
 * To open Uploaded or Saved PDF file
 * 
 * 
 */
 
 /**
  * Function to show dialog and get the exercise separator
  * @param {type} fileName
  * @param {type} fileId
  */
function setExerciseSeperator(fileName, fileId) {
    
    var exerSeperator = prompt("Please enter exercise seperator", "Exercise");
    
    /**
     * If cancel on promt then dont load the file
     */
    if(exerSeperator === null){
        return;
    }
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
    
    var spinner = createSpinner();
    showOverlay();
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/getPDFdataFromPY.php',
        data: { fName: fileName, exSep: exerSeperator, fileId: fileId}
      })
    .success(function( msg ) {
        loadFileContent('printUploadedDivContent.php');
        spinner.stop();
        hideOverlay();
    })
    .fail(function ( data ) {
        $.notify("Error opening uploaded file", "error");
        spinner.stop();
        hideOverlay();
    });
}

/**
 * Open Saved file
 * @param {type} fileName
 * @param {type} fileId
 */
function openSavedPDF(fileName, fileId){
    hideFileListCont();
    
    var spinner = createSpinner();
    showOverlay();
    
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/getPDFdataFromDB.php',
    data: { fName: fileName, fileId: fileId}
    })
    .success(function( msg ) {
        loadFileContent('printStoredDivController.php');    
        spinner.stop();
        hideOverlay();
    })
    .fail(function ( data ) {
        $.notify("Error opening saved file", "error");
        spinner.stop();
        hideOverlay();
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

/*
 * For screen resizing
 *  if screen is small make pictures bigger
 */
$(window).resize(function() {

var width = $(window).width();
//console.log(width);    
    if (width < 600) {
        $("#divi").find( "img" ).css({
          "max-width": "100%"
        });
    }
    else {
        $( '#divi').find( "img" ).css({
        "max-width": "50%"
        });
    }
});