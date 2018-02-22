<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Set up theme template hooks
 * 
 * @package     iPress\Includes
 * @link        http://on.tinternet.co.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

//----------------------------------------------
//  Template Hooks
//----------------------------------------------

/**
 * General
 *
 * @see ipress_skip_links()
 */
add_action( 'ipress_before_header', 'ipress_skip_links',    10 );
add_action( 'ipress_sidebar',       'ipress_get_sidebar',   10 );

/**
 * Header
 * @see ipress_site_branding()
 * @see ipress_primary_navigation()
 */
add_action( 'ipress_header',    'ipress_site_branding',         10 );
add_action( 'ipress_header',    'ipress_primary_navigation',    20 );

/**
 * Footer
 *
 * @see ipress_footer_widgets()
 * @see ipress_credit()
 */
add_action( 'ipress_footer', 'ipress_footer_widgets', 10 );
add_action( 'ipress_footer', 'ipress_credit',         20 );

/**
 * Homepage
 *
 */

/**
 * Posts
 *
 * @see ipress_post_sticky()
 * @see ipress_post_header()
 * @see ipress_post_meta()
 * @see ipress_post_content()
 * @see ipress_post_footer()
 * @see ipress_paging_nav()
 * @see ipress_post_thumbnail()
 */
add_action( 'ipress_loop_post',     'ipress_post_sticky',       5 );
add_action( 'ipress_loop_post',     'ipress_post_header',       10 );
add_action( 'ipress_loop_post',     'ipress_post_meta',         20 );
add_action( 'ipress_loop_post',     'ipress_post_content',      30 );
add_action( 'ipress_loop_post',     'ipress_post_footer',       40 );

add_action( 'ipress_loop_after',            'ipress_paging_nav',    10 );
add_action( 'ipress_post_content_before',   'ipress_post_thumbnail', 10 );

/**
 * Single Post
 *
 * @see ipress_post_sticky()
 * @see ipress_post_header()
 * @see ipress_post_meta()
 * @see ipress_post_content()
 * @see ipress_post_footer()
 * @see ipress_post_nav()
 */
add_action( 'ipress_single_post',         'ipress_post_header',             10 );
add_action( 'ipress_single_post',         'ipress_post_meta',               20 );
add_action( 'ipress_single_post',         'ipress_post_content',            30 );
add_action( 'ipress_single_post',         'ipress_post_footer',             40 );
add_action( 'ipress_single_post_bottom',  'ipress_post_nav',                10 );
add_action( 'ipress_single_post_bottom',  'ipress_display_comments',        20 );

/**
 * Pages
 *
 * @see  ipress_page_header()
 * @see  ipress_page_content()
 * @see  ipress_init_structured_data()
 * @see  ipress_display_comments()
 */
add_action( 'ipress_page',       'ipress_page_header',          10 );
add_action( 'ipress_page',       'ipress_page_content',         20 );
add_action( 'ipress_page',       'ipress_page_footer',          30 );
add_action( 'ipress_page_after', 'ipress_display_comments',     10 );
add_action( 'ipress_post_content_before', 'ipress_post_thumbnail',  10 );

/**
 * Search
 *
 * @see ipress_post_header()
 * @see ipress_post_meta()
 * @see ipress_post_excerpt()
 * @see ipress_footer()
 * @see ipress_paging_nav()
 */
add_action( 'ipress_loop_search',     'ipress_post_header',     10 );
add_action( 'ipress_loop_search',     'ipress_post_meta',       20 );
add_action( 'ipress_loop_search',     'ipress_post_excerpt',    30 );
add_action( 'ipress_loop_search',     'ipress_post_footer',     40 );
add_action( 'ipress_loop_after',      'ipress_paging_nav',      10 );

/**
 * Core - Wordpress built-in actions & filters
 */

//end
