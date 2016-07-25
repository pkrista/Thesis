/* 
 * This file stores JS functions to convert pdf to multipe EPS files 
 */


function doMagic(fileTitle){
    var spinner = createSpinner();
    showOverlay();
    console.log(fileTitle);  
     var data = {
	"fileTitle": fileTitle
	};
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/pdfToEpsConverter.php?fileTitle='+fileTitle,
        data: {fileTitle: fileTitle}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("File converted successfily", "success");
        spinner.stop();
        hideOverlay();
        window.location = 'controller/pdfToEpsConverter.php?fileTitle='+fileTitle;
        
    })
    .fail(function ( data ) {
        console.log(data);
        $.notify("Error converting file", "error");
        spinner.stop();
        hideOverlay();
    });
    
}