<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme template hooks - actions and filters
 * 
 * @package     iPress\Includes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * Set up theme template hooks
 */ 
final class IPR_Hooks {

    /**
     * Class constructor
     */
    public function __construct() {
        
        // Place core hooks here, e.g. after_setup_theme, enqueue_scripts
        $this->init_core();
        
        // Hooks - Remove hooks, add new hooks 
        add_action( 'init', [ $this, 'init_markup' ] );

        // Homepage - Remove hooks, add new hooks
        add_action( 'init', [ $this, 'homepage_markup' ] );
    }

    //----------------------------------------------
    //  Core Actions & Filters
    //----------------------------------------------

    /**
     * WordPress core hooks - actions & filters
     */
    private function init_core() {};

    //----------------------------------------------
    //  Theme Hooks - Actions & Filters
    //----------------------------------------------

    /**
     * Initialise theme hooks
     */
    public function init_markup() {
    
        // General
        add_action( 'ipress_before_header', [ $this, 'skip_links' ],    10 );
        add_action( 'ipress_sidebar',       [ $this, 'get_sidebar' ],   10 );
    
        // Header
        add_action( 'ipress_header',        [ $this, 'site_branding' ],         10 );
        add_action( 'ipress_header',        [ $this, 'primary_navigation' ],    20 );

        // Footer
        add_action( 'ipress_footer',        [ $this, 'footer_widgets' ],    10 );
        add_action( 'ipress_footer',        [ $this, 'credit_info' ],       20 );

        // Posts
        add_action( 'ipress_loop_post',     [ $this, 'post_sticky' ],       5 );
        add_action( 'ipress_loop_post',     [ $this, 'post_header' ],       10 );
        add_action( 'ipress_loop_post',     [ $this, 'post_meta' ],         20 );
        add_action( 'ipress_loop_post',     [ $this, 'post_content' ],      30 );
        add_action( 'ipress_loop_post',     [ $this, 'post_footer' ],       40 );

        add_action( 'ipress_loop_after',            [ $this, 'paging_nav' ],        10 );
        add_action( 'ipress_post_content_before',   'ipress_post_thumbnail',        10 );

        // Single Post
        add_action( 'ipress_single_post',         [ $this, 'post_header' ],         10 );
        add_action( 'ipress_single_post',         [ $this, 'post_meta' ],           20 );
        add_action( 'ipress_single_post',         [ $this, 'post_content' ],        30 );
        add_action( 'ipress_single_post',         [ $this, 'post_footer' ],         40 );
        add_action( 'ipress_single_post_bottom',  [ $this, 'post_nav' ],            10 );
        add_action( 'ipress_single_post_bottom',  [ $this, 'display_comments' ],    20 );

        // Pages
        add_action( 'ipress_page',                  [ $this, 'page_header' ],       10 );
        add_action( 'ipress_page',                  [ $this, 'page_content' ],      20 );
        add_action( 'ipress_page',                  [ $this, 'page_footer' ],       30 );
        add_action( 'ipress_page_after',            [ $this, 'display_comments' ],  10 );
        add_action( 'ipress_post_content_before',   'ipress_post_thumbnail',        10 );

        // Search
        add_action( 'ipress_loop_search',     [ $this, 'post_header' ],     10 );
        add_action( 'ipress_loop_search',     [ $this, 'post_meta' ],       20 );
        add_action( 'ipress_loop_search',     [ $this, 'post_excerpt' ],    30 );
        add_action( 'ipress_loop_search',     [ $this, 'post_footer' ],     40 );
        add_action( 'ipress_loop_after',      [ $this, 'paging_nav' ],      10 );
    }

    //----------------------------------------------
    //  Homepage Hooks - Actions & Filters
    //----------------------------------------------

    /**
     * Initialise theme hooks
     */
    public function homepage_markup() {}

    //----------------------------------------------
    //  Core Hooks Functionality
    //----------------------------------------------

    //----------------------------------------------
    //  Template Hook Functions - General
    //----------------------------------------------

    /**
     * Add skip links html
    */
    public function skip_links() {
        get_template_part( 'templates/skip-links' );
    }    

    /**
     * Display sidebar
     *
     * @uses get_sidebar()
     */
    public function get_sidebar() {
	    get_sidebar();
    }

    //----------------------------------------------
    //  Template Hook Functions - Header
    //----------------------------------------------

    /**
     * Site branding wrapper and display
     */
    public function site_branding() {
        get_template_part( 'templates/site-branding' );
    }

    /**
     * Site navigation
     */
    public function primary_navigation() {
        get_template_part( 'templates/site-navigation' );
    }
    
    //----------------------------------------------
    //  Template Hook Functions - Footer
    //----------------------------------------------

    /**
     * Display the footer widget regions
     */
    public function footer_widgets() {
        get_template_part( 'templates/footer-widgets' );
    }

    /**
     * Display the theme credit
     */
    public function credit_info() {
        get_template_part( 'templates/site-credit' );
    }

    //----------------------------------------------
    //  Template Hook Functions - Posts
    //----------------------------------------------

    /**
     * Display the post sticky link
     */
    public function post_sticky() {
        get_template_part( 'templates/loop-sticky' );
    }

    /**
     * Display the post header 
     */
    public function post_header() {
        get_template_part( 'templates/loop-header' );
    }

    /**
     * Display the post meta data
     */
    public function post_meta() {
        get_template_part( 'templates/loop-meta' );
    }

    /**
     * Display the post content
     */
    public function post_content() {
        get_template_part( 'templates/loop-content' );
    }

    /**
     * Display the post content
     */
    public function post_excerpt() {
        get_template_part( 'templates/loop-excerpt' );
    }

    /**
     * Display the post footer
     */
    public function post_footer() {
        get_template_part( 'templates/loop-footer' );
    }

    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    public function paging_nav() {
    
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
    public function display_comments() {
    
        // If comments are open or we have at least one comment, load up the comment template.
	    if ( comments_open() || '0' != get_comments_number() ) :
		    comments_template();
	    endif;
    }

    /**
     * Display navigation to next/previous post when applicable.
     */
    public function post_nav() {
    
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
    public function page_header() {
        get_template_part( 'templates/page-header' );
    }

    /**
     * Display the page content
     */
    public function page_content() {
        get_template_part( 'templates/page-content' );
    }

    /**
     * Display the page footer 
     */
    public function page_footer() {
        get_template_part( 'templates/page-footer' );
    }

    //----------------------------------------------
    //  Homepage Hooks Functionality
    //----------------------------------------------
}

// Instantiate Hooks Class
return new IPR_Hooks;

//end
