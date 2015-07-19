/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * To add new div
 * 
 */

function addContentShow(){   
    var click = $('#btnAddCont').data('clicked');
    
    if(click){
        $('#btnAddCont').data('clicked', false);
        
        //show placed where to add content
        $('#divi').find('div').each(function( index ) {
            var element = $( this );

            if(element.attr('id') === 'addNewDiv'){ //element.removeAttr('style');
                element.hide();
            }
        });
        $('#btnAddCont').attr('title', 'Click to add content');
        $('#btnAddCont').removeAttr('style');
    }
    else{
        $('#btnAddCont').data('clicked', true);
         
        //show placed where to add content
        $('#divi').find('div').each(function( index ) {
            var element = $( this );

            if(element.attr('id') === 'addNewDiv'){ //element.removeAttr('style');
                element.show();
            }
        });
        $('#btnAddCont').attr('title', 'Click to hide');
        
        //hide addContent button and show cancel
        $('#btnAddCont').css('background-color', '#B9B9B9');
    }
    
    
    


    
}

/**
 * 
 * Function adds div as new question where user indicates
 * 
 * 
 */
function addContHere(elem, event){
    alert('div will be addeded here');
        
    var parent = elem.parentNode;
//    console.log(elem);
//    console.log(parent); 
    
    //Change style and class
    //set id id="I'.$p.'"'
    parent.className = 'large-12 columns callout panel';
    parent.id = 'qid';
    parent.style = 'padding-right: 0.2rem; padding-bottom: 0rem';
    
//    console.log(parent.childNodes);
    //[0] div text
    //[1] delDiv
    //[2] Answer
    //[3] Explanation btn
    //[4] Explanation div
    //[5] AddHere
    
    //Show delDiv
    var delDiv = parent.childNodes[1];
        delDiv.style.display = 'inline';
    //Show answer div
    var ansDiv = parent.childNodes[2];
        ansDiv.style.display = 'inline';
    //Show Explanation <a>
    var explA = parent.childNodes[3];
        explA.style.display = 'inline';
    //Hide addHere <a>
    var addHereA = parent.childNodes[5];
        addHereA.style.display = 'none';
    
    //Set content
    var divCont = parent.innerHTML;
    parent.innerHTML = 'Question '+divCont;
}

/**
 * Return to Home page
 * 
 */
function backToHomePage(){
    window.location.reload();
}