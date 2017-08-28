<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\User
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
 * Set up user features
 */ 
final class IPR_User {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {}

    //----------------------------------------------
    //  User Functionality 
    //----------------------------------------------

}

// Instantiate User Class
return new IPR_User;

//end
