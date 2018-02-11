<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
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
 * Set up core theme features
 */ 
final class IPR_Theme {

    /**
     * Post structured data
     */
    private static $structured_data;

    /**
     * Class constructor. Set up hooks
     */
    public function __construct() {

        // Default content width for image manipulation
        add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

        // Core WordPress functionality
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Single post data
        add_action( 'wp_footer', [ $this, 'get_structured_data' ] );

        // Preload fonts
        add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );
    }

    //----------------------------------------------
    //  Theme SetUp
    //----------------------------------------------

    /**
     * Required default content width for image manipulation
     * - Priority 0 to make it available to lower priority callbacks
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

        // Localisation Support - Loads file e.g: wp-content/themes/ipress/includes/languages/en_GB.mo
        load_theme_textdomain( 'ipress', IPRESS_LANG_DIR );

        // Enables post and comment RSS feed links to head 
        add_theme_support( 'automatic-feed-links' ); 

        // Make WordPress manage the document title & <title> tag
        add_theme_support( 'title-tag' );

        // Add thumbnail theme support & post type support
        // @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        // - add_theme_support( 'post-thumbnails' ); 
        // - add_theme_support( 'post-thumbnails', $post_types ); 
        add_theme_support( 'post-thumbnails' ); 

        // Set thumbnail default size: width, height, crop
        // - set_post_thumbnail_size( 50, 50 ); // 50px x 50px, prop resize
        // - set_post_thumbnail_size( 50, 50, true ); // 50px x 50px, hard crop
        // - set_post_thumbnail_size( 50, 50, [ 'left', 'top' ] ); // 50px x 50px, hard crop from top left
        // - set_post_thumbnail_size( 50, 50, [ 'center', 'center' ] ); // 50 px x 50px, crop from center
        $post_thumb_size = apply_filters( 'ipress_post_thumb_size', [] );
        if ( !empty( $post_thumb_size ) ) {
            $this->set_post_thumb_size( $post_thumb_size );
        }

        // Core image sizes overrides
        // - add_image_size( 'large', 1024, '', true ); // Large Image 
        // - add_image_size( 'medium', 768, '', true ); // Medium Image 
        // - add_image_size( 'small', 320, '', true);   // Small Image 
        $image_size_default = apply_filters( 'ipress_image_size_default', [] );
        if ( !empty( $image_size_default ) ) {
            $this->set_add_image_size( $image_size_default );
        }
 
        // Custom image sizes
        // - add_image_size( 'custom-size', 220 );                  // 220px wide, relative height, soft proportional crop mode
        // - add_image_size( 'custom-size-prop', 220, 180 );        // 220px x 180px, soft proportional crop
        // - add_image_size( 'custom-size-prop-height', 9999, 180); // 180px height: proportion resize 
        // - add_image_size( 'custom-size', 220, 180, true );       // 220 pixels wide by 180 pixels tall, soft proportional crop mode
        $add_image_size = apply_filters( 'ipress_add_image_size', [] );
        if ( !empty( $add_image_size ) ) {
            $this->set_add_image_size( $add_image_size );
        }

        // Add menu support 
        add_theme_support( 'menus' ); 

        // Register navigation menu locations
        // register_nav_menus( [ 
        //   'primary'   => __( 'Primary Menu', 'ipress' ),
        //   'secondary' => __( 'Secondary Menu', 'ipress' ),
        //   'social'    => __( 'Social Menu', 'ipress' ),
        //   'header'    => __( 'Header Menu', 'ipress' ) 
        // ] );
        $nav_menus = apply_filters( 'ipress_nav_menus', [ 
            'primary'   => __( 'Primary Menu', 'ipress' )
        ] );
        if ( !empty( $nav_menus ) ) { register_nav_menus( $nav_menus ); }

        // Enable support for HTML5 markup: 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets'
        add_theme_support( 'html5', apply_filters( 'ipress_html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets'
        ] ) );
 
        // Newer title tag hooks - requires title-tag support above
        add_filter( 'pre_get_document_title',   [ $this, 'pre_get_document_title' ] ); 
        add_filter( 'document_title_separator', [ $this, 'document_title_separator' ], 10, 1 ); 
        add_filter( 'document_title_parts',     [ $this, 'document_title_parts' ], 10, 1 ); 
    }

    //----------------------------------------------
    //  Thumbnail & Image Support
    //----------------------------------------------

    /**
     * Set up thumbnail image size
     *
     * @param array $size
     */
    private function set_post_thumb_size( $size ) {
        $crop = ( isset( $size['crop'] ) ) ? $size['crop'] : false;
        set_post_thumbnail_size( $size['width'], $size['height'], $crop );
    }

    /**
     * Set up thumbnail image size
     *
     * @param array $size
     */
    private function set_add_image_size( $sizes ) {
        foreach ( $sizes as $size ) {
            $crop = ( isset( $size['crop'] ) ) ? $size['crop'] : false;
            add_image_size( $size['name'], $size['width'], $size['height'], $crop );
        }
    }

    //----------------------------------------------
    //  Title Tag Support
    //  - Make WordPress manage the document title
    //----------------------------------------------

    /**
     * Define the pre_get_document_title callback 
     *  
     * @return string
     */
    public function pre_get_document_title() { 
    
        // Home page?
        if ( ipress_is_home_page() ) {

            // Get details
            $title = get_bloginfo( 'name' );        
            $sep = (string)apply_filters( 'ipress_document_title_separator', '-' );
            $app = (bool)apply_filters( 'ipress_home_doctitle_append', true );

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
        $app_site_name = (bool)apply_filters( 'ipress_append_site_name', true );
        $title['site'] = ( $app_site_name ) ? get_bloginfo( 'name' ) : '';

        // Return
        return $title; 
    }

    /**
     * Add preconnect for Google Fonts
     *
     * @param   array   $urls   URLs to print for resource hints
     * @param   string  $relation_type  The relation type the URLs are printed
     * @return  array   $urls   URLs to print for resource hints
     */
    public function resource_hints( $urls, $relation_type ) {
  
        if ( wp_style_is( 'ipress-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
    		$urls[] = [
			    'href' => 'https://fonts.gstatic.com',
			    'crossorigin',
            ];
    	}

    	return $urls;
    }

    //----------------------------------------------
    //  Post Structured Data
    //----------------------------------------------
    
    /**
	 * Set post structured_data
	 *
     * @param array $json
     * @param boolean $reset default true
     * @return void
	 */
    public static function set_structured_data( $json, $reset=true ) {

        // Final check
		if ( ! is_array( $json ) || empty( $json ) ) { 
            if ( $reset ) { self::$structured_data = []; }
            return; 
        }

        // Update current data
        self::$structured_data[] = $json;
    }

	/**
	 * Outputs structured data
	 *
     * @return void
     */
    public function get_structured_data() {

        // Only if set        
        if ( ! self::$structured_data ) { return; }

        // Schemify
        $structured_data['@context'] = 'http://schema.org/';
		if ( count( self::$structured_data ) > 1 ) {
			$structured_data['@graph'] = self::$structured_data;
		} else {
			$structured_data = $structured_data + self::$structured_data[0];
		}

        // Output
        echo sprintf( '<script type="application/ld+json">%s</script>', wp_json_encode( $this->sanitize_structured_data( $structured_data ) ) );
	}

	/**
	 * Sanitizes structured data
	 *
	 * @param  array $data
	 * @return array
	 */
    public function sanitize_structured_data( $data ) {

		$sanitized = [];

		foreach ( $data as $key => $value ) {
			if ( is_array( $value ) ) {
				$sanitized_value = $this->sanitize_structured_data( $value );
			} else {
				$sanitized_value = sanitize_text_field( $value );
			}

			$sanitized[ sanitize_text_field( $key ) ] = $sanitized_value;
		}

		return $sanitized;
	}
}

// Instantiate Theme Class
return new IPR_Theme;

//end
