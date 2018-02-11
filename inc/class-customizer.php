<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme customizer features
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
 * Initialise and set up Customizer features
 */ 
final class IPR_Customizer {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Core WordPress functionality
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Theme settings
        add_action( 'after_setup_theme', [ $this, 'theme_settings' ], 12 );

        // Content layout
		add_filter( 'body_class', [ $this, 'layout_class' ] );

        // Register customizer function
        add_action( 'customize_register', [ $this, 'customize_register' ] );

        // Customizer preview scripts
        add_action( 'customize_preview_init', [ $this, 'customize_preview_js' ] );

        // Customizer controls js
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_js' ] );

        // Customizer controls css
        add_action( 'customize_controls_print_styles', [ $this, 'customizer_controls_css' ] );
    }

    //----------------------------------------------
    //  Customizer Support
    //----------------------------------------------

    /**
     * Set up core customizer driven theme support & functionality
     * 
     * - add_theme_support( 'custom-logo' )
     * - add_theme_support( 'custom-header' )
     * - register_default_headers()
     * - add_theme_support( 'custom-background' )
     * - add_theme_support( 'customize-selective-refresh-widgets' )
     */
    public function setup_theme() {

        // Enable support for custom logo
        // 
        // @see https://developer.wordpress.org/themes/functionality/custom-logo/
        // logo_args = [
        //   'width'       => 250,
        //   'height'      => 80,
        //   'flex-width'  => true,
        //   'flex-height' => true,
        //   'header-text' => [ get_bloginfo( 'name' ), get_bloginfo( 'description' ) ]
        // ];
        // - add_theme_support( 'custom-logo', apply_filters( 'ipress_custom_logo_args', $logo_args ) );
        $logo_args = [
		    'width'       => 200,
		    'height'      => 133,
		    'flex-width'  => true
		];
        add_theme_support( 'custom-logo', apply_filters( 'ipress_custom_logo_args', $logo_args ) );

        // Enable support for custom headers
        // 
        // @see https://developer.wordpress.org/themes/functionality/custom-headers/    
        // $header_args = [
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
        // - add_theme_support( 'custom-header', apply_filters( 'ipress_custom_header_args', $header_args ) ); 
        $header_args = [
			'default-image' => '',
			'header-text'   => false,
			'width'         => 1600,
			'height'        => 200,
			'flex-width'    => true,
			'flex-height'   => true
        ];        
        add_theme_support( 'custom-header', apply_filters( 'ipress_custom_header_args', $header_args ) ); 

        // Register default header images
        // @see	https://codex.wordpress.org/Function_Reference/register_default_headers
        //	register_default_headers( apply_filters( 'ipress_register_default_headers', [
		//      'default-image' => [
		//	        'url'           => '%s/assets/images/header.jpg',
		//	        'thumbnail_url' => '%s/assets/images/header.jpg',
		//	        'description'   => __( 'Default Header Image', 'ipress' ),
		//      ],
	    //  ] ) );

        // Enable support for custom backgrounds - default false
        // @see https://codex.wordpress.org/Custom_Backgrounds
        // $background_args = [ 
        //     'default-color'         => apply_filters( 'ipress_default_background_color', 'ffffff' ), 
        //     'default-image'         => '', 
        //     'wp-head-callback'      => '_custom_background_cb',
        //     'admin-head-callback'   => '',
        //     'admin-preview-callback' => ''
        // ];
        // - add_theme_support( 'custom-background', apply_filters( 'ipress_custom_background_args', $background_args ) ); 
		add_theme_support( 'custom-background', apply_filters( 'ipress_custom_background_args', [
			'default-color' => apply_filters( 'ipress_default_background_color', 'ffffff' ),
			'default-image' => '',
        ] ) );

    	// Add theme support for selective refresh for widgets
	    add_theme_support( 'customize-selective-refresh-widgets' );
    }

    //----------------------------------------------
    //  Theme Mods - Customizer driven
    //----------------------------------------------

    /**
     * Check and setup default theme settings - mods & options
     * - Check if setting is set, if not set default
     */
    public function theme_settings() {

    	// Content position
        $ipress_layout = get_theme_mod( 'ipress_layout' );
        error_log( 'Layout[' . $ipress_layout . ']' );
    	if ( empty( $ipress_layout ) ) {
    		set_theme_mod( 'ipress_layout', 'left' );
    	}
    }

    //----------------------------------------------
    //  Customizer Functionality
    //----------------------------------------------

    /**
     * Set up customizer
     *
     * @param object $wpm WP_Customiser_Manager
     */
    public function customize_register( $wpm ) {

		// Custom controls
		require_once IPRESS_CONTROLS_DIR . '/class-customizer-checkbox-multiple.php';

        // Modifiy default controls  
        $wpm->get_setting( 'blogname' )->transport         = 'postMessage'; 
        $wpm->get_setting( 'blogdescription' )->transport  = 'postMessage'; 
        $wpm->get_setting( 'header_textcolor' )->transport = 'postMessage'; 

        // Dynamic refresh
        if ( isset( $wpm->selective_refresh ) ) { 
			$wpm->selective_refresh->add_partial( 'custom_logo', [
				'selector'        => '.site-branding',
				'render_callback' => [ $this, 'get_site_logo' ],
            ] );
            $wpm->selective_refresh->add_partial( 'blogname', [ 
                'selector'        => '.site-title a', 
                'render_callback' => [ $this, 'get_site_name' ], 
            ] ); 
            $wpm->selective_refresh->add_partial( 'blogdescription', [ 
                'selector'        => '.site-description', 
                'render_callback' => [ $this, 'get_site_description' ], 
            ] ); 
        } 
         
		// Change background image section title & priority.
		$wpm->get_section( 'background_image' )->title     = __( 'Background', 'honeycomb' );
		$wpm->get_section( 'background_image' )->priority  = 30;

		// Move background color setting alongside background image.
		$wpm->get_control( 'background_color' )->section   = 'background_image';
		$wpm->get_control( 'background_color' )->priority  = 20;

		// Change header image section title & priority.
		$wpm->get_section( 'header_image' )->title         = __( 'Header', 'honeycomb' );
		$wpm->get_section( 'header_image' )->priority      = 25;

        // Change the default section titles
        $wpm->get_section( 'colors' )->title = __( 'Theme Colours' );
 
        // Add new Theme Panels, sections & controls
    	$wpm->add_panel( 'theme_panel', [
	    	'title'       => __( 'Theme Options', 'ipress' ),
		    'description' => __( 'Configure your theme settings', 'ipress' ),
    	] );

    	// Page Options.
	    $wpm->add_section( 'ipress_layout', [
		    'title'     => __( 'Content Layout', 'ipress' ),
		    'panel'     => 'theme_panel',
	    ] );

    	$wpm->add_setting( 'ipress_layout', [
	    	'default'           => apply_filters( 'ipress_default_layout', ( is_rtl() ) ? 'left' : 'right' ),
		    'sanitize_callback' => 'ipress_sanitize_layout',
		    'transport'         => 'postMessage',
	    ] );

    	$wpm->add_control( 'ipress_layout', [
	    	'label'       => __( 'Page Layout', 'ipress' ),
		    'section'     => 'ipress_layout',
    		'type'        => 'radio',
	    	'description' => __( 'Content section left or right.', 'ipress' ),
		    'choices'     => [
			    'left'  => __( 'Content - Sidebar', 'ipress' ),
			    'right' => __( 'Sidebar - Content', 'ipress' )
            ],
        ] );
    }

    //----------------------------------------------
    //  Customizer Partials
    //----------------------------------------------

	/**
	 * Get site logo
	 *
	 * @return string
	 */
	public function get_site_logo() {
		return ipress_site_title_or_logo( false );
    }

	/**
	 * Get site name
	 *
	 * @return string
	 */
	public function get_site_name() {
		return get_bloginfo( 'name', 'display' );
	}

	/**
	 * Get site description
	 *
	 * @return string
	 */
	public function get_site_description() {
		return get_bloginfo( 'description', 'display' );
	}

	/**
	 * Layout classes
	 * Adds 'content-sidebar' and 'sidebar-content' classes to the body tag
	 *
	 * @param  array $classes 
	 * @return array
	 */
	public function layout_class( $classes ) {

        $left_or_right = get_theme_mod( 'ipress_layout' );
		$classes[] = ( $left_or_right === 'left' ) ? 'content-sidebar' : 'sidebar-content';

		return $classes;
	}

    //----------------------------------------------
    //  Customizer Scripts
    //----------------------------------------------

    /**
     * Customizer preview scripts
     */
    public function customize_preview_js() {
        wp_enqueue_script( 'ipress-customizer', IPRESS_JS_DIR . '/customizer.js', [ 'customize-preview' ], null, true ); 
    }

    /**
     * Customizer controls scripts
     */
    public function customize_controls_js() {}


	/**
     * Add CSS for custom controls
     * 
	 * @link https://github.com/reduxframework/kirki/
	 */
	public function customizer_controls_css() {
        wp_register_style( 'ipress-customizer-controls', IPRESS_CSS_DIR . '/customizer.css', null, null, 'all' );
    	wp_enqueue_style( 'ipress-customizer-controls' );
	}
}

//----------------------------------------------
//  Customizer Functions
//----------------------------------------------

/**
 * Sanitize a radio button.
 */
function ipress_sanitize_layout( $layout ) {

	$layouts = [
		'left'  => __( 'Content Sidebar', 'ipress' ),
		'right' => __( 'Sidebar Content', 'ipress' )
	];

	return ( array_key_exists( $layout, $layouts ) ) ? $layout : '';
}

// Instantiate Customizer class
return new IPR_Customizer;

//end
