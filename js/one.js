/**
 * For draging and dropping elements
 * 
 * 
 */    

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.lastChild.appendChild(document.getElementById(data));
    ev.target.style.border = "";
}

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

/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosend(){
    var myDivUL = document.getElementById("divi").getElementsByTagName('div');
    for (var i = 0; i < myDivUL.length; i++) { 
        var status = myDivUL[i].getAttribute("data-id"); 
        console.log(status);
    }   
    console.log("______________");
    alert("Yo first");
    
    var pageArray = [];
    
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
//                
//                
//            });
        }   
    });
    console.log(pageArray);
    $.ajax({
        url: '../controller/arrayeditController.php',
        type: 'post',
        async: true,
        data: {
            page: pageArray
        },
        success: function(data){
            //alert(res);
//            $('GOOD').html(res);
            console.log('GOOD');
            console.log(data);
        }
    });
}

