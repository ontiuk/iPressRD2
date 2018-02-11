<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme ajax functionality
 * 
 * @package     iPress\Includes
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
     */
    public function __construct() {

        // Initialize Ajax functionality
        $this->init();
    }

    //----------------------------------------------
    //  Ajax Actions
    //----------------------------------------------

    /**
     * Initialise Ajax hooks
     * 
     * - wp_ajax_xxx 
     * - wp_ajax_nopriv_xxx
     */
    public function init() {}
        
    //----------------------------------------------
    //  Ajax Functionality
    //----------------------------------------------

}

// Instantiate Ajax Class
return new IPR_Ajax;

//end
