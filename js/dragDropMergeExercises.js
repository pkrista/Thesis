/* 
 * 
 */

/**
 * Ondrag start
 * @param {type} ev
 */
function drag(ev) {
    ev.dataTransfer.setData("exerciseIndex", ev.target.id);
}


/**
 * To receive element
 * @param {type} ev
 */
function allowDrop(ev) {
    ev.preventDefault();
}

/**
 * To merge elements
 * @param {type} ev
 */
function drop(ev) {
    ev.preventDefault();
    var transferId = ev.dataTransfer.getData("exerciseIndex");
    var targetId = ev.target.id;
    
    var parentElement = ev.dataTransfer.mozSourceNode.parentElement;
    
    console.log(transferId);
    console.log(targetId);
    
    //do mgic in ajax
    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/mergeExerciseController.php',
    data: {exerciseIndex: transferId, targetExerciseIndex: targetId}
  })
    .success(function( msg ) {
        _msg = msg;
        if(msg.indexOf('1') > -1){
            console.log('printStoredDivController');
            
            //remove dragged exercise
            deleteDivStored(parentElement, transferId, 'Delete dragged exercise');
            loadFileContent('printStoredDivController.php');
        }
        else{
            console.log('printUploadedDivContent');
            
            //remove dragged exercise
            deleteDiv(parentElement, transferId, 'Delete dragged exercise');
            loadFileContent('printUploadedDivContent.php');
        }
        
        $.notify("Exercises merged successfully", "success");
    })
    .fail(function ( data ) {
        $.notify("Error chaning pages", "error");
    });
    
    
    //ev.target.appendChild(document.getElementById(data));
}

/**
 * Load content of Next or Pre page
 * @param {type} file the name of the file to load
 * @returns {undefined}
 */
function loadFileContent(file){ 
    $("#eeee").load('controller/'+file);
}