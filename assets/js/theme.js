// Theme jQuery functionality
( function( $, t, undefined ) {
	"use strict";
	
	// Vars

	// Window & Document
	var body	= $('body'),
		_window = $(window);
	
	// On window load functions
	_window.on('load', function(){});

	// Window scroll function
    _window.scroll(function () {});

	// Disable default link behavior for dummy links : href='#'
	$('a[href="#"]').click( function(e) {
		e.preventDefault();
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

	// Function definitions
	
	// Inner IIFE
	( function() {} )();

	// Document Ready DOM
	$(function(){ 

		// scroll body to top on click
		$('.scroll-top').on( 'click', function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

	});

	// Other jQuery
    $('.scroll-top').hide();

})( jQuery, theme );

//end
