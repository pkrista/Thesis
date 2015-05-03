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


//Load first page when open document
$( document ).ready(function() {
    $("#divi").load('../controller/printdivController.php');
});    
/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosend(direction){  
    var pageArray = [];
    
   
    $('#divi').find("img").each(function( index ) {
//    $('#pid').each(function( index ){
        
        var element = $( this );
        if(element.is('.dddP') && $( this ).is(":visible") ){
            var image = '<img src="'+(element.attr("src"))+'"';
            pageArray.push(image);
        }

    });

//console.log($('#divi').html());
    
    $('#divi').find("div").each(function( index ) {
        var element = $( this );
        
        if(element.is('#qid')){
            // get everyting from div question in html format and put in array
            pageArray.push(element.html());

//           console.log( index + ": " + $( this ).attr('data-id'));
//            console.log( index + ": " + $( this ).text()); 
//            console.log(element.html());
        
//            var $id = element.attr('class');
//            console.log($id);
//            console.log("DIV");
//            
//            $('#qid').find("div").each(function( index ) {
//                var element = $( this );
//                var $id = element.attr('class');
//                console.log($id);
              
//            });
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
          $("#divi").load('../controller/printdivController.php');

        });
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
    
}