<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * ACF Plugin functionality
 * 
 * @package     iPress\Includes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

if ( ! class_exists( 'IPR_ACF' ) ) :

	/**
	 * Advanced Custom Fields Plugin Functionality
	 */
	final class IPR_ACF {
		
		// Class Constructor
		public function __construct() {

			// Add the theme options page
			add_action( 'init', [ $this, 'acf_options_page' ] ); 
		}

		//----------------------------------------------
		//  ACF Functionality
		//----------------------------------------------

		/**
		 * Add ACF Options Page if allowed: 
		 *
		 *  e.g ipr_acf_pages[]
		 *	
		 *	'terms' => [ 
		 *		'page_title'    => __( 'Terms and Conditions', 'ipress' ),
		 *		'menu_title'    => __( 'Terms', 'ipress' ),
		 *		'menu_slug'     => 'classworx-terms',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	],
		 *	'privacy' => [ 
		 *		'page_title'    => __( 'Privacy Policy', 'ipress' ),
		 *		'menu_title'    => __( 'Privacy', 'ipress' ),
		 *		'menu_slug'     => 'classworx-privacy',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	],
		 *	'Shipping' => [ 
		 *		'page_title'    => __( 'Shipping Policy', 'ipress' ),
		 *		'menu_title'    => __( 'Shipping', 'ipress' ),
		 *		'menu_slug'     => 'classworx-shipping',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	]
		 */
		public function acf_options_page() { 

			// Check ACF Admin OK
			if ( ! $this->admin_acf_active() ) { return; }

			// Check Options Page OK        
			if ( ! function_exists('acf_add_options_page') ) { return; }
			
			// Add Options Page
			$parent = acf_add_options_page( [  
				'title'      => apply_filters( 'ipress_acf_title', 'iPress' ), 
				'capability' => 'manage_options', 
			] ); 

			// Set Options Page Subpages
			$subpages = apply_filters( 'ipress_acf_pages', [] );
	   
			// Add Subpages? 
			if ( $subpages ) {
				foreach ( $subpages as $k=>$v ) {
					acf_add_options_sub_page( $v );
				} 
			}
		}

		//----------------------------------------------
		//  Other
		//----------------------------------------------    

		/**
		 * Check at admin level if ACF is active
		 *
		 * @return boolean
		 */
		protected function admin_acf_active() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			return ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) ? true : false; 
		}

		/**
		 * Front-end check if ACF is active
		 * 
		 * @return boolean
		 */
		protected function front_acf_active() {
			return ( class_exists('acf') ) ? true : false;
		}
	}

endif;

// Initialise ACF class
return new IPR_ACF();

// End
