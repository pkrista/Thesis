/* 
 * To open Uploaded or Saved PDF file
 * 
 * 
 */

//test 15.05
//function setExerciseSeperator(fileName, fileId) {
//
//    
//    var exerSeperator = prompt("Please enter exercise seperator", "Exercise");
//
//    hideFileListCont();
//    
//    $.ajax({
//        async: true,
//        method: 'post',
//        url: 'controller/getPDFdataFromPY.php',
//        data: { fName: fileName, exSep: exerSeperator, fileId: fileId}
//      })
//        .success(function( msg ) {
//            var result = msg;
//    
//            console.log(result);
//            loadFileContent('printdivController.php');
//
//        });
//}

//old one 16.05
function setExerciseSeperator(fileName, fileId) {

    
    var exerSeperator = prompt("Please enter exercise seperator", "Exercise");

    hideFileListCont();
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'view/fileedit.php',
        data: { fName: fileName, exSep: exerSeperator, fileId: fileId}
      })
        .success(function( msg ) {
            var result = msg;
    //Test
        console.log(result);
//            alert(msg);
//            document.getElementById("filesListandupload").innerHTML = msg;
//                loadFileContent('printdivController.php');
                loadFileContent('printUploadedDivContent.php');
//                loadPageofHTML();
        });
}

/**
 * 
 * @returns {undefined}
 */
function openUploadedPDF(){
    
}

/**
 * Open Saved file
 * 
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
            console.log('-----------------------------------------------');
            
            loadFileContent('printStoredDivController.php');
//            $("#eeee").load('controller/printStoredDivController.php');
//            $("#eeee").load(msg);
            
        });
}

/**
 * load PDF exercises and images into page
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

    

//To save data
function saveData(){
    //first save current page
    var pageArray = [];
    var direction = 'next';
    

    $( '#divi' ).find('img, div').each(function( index ) {
        var element = $( this );
        
        if(element.is('#pid') && $( this ).is(":visible") ){
            var image = '<img src="'+(element.attr("src"))+'"';
            pageArray.push(image);
//            console.log(image);
        }
        if(element.is('#qid')){
            // get everyting from div question in html format and put in array
            //put marck that exercise is combined with one in previous page
//            console.log(element.data("combined"));
            if(element.data("combined") === 'yes'){
                pageArray.push('**PREpage**'+element.html());
            }
            else{
                pageArray.push(element.html());
            }
        }
        if(element.is('#pName')){
            pageInfo = element.text();            
        }
        
      });
    console.log('Saving Data aray');
    console.log(pageArray);
    console.log('Saving Data end');
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/arrayeditController.php',
        data: { page: pageArray, direction: direction, pageinfo: pageInfo}
      })
        .success(function( msg ) {
          console.log(msg);
//            window.location.reload();
//            $("#eeee").load('controller/savefileController.php');

        });
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/savefileController.php',
        data: { page: 'Yello'}
      })
        .success(function( msg ) {
          console.log('went into save file');
          console.log(msg);
  
//          $("#divi").load('../controller/savefileController.php');

        });
}


    
//function loadXMLDoc() {
//    //Thete needs to be function to store array everytime change pages
//    document.write('PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP');
//}


 
///**
// * Function tu turn pages and refresh the cintent
// * collect values from div to create new 2d array
// * and dysplay next or previous page
// */
//function getalldataTosend(direction){  
//    var pageArray = [];
//    var pageInfo = '';
//
//    $( '#divi' ).find('img, div').each(function( index ) {
//        var element = $( this );
//        
//        if(element.is('#pid') && $( this ).is(":visible") ){
//            var image = '<img src="'+(element.attr("src"))+'"';
//            pageArray.push(image);
////            console.log(image);
//        }
//        if(element.is('#qid')){
//            // get everyting from div question in html format and put in array
//
//            //put marck that exercise is combined with one in previous page
////            console.log(element.data("combined"));
//            if(element.data("combined") === 'yes'){
//                pageArray.push('**PREpage**'+element.html());
//            }
//            else{
//                pageArray.push(element.html());
//            }
//        }
//        if(element.is('#pName')){
//            pageInfo = element.text();            
//        }
//        
//      });
//    
////    console.log(pageArray);
////    console.log(pageInfo);
//    
//    $.ajax({
//        async: true,
//        method: 'post',
//        url: 'controller/arrayeditController.php',
//        data: { page: pageArray, direction: direction, pageinfo: pageInfo}
//      })
//        .success(function( msg ) {
//            console.log(msg);
//            loadFileContent('printdivController.php');
//
//        });
//}



////To change pages
//function nextPage(){
//    getalldataTosend('next');
//}
////To change pages
//function prePage(){
//    getalldataTosend('pre');
//}

///*
// * To delete DIV
// * 
// */
//
// function deleteDiv(elem) {
//   var parent = elem.parentNode;
//   
//   // if the ok button is clicked, result will be true (boolean)
//    var result = confirm( "Delete?" );
//    if ( result ) {
//        //if next element is image delete it also
//        var nextElement = parent.nextElementSibling;
//        
//        while(nextElement !== null && nextElement.tagName === 'IMG'){
//            nextElement.remove();
//            
//            nextElement = parent.nextElementSibling;
//            console.log(nextElement);
//        }
//        
//        // the user clicked ok
//        parent.remove();
//    } else {
//        // the user clicked cancel or closed the confirm dialog.
//    } 
//}

///*
// * For dropdowm explanation
// */
//
//function openExplDiv(elem){
//    var nextElement = elem.nextElementSibling;
//    
//    var visibility = nextElement.style.visibility; //visibility to explanation div
//    
//    var children = elem.childNodes[1]; //arrow down/up 
//    
//    if(visibility === 'visible'){
//        nextElement.style.visibility = 'hidden';
//        children.className = 'fi-arrow-down';
//    }
//    else{
//        nextElement.style.visibility = 'visible';
//        children.className = 'fi-arrow-up';
//    }
//
//}





/**
 * To drag and drop elements
 */    
//
//function allowDrop(ev) {
//    ev.preventDefault();
//}
//
//function drag(ev) {
//    ev.dataTransfer.setData("text", ev.target.id);
//}
//
////Drop img element to last element in divi div that is other div that stores img
//function drop(ev) {
//    ev.preventDefault();
//    var data = ev.dataTransfer.getData("text");
//    ev.target.lastChild.appendChild(document.getElementById(data));
//    ev.target.style.border = "";
//    
//    //Change images id and class to images that was dregged into question
//    $('#divi').find("img").each(function( index ) {
//        var element = $( this );
//        var par = element.parent();
//        
//        if(par.is('#div1')){
//            element.removeClass('dddP').addClass('dddI');
//            element.prop('id', 'pic1');
//        }
//
//    });
//}
//
////ON drag enter make object borders in diferent colour
//function dragEnter(event) {
//    if(event.target.className === "ddd" ){
//        var imgDiv = event.target.lastChild;
//        event.target.style.border = "3px dotted red";
//        if(imgDiv.className === "dddI"){
//            imgDiv.style.visibility = "visible";
//        }        
//    }
//}
//
//function dragLeave(ev) {
//    if (ev.target.className === "dddI" || ev.target.className === 'ddd' ) {
//        ev.target.style.border = "";
//        ev.target.parentNode.style.border = "";
//    }
//}
