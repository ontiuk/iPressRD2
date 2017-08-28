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
 * Set up core WordPress theme features
 */ 
final class IPR_Init {

    /**
     * Class constructor. Set up hooks
     */
    public function __construct() {

        // Clean up the messy WordPress header
        add_action( 'init', [ $this, 'header_clean' ] );

        // Remove the bloody awful emojicons! Worse than Pokemon!
        add_action( 'init', [ $this, 'disable_emojicons' ] );

        // Remove the admin bars
        // add_action( 'init', [ $this, 'admin_bar' ] );

        // Add a pingback url for articles if pings active
        add_action( 'wp_head', [ $this, 'pingback_header' ] );    
    }

    //----------------------------------------------
    //  Header Tidy Up
    //----------------------------------------------

    /**
     * Clean the WordPress Header
     * - The WordPress head contains multiple meta & link records,
     * - many of which are not required, are detrimental, and slow loading
     * - All are removed here by default. Comment out/remove entries to reactivate
     */
    public function header_clean() {
    
        // Due process
        $do_clean = apply_filters( 'ipress_header_clean', true );
        if ( ! $do_clean ) { return; }

        // Post & comment feeds    
        remove_action( 'wp_head', 'feed_links', 2 );

        // Category feeds
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        // EditURI link    
        remove_action( 'wp_head', 'rsd_link' );

        // Windows live writer    
        remove_action( 'wp_head', 'wlwmanifest_link' );

        // Remove meta robots tag from wp_head
        remove_action( 'wp_head', 'noindex', 1 );

        // Index link
        remove_action( 'wp_head', 'index_rel_link' ); 

        // Previous link
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

        // Start link
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

        // Links for adjacent posts    
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 

        // XHTML generator
        add_filter( 'the_generator', [ $this, 'disable_version' ] );
        remove_action( 'wp_head', 'wp_generator' ); 

        // Shortlink for the page    
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

        // Remove WP version from scripts    
        add_filter( 'style_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 ); 
        add_filter( 'script_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 );

        // Remove 'text/css' from enqueued stylesheet
        add_filter( 'style_loader_tag', [ $this, 'style_remove' ] );

        // Remove inline Recent Comment Styles from wp_head()
        add_action( 'widgets_init', [ $this, 'head_comments' ] );

        // Canonical refereneces    
        remove_action( 'wp_head', 'rel_canonical' );  

        // Show less info to users on failed login for security.
        add_filter( 'login_errors', [ $this, 'login_info' ] );  
    }

    /**
     * Disable Version Reference
     *
     * @return  string
     */
    public function disable_version() { 
        return ''; 
    }
    
    /**
     * remove WP version from scripts    
     *
     * @param   string $src
     * @param   string $handle
     * @return  string
     */
    public function loader_src( $src, $handle ) { 
        return ( strpos( $src, 'ver=' ) ) ? remove_query_arg( 'ver', $src ) : $src; 
    }

    /**
     * Remove 'text/css' from our enqueued stylesheet
     *
     * @param   string
     * @return  string
     */
    public function style_remove($tag) {
        return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
    }

    /**
     * Remove wp_head() injected Recent Comment styles
     *
     * global $wp_widget_factory;
     */
    public function head_comments(){

        global $wp_widget_factory;

        // Remove head comments
        remove_action( 'wp_head', [
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ] );

        // Check and remove
        if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
            remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
        }
    }

    /**
     * Show less info to users on failed login for security
     *
     * @return string
     */
    public function login_info() {
    	return apply_filters( 'ipress_login_info', __( '<strong>ERROR</strong>: Stop guessing!', 'ipress' ) );
    }

    //----------------------------------------------
    //  Features
    //----------------------------------------------

    /**
     * Remove emojicons support - hurrah!
     */
    public function disable_emojicons() { 

        // Remove head/foot styles & scripts    
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );    
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        // Editor functionality
        add_filter( 'tiny_mce_plugins', [ $this, 'disable_emojis_tinymce' ] );
    } 

    /**
     *  Remove tinymce emoji support
     *
     *  @param  array $plugins
     *  @return array
     */
    public function disable_emojis_tinymce( $plugins ) { 
        return ( is_array( $plugins ) ) ? array_diff( $plugins, [ 'wpemoji' ] ) : []; 
    } 

    /**
     * Hide the Admin Bar
     */
    public function admin_bar() {

        // admin bar - All Users
        // $this->hide_adminbar( true );
    
        // admin bar - Non Admin Users Only
        // $this->hide_adminbar( false );
    }

    /**
     *  Remove adminbar for non-admin logged in users
     *
     *  @param boolean $all
     */
    private function hide_adminbar( $all ) {

        // All users or logged in non-admin users
        if ( $all ) { 
            add_filter( 'show_admin_bar', '__return_false' );
        } else { 
            if ( !current_user_can( 'administrator' ) && !is_admin() ) { add_filter( 'show_admin_bar', '__return_false' ); }
        }
    }

    /**
     * Add a pingback url for articles if pings active
     */
    public function pingback_header() {
    	if ( is_singular() && pings_open() ) {
    		echo sprintf( '<link rel="pingback" href="%s">', get_bloginfo( 'pingback_url' ) );
	    }
    }
}

// Instantiate Initialiser Class
return new IPR_Init;

//end
