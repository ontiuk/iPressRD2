<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Template
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

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

        // Add /partials path to template partials search paths Trac #13239
//        add_filter( 'template_locations', [ $this, 'template_locations' ], 10, 1 );        

        // Modify template partial search path for e.g. header file Trac #13239
//        add_filter( 'locate_template', [ $this, 'locate_template' ], 10, 2 ); 
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

    //---------------------------------------------
    // Template Override Functions - Trac #13239
    //---------------------------------------------

    /**
     * Add /partials path to template partials search paths
     *
     * @param   array $locations
     * @return  array
     */
    public function template_locations ( $locations ) {
        unset( $locations['theme-compat'] );
        array_walk( $locations, function ( &$v, $k, $s ) { $v .= $s; }, '/partials' );
        return $locations;
    }

    /**
     * Add /partials & /templates path to template partials search paths
     *
     * @param   array $locations
     * @return  array
     */
//  public function template_locations ( $locations ) {
//      unset( $locations['theme-compat'] );
//      $new_locat = [
//        'template-partials'     => get_template_directory() . '/partials',
//        'template-templates'    => get_template_directory() . '/templates'
//      ];
//      return array_merge( $new_locat, $locations );
//  }

    /**
     * Modify template partial search path for e.g. header file
     *
     * @param   string  $location
     * @param   array   $template_names
     * @return  array
     */
    public function locate_template ( $location, $template_names ) {
        if ( in_array( 'header.php', $template_names ) ) {
            $location = ( is_child_theme() ) ? get_theme_file_path() . 'header.php' : get_parent_theme_file_path() . 'partials/header.php';
        }
        return $location;
    }
}

// Instantiate Template Class
return new IPR_Template;

//end
