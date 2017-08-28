<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Init
 * @link        http://ipress.co.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * Set up core WordPress Jetpack features
 */ 
final class IPR_Jetpack {

	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_action( 'after_setup_theme',  [ $this, 'jetpack_init' ] );
	}

	/**
     * Add theme support for Jetpack functionality
     * 
	 * @see http://jetpack.me/support/infinite-scroll/
     * @see https://jetpack.com/support/responsive-videos/
	 */
    public function jetpack_init() {

        // Jetpack Reponsive Videos
        add_theme_support( 'jetpack-responsive-videos' );

        // Jetpack Infinite Scroll
		add_theme_support( 'infinite-scroll', apply_filters( 'ipress_jetpack_infinite_scroll', [
			'container'      => 'main',
			'footer'         => 'page',
			'type'           => 'click',
			'posts_per_page' => '12',
			'render'         => [ $this, 'infinite_scroll_render' ],
			'footer_widgets' => [],
        ] ) );
    }

	/**
	 * A loop used to display content appended using Jetpack inifinte scroll
	 * @return void
	 */
	public function jetpack_infinite_scroll_loop() {

        // Initiate loop
        while ( have_posts() ) : the_post();
            if ( is_search() ) :
		        get_template_part( 'templates/content', 'search' );
	        else :
		        get_template_part( 'templates/content', get_post_format() );
       		endif;
        endwhile;
	}
}

// Initiate Jetpack Class
return new IPR_Jetpack();
