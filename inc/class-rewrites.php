<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Rewrites
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
 * Set up query rewrite features
 */ 
final class IPR_Rewrites {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Add new query vars
        add_filter( 'query_vars', [ $this, 'query_vars' ] , 10, 1 );
    }

    //----------------------------------------------
    //  Rewrite Rules
    //----------------------------------------------

    //----------------------------------------------
    //  Query Vars Rules
    //----------------------------------------------

    /**
     * Add a new query var
     *
     * @param   array
     * @return  array
     */
    public function query_vars( $qvars ) {
    
        // Filterable query vars
        $query_vars = apply_filters( 'ipress_query_vars', [] );

        // Return modified query vars
        return ( empty( $query_vars ) ) ? $qvars : array_merge( $qvars, array_map( sanitize_title_with_dashes, $query_vars ) );   
    }
}

// Instantiate Rewrites Class
return new IPR_Rewrites;

//end
