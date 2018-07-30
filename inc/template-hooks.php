<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template hooks - actions and filters
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Core Actions & Filters
//----------------------------------------------

//------------------------------------------
//  General
//------------------------------------------

/**
 * @see  ipress_skip_links()
 * @see  ipress_get_sidebar()
 * @see  ipress_scroll_top()
 */
add_action( 'ipress_before_header', 'ipress_skip_links',	3 );
add_action( 'ipress_sidebar',		'ipress_get_sidebar',	10 );
add_action( 'ipress_after_content',	'ipress_scroll_top', 	10 );
	    
//------------------------------------------
//  Header
//------------------------------------------

/**
 * @see  ipress_site_branding()
 * @see  ipress_primary_navigation()
 */
add_action( 'ipress_header',	'ipress_site_branding',			10 );
add_action( 'ipress_header',	'ipress_primary_navigation',	20 );

//------------------------------------------
//  Footer
//------------------------------------------

/**
 * @see  ipress_footer_widgets()
 * @see  ipress_credit()
 */
add_action( 'ipress_footer',	'ipress_footer_widgets',	10 );
add_action( 'ipress_footer',	'ipress_credit_info',		20 );

//------------------------------------------
//  Posts
//------------------------------------------

/**
 * @see  ipress_loop_sticky()
 * @see  ipress_loop_header()
 * @see  ipress_loop_meta()
 * @see  ipress_loop_content()
 * @see  ipress_loop_footer()
 * @see	 ipress_init_structured_data()
 * @see  ipress_paging_nav()
 * @see  ipress_post_thumbnail()
 */
add_action( 'ipress_loop_post',		'ipress_loop_sticky',			5 );
add_action( 'ipress_loop_post',		'ipress_loop_header',			10 );
add_action( 'ipress_loop_post',		'ipress_loop_meta',				20 );
add_action( 'ipress_loop_post',		'ipress_loop_content',			30 );
add_action( 'ipress_loop_post',		'ipress_loop_footer',			40 );
add_action( 'ipress_loop_footer',	'ipress_init_structured_data',	10 );

add_action( 'ipress_loop_after',			'ipress_paging_nav',	10 );
add_action( 'ipress_loop_content_before',	'ipress_loop_image',	10 );

//------------------------------------------
// Post Formats - Not Yet Implemented
//------------------------------------------

/**
 * @see  ipress_loop_sticky()
 * @see  ipress_loop_header()
 * @see  ipress_loop_content_audio()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_loop_post_audio',   'ipress_loop_sticky',          5 );
add_action( 'ipress_loop_post_audio',   'ipress_loop_header',          10 );
add_action( 'ipress_loop_post_audio',   'ipress_loop_content_audio',   20 );
add_action( 'ipress_loop_post_audio',   'ipress_init_structured_data', 30 );

/**
 * @see  ipress_loop_header()
 * @see  ipress_loop_content_excerpt()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_loop_post_excerpt', 'ipress_loop_header',          10 );
add_action( 'ipress_loop_post_excerpt', 'ipress_loop_content_excerpt', 20 );
add_action( 'ipress_loop_post_excerpt', 'ipress_init_structured_data', 30 );

/**
 * @see  ipress_loop_sticky()
 * @see  ipress_loop_header()
 * @see  ipress_loop_content_gallery()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_loop_post_gallery', 'ipress_loop_sticky',          5 );
add_action( 'ipress_loop_post_gallery', 'ipress_loop_header',          10 );
add_action( 'ipress_loop_post_gallery', 'ipress_loop_content_gallery', 20 );
add_action( 'ipress_loop_post_gallery', 'ipress_init_structured_data', 30 );

/**
 * @see  ipress_loop_sticky()
 * @see  ipress_loop_header()
 * @see  ipress_loop_content_image()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_loop_post_image',   'ipress_loop_sticky',          5 );
add_action( 'ipress_loop_post_image',   'ipress_loop_header',          10 );
add_action( 'ipress_loop_post_image',   'ipress_loop_content_image',   20 );
add_action( 'ipress_loop_post_image',   'ipress_init_structured_data', 30 );

//------------------------------------------
//  Single
//------------------------------------------

/**
 * @see  ipress_post_header()
 * @see  ipress_post_meta()
 * @see  ipress_post_content()
 * @see  ipress_post_footer()
 * @see  ipress_init_structured_data()
 * @see  ipress_post_nav()
 * @see  ipress_display_comments()
 * @see  ipress_post_thumbnail
 */
add_action( 'ipress_single_post',			'ipress_post_header',			10 );
add_action( 'ipress_single_post',		  	'ipress_post_meta',				20 );
add_action( 'ipress_single_post',		  	'ipress_post_content',			30 );
add_action( 'ipress_single_post',		  	'ipress_post_footer',			40 );
add_action( 'ipress_post_footer',			'ipress_init_structured_data',	10 );

add_action( 'ipress_single_post_bottom',  	'ipress_post_nav',			10 );
add_action( 'ipress_single_post_bottom',  	'ipress_display_comments',	20 );
add_action( 'ipress_post_content_before',	'ipress_post_thumbnail',	10 );

//------------------------------------------
//  Page
//------------------------------------------

/**
 * @see  ipress_page_header()
 * @see  ipress_page_content()
 * @see  ipress_page_footer()
 * @see  ipress_init_structured_data()
 * @see  ipress_display_comments()
 * @see  ipress_post_thumbnail
 */
add_action( 'ipress_page',					'ipress_page_header',			10 );
add_action( 'ipress_page',					'ipress_page_content',			20 );
add_action( 'ipress_page',					'ipress_page_footer',			30 );
add_action( 'ipress_page_footer',			'ipress_init_structured_data',	10 );

add_action( 'ipress_page_after_content',	'ipress_display_comments',		10 );
add_action( 'ipress_page_content_before',	'ipress_post_thumbnail',		10 );

//------------------------------------------
//  Search
//------------------------------------------

/**
 * @see  ipress_loop_header()
 * @see  ipress_loop_meta()
 * @see  ipress_loop_excerpt()
 * @see  ipress_loop_footer()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_loop_search',	'ipress_loop_header',			10 );
add_action( 'ipress_loop_search',	'ipress_loop_meta',				20 );
add_action( 'ipress_loop_search',	'ipress_loop_excerpt',			30 );
add_action( 'ipress_loop_search',	'ipress_loop_footer',			40 );
add_action( 'ipress_loop_footer',	'ipress_init_structured_data',	10 );

//------------------------------------------
//  Homepage
//------------------------------------------

//End
