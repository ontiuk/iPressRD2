<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Query
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

/**
 * Set up query manipulation functionality
 */ 
final class IPR_Query {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Eliminate duplicates in query results
        //add_filter( 'posts_distinct', [ $this, 'posts_distinct' ] );

        // Set the GROUP BY clause for the SQL query 
        //add_filter( 'posts_groupby', [ $this, 'posts_groupby' ] );

        // Set the table JOIN clause for the SQL query 
        //add_filter( 'posts_join', [ $this, 'posts_join' ] );

        // Set the LIMIT clause for the SQL query 
        //add_filter( 'post_limits', [ $this, 'posts_limit' ], 10, 2 );

        // Set the ORDER BY clause for the SQL query 
        //add_filter( 'posts_orderby', [ $this, 'posts_orderby' ] );

        // Set the POSTS JOIN PAGED clause for the SQL query 
        //add_filter( 'posts_join_paged', [ $this, 'posts_join_paged' ] );

        // Set the POSTS WHERE clause for the SQL query 
        //add_filter( 'posts_where' , [ $this, 'posts_where' ] );

        // Customise the Post Type query if a taxonomy term is used
        //add_action( 'pre_get_posts', [ $this, 'post_type_archives' ] );

        // Exclude category posts from home page - defaults to unclassified
        //add_action( 'pre_get_posts', [ $this, 'exclude_categories' ] );

        // Query post clauses
        //add_filter( 'posts_clauses', [ $this, 'posts_clauses' ] );

        // Term query clauses
        //add_filter( 'terms_clauses', [ $this, 'terms_clauses' ] );

        // Add custom post types to Search
        //add_action( 'pre_get_posts', [ $this, 'search_include' ] );
    }

    //----------------------------------------------
    //  Main Query Filters
    //----------------------------------------------

    /**
     * Set the query duplicate restrictions
     *
     * @return  string
     */
    public function posts_distinct() { return 'DISTINCT'; }

    /**
     * Set the Group By clause
     *
     * @global  $wpdb
     * @param   string
     * @return  string
     */
    public function posts_groupby( $groupby ) {
    
        global $wpdb;

        return $groupby;
    }

    /**
     * Set the table join parameters
     * 
     * @param   string
     * @return  string
     */
    public function posts_join( $join ) { return $join; }

    /**
     * Set the return limiter
     * 
     * @param   integer
     * @param   string
     * @return  string
     */
    public function posts_limit( $limit, $query ) {
        return $limit;
    }


    /**
     * Set the orderby clause
     * 
     * @param   string
     * @return  string
     */
    public function posts_orderby( $orderby ) {
        return $orderby;
    }

    /**
     * Set the paged join clause
     * 
     * @param   string
     * @return  string
     */
    public function posts_join_paged( $join_paged ) {
        return $join_paged; 
    }

    /**
     * Set the where clause
     * 
     * @param   string
     * @return  string
     */
    public function posts_where( $where ) { return $where; }

    /**
     * Posts Clauses
     *
     * @param   array   $pieces
     * @return  array
     */
    public function posts_clauses( $pieces ) {
        return $pieces;
    }

    //----------------------------------------------  
    // Terms Query Filters
    //----------------------------------------------  

    /**
     * Terms Clauses
     *
     * @param   array   $pieces
     * @return  array
     */
    public function terms_clauses( $pieces ) {
        return $pieces;
    }

    //----------------------------------------------  
    // Main Query Manipulation
    //----------------------------------------------  

    /**
     * Customise the Post Type query if a taxonomy term is used
     *
     * @param   object  WP_Query
     */
    function post_type_archives( $query ) {

        $post_types = apply_filters( 'ipress_query_post_type_archives', [] );

        // Main query & post-types
        if ( $query->is_main_query() && !is_admin() && $query->is_post_type_archive( $post_types ) ) {

            // Only if taxonomy set modify query
            if ( is_tax() ) {

                $tax_obj = $query->get_queried_object();
            
                $tax_query = [
                        'taxonomy'  => $tax_obj->taxonomy,
                        'field'     => 'slug',
                        'terms'     => $tax_obj->slug,
                        'include_children' => false
                ];
            
                $query->tax_query->queries[] = $tax_query;
                $query->query_vars['tax_query'] = $query->tax_query->queries;
            }
        }
    }

    /**
     * Exclude uncategorised posts from home/posts page
     *
     * @param object WP_Query
     */
    public function exclude_categories( $query ) {

        // Select categories to exclude: default 'uncategorised'
        $exc_cats = apply_filters( 'ipress_exclude_category', ['-1'] );
            
        // Main query & home page
        if ( $query->is_home() && $query->is_main_query() && $exc_cats ) {
            $cats = array_map( [ $this, 'exclude_category_map' ], $exc_cats );
            $cats = join( ',', $cats );
            $query->set( 'cat', $cats );
        }
    }
    
    /**
     * Map excluded categories to negatives
     *
     * @param string
     * @return integer
     */ 
    private function exclude_category_map( $cat ) {
        $cat = (int)$cat;
        return ( $cat <= 0 ) ? $cat : ( -1 * $cat );
    }

    /**
     * Use deals post type in Search
     *
     * @param object $query WP_Query object
     */
    public function search_include( $query ) {

        // Set search post types
        $post_types = apply_filters( 'ipress_query_search_include', [] );

        // Main query search
        if ( !is_admin() && $query->is_main_query() && $query->is_search && $post_type ) {
            $query->set( 'post_type', [ $post_types ] );
        }
    }
}

// Instantiate Query Class
return new IPR_Query;

//end
