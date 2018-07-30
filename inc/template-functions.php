<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template hooks functions
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Core Hooks Functions
//----------------------------------------------

//----------------------------------------------
//	General Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_skip_links' ) ) {
	/**
	 * Add skip links html
	*/
	function ipress_skip_links() {
		get_template_part( 'templates/global/skip-links' );
	}	 
}

if ( ! function_exists( 'ipress_get_sidebar' ) ) {
	/**
	 * Display sidebar
	 *
	 * @uses 	get_sidebar()
	 * @param	string	$sidebar default empty
	 */
	function ipress_get_sidebar( $sidebar='' ) {
		if ( empty( $sidebar ) ) {
			get_sidebar();
		} else {
			get_sidebar( $sidebar );
		}
	}
}

if ( ! function_exists( 'ipress_scroll_top' ) ) {
	/**
	 * Scroll to top link
	 */
	function ipress_scroll_top() {
		echo '<div id="scrollTop" class="scroll-top"></div>';
	}
}

//----------------------------------------------
//	Header Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 */
	function ipress_site_branding() {
		get_template_part( 'templates/header/site-branding' );
	}
}

if ( ! function_exists( 'ipress_primary_navigation' ) ) {
	/**
	 * Site navigation
	 */
	function ipress_primary_navigation() {
		get_template_part( 'templates/header/site-navigation' );
	}
}

//----------------------------------------------
//	Footer Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions
	 */
	function ipress_footer_widgets() {
		get_template_part( 'templates/footer/footer-widgets' );
	}
}

if ( ! function_exists( 'ipress_credit_info' ) ) {
	/**
	 * Display the theme credit
	 */
	function ipress_credit_info() {
		get_template_part( 'templates/footer/site-credit' );
	}
}

//----------------------------------------------
//	Posts Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_loop_sticky' ) ) {
	/**
	 * Display the post sticky link
	 */
	function ipress_loop_sticky() {
		get_template_part( 'templates/loop/loop-sticky' );
	}
}

if ( ! function_exists( 'ipress_loop_header' ) ) {
	/**
	 * Display the post header 
	 */
	function ipress_loop_header() {
		get_template_part( 'templates/loop/loop-header' );
	}
}

if ( ! function_exists( 'ipress_loop_meta' ) ) {
	/**
	 * Display the post meta data
	 */
	function ipress_loop_meta() {
		get_template_part( 'templates/loop/loop-meta' );
	}
}

if ( ! function_exists( 'ipress_loop_content' ) ) {
	/**
	 * Display the post content
	 */
	function ipress_loop_content() {
		get_template_part( 'templates/loop/loop-content' );
	}
}

if ( ! function_exists( 'ipress_loop_excerpt' ) ) {
	/**
	 * Display the post excerpt
	 */
	function ipress_loop_excerpt() {
		get_template_part( 'templates/loop/loop-excerpt' );
	}
}

if ( ! function_exists( 'ipress_loop_footer' ) ) {
	/**
	 * Display the post footer
	 */
	function ipress_loop_footer() {
		get_template_part( 'templates/loop/loop-footer' );
	}
}

if ( ! function_exists( 'ipress_loop_thumbnail' ) ) {
	/**
	 * Display the post thumbnail
	 */
	function ipress_loop_thumbnail() {
		get_template_part( 'templates/loop/loop-thumbnail' );
	}
}

if ( ! function_exists( 'ipress_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function ipress_paging_nav() {

		global $wp_query;

		$args = [
			'type'		=> 'list',
			'next_text' => _x( 'Next', 'Next post', 'ipress' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'ipress' ),
		];

		the_posts_pagination( $args );
	}
}

//----------------------------------------------
//	Single Post Hook Functions 
//----------------------------------------------

if ( ! function_exists( 'ipress_post_header' ) ) {
	/**
	 * Display the post header 
	 */
	function ipress_post_header() {
		get_template_part( 'templates/single/post-header' );
	}
}

if ( ! function_exists( 'ipress_post_meta' ) ) {
	/**
	 * Display the post meta data
	 */
	function ipress_post_meta() {
		get_template_part( 'templates/single/post-meta' );
	}
}

if ( ! function_exists( 'ipress_post_content' ) ) {
	/**
	 * Display the post content
	 */
	function ipress_post_content() {
		get_template_part( 'templates/single/post-content' );
	}
}

if ( ! function_exists( 'ipress_post_footer' ) ) {
	/**
	 * Display the post footer
	 */
	function ipress_post_footer() {
		get_template_part( 'templates/single/post-footer' );
	}
}

if ( ! function_exists( 'ipress_post_image' ) ) {
	/**
	 * Display the post image
	 */
	function ipress_post_image() {
		get_template_part( 'templates/single/post-image' );
	}
}

if ( ! function_exists( 'ipress_display_comments' ) ) {
	/**
	 * Display the comments form
	 */
	function ipress_display_comments() {

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'ipress_post_nav' ) ) {
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
}

//----------------------------------------------
//	Template Hook Functions - Pages
//----------------------------------------------

if ( ! function_exists( 'ipress_page_header' ) ) {
	/**
	 * Display the page header 
	 */
	function ipress_page_header() {
		get_template_part( 'templates/page/page-header' );
	}
}

if ( ! function_exists( 'ipress_page_content' ) ) {
	/**
	 * Display the page content
	 */
	function ipress_page_content() {
		get_template_part( 'templates/page/page-content' );
	}
}

if ( ! function_exists( 'ipress_page_footer' ) ) {
	/**
	 * Display the page footer 
	 */
	function ipress_page_footer() {
		get_template_part( 'templates/page/page-footer' );
	}
}

if ( ! function_exists( 'ipress_page_image' ) ) {
	/**
	 * Display the page image 
	 */
	function ipress_page_image() {
		get_template_part( 'templates/page/page-image' );
	}
}

//----------------------------------------------
//	Post Formats Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_loop_content_audio' ) ) {
	/**
	 * Display the post format content audio 
	 */
	function ipress_loop_content_audio() {
		get_template_part( 'templates/loop/loop-content-audio' );
	}
}

if ( ! function_exists( 'ipress_loop_content_excerpt' ) ) {
	/**
	 * Display the post format content excerpt
	 */
	function ipress_loop_content_excerpt() {
		get_template_part( 'templates/loop/loop-content-excerpt' );
	}
}
if ( ! function_exists( 'ipress_loop_content_gallery' ) ) {
	/**
	 * Display the post format content gallery
	 */
	function ipress_loop_content_gallery() {
		get_template_part( 'templates/loop/loop-content-gallery' );
	}
}
if ( ! function_exists( 'ipress_loop_content_image' ) ) {
	/**
	 * Display the post format content image
	 */
	function ipress_loop_content_image() {
		get_template_part( 'templates/loop/loop-content-image' );
	}
}

//----------------------------------------------
//	Homepage Hooks Functions
//----------------------------------------------

