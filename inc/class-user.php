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
 * Set up user features
 */ 
final class IPR_User {

	/**
	 * Class constructor
	 */
	public function __construct() {
		
		// Initialize User functionality
		$this->init();
	}

	//----------------------------------------------
	//	User Actions & Filters
	//----------------------------------------------

	/**
	 * Initialise User hooks
	 */
	public function init() {}

	//----------------------------------------------
	//	User Functionality 
	//----------------------------------------------

}

// Instantiate User Class
return new IPR_User;

//end
