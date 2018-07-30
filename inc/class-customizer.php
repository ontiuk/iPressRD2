<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme customizer features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Customizer' ) ) :

	/**
	 * Initialise and set up Customizer features
	 */ 
	final class IPR_Customizer {

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {

			//----------------------------------------------
			//	Customizer Support & Layout
			//----------------------------------------------
						
			add_action( 'after_setup_theme', 	[ $this, 'setup_theme' ] );
			add_action( 'after_setup_theme', 	[ $this, 'theme_settings' ], 12 );
			add_filter( 'body_class', 			[ $this, 'layout_class' ] );

			//----------------------------------------------
			//	Customizer Settings, Controls & Scripts
			//----------------------------------------------

			add_action( 'customize_register', 					[ $this, 'customize_register' ] );
			add_action( 'customize_preview_init', 				[ $this, 'customize_preview_js' ] );
			add_action( 'customize_controls_enqueue_scripts', 	[ $this, 'customize_controls_js' ] );
			add_action( 'customize_controls_print_styles', 		[ $this, 'customizer_controls_css' ] );

			//----------------------------------------------
			//	Custom Theme Mods & CSS
			//----------------------------------------------

			add_action( 'wp_enqueue_scripts',              [ $this, 'add_customizer_css' ], 130 );
			add_action( 'customize_register',              [ $this, 'edit_default_customizer_settings' ], 99 );
			add_action( 'init',                            [ $this, 'default_theme_mod_values' ], 10 );

			add_action( 'after_switch_theme',              [ $this, 'set_style_theme_mods' ] );
			add_action( 'customize_save_after',            [ $this, 'set_style_theme_mods' ] );
		}

		//----------------------------------------------
		//	Customizer Support & Layout
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
			//	 'width'	   => 250,
			//	 'height'	   => 80,
			//	 'flex-width'  => true,
			//	 'flex-height' => true,
			//	 'header-text' => [ get_bloginfo( 'name' ), get_bloginfo( 'description' ) ]
			// ];
			// - add_theme_support( 'custom-logo', apply_filters( 'ipress_custom_logo_args', $custom_logo_args ) );
			$custom_logo = apply_filters( 'ipress_custom_logo', true );
			$custom_logo_args = [
				'width'		  => 200,
				'height'	  => 133,
				'flex-width'  => true
			];
			if ( $custom_logo ) {
				add_theme_support( 'custom-logo', apply_filters( 'ipress_custom_logo_args', $custom_logo_args ) );
			}

			// Enable support for custom headers
			// 
			// @see https://developer.wordpress.org/themes/functionality/custom-headers/	
			// $header_args = [
			//	  'default-image'		   => '',
			//	  'random-default'		   => false,
			//	  'width'				   => 0,
			//	  'height'				   => 0,
			//	  'flex-height'			   => false,
			//	  'flex-width'			   => false,  
			//	  'default-text-color'	   => '', 
			//	  'header-text'			   => true,
			//	  'uploads'				   => true,
			//	  'wp-head-callback'	   => '',
			//	  'admin-head-callback'    => '',
			//	  'admin-preview-callback' => ''
			// ];
			// - add_theme_support( 'custom-header', apply_filters( 'ipress_custom_header_args', $custom_header_args ) ); 
			$custom_header = apply_filters( 'ipress_custom_header', false );
			$custom_header_args = [
				'default-image' => '',
				'header-text'	=> false,
				'width'			=> 1600,
				'height'		=> 200,
				'flex-width'	=> true,
				'flex-height'	=> true
			];		
			if ( $custom_header ) {
				add_theme_support( 'custom-header', apply_filters( 'ipress_custom_header_args', $custom_header_args ) ); 
			}
			
			// Register default header images
			// @see	https://codex.wordpress.org/Function_Reference/register_default_headers
			//	register_default_headers( apply_filters( 'ipress_default_header_args', [
			//		'default-image' => [
			//			'url'			=> '%s/assets/images/header.jpg',
			//			'thumbnail_url' => '%s/assets/images/header.jpg',
			//			'description'	=> __( 'Default Header Image', 'ipress' ),
			//		],
			//	] ) );
			$default_headers = apply_filters( 'ipress_default_headers', false );
			if ( $default_headers ) {
				register_default_headers( apply_filters( 'ipress_default_header_args', [] ) ); 
			}
					
			// Enable support for custom backgrounds - default false
			// @see https://codex.wordpress.org/Custom_Backgrounds
			// $background_args = [ 
			//	   'default-color'		   => apply_filters( 'ipress_default_background_color', 'ffffff' ), 
			//	   'default-image'		   => '', 
			//	   'wp-head-callback'	   => '_custom_background_cb',
			//	   'admin-head-callback'   => '',
			//	   'admin-preview-callback' => ''
			// ];
			// - add_theme_support( 'custom-background', apply_filters( 'ipress_custom_background_args', $background_args ) ); 
			$custom_background = apply_filters( 'ipress_custom_background', false );
			$custom_background_args = [
				'default-color' => apply_filters( 'ipress_default_background_color', 'ffffff' ),
				'default-image' => apply_filters( 'ipress_default_background_image', '' )
			];
			if ( $custom_background ) {
				add_theme_support( 'custom-background', apply_filters( 'ipress_custom_background_args', $custom_backround_args ) );
			}
			
			// Add theme support for selective refresh for widgets
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		/**
		 * Check and setup default theme settings - mods & options
		 * - Check if setting is set, if not set default
		 */
		public function theme_settings() {
			$ipress_layout = get_theme_mod( 'ipress_layout' );
			if ( empty( $ipress_layout ) ) {
				set_theme_mod( 'ipress_layout', 'left' );
			}
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
		//	Customizer Settings, Controls & Scripts
		//----------------------------------------------

		/**
		 * Set up customizer and theme panel
		 * - Child theme extends settings and controls
		 *
		 * @param object $wpm WP_Customiser_Manager
		 */
		public function customize_register( $wpm ) {

			// Custom controls
			require_once IPRESS_CONTROLS_DIR . '/class-customizer-checkbox-multiple.php';

			// Modifiy default controls  
			$wpm->get_setting( 'blogname' )->transport		   = 'postMessage'; 
			$wpm->get_setting( 'blogdescription' )->transport  = 'postMessage'; 

			// Dynamic refresh
			if ( isset( $wpm->selective_refresh ) ) { 
				$wpm->selective_refresh->add_partial( 'custom_logo', [
					'selector'		  => '.site-branding',
					'render_callback' => [ $this, 'get_site_logo' ],
				] );
				$wpm->selective_refresh->add_partial( 'blogname', [ 
					'selector'		  => '.site-title a', 
					'render_callback' => [ $this, 'get_site_name' ], 
				] ); 
				$wpm->selective_refresh->add_partial( 'blogdescription', [ 
					'selector'		  => '.site-description', 
					'render_callback' => [ $this, 'get_site_description' ], 
				] ); 
			} 
			 
			// Change background image section title & priority.
			$wpm->get_section( 'background_image' )->title	   = __( 'Background', 'ipress' );
			$wpm->get_section( 'background_image' )->priority  = 30;

			// Move background color setting alongside background image.
			$wpm->get_control( 'background_color' )->section   = 'background_image';
			$wpm->get_control( 'background_color' )->priority  = 20;

			// Change header image section title & priority.
			$wpm->get_section( 'header_image' )->title		   = __( 'Header', 'ipress' );
			$wpm->get_section( 'header_image' )->priority	   = 25;

			// Change the default section titles
			$wpm->get_section( 'colors' )->title = __( 'Theme Colours', 'ipress' );
	 
			// Add new Theme Panels, sections & controls
			$wpm->add_panel( 'theme_panel', [
				'title'		  => __( 'Theme Options', 'ipress' ),
				'description' => __( 'Configure your theme settings', 'ipress' ),
			] );

			// Page Options.
			$wpm->add_section( 'ipress_layout', [
				'title'		=> __( 'Content Layout', 'ipress' ),
				'panel'		=> 'theme_panel',
			] );

			$wpm->add_setting( 'ipress_layout', [
				'default'			=> apply_filters( 'ipress_default_layout', ( is_rtl() ) ? 'left' : 'right' ),
				'sanitize_callback' => 'ipress_sanitize_layout',
				'transport'			=> 'postMessage',
			] );

			$wpm->add_control( 'ipress_layout', [
				'label'		  => __( 'Page Layout', 'ipress' ),
				'section'	  => 'ipress_layout',
				'type'		  => 'radio',
				'description' => __( 'Content section left or right.', 'ipress' ),
				'choices'	  => [
					'left'	=> __( 'Content - Sidebar', 'ipress' ),
					'right' => __( 'Sidebar - Content', 'ipress' )
				],
			] );
		}

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

		//----------------------------------------------
		//	Custom Theme Mods & CSS
		//----------------------------------------------

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * - If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 */
		public function add_customizer_css() {
			$ipress_styles = get_theme_mod( 'ipress_styles' );

			if ( is_customize_preview() || ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || false === $ipress_styles ) {
				$css = $this->get_css();
				if ( $css ) {
					wp_add_inline_style( 'ipress-style', $css );
				}
			} else {
				wp_add_inline_style( 'ipress-style', get_theme_mod( 'ipress_styles' ) );
			}
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_ipress_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
			$ipress_theme_mods 	= $this->get_ipress_theme_mods();
			$ipress_styles 		= apply_filters( 'ipress_custom_css', '' );

			return apply_filters( 'ipress_customizer_css', $ipress_styles, $ipress_theme_mods );
		}

		/**
		 * Get all of the iPress theme mods.
		 *
		 * @return array $ipress_theme_mods 
		 */
		public function get_ipress_theme_mods() {
			return apply_filters( 'ipress_theme_mods', [] );
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter ipredd_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			$default_settings_values = $this->get_default_setting_values();
			if ( $default_settings_values ) {
				foreach ( $default_setting_values as $mod => $val ) {
					$wp_customize->get_setting( $mod )->default = $val;
				}
			}
		}
		
		/**
		 * Returns an array of the desired default Honeycomb Options
		 *
		 * @return array
		 */
		public function get_default_setting_values() {
			return apply_filters( 'ipress_setting_default_values', [] );
		}

		/**
		 * Adds a value to each customizer setting if one isn't already present.
		 *
		 * @uses get_ipress_default_setting_values()
		 */
		public function default_theme_mod_values() {
			$default_settings_values = $this->get_default_setting_values();			
			if ( $default_settings_values ) {
				foreach ( $default_setting_values as $mod => $val ) {
					add_filter( 'theme_mod_' . $mod, [ $this, 'get_theme_mod_value' ], 10 );
				}
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$current_key	= substr( current_filter(), 10 );
			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $current_key ] ) ) { return $value; }
			$values = $this->get_default_setting_values();

			return isset( $values[ $current_key ] ) ? $values[ $current_key ] : $value;
		}

		/**
		 * Assign customizer styles to theme mods.
		 *
		 * @return void
		 */
		public function set_style_theme_mods() {
			$css = $this->get_css();
			if ( $css ) {
				set_theme_mod( 'ipress_styles', $css );
			}
		}

		//----------------------------------------------
		//	Customizer Partials
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

	}

endif;

//----------------------------------------------
//	Customizer Functions
//----------------------------------------------

/**
 * Sanitize a radio button.
 */
function ipress_sanitize_layout( $layout ) {

	$layouts = [
		'left'	=> __( 'Content Sidebar', 'ipress' ),
		'right' => __( 'Sidebar Content', 'ipress' )
	];

	return ( array_key_exists( $layout, $layouts ) ) ? $layout : '';
}

// Instantiate Customizer class
return new IPR_Customizer;

//end
