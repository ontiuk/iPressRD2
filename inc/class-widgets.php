<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress widget features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Widgets' ) ) :

	/**
	 * Initialise and set up widgets
	 */ 
	final class IPR_Widgets {

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {

			// Core widget initialisation
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );	
		}

		//------------------------------------------
		//	Widget Loading 
		//------------------------------------------

		/**
		 * Widget Autoload
		 *
		 * @param	string $widget
		 * @return	boolean
		 */
		private function widget_autoload( $widget ) {

			// Syntax for widget classname to file
			$classname = 'class-' . str_replace( '_', '-', strtolower( $widget ) );

			// Create the actual filepath
			$file_path = ( is_child_theme() ) ? trailingslashit( IPRESS_CHILD_WIDGETS_DIR ) . $classname . '.php' : trailingslashit( IPRESS_WIDGETS_DIR ) . $classname . '.php';

			// Check if the file exists in parent theme
			if ( file_exists( $file_path ) && is_file( $file_path ) ) { 
				include $file_path; 
				return true; 
			}

			// Bad file or path?
			return false;
		}
		
		/**
		 * Load & Initialise default widgets
		 */
		public function widgets_init() {

			// Contruct widgets list
			$widgets = apply_filters( 'ipress_widgets', [] );

			// Register widgets
			foreach ( $widgets as $widget ) {

				// Load widget file... spl_autoload might be better
				if ( ! $this->widget_autoload( $widget ) ) { continue; }

				// Register widget
				register_widget( $widget );
			}
		}
	}

endif;

// Instantiate Widgets Class
return new IPR_Widgets;

//end
