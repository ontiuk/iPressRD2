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

/**
 * Initialise and set up Customizer features
 */ 
final class IPR_Customizer {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Register customizer function
        add_action( 'customize_register', [ $this, 'customize_register' ] );

        // Customizer preview scripts
        add_action( 'customize_preview_init', [ $this, 'customize_preview_js' ] );

        // Customizer controls
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_js' ] );
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
