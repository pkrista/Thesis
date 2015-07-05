/* 
 * 
 * 
 * 
 */


function setExerciseSeperator(fileName) {

    var exerSeperator = prompt("Please enter exercise seperator", "Exercise");

    var elem = document.getElementById('filesListandupload');
    $(elem).hide();
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'view/fileedit.php',
        data: { fName: fileName, exSep: exerSeperator}
      })
        .success(function( msg ) {
            var result = msg;
        console.log(result);
//            alert(msg);
//            document.getElementById("filesListandupload").innerHTML = msg;
                loadFileContent();
                loadPageofHTML();
        });
}

function loadFileContent(){

    $("#eeee").load('controller/printdivController.php');

}





/**
 * 
 * 
 * 
 * 
 * From other fileedit.php file
 * 
 * 
 */

/**
 * To drag and drop elements
 */    

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

//Drop img element to last element in divi div that is other div that stores img
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.lastChild.appendChild(document.getElementById(data));
    ev.target.style.border = "";
    
    //Change images id and class to images that was dregged into question
    $('#divi').find("img").each(function( index ) {
        var element = $( this );
        var par = element.parent();
        
        if(par.is('#div1')){
            element.removeClass('dddP').addClass('dddI');
            element.prop('id', 'pic1');
        }

    });
}

//ON drag enter make object borders in diferent colour
function dragEnter(event) {
    if(event.target.className === "ddd" ){
        var imgDiv = event.target.lastChild;
        event.target.style.border = "3px dotted red";
        if(imgDiv.className === "dddI"){
            imgDiv.style.visibility = "visible";
        }        
    }
}

function dragLeave(ev) {
    if (ev.target.className === "dddI" || ev.target.className === 'ddd' ) {
        ev.target.style.border = "";
        ev.target.parentNode.style.border = "";
    }
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

    
function loadXMLDoc() {
    //Thete needs to be function to store array everytime change pages
    document.write('PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP');
}


////Load first page when open document
//$( document ).ready(function() {
//    $("#divi").load('../controller/printdivController.php');
//});    
/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosend(direction){  
    var pageArray = [];
//    var element = $( this );
//    pageArray.push(element.html());
   
//    $('#divi').find("img").each(function( index ) {
////    $('#pid').each(function( index ){
//        
//        var element = $( this );
//        if(element.is('.dddP') && $( this ).is(":visible") ){
//            var image = '<img src="'+(element.attr("src"))+'"';
////            pageArray.push(image);
//        }
//
//    });

//console.log($('#divi').html());
    
//    $('#divi').find("div").each(function( index ) {
//        var element = $( this );
//        
//        if(element.is('#qid')){
//        }
//    });
    

    $( '#divi' ).find('img, div').each(function( index ) {
        var element = $( this );
        
        if(element.is('#pid') && $( this ).is(":visible") ){
            var image = '<img src="'+(element.attr("src"))+'"';
            pageArray.push(image);
            console.log(image);
        }
        if(element.is('#qid')){
            // get everyting from div question in html format and put in array
            pageArray.push(element.html());
            console.log(element.html());
        }
        
      });
    
    
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/arrayeditController.php',
        data: { page: pageArray, direction: direction}
      })
        .success(function( msg ) {
          loadPageofHTML();

        });
}

function loadPageofHTML(){
//    $("#divi").load('controller/printdivController.php');
    $("#eeee").load('controller/printdivController.php');
//    $("#divi").load('view/fileedit.php');
}



//To change pages
function nextPage(){
    getalldataTosend('next');
}
//To change pages
function prePage(){
    getalldataTosend('pre');
}


//To save data
function saveData(){
    //first save current page
    var pageArray = [];
    var direction = 'next';
    
    $('#divi').find("img").each(function( index ) {
//    $('#pid').each(function( index ){
        alert('Pictures that are not connected t excersises will not be saved');
//        var element = $( this );
//        if(element.is('.dddP') && $( this ).is(":visible") ){
//            var image = '<img src="'+(element.attr("src"))+'"';
//            pageArray.push(image);
//        }

    });
    
    $('#divi').find("div").each(function( index ) {
        var element = $( this );
        
        if(element.is('#qid')){
            // get everyting from div question in html format and put in array
            pageArray.push(element.html());
        }
    });
    console.log(pageArray);
    
    $.ajax({
        async: true,
        method: 'post',
        url: '../controller/arrayeditController.php',
        data: { page: pageArray, direction: direction}
      })
        .success(function( msg ) {
          console.log(msg);
          console.log('did it');
//          $("#divi").load('../controller/printdivController.php');

        });
    
    
    
    console.log('Saving data');
    
    $.ajax({
        async: true,
        method: 'post',
        url: '../controller/savefileController.php',
        data: { page: 'Yello'}
      })
        .success(function( msg ) {
          console.log(msg);
//          $("#divi").load('../controller/savefileController.php');

        });
}


/*
 * For screen resizing
 *  if screen is small make pictures bigger
 */

$(window).resize(function() {

  if ($(this).width() < 500) {
    $('#divi').find("img").each(function( index ) {
        var element = $( this );
        element.css({"max-width":"100%"});
    });

  } else {
    $('#divi').find("img").each(function( index ) {
        var element = $( this );
        element.css({"max-width":"40%"});
    });

    }
});

