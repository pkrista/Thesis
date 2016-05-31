$(document).foundation();

function showOverlay(){
    $("#overlay").show();
}

function hideOverlay(){
    $("#overlay").hide();
}

function createSpinner(){
    
    var opts = {
        lines: 11 // The number of lines to draw
      , length: 20 // The length of each line
      , width: 20 // The line thickness
      , radius: 60 // The radius of the inner circle
      , scale: 1 // Scales overall size of the spinner
      , corners: 1 // Corner roundness (0..1)
      , color: '#000' // #rgb or #rrggbb or array of colors
      , opacity: 0.25 // Opacity of the lines
      , rotate: 0 // The rotation offset
      , direction: 1 // 1: clockwise, -1: counterclockwise
      , speed: 1 // Rounds per second
      , trail: 50 // Afterglow percentage
      , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
      , zIndex: 2e9 // The z-index (defaults to 2000000000)
      , className: 'spinner' // The CSS class to assign to the spinner
      , top: '50%' // Top position relative to parent
      , left: '50%' // Left position relative to parent
      , shadow: true // Whether to render a shadow
      , hwaccel: false // Whether to use hardware acceleration
      , position: 'absolute' // Element positioning
      };
    
    var target = document.getElementById('body');
    var spinner = new Spinner(opts).spin(target);
    
    target.appendChild(spinner.el);
    
    return spinner;
}