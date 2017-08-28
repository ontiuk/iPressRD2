<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Redirect
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * Set up redirect features
 */ 
final class IPR_Redirect {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {}

    //----------------------------------------------
    //  Redirect Functionality
    //----------------------------------------------

}

// Instantiate Redirect Class
return new IPR_Redirect;

//end
