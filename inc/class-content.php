<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme starter content
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @see			https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Content' ) ) :

	/**
	 * Set up theme starter content
	 *
	 * @see https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
	 */ 
	final class IPR_Content {

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {
		
			// Set up content hook
			add_action( 'after_setup_theme', [ $this, 'starter_content_init' ] );
		}

		//----------------------------------------------
		//	Content Functionality
		//----------------------------------------------

		/**
		 * Initialise starter content if available
		 */
		public function starter_content_init() {

			// Filterable starter content
			$starter_content = (array) apply_filters( 'ipress_starter_content', [] );
			if ( empty( $starter_content ) ) { return; }

			// Add theme support if required
			add_theme_support( 'starter-content', $starter_content );
		}
	}

endif;

// Instantiate Content Class
return new IPR_Content;

//end
