<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.co.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Load_Styles' ) ) :

	/**
	 * Set up theme styles
	 */ 
	final class IPR_Load_Styles {

		/**
		 * Admin styles 
		 *
		 * @var array $admin
		 */
		private $admin = [];

		/**
		 * Styles for dequeueing
		 *
		 * @var array $undo
		 */
		private $undo = [];

		/**
		 * Core styles
		 *
		 * @var array $core
		 */
		private $core = [];

		/**
		 * External styles
		 *
		 * @var array $external
		 */
		private $external = [];

		/**
		 * Header styles
		 *
		 * @var array $header
		 */
		private $header = [];

		/**
		 * Plugin styles
		 *
		 * @var array $plugins
		 */
		private $plugins = [];

		/**
		 * Page styles
		 *
		 * @var array $page
		 */
		private $page = [];

		/**
		 * Theme styles
		 *
		 * @var array $theme
		 */
		private $theme = [];

		/**
		 * Theme fonts
		 *
		 * @var array $fonts
		 */
		private $fonts = [];

		/**
		 * Login styles
		 *
		 * @var array $login
		 */
		private $login = [];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Load admin styles
			add_action( 'admin_enqueue_scripts', 				[ $this, 'load_admin_styles' ] ); 

			// Login page styles
			add_action( 'login_enqueue_scripts', 				[ $this, 'load_login_styles' ], 10 );			

			// Customiser custom css
			add_action( 'customize_controls_enqueue_scripts', 	[ $this, 'customizer_styles' ] );

			// Add Editor Styles
			add_action( 'admin_init', 							[ $this, 'editor_styles' ] );

			// Front-end only
			if ( is_admin() ) { return; }

			// Main styles 
			add_action( 'wp_enqueue_scripts', 					[ $this, 'load_styles' ] ); 

			// Dequeueue styles
			add_action( 'wp_enqueue_scripts', 					[ $this, 'undo_styles' ], 99 ); 

			// Fonts & typography 
			add_action( 'wp_enqueue_scripts', 					[ $this, 'load_fonts' ] ); 

			// Conditional header styles
			add_action( 'wp_enqueue_scripts', 					[ $this, 'conditional_styles' ] ); 

			// Embed styles
			add_action( 'enqueue_embed_scripts',				[ $this, 'print_embed_styles' ] );

			// Header Inline CSS
			add_action( 'wp_head', 								[ $this, 'header_styles' ], 12 );
		}

		/**
		 * Initialise main styles
		 *
		 * @param array $styles
		 * @param array $fonts
		 */
		public function init( $styles, $fonts ) {

			// Admin styles: [ 'label' => [ 'hook', 'src', (array)deps, 'ver' ] ... ]
			$this->admin = $this->set_key( $styles, 'admin' );

			// Core styles for deregistration: [ 'style-name', [ 'style-name2', 'template' ] ... ]
			$this->undo = $this->set_key( $styles, 'undo' );

			// Core styles: [ 'style-name', 'style-name' ... ];
			$this->core = $this->set_key( $styles, 'core' );

			// External styles: [ 'style-name', 'style-name2' ... ]
			$this->external = $this->set_key( $styles, 'external' );

			// Header styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->header = $this->set_key( $styles, 'header' );

			// Plugin styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->plugins = $this->set_key( $styles, 'plugins' );

			// Page styles: [ 'label' => [ 'template', 'src', (array)deps, 'version', 'media' ] ... ];
			$this->page = $this->set_key( $styles, 'page' );

			// Theme styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ];
			$this->theme = $this->set_key( $styles, 'theme' );

			// Login style: [ 'label' => [ 'src', (array)deps, 'ver', ' ] ... ]
			$this->login = $this->set_key( $styles, 'login' );

			// Theme fonts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ];
			$this->fonts = ( is_array( $fonts ) && ! empty( $fonts ) ) ? $fonts : [];
		}

		/**
		 * Validate and set key
		 *
		 * @param 	array 	$styles
		 * @param 	string 	$key
		 * @return 	array
		 */
		private function set_key( $styles, $key ) {
			return ( isset ( $styles[$key] ) && is_array( $styles[$key] ) && ! empty( $styles[$key] ) ) ? $styles[$key] : [];
		}

		//----------------------------------------------
		//	Admin Styles
		//----------------------------------------------

		/**
		 * Load admin styles
		 *
		 * @param	string	$hook	Current admin page
		 */
		public function load_admin_styles( $hook ) {

			// Initial validation
			if ( empty( $this->admin ) ) { return; }

			// Register & enqueue admin styles
			foreach ( $this->admin as $k=>$v ) { 
				
				// Test hook dependency
				if ( !empty( $v[0] ) && $hook != $v[0] ) { continue; }

				// Register and enqueue style
				wp_register_style( $k, $v[1], $v[2], $v[3] );
        		wp_enqueue_style( $k );
			}
		}

		//----------------------------------------------
		//	Scripts, Styles & Fonts
		//----------------------------------------------

		/**
		 * Load CSS styles files
		 */
		public function load_styles() { 

			// Register & enqueue core css in order
			foreach ( $this->core as $k=>$v ) { 
				wp_register_style( $k, $v[0], $v[1], $v[2] ); 
				wp_enqueue_style( $k ); 
			}

			// Register & enqueue header styles
			foreach ( $this->external as $k=>$v ) { 
				wp_register_style( $k, $v[0], $v[1], $v[2] ); 
				wp_enqueue_style( $k );
			}

			// Register & enqueue css in order
			foreach ( $this->header as $k=>$v ) {
				$m = ( isset( $v[3] ) && ! empty( $v[3] ) ) ? $v[3] : 'all';
				wp_register_style( $k, $v[0], $v[1], $v[2], $m ); 
				wp_enqueue_style( $k ); 
			}
		
			// Register & enqueue plugin styles 
			foreach ( $this->plugins as $k=>$v ) { 
				$m = ( isset( $v[3] ) && ! empty( $v[3] ) ) ? $v[3] : 'all';
				wp_register_style( $k, $v[0], $v[1], $v[2], $m ); 
				wp_enqueue_style( $k ); 
			}

			// Page templates in footer head
			foreach ( $this->page as $k=>$v ) {
				if ( is_page_template( $v[0] ) ) {
					$m = ( isset( $v[4] ) && ! empty( $v[4] ) ) ? $v[4] : 'all';
					wp_register_style( $k, $v[1], $v[2], $v[3], $m ); 
					wp_enqueue_style( $k );
				}
			}

			// Register & enqueue core styles last
			foreach ( $this->theme as $k=>$v ) { 
				$m = ( isset( $v[3] ) && ! empty( $v[3] ) ) ? $v[3] : 'all';
				wp_register_style( $k, $v[0], $v[1], $v[2], $m ); 
				wp_enqueue_style( $k ); 
				wp_style_add_data( $k, 'rtl', 'replace' );
			}
		}

		/**
		 * Dequeue styles 
		 */
		public function undo_styles() { 
	 
			// Dequeue core styles
			foreach ( $this->undo as $s ) { 

				// Page template or global
				if ( is_array( $s ) ) {
					is_page_template( $s[1] ) {
						wp_dequeue_style( $s[0] );
						wp_deregister_style( $s[0] ); 
					}
				} else {
					wp_dequeue_style( $s );
					wp_deregister_style( $s ); 
				}
			}
		}

		//----------------------------------------------
		// Load Theme Fonts
		//----------------------------------------------

		/**
		 * Load custom front-end fonts 
		 */
		public function load_fonts() { 

			// No fonts set?
			if ( ! isset( $this->fonts['family'] ) || empty( $this->fonts['family'] ) ) { return; }

			// Construct font: family
			$query_args = [
				'family' => ( is_array( $this->fonts['family'] ) ) ? join( '|', $this->fonts['family'] ) : $this->fonts['family']
			];

			// Construct font: subset - 'latin,latin-ext'
			if ( isset( $this->fonts['subset'] ) && ! empty( $this->fonts['subset'] ) ) { 
				$query_args['subset'] = urlencode( $this->fonts['subset'] );
			}

			// Set fonts url
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			// Register & enqueue css style file for later use 
			wp_register_style( 'ipress-fonts', esc_url_raw( $fonts_url ), [], null ); 
			wp_enqueue_style( 'ipress-fonts' ); 
		}

		//----------------------------------------------
		// Conditional Styles 
		//----------------------------------------------

		/**
		 * Load conditional styles for old IE support. Deprecated
		 */
		public function conditional_styles() {

			global $wp_styles;

			// A bit outdated now...
			$show_conditional = apply_filters( 'ipress_show_conditional', false );
			if ( ! $show_conditional ) { return; }

			// Load our stylesheet for IE9
			wp_enqueue_style( 'ie9', IPRESS_CSS_URL . '/ie9.css', [] );

			// Add to global styles list
			$wp_styles->add_data( 'ie9', 'conditional', 'IE 9' );
		}

		//----------------------------------------------
		//	Header & Footer Styles
		//----------------------------------------------

		/**
		 * Load inline header css
		 */
		public function header_styles() {

			// Use filter to add styles
			$header_styles = apply_filters( 'ipress_header_styles', get_theme_mod( 'ipress_header_styles', '' ) );
			if ( ! $header_styles ) { return; }
			
			// Capture output	
			wp_add_inline_style( 'style', $header_styles );
		}

		//----------------------------------------------
		// Embed Styles 
		//----------------------------------------------

		/**
		 * Add styles for embeds
		 */
		public function print_embed_styles() {
			?>
			<style type="text/css">
				.wp-embed {
					padding: 2.618em !important;
					border: 0 !important;
					border-radius: 3px !important;
					font-family: sans-serif !important;
					-webkit-font-smoothing: antialiased;
					background-color: #fafafa !important;
				}

				.wp-embed .wp-embed-featured-image {
					margin-bottom: 2.618em;
				}

				.wp-embed .wp-embed-featured-image img,
				.wp-embed .wp-embed-featured-image.square {
					min-width: 100%;
					margin-bottom: .618em;
				}

				a.wc-embed-button {
					padding: .857em 1.387em !important;
					font-weight: 600;
					background-color: #333;
					color: #fff !important;
					border: 0 !important;
					line-height: 1;
					border-radius: 0 !important;
					box-shadow:
						inset 0 -1px 0 rgba(#000,.3);
				}

				a.wc-embed-button + a.wc-embed-button {
					background-color: #60646c;
				}
			</style>
			<?php
		}
		
		//----------------------------------------------
		// Customizer Styles 
		//----------------------------------------------

		/**
		 * Load customiser styles
		 */
		public function customizer_styles() {
			wp_enqueue_style( 'ipress-customize', IPRESS_CSS_URL . '/customizer.css' );
		}

		//----------------------------------------------
		// Visual Editor Style
		//----------------------------------------------

		/**
		 * Style the Visual Editor
		 */
		public function editor_styles() {
			add_editor_style( IPRESS_CSS_URL . '/editor.css' );
		}

		//----------------------------------------------
		//	Login Page Scripts
		//----------------------------------------------

		/**
		 * Load login styles
		 */
		public function load_login_styles() {

			// Initial validation
			if ( empty( $this->login ) ) { return; }

			// Register & enqueue admin styles
			foreach ( $this->login as $k=>$v ) { 
				
				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2] ); 
				wp_enqueue_style( $k );
			}
		}
	}

endif;

// Instantiate Styles Loader class
return new IPR_Load_Styles;

//end
