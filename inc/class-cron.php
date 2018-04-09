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

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

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

// Instantiate Cron Class
return new IPR_Cron;

//end
