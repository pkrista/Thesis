/* 
 * This file stores JS functions to convert pdf to multipe EPS files 
 * 
 * 
 */


function doMagic(fileTitle){
    alert("yes");
    //get variables
    //location and name of file
    //use ajax to send data to php to do the job
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/pdfToEpsConverter.php',
        data: { title: fileTitle}
    })
    .success(function( msg ) {
        console.log(msg);
        $.notify("File converted successfily", "success");
    })
    .fail(function ( data ) {
        $.notify("Error converting file", "error");
    });
    
}

