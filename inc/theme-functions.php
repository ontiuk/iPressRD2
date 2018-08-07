<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

/**
 * Theme
 * Pagination
 * Miscellaneous
 * Images & Media
 * Menu & Navigation
 * WooCommerce
 */

//----------------------------------------------
//	Theme
//	
//	- ipress_is_home_page
//	- ipress_is_index
//----------------------------------------------

/**
 * Check if the root page of the site is being viewed
 *
 * is_front_page() returns false for the root page of a website when
 * - the WordPress 'Front page displays' setting is set to 'Static page'
 * - 'Front page' is left undefined
 * - 'Posts page' is assigned to an existing page
 *
 * @return boolean
 */
function ipress_is_home_page() {
	return ( is_front_page() || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) ) ? true : false;
}

/**
 * Check if the page being viewed is the index page
 *
 * @param	string	$page
 * @return	boolean
 */
function ipress_is_index( $page ) {
	return ( basename( $page ) === 'index.php' );
}

//end
