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

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

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
		$starter_content = apply_filters( 'ipress_starter_content', [] );

		// Add theme support if required
		if ( is_array( $starter_content ) && !empty( $starter_content ) ) {
			add_theme_support( 'starter-content', $starter_content );
		}
	}
}

// Instantiate Content Class
return new IPR_Content;

//end
