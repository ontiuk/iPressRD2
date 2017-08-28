<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Customizer
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

        // Register customizer function
        add_action( 'customize_register', [ $this, 'customize_register' ] );

        // Customizer preview scripts
        add_action( 'customize_preview_init', [ $this, 'customize_preview_js' ] );

        // Customizer controls
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_js' ] );
    }

    //----------------------------------------------
    //  Customizer Support
    //----------------------------------------------

    /**
     * Set up core customizer driven theme support & functionality
     * - add_theme_support( 'custom-logo' )
     * - add_theme_support( 'site-logo' ) (Jetpack)
     * - add_theme_support( 'custom-header' )
     * - register_default_headers()
     * - add_theme_support( 'custom-background' )
     * - add_theme_support( 'customize-selective-refresh-widgets' )
     */
    public function setup_theme() {

        // Enable support for custom logo
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

        // Add support for the Jetpack Site Logo plugin and the site logo functionality
        // https://github.com/automattic/site-logo
		// http://jetpack.me/
		//
		// - add_theme_support( 'site-logo', apply_filters( 'ipress_jetpack_logo_args', [ 'size' => 'full' ] ) );

        // Enable support for custom headers
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
		//	        'url'           => '%s/images/header.jpg',
		//	        'thumbnail_url' => '%s/images/header.jpg',
		//	        'description'   => __( 'Default Header Image', 'ipress' ),
		//      ],
	    //  ] ) );

        // Enable support for custom backgrounds - default false
        // @see https://codex.wordpress.org/Custom_Backgrounds
        // $background_args = [ 
        //     'default-color'         => '', 
        //     'default-image'         => '', 
        //     'wp-head-callback'      => '_custom_background_cb',
        //     'admin-head-callback'   => '',
        //     'admin-preview-callback' => ''
        // ];
        // - add_theme_support( 'custom-background', apply_filters( 'ipress_custom_background_args', $background_args ) ); 
    
    	// Add theme support for selective refresh for widgets
	    // - add_theme_support( 'customize-selective-refresh-widgets' );
    }

    //----------------------------------------------
    //  Theme Mods - Customizer driven
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

    //----------------------------------------------
    //  Customizer Functionality
    //----------------------------------------------

    /**
     * Set up customizer
     *
     * @param object $wpm WP_Customiser_Manager
     */
    public function customize_register( $wpm ) {
  
        // $wp_customize calls go here
  
        // Remove the default customize sections 
        // $wpm->remove_section( 'title_tagline' );
        // $wpm->remove_section( 'colors' );
        // $wpm->remove_section( 'background_image' );
        // $wpm->remove_section( 'static_front_page' );
        // $wpm->remove_section( 'nav' );

        // remove the default controls
        // $wpm->remove_control( 'blogdescription' );

        // Modifiy default controls  
        // $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	    // $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	    // $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

        // Change the default section titles
        // $wpm->get_section( 'colors' )->title = __( 'Theme Colors' );
        // $wpm->get_section( 'background_image' )->title = __( 'Images' );

        // Add Controls to default sections

        /*
    	$wp_customize->add_setting( 'colorscheme_hue', [
	    	'default'           => 10,
		    'transport'         => 'postMessage',
		    'sanitize_callback' => 'absint', 
    	] );
        */

        /*
    	$wp_customize->add_control( 'colorscheme_hue', [
	    	'type'    => 'range',
		    'input_attrs' => [
			    'min' => 0,
    			'max' => 359,
	    		'step' => 1,
		    ],
    		'section'  => 'colors',
	    	'priority' => 10,
        ] );
        */

        // Add new Theme Panels, sections & controls
    
        // Add the Theme Options section

        /*
    	$wp_customize->add_panel( 'theme_panel', [
	    	'title'       => __( 'Theme Options', 'ipress' ),
		    'description' => __( 'Configure your theme settings', 'ipress' ),
    	] );

    	// Page Options.
	    $wp_customize->add_section( 'page_layout', [
		    'title'           => __( 'Content Layout', 'ipress' ),
		    'panel'           => 'theme_panel',
	    ] );

    	$wp_customize->add_setting( 'page_layout', [
	    	'default'           => 'left',
		    'sanitize_callback' => 'ipress_sanitize_layout',
		    'transport'         => 'postMessage',
	    ] );

    	$wp_customize->add_control( 'theme_layout', [
	    	'label'       => __( 'Page Layout', 'ipress' ),
		    'section'     => 'page_layout',
    		'type'        => 'radio',
	    	'description' => __( 'Page Layout. Content Section Left or Right', 'ipress' ),
		    'choices'     => [
			    'content-left'  => __( 'Content Left', 'ipress' ),
			    'content-right' => __( 'Content Right', 'ipress' )
		    ],
        ] );
        */
    }

    //----------------------------------------------
    //  Customizer Scripts
    //----------------------------------------------

    /**
     * Customizer preview scripts
     */
    public function customize_preview_js() {}

    /**
     * Customizer controls scripts
     */
    public function customize_controls_js() {}
}

//----------------------------------------------
//  Customizer Functions
//----------------------------------------------

/**
 * Sanitize a radio button.
 */
function ipress_sanitize_layout( $layout ) {

	$layouts = [
		'content-left'  => __( 'Content Left', 'ipress' ),
		'content-right' => __( 'Content Right', 'ipress' )
	];

	return ( array_key_exists( $layout, $layouts ) ) ? $layout : '';
}

// Instantiate Customizer class
return new IPR_Customizer;

//end
