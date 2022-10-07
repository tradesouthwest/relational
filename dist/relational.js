/*!
 * Relational Scripts
 * Version 1.0.0
 */

jQuery(function($) {
  // Bootstrap menu magic
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $(".dropdown-toggle").attr('data-toggle', 'dropdown');
    } else {
      $(".dropdown-toggle").removeAttr('data-toggle dropdown');
    }
     
  });
});

/* --------- jQuery capsule ---------- */
(function( $ ) {
    "use strict";
    jQuery(document).ready(function() {

        $(function() {

            var windowsize = $(window).width();
            
            if (windowsize < 769) {
                $(".space-above-fornav").css("height", $(".navbar-fixed").height());
                console.log($(".navbar-fixed").height());
                console.log($(".space-above-fornav").height());
            } else {
                $(".space-above-fornav").css("height", $(".navbar-fixed").height());
                console.log($(".space-above-fornav").height());
            }
            /* Reset to defaults if agent is resized manually */
            $( window ).resize( function() {
                $(".space-above-fornav").css("height", $(".navbar-fixed").height());
                console.log($(".space-above-fornav").height());
            });

        });
    
    });
})(jQuery);
