<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme standalone functions
 * 
 * @package     iPress\Template-Functions
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
//  Template Hook Functions - General
//----------------------------------------------

/**
 * Add skip links html
 */
function ipress_skip_links() {
    get_template_part( 'templates/skip-links' );
}    

/**
 * Display ipress sidebar
 *
 * @uses get_sidebar()
 */
function ipress_get_sidebar() {
	get_sidebar();
}

//----------------------------------------------
//  Template Hook Functions - Header
//----------------------------------------------

/**
 * Site branding wrapper and display
 */
function ipress_site_branding() {
    get_template_part( 'templates/site-branding' );
}

/**
 * Site navigation
 */
function ipress_primary_navigation() {
    get_template_part( 'templates/site-navigation' );
}

//----------------------------------------------
//  Template Hook Functions - Footer
//----------------------------------------------


/**
 * Display the theme credit
 */
function ipress_credit() {
    get_template_part( 'templates/site-credit' );
}

/**
 * Display the footer widget regions
 */
function ipress_footer_widgets() {
    get_template_part( 'templates/footer-widgets' );
}

//----------------------------------------------
//  Template Hook Functions - Homepage
//----------------------------------------------

//----------------------------------------------
//  Template Hook Functions - Posts
//----------------------------------------------

/**
 * Display the post sticky link
 */
function ipress_post_sticky() {
    get_template_part( 'templates/loop-sticky' );
}

/**
 * Display the post header 
 */
function ipress_post_header() {
    get_template_part( 'templates/loop-header' );
}

/**
 * Display the post meta data
 */
function ipress_post_meta() {
    get_template_part( 'templates/loop-meta' );
}

/**
 * Display the post content
 */
function ipress_post_content() {
    get_template_part( 'templates/loop-content' );
}

/**
 * Display the post content
 */
function ipress_post_excerpt() {
    get_template_part( 'templates/loop-excerpt' );
}

/**
 * Display the post footer
 */
function ipress_post_footer() {
    get_template_part( 'templates/loop-footer' );
}

/**
 * Display navigation to next/previous set of posts when applicable.
 */
function ipress_paging_nav() {
	global $wp_query;

	$args = [
		'type' 	    => 'list',
		'next_text' => _x( 'Next', 'Next post', 'ipress' ),
		'prev_text' => _x( 'Previous', 'Previous post', 'ipress' ),
    ];

	the_posts_pagination( $args );
}

//----------------------------------------------
//  Template Hook Functions - Single Post
//----------------------------------------------

/**
 * Display the comments form
 */
function ipress_display_comments() {
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || '0' != get_comments_number() ) :
		comments_template();
	endif;
}

/**
 * Display navigation to next/previous post when applicable.
 */
function ipress_post_nav() {
	$args = [
		'next_text' => '%title',
		'prev_text' => '%title',
    ];
	the_post_navigation( $args );
}

//----------------------------------------------
//  Template Hook Functions - Pages
//----------------------------------------------

/**
 * Display the page header 
 */
function ipress_page_header() {
    get_template_part( 'templates/page-header' );
}

/**
 * Display the page content
 */
function ipress_page_content() {
    get_template_part( 'templates/page-content' );
}

/**
 * Display the page footer 
 */
function ipress_page_footer() {
    get_template_part( 'templates/page-footer' );
}

//----------------------------------------------
//  Template Hook Functions - Core
//----------------------------------------------

//end
