<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Ajax
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
 * Set up ajax features
 */ 
final class IPR_Ajax {

    /**
     * Class constructor
     * - set up hooks
     * 
     * - wp_ajax_xxx 
     * - wp_ajax_nopriv_xxx
     */
    public function __construct() {}

    //----------------------------------------------
    //  Ajax Functionality
    //----------------------------------------------

}

// Instantiate Ajax Class
return new IPR_Ajax;

//end
