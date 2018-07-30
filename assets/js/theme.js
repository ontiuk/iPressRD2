// Theme jQuery functionality
( function( $, t, undefined ) {
	"use strict";
	
	// Window & Document
	var body	= $('body'),
		_window = $(window);
	
	// On window load functions
	_window.on('load', function(){});

    // Windor scroll to top functions
    _window.on('scroll', function () {
        if (_window.scrollTop() >= 800) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });

	// Disable default link behavior for dummy links : href='#' & internal nav links
    $('a[href^="#"]').on('click', function(event) {
        event.preventDefault();
        var target = $(this.getAttribute('href'));
    
        if ( target.length ) {
            $('html, body').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });

    // ------------------------------------------------------- //
    // Scroll To Identirier
    // ------------------------------------------------------ //
    function scrollTo(full_url) {
        var parts = full_url.split("#");
        var trgt = parts[1];
        var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top - 100;
        if (target_top < 0) {
            target_top = 0;
        }

        $('html, body').animate({
            scrollTop: target_top
        }, 1000);
    }
	
	// Document Ready DOM
	$(function(){ 

		// scroll body to top on click
		$('.scroll-top').on( 'click', function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

        // Animated scrolling
        $('.scroll-to, .scroll-to-top').click(function (e) {
            e.preventDefault();

            var full_url = this.href,
                parts = full_url.split("#");
    
            if (parts.length > 1) {
                scrollTo(full_url);
            }
        });

	});

	// Other jQuery
    $('.scroll-top').hide();

})( jQuery, theme );

//end
