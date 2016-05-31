/* 
 * This file stores JS functions to convert pdf to multipe EPS files 
 * 
 * 
 */


function doMagic(fileTitle){
    var spinner = createSpinner();
    showOverlay();
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/pdfToEpsConverter.php',
        data: { title: fileTitle}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("File converted successfily", "success");
        spinner.stop();
        hideOverlay();
    })
    .fail(function ( data ) {
        $.notify("Error converting file", "error");
        spinner.stop();
        hideOverlay();
    });
    
}