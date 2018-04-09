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
 * Set up template & template heirarchy features
 * - hook: template_include
 * - hook: template_redirect
 */ 
final class IPR_Template {

	/**
	 * Class constructor
	 * - set up hooks
	 */
	public function __construct() {}

	//---------------------------------------------
	// Theme Template Functionality  
	//---------------------------------------------

}

// Instantiate Template Class
return new IPR_Template;

//end
