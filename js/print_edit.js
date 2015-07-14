/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//If the div data (question/answer/explanation) will be changes then the value will be true
function dataChganged(object){  
    //get data-changed variable
    var changed = object.dataset.changed;
    if(changed === 'false'){
        object.dataset.changed = 'true';
//        console.log('changed');
    }
}



//To change pages
function nextPage1(){
    getalldataTosend('next','page');
}
//To change pages
function prePage1(){
    getalldataTosend('pre','page');
}

//To save data in the db
function saveChangesInDB(){
    alert('start saving changes');
    getalldataTosend('','save');
}

/**
 * Function tu turn pages and refresh the cintent
 * collect values from div to create new 2d array
 * and dysplay next or previous page
 */
function getalldataTosend(direction, status){  
    
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
                loadFileContent();
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
            saveLoadFileContent()   
        });
        
//        window.location.reload();
    }
}

//Next page or Pre page
function loadFileContent(){ 
    $("#eeee").load('controller/printStoredDivController.php');
}

//update changed exercises in DB
function saveLoadFileContent(){ 
    $("#eeee").load('controller/updateExercisesPDFDB.php');
    $("#eeee").load('controller/printStoredDivController.php');
}
