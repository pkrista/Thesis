/* 
 * maybe rename??? used in both saved and upoaded TODO
 */


/**
 * Change data value "changes" to TRUE
 * 
 * div data (question/answer/explanation) was changes
 * @param {type} object (exercise object)
 */
function dataChganged(object){  
    //get data-changed variable
    var changed = object.dataset.changed;
    if(changed === 'no'){
        object.dataset.changed = 'yes';
    }
}

/**
 * Call this function when exercises was changed (event onChange)
 * 
 * @param {type} object (exercise object)
 * @param {type} page_nr 
 */
function questionChanged(object, page_nr, exerciseIndex){
    dataChganged(object);
    var id = object.dataset.id;
    
    var i = 0; 
    var question_string = '';
    var solution_string = '';
    var explanation_string = '';

   while(object.childNodes[i]){
        /**
         * get question
         */
        if(object.childNodes[i].nodeName === "#text"){
            question_string = question_string + object.childNodes[i].nodeValue;
        }
        if(object.childNodes[i].nodeName === "BR"){
            question_string = question_string + '<br>';
        }
        
        /**
         * get answer
         */
        if(object.childNodes[i].id === 'aid'){
            console.log('Solution ' + object.childNodes[i].value);
            solution_string = object.childNodes[i].value;
        }
         
        /**
         * get explanation
         */
        if(object.childNodes[i].id === 'dropExplanation'){
            explanation_string = object.childNodes[i].value;
//            explanation_string = object.childNodes[i].getElementsByClassName("bar")[0].value;
            console.log('Explanation ' + explanation_string);
        }
        
        i++;
    }

    $.ajax({
        async: true,
        method: 'post',
        url: 'controller/storeEditedPageExerciseContentController.php',
        data: { question: question_string, solution: solution_string, explanation: explanation_string, exId: exerciseIndex, page_nr: page_nr, type: "exercise"}
    })
    .success(function( msg ) {
        console.log(msg);
    })
    .fail(function ( data ) {
        $.notify("Error saving changes", "error");
    });
}

/**
 * Call this function when page name was changed (event onChange)
 * 
 * @param {type} object (Page object)
 * @param {type} page_nr
 * @param {type} pageId
 */
function chagePageName(object, page_nr, pageId){
    
    if(pageId===-1){
        console.log("editSaveContent.js Edited file name from uploaded PDF (cnverted PY)");
    }
    else{
        var page_name = object.childNodes[0].textContent;
        console.log("New page name" , page_name);
    
        $.ajax({
            async: true,
            method: 'post',
            url: 'controller/storeEditedPageExerciseContentController.php',
            data: { page_name: page_name, page_nr: page_nr, type: "page" , page_id: pageId}
        })
        .success(function( msg ) {
            console.log(msg);
        })
        .fail(function ( data ) {
            $.notify("Error saving changes", "error");
        });
    }
}