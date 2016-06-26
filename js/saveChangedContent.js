/* 
 * Save changes in object session
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
 * Function to store selected category
 * @param {type} object
 * @param {type} page_nr
 * @param {type} pageId
 */
function onCategorySelected( object, page_nr, pageId){
    $.ajax({
            async: true,
            method: 'post',
            url: 'controller/storeEditedPageExerciseContentController.php',
            data: { category: object.value, category_id: object[object.selectedIndex].id, page_nr: page_nr, type: "category" , page_id: pageId}
        })
        .success(function( msg ) {
            console.log(msg);
        })
        .fail(function ( data ) {
            $.notify("Error saving changes", "error");
    });
}
/**
 * Function to store selected course
 * @param {type} object
 * @param {type} page_nr
 * @param {type} pageId
 */
function onCourseSelected(object, page_nr, pageId){
    $.ajax({
            async: true,
            method: 'post',
            url: 'controller/storeEditedPageExerciseContentController.php',
            data: { course: object.value, course_id: object[object.selectedIndex].id, page_nr: page_nr, type: "course" , page_id: pageId}
        })
        .success(function( msg ) {
            console.log(msg);
        })
        .fail(function ( data ) {
            $.notify("Error saving changes", "error");
    });
}