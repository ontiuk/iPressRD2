<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
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
 * Set up template & template heirarchy features
 */ 
final class IPR_Template {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Reset path for main template files, except index.php
        add_filter( 'template_include', [ $this, 'template_include' ], 99 );
    }

    //---------------------------------------------
    // Theme Template Functionality  
    //---------------------------------------------

    /**
     * Reset path for main template files, except index.php
     *
     * @param   string
     * @return  string
     */
    public function template_include( $template ) {
    
        // WooCommerce override: allow Woocommerce version of template_include to take priority if set
        if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) { return $template; }

        // Test restrictions
        return ( is_child_theme() ) ? $template : IPRESS_ROUTE_DIR . '/' . basename( $template );
    }
}

// Instantiate Template Class
return new IPR_Template;

//end
