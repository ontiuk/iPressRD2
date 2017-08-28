<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Page
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
 * Set up page support features
 */ 
final class IPR_Page {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Page excerpt & tag support
        add_action( 'init', [ $this, 'page_support' ] );

        // Tags query support
        add_action( 'pre_get_posts', [ $this, 'page_tags_query' ] );

        // Add post types to generic search
        add_action( 'pre_get_posts', [ $this, 'add_cpt_to_search' ] ); 
    }

    //----------------------------------------------  
    // Page Excerpt & Tag Support
    //----------------------------------------------  

    /**
     * Set up page excerpt & tag support
     */
    public function page_support() {

        // Page excerpt support
        $page_excerpt_support = (bool)apply_filters( 'ipress_page_excerpt', false );
        if ( $page_excerpt_support ) { add_post_type_support( 'page', 'excerpt' ); }

        // Page tag support   
        $page_tag_support = (bool)apply_filters( 'ipress_page_tags', false );
        if ( $page_tag_support ) { register_taxonomy_for_object_type( 'post_tag', 'page' ); }
    }

    /**
     * Ensure all tags are included in queries
     * 
     * @param object $query WP_Query
     */
    public function page_tags_query( $wp_query ) {
        $page_tag_support = (bool)apply_filters( 'ipress_page_tags_query', false );
        if ( $page_tag_support && $wp_query->get( 'tag' ) ) { $wp_query->set( 'post_type', 'any' ); }
    }

    /**
     * Add custom post types to search
     *  
     * @param object $query WP_Query
     * @return object
     */
    public function add_cpt_to_search( $query ) { 

        // Generate search post types - e.g names from get_post_types( [ 'public' => true, 'exclude_from_search' => false ], 'objects' ); 
        $post_types = (array)apply_filters( 'ipress_search_types', [] );
        if ( empty( $post_types ) ) { return $query; }

     	// Check to verify it's search page & add post types to search
        if ( !is_admin() && $query->is_main_query() && $query->is_search() ) { 
            $query->set( 'post_type', array_merge( $post_types, [ 'post', 'page' ] ) ); 
 	    } 
     	return $query; 
    } 
}

// Instantiate Page Class
return new IPR_Page;

//end
