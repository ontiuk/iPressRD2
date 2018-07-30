<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Cron' ) ) :

	/**
	 * Set up cron functionality 
	 */ 
	final class IPR_Cron {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Initialize cron functionality
			$this->init();
		}

		//----------------------------------------------
		//	Cron Actions
		//----------------------------------------------

		/**
		 * Initialise Cron hooks
		 */
		public function init() {}
			
		//----------------------------------------------
		//	Cron Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Cron Class
return new IPR_Cron;

//end
