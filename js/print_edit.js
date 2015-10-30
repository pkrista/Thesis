/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//If the div data (question/answer/explanation) will be changes then the value will be true
function dataChganged(object){  
    //get data-changed variable
    var changed = object.dataset.changed;
    if(changed === 'no'){
        object.dataset.changed = 'yes';
//        console.log('changed');
    }
}
function questionChanged(object, page_nr){
    dataChganged(object);
    var id = object.dataset.id;
    var rr = object.dataset.changed;
    
//    console.log(id);
//    console.log(object.childNodes[0]);
    console.log(object.childNodes);
//    console.log(object.childNodes[0].nodeType);
    
    var i = 0; 
    var question_string = '';
    var solution_string = '';
    var explanation_string = '';
    

   while(object.childNodes[i]){
        //get question
        if(object.childNodes[i].nodeName === "#text"){
            question_string = question_string + object.childNodes[i].nodeValue;
        }
        if(object.childNodes[i].nodeName === "BR"){
            question_string = question_string + '<br>';
        }
        
        
        //get answer
        if(object.childNodes[i].id === 'aid'){
            console.log('Solution ' + object.childNodes[i].textContent);
            solution_string = object.childNodes[i].textContent;
        }

         
        //get explanation
        if(object.childNodes[i].id === 'dropExplanation'){
            console.log('Explanation ' + object.childNodes[i].textContent);
            explanation_string = object.childNodes[i].textContent;
        }
        
        i++;
    }
    


    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/changeQuestionPage.php',
        data: { question: question_string, solution: solution_string, explanation: explanation_string, exId: id, page_nr: page_nr, type: "exercise"}
      })
        .success(function( msg ) {
            console.log(msg);
            
        });
}

function saveChangesDB(){

    $.ajax({
    async: true,
    method: 'post',
    url: 'controller/updateChangesDB.php',
    data: {}
    })
    .success(function( msg ) {
        console.log(msg);
        alert('Successful');
    });
}

function chagePageName(object, page_nr){
    console.log(object.childNodes[0].textContent);
//    alert('yes');
    var page_name = object.childNodes[0].textContent;
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/changeQuestionPage.php',
        data: { page_name: page_name, page_nr: page_nr, type: "page"}
      })
        .success(function( msg ) {
            console.log(msg);
            
        });

}

//To change pages
function nextPageStored(){
    getalldataTosendStored('next','page');
}
//To change pages
function prePageStored(){
    getalldataTosendStored('pre','page');
}

//To save data in the db
function saveChangesInDB(){
    alert('start saving changes');
    getalldataTosendStored('','save');
}

/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosendStored(direction, status){  
    
    var changedPageArray = [];
    var pageInfo;
//    console.log("function");
    $( '#divi' ).find('img, div').each(function( index ) {
        var element = $( this );
        var id = element.attr('id');

        //store just those elements that are being changed
        if(element.attr('id') === 'qid' && element.data('changed')){
            var exerciseArray = [];
            
            var elID = element.data('id');
            var elQuestion = element.html() ; //element.text(); //element.get()[0].firstChild.data;
            var elAnswer = element.find('#aid').text();
            var elExplanation = element.find('#dropExplanation').text();
            
//          put mark that exercise is combined with one in previous page
            if(element.data("combined") === 'yes'){
                elQuestion = '**PREpage**'+elQuestion;
//                console.log("combined YEs and stored");
            }
            
            exerciseArray.push(elID, elQuestion, elAnswer, elExplanation);
            changedPageArray.push(exerciseArray);

//            console.log(element.html());
//            console.log(element.get()[0].firstChild);
//            console.log(element.get()[0].firstChild.data);
//            console.log(element.children()[4]);
//            console.log(element.find('#dropExplanation').text());

        }
        if(element.attr('id') === 'pName' && element.data('changed')){
            pageInfo = element.text();            
        }
        
      });
      
    
//    console.log(changedPageArray);
//    console.log(pageInfo);
    
    if(status === 'page'){
        $.ajax({
            async: true,
            method: 'post',
            url: 'controller/editSavedArrayController.php',
            data: { page: changedPageArray, direction: direction, pageinfo: pageInfo}
          })
            .success(function( msg ) {
                console.log(msg);
                loadFileContent('printStoredDivController.php');
            });
    }
    if(status === 'save'){
        
        $.ajax({
        async: true,
        method: 'post',
        url: 'controller/editSavedArrayController.php',
        data: { page: changedPageArray, direction: direction, pageinfo: pageInfo}
        })
         .success(function( msg ) {
            console.log(msg);
            saveLoadFileContent();   
        });
        
//        window.location.reload();
    }
}

//Next page or Pre page
function loadFileContent(file){ 
    $("#eeee").load('controller/'+file);
}

//update changed exercises in DB
function saveLoadFileContent(){ 
    $("#eeee").load('controller/updateExercisesPDFDB.php');
    $("#eeee").load('controller/printStoredDivController.php');
}


/*
 * For dropdowm explanation
 */

function openExplDiv(elem){
    var nextElement = elem.nextElementSibling;
    
    var visibility = nextElement.style.visibility; //visibility to explanation div
    
    var children = elem.childNodes[1]; //arrow down/up 
    
    if(visibility === 'visible'){
        nextElement.style.visibility = 'hidden';
        children.className = 'fi-arrow-down';
    }
    else{
        nextElement.style.visibility = 'visible';
        children.className = 'fi-arrow-up';
    }

}

/*
 * To delete DIV
 * 
 */

 function deleteDiv(elem) {
   var parent = elem.parentNode;
   
   // if the ok button is clicked, result will be true (boolean)
    var result = confirm( "Delete?" );
    if ( result ) {
        //if next element is image delete it also
        var nextElement = parent.nextElementSibling;
        
        while(nextElement !== null && nextElement.tagName === 'IMG'){
            nextElement.remove();
            
            nextElement = parent.nextElementSibling;
            console.log(nextElement);
        }
        
        // the user clicked ok
        parent.remove();
    } else {
        // the user clicked cancel or closed the confirm dialog.
    } 
}


/**
 * 
 * JS functiond for unstored files in DB
 * 
 */

//To change pages
function nextPage(){
    getalldataTosend('next');
}
//To change pages
function prePage(){
    getalldataTosend('pre');
}

/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosend(direction){  
    var pageArray = [];
    var pageInfo = '';

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
    
//    console.log(pageArray);
//    console.log(pageInfo);
    
    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/arrayeditController.php',
        data: { page: pageArray, direction: direction, pageinfo: pageInfo}
      })
        .success(function( msg ) {
            console.log(msg);
            loadFileContent('printdivController.php');

        });
}


