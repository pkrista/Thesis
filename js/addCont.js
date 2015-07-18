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

function addContHere(object){
    alert('div will be addeded here');
    
}

/**
 * Return to Home page
 * 
 */
function backToHomePage(){
    window.location.reload();
}