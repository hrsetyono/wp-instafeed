// Extra scripts for Admin pages
(function($) { 'use strict';

$(document).ready(start);
$(document).on('page:load', start);
$(window).load(startOnLoad);

function start() {
  app.init();
}

// functions that needs to run only after everything loads
function startOnLoad() {

}

///

var app = {
  init: function() {
    // do something
  }
}

})(jQuery);
