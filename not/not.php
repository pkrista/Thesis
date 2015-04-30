<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//From file edit


//echo '<div>';
//  
//    echo 'second';
//        $path = "../uploads/".$filename;
//            
//        $command = "test.py $path";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';


//echo '<div>';
//       echo 'third '  ;   
//        $command = "tt.py";
//         
//        $pid = popen($command,"r");
// 
//        while( !feof( $pid ) )
//            {
//                echo fread($pid, 256);
//                flush();
//                ob_flush();
//                usleep(100000);
//            }
//        pclose($pid);
//
//echo '</div>';


/**from fileedit
 * For drag and Drop 
 *
 */
//function dragStart(ev) {
////    var parnode = ev.target.parentNode;
//    if(ev.target.id == 'pid'){
//        ev.dataTransfer.effectAllowed='move';
//        ev.target.style.opacity = "0.4";
////        ev.target.parentNode.style.opacity = "0.4";
////        ev.dataTransfer.setData("Text", ev.target.id); 
//        var dt = ev.dataTransfer;
//        dt.mozSetDataAt("image/png", stream, 0);
//        dt.mozSetDataAt("application/x-moz-file", file, 0);
//        dt.setData("Text", ev.target.id); 
//        dt.setData("text/uri-list", imageurl);
//        dt.setData("text/plain", imageurl);
//    }

    
//    ev.dataTransfer.effectAllowed='move';
//    ev.dataTransfer.setData("Text", ev.target.getAttribute('id'));   
//    // Change the opacity of the draggable element
//    ev.target.style.opacity = "0.4";
//    ev.dataTransfer.setDragImage(ev.target,0,0);
//    return true;
    
//}

//function dragEnd(ev){
////    ev.document.getElementById(ev.target.id).empty();
////    
////    // Change the opacity of the draggable element
////    ev.target.style.opacity = "1";
//    
////    document.getElementById(ev.target.id).innerHTML = "";
////    document.getElementById(ev.target.id).style.visibility='hidden';
////    ev.target.id.parentNode.id;
////    var parnode = ev.target.parentNode;
//    if(ev.target.id == 'pid'){
//        ev.target.style.visibility='hidden';
//     }
//    
//    
//    
//}
//
//function drop(ev) {
//    ev.target.style.background = "";
//    ev.preventDefault();
//    var data = ev.dataTransfer.getData("text");
//    ev.target.appendChild(document.getElementById(data));
//    
//
////    dragged.parentNode.removeChild( dragged );
////    ev.target.appendChild( dragged );
////    
////    
////   ev.target.style.border = "";
////   ev.preventDefault();
////   var data = ev.dataTransfer.getData('Text');
////   ev.target.appendChild(document.getElementById(data));
////   ev.stopPropagation();
//}

//function allowDrop(ev) {
//    ev.preventDefault();
//}

