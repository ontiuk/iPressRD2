<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme specific WP-REST API functionality in-absentia of plugin
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_API' ) ) :

	/**
	 * Set up WP-REST API functionality
	 */ 
	final class IPR_API {

		/**
		 * Class constructor
		 */
		public function __construct() {
			
			// Set up new REST endpoints 
			$this->init();
		}

		//----------------------------------------------
		//	REST API Endpoints
		//----------------------------------------------

		/**
		 * Set up theme specific REST endpoints
		 */
		public function init() {}

		//----------------------------------------------
		//	REST API Functionality
		//----------------------------------------------

	}

endif;

// Instantiate REST API Class
return new IPR_API;

//end
