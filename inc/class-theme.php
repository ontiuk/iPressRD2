<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Theme
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

/**
 * Set up core theme features
 */ 
final class IPR_Theme {

    /**
     * Class constructor. Set up hooks
     */
    public function __construct() {

        // Default content width for image manipulation
        add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

        // Core WordPress functionality
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Theme settings
        add_action( 'after_setup_theme', [ $this, 'theme_settings' ] );
    }

    //----------------------------------------------
    //  Theme SetUp
    //----------------------------------------------

    /**
     * Required default content width for image manipulation
     * - Priority 0 to make it available to lower priority callbacks.
     *
     * @global int $content_width
     */
    public function content_width() {
        $GLOBALS['content_width'] = apply_filters( 'ipress_content_width', 840 );
    }

    /**
     * Set up core theme settings & functionality
     */
    public function setup_theme() {

        // Localisation Support 
        load_theme_textdomain( 'ipress', IPRESS_LANG_DIR );

        // Enables post and comment RSS feed links to head 
        add_theme_support( 'automatic-feed-links' ); 

        // Make WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Add thumbnail theme support & post type support
        // - add_theme_support( 'post-thumbnails' ); 
        // - add_theme_support( 'post-thumbnails', $post_types ); 
        add_theme_support( 'post-thumbnails' ); 

        // Set thumbnail default size: width, height, crop
        // - set_post_thumbnail_size( 50, 50 ); // 50px x 50px, prop resize
        // - set_post_thumbnail_size( 50, 50, true ); // 50px x 50px, hard crop
        // - set_post_thumbnail_size( 50, 50, [ 'left', 'top' ] ); // 50px x 50px, hard crop from top left
        // - set_post_thumbnail_size( 50, 50, [ 'center', 'center' ] ); // 50 px x 50px, crop from center

        // Core image sizes overrides
        // - add_image_size( 'large', 1024, '', true ); // Large Image 
        // - add_image_size( 'medium', 768, '', true ); // Medium Image 
        // - add_image_size( 'small', 320, '', true);   // Small Image 
 
        // Custom image sizes
        // - add_image_size( 'custom-size', 220 );                  // 220px wide, relative height, soft proportional crop mode
        // - add_image_size( 'custom-size-prop', 220, 180 );        // 220px x 180px, soft proportional crop
        // - add_image_size( 'custom-size-prop-height', 9999, 180); // 180px height: proportion resize 
        // - add_image_size( 'custom-size', 220, 180, true );       // 220 pixels wide by 180 pixels tall, soft proportional crop mode

        // Add menu support 
        add_theme_support( 'menus' ); 

        // Register main navigation menu location
        register_nav_menus( [ 
            'primary'   => __( 'Primary Menu', 'ipress' )
        ] );

        // Register additional navigation menu locations
        // register_nav_menus( [ 
        //   'secondary' => __( 'Secondary Menu', 'ipress' ),
        //   'social'    => __( 'Social Menu', 'ipress' ),
        //   'header'    => __( 'Header Menu', 'ipress' ) 
        // ] );

        // Enable support for HTML5 markup: 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        add_theme_support( 'html5', [
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
            'caption'
        ] );
 
        // Add post-format support: 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        // - add_theme_support( 'post-formats', [ 'image', 'link' ] ); 

        // Enable support for custom logo - default off
        // see: https://developer.wordpress.org/themes/functionality/custom-logo/
        // logo_defaults = [
        //   'height'      => 80,
        //   'width'       => 250,
        //   'flex-height' => true,
        //   'flex-width'  => true,
        //   'header-text' => [ get_bloginfo( 'name' ), get_bloginfo( 'description' ) ]
        // ];
        // - add_theme_support( 'custom-logo', $logo_defaults );

        // Enable support for custom headers
        // see: https://developer.wordpress.org/themes/functionality/custom-headers/    
        // $header_defaults = [
        //    'default-image'          => '',
        //    'random-default'         => false,
        //    'width'                  => 0,
        //    'height'                 => 0,
        //    'flex-height'            => false,
        //    'flex-width'             => false,  
        //    'default-text-color'     => '', 
        //    'header-text'            => true,
        //    'uploads'                => true,
        //    'wp-head-callback'       => '',
        //    'admin-head-callback'    => '',
        //    'admin-preview-callback' => ''
        // ];
        // - add_theme_support( 'custom-header', $header_defaults ); 

        // Enable support for custom backgrounds - default false
        // see: https://codex.wordpress.org/Custom_Backgrounds
        // $background_defaults = [ 
        //     'default-color'         => '', 
        //     'default-image'         => '', 
        //     'wp-head-callback'      => '_custom_background_cb',
        //     'admin-head-callback'   => '',
        //     'admin-preview-callback' => ''
        // ];
        // - add_theme_support( 'custom-background', $background_defaults ); 
    
        // Add Woocommerce support?
        // - add_theme_support( 'woocommerce' ); 

        // Newer title tag hooks - requires title-tag support above
        add_filter( 'pre_get_document_title',   [ $this, 'pre_get_document_title' ] ); 
        add_filter( 'document_title_separator', [ $this, 'document_title_separator' ], 10, 1 ); 
        add_filter( 'document_title_parts',     [ $this, 'document_title_parts' ], 10, 1 ); 
    }

    //----------------------------------------------
    //  Title Tag Support
    //  - Make WordPress manage the document title
    //  - Required there is no hardcodeded title tag in header
    //----------------------------------------------

    /**
     * Define the pre_get_document_title callback 
     *  
     * @return  string
     */
    public function pre_get_document_title() { 
    
        // Home page?
        if ( ipress_is_home_page() ) {

            // Get details
            $title = get_bloginfo( 'name' );        
            $sep = (string)apply_filters( 'ipress_document_title_separator', '-' );
            $app = (bool)apply_filters( 'ipress_home_doctitle_append', '__return_true' );

            // Sanitize title
            $title = wptexturize( $title );
            $title = convert_chars( $title );
            $title = esc_html( $title );
            $title = capital_P_dangit( $title );

            // Return title        
            return ( $app ) ? $title . ' ' . $sep . ' ' . get_bloginfo( 'description' ) : $title;
        }

        // Default
        return ''; 
    } 

    /**
     * Define the document_title_separator callback 
     *
     * @param   string $sep
     * @return  string
     */
    public function document_title_separator( $sep ) { 

        // Get the theme setting and set if needed...
        $ts_sep = (string)apply_filters( 'ipress_doctitle_separator', '' );

        // Return title separator
        return ( empty( $ts_sep ) ) ? $sep : esc_html( $ts_sep ); 
    } 

    /**
     * Define the document_title_parts callback 
     *
     * @param   array $title
     * @return  array
     */ 
    public function document_title_parts( $title ) { 

        // Home page or not amending inner pages
        if ( is_front_page() || ipress_is_home_page() ) { return $title; }
    
        // Append site name?
        $app_site_name = (bool)apply_filters( 'ipress_append_site_name', '__return_true' );
        $title['site'] = ( $app_site_name ) ? get_bloginfo( 'name' ) : '';

        // Return
        return $title; 
    }

    //----------------------------------------------
    //  Theme Mods
    //----------------------------------------------

    /**
     * Check and setup default theme settings - mods & options
     * - Check if setting is set, if not set default
     */
    public function theme_settings() {

        // Latest blog posts style
    	$post_format = get_theme_mod( 'ipress_posts_format' );
	    if ( empty( $post_format ) ) {
		    set_theme_mod( 'ipress_post_format', 'default' );
	    }

    	// Content position
	    $ipress_content = get_theme_mod( 'ipress_content' );
    	if ( empty( $ipress_content ) ) {
    		set_theme_mod( 'ipress_content', 'left' );
    	}
    }
}

// Instantiate Theme Class
return new IPR_Theme;

//end
