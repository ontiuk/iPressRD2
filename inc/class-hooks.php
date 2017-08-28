<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Hooks
 * @link        http://on.tinternet.co.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * Set up custom hooks functionality
 */ 
final class IPR_Hooks {

    /**
     * Hooks handle
     *
     * @var object $hooks
     */
    private $hooks;
    
    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {
        
        // Initialise hooks handler
        $this->hooks = new WP_Hook;

        //------------------------------------------
        //  Initialise Hook Actions
        //------------------------------------------

    }

    //----------------------------------------------
    // Hook Functionlity
    //----------------------------------------------

}

// Instantiate Hooks class
return new IPR_Hooks;

//end
