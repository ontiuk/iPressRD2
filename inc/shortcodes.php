<?php 

/**
 * iPress - WordPress Base Theme                       
 * ==========================================================
 *
 * Theme shortcodes
 *
 * @package     iPress\Shortcodes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

//----------------------------------------------  
// Shortcodes
//----------------------------------------------  

// Include shortcode files by type
include_once( IPRESS_SHORTCODES_DIR . '/analytics.php' );
include_once( IPRESS_SHORTCODES_DIR . '/category.php' );
include_once( IPRESS_SHORTCODES_DIR . '/date.php' );
include_once( IPRESS_SHORTCODES_DIR . '/links.php' );
include_once( IPRESS_SHORTCODES_DIR . '/media.php' );
include_once( IPRESS_SHORTCODES_DIR . '/post.php' );
include_once( IPRESS_SHORTCODES_DIR . '/search-form.php' );
include_once( IPRESS_SHORTCODES_DIR . '/user.php' );

//---------------------------------------------
//  Shortcode Actions
//---------------------------------------------

// Allow shortcodes in Widgets
add_filter( 'widget_text', 'do_shortcode' );          

// Remove <p> tags in Widgets
add_filter( 'widget_text', 'shortcode_unautop' ); 

// Remove auto <p> tags in Excerpt
add_filter( 'the_excerpt', 'shortcode_unautop' ); 

// Allows Shortcodes to be executed in Excerpt
add_filter( 'the_excerpt', 'do_shortcode' );     

//---------------------------------------------
//  Shortcode Functions
//---------------------------------------------

/**
 * Call a shortcode function by tag name
 *
 * @param string $tag     Shortcode function to call
 * @param array  $atts    Shortcode attributes 
 * @param array  $content Shortcode content
 *
 * @return string|bool False on failure, shortcode result on success
 */
function ipress_do_shortcode( $tag, $atts = [], $content = null ) {

    global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) || !is_array( $atts ) ) { return false; }
	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

//end
