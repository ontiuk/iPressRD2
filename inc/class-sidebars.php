<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package		iPress\Includes
 * @link		http://on.tinternet.co.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Sidebars' ) ) :

	/**
	 * Set up sidebar / widget areas
	 */ 
	final class IPR_Sidebars {

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {

			// Core sidebar initialisation
			add_action( 'widgets_init', [ $this, 'sidebars_init' ] );	 
		}

		//----------------------------------------------
		// Sidebar Functionality
		//----------------------------------------------

		/**
		 * Set sidebar defaults
		 *
		 * @param	array	$sidebar
		 * @return	array
		 */
		private function sidebar_defaults ( $args ) {

			// Set default wrappers
			$defaults = apply_filters( 'ipress_sidebar_defaults', [
				'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
				'after_widget'	=> '</div></section>' . PHP_EOL,
				'before_title'	=> '<h4 class="widget-title widgettitle">',
				'after_title'	=> '</h4>' . PHP_EOL
			] );

			// Filterable sidebar defaults
			$defaults = apply_filters( 'ipress_sidebar_' . $args['id'] . '_defaults', $defaults );
			$args = wp_parse_args( $args, $defaults );

			// Return sidebar params
			return $args;
		}	

		/**
		 * Register theme sidebars
		 *
		 * @return array
		 */
		private function register_sidebars() {

			// Default sidebars
			$default_sidebars = (array) apply_filters( 'ipress_default_sidebars', [
				'primary'		=> [ 
					'name'			=> __( 'Primary Sidebar', 'ipress' ),
					'description'	=> __( 'This is the primary sidebar for two-column and full-width layouts.', 'ipress' )
				]
			] );

			// Footer widgets - default 3, false or 0 for none
			$footer_widget_areas = (int) apply_filters( 'ipress_footer_widget_areas', 3 );
			if ( $footer_widget_areas > 0 ) {
				$footer_sidebars = [];

				for ( $i = 1; $i <= intval( $footer_widget_areas ); $i++ ) {
					$footer = sprintf( 'footer-%d', $i );
	
					$footer_sidebars[ $footer ] = [
						'name'        => sprintf( __( 'Footer %d', 'ipress' ), $i ),
						'description' => sprintf( __( 'Footer sidebar area %d.', 'ipress' ), $i )
					];
				}
			} else { $footer_sidebars = []; }

			// Custom widgets
			$custom_sidebars = (array)apply_filters( 'ipress_custom_sidebars', [] );

			// Set default sidebars
			return array_merge( $default_sidebars, $footer_sidebars, $custom_sidebars );
		}

		//----------------------------------------------
		// Sidebars Action & Filter Functions
		//----------------------------------------------

		/**
		 * Kickstart sidebar widget areas
		 *
		 * @global	$ipress_sidebars
		 * @uses	register_sidebar()
		 */
		public function sidebars_init() {

			// Get sidebars
			$ipress_sidebars = $this->register_sidebars();

			// Register widget areas
			foreach ( $ipress_sidebars as $id => $sidebar ) {

				// Reasign sidebar ID
				$sidebar['id'] = $id;

				// Need name...
				if ( !isset( $sidebar['name'] ) || empty( $sidebar['name'] ) ) { continue; }
	 
				// ...and description
				if ( !isset( $sidebar['description'] ) || empty( $sidebar['description'] ) ) {
					$sidebar['description'] = sprintf( __( 'This is the %s sidebar description', 'ipress' ), $sidebar['name'] );
				}

				// Set up defaults for each sidebar
				$sidebar = $this->sidebar_defaults( $sidebar );    

				// Register sidebar
				register_sidebar( $sidebar );	 
			}
		}
	}

endif;

// Instantiate Sidebars Class
return new IPR_Sidebars;

//end
