<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * WordPress Helper functions
 * 
 * @package     iPress\Helper
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

//----------------------------------------------
//  WordPress Helper Functions
//
//  - ipress_get_category
//  - ipress_the_category_id
//  - ipress_get_category_id
//  - ipress_the_category_parent_id
//  - ipress_get_category_parent_id
//  - ipress_the_category_slug
//  - ipress_get_category_slug
//  - ipress_the_category_name
//  - ipress_get_category_name
//  - ipress_the_category_count
//  - ipress_get_category_count
//  - ipress_has_categories
//  - ipress_the_tax_term_count
//  - ipress_get_tax_term_count
//  - ipress_get_posts
//  - ipress_post_count
//  - ipress_get_post_list
//  - ipress_the_id_by_name
//  - ipress_get_id_by_name
//  - ipress_id_by_type_name
//  - ipress_get_user
//  - ipress_the_user_id
//  - ipress_get_user_id
//  - ipress_the_user_name
//  - ipress_get_user_name
//  - ipress_the_user_level
//  - ipress_get_user_level
//  
//----------------------------------------------

//----------------------------------------------
//  Category Functions
//----------------------------------------------

/**
 * Return the current object
 * 
 * @return object stdClass
 */
function ipress_get_category() {
    return get_the_category()[0];
}

/**
 * Output the current category ID
 */
function ipress_the_category_id() {
    echo get_the_category()[0]->cat_ID;
}

/**
 * Return the current category ID
 * 
 * @return integer
 */
function ipress_get_category_id() {
    return get_the_category()[0]->cat_ID;
}

/**
 * Output the current category parent ID
 */
function ipress_the_category_parent_id() {
    echo get_the_category()[0]->category_parent;
}

/**
 * Return the current category parent ID
 * 
 * @return integer
 */
function ipress_get_category_parent_id() {
    return get_the_category()[0]->category_parent;
}

/**
 * Output the current category slug
 */
function ipress_the_category_slug() {
    echo get_the_category()[0]->slug;
}

/**
 * Return the current category slug
 * 
 * @return string
 */
function ipress_get_category_slug() {
    return get_the_category()[0]->slug;
}

/**
 * Output the current category name
 */
function ipress_the_category_name() {
    echo get_the_category()[0]->cat_nicename;
}

/**
 * Return the current category name
 *
 * @return string
 */
function ipress_get_category_name() {
    return get_the_category()[0]->cat_nicename;
}

/**
 * Output the category count
 *
 * @param string|integer    $cat    category ID or slug - empty for current category
 */
function ipress_the_category_count( $cat='' ) {
    echo ipress_get_category_count( $cat );
}

/**
 * Return the category count
 * 
 * @global  $wpdb
 * @param   string|integer    $cat    category ID or slug - empty for current category
 * @return  integer
 */
function ipress_get_category_count( $cat='' ) {

    global $wpdb;

    // Current category
    if ( empty( $cat ) ) {
        return (int)get_the_category()[0]->category_count;
    }

    // Category by ID
    if ( is_numeric( $cat ) ) {
        $q = 'SELECT ' . $wpdb->term_taxonomy . '.count FROM ' . $wpdb->terms . ', ' . $wpdb->term_taxonomy . ' ' . 
             'WHERE ' . $wpdb->terms . '.term_id=' . $wpdb->term_taxonomy . '.term_id ' .  
             'AND ' . $wpdb->term_taxonomy . '.term_id=%d';
        $qs = $wpdb->prepare( $q, absint( $cat ) );
        return (int)$wpdb->get_var( $qs );
    }

    // Category by slug
    $q = 'SELECT ' . $wpdb->term_taxonomy . '.count FROM ' . $wpdb->terms . ', ' . $wpdb->term_taxonomy . ' ' .
         'WHERE ' . $wpdb->terms . '.term_id=' . $wpdb->term_taxonomy . '.term_id ' . 
         'AND' .  $wpdb->terms . '.slug=%s';
    $qs = $wpdb->prepare( $q, strtolower( $cat ) );

    // Return category count
    return (int)$wpdb->get_var( $qs );
}

/**
 * Returns true if multiple categories
 *
 * @return bool
 */
function ipress_has_categories() {

    // No transient, set one
    if ( false === ( $the_cats = get_transient( 'ipress_categories' ) ) ) {

        // Create an array of all categories attached to posts
		$the_cats = get_categories( [
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2,
		] );

        // Set transient as category count
        $the_cats = count( $the_cats );
		set_transient( 'ipress_categories', $the_cats );
	}

    // More than 1 category>
    return ( $the_cats > 1 ) ? true : false;
}

/**
 * Flush out the transients used in ipress_has_categories
 */
function ipress_flush_category_transients() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    delete_transient( 'ipress_categories' );
}

// Hook category change
add_action( 'edit_category', 'ipress_flush_category_transients' );
add_action( 'save_post',     'ipress_flush_category_transients' );

//---------------------------------------------
//  Taxonomy Functions
//---------------------------------------------

/**
 * Output the taxonomy term count
 *
 * @param string $tax taxonomy name
 * @param string|integer $term term id or name
 */
function ipress_the_tax_term_count( $tax, $term ) {
    echo ipress_get_tax_term_count( $tax, $term );
}

/**
 * Return the taxonomy term count
 *
 * @global  $wpdb
 * @param   string $tax taxonomy name
 * @param   string|integer $term term id or name
 * @return  integer
 */
function ipress_get_tax_term_count( $tax, $term ) {

    global $wpdb;

    // Current category
    if ( empty( $tax ) || empty( $term ) ) { return 0; }

    // Category by ID
    if ( is_numeric( $term ) ) {
        $q = 'SELECT ' . $wpdb->term_taxonomy . '.count FROM ' . $wpdb->terms . ', ' . $wpdb->term_taxonomy . ' ' . 
             'WHERE ' . $wpdb->terms . '.term_id=' . $wpdb->term_taxonomy . '.term_id ' .
             'AND ' . $wpdb->term_taxonomy . '.taxonomy=%s ' . 
             'AND ' . $wpdb->term_taxonomy . '.term_id=%d';
        $qs = $wpdb->prepare( $q, $tax, absint( $term ) );
        return (int)$wpdb->get_var( $qs );
    }

    // Category by slug
    $q = 'SELECT ' . $wpdb->term_taxonomy . '.count FROM ' . $wpdb->terms . ', ' . $wpdb->term_taxonomy . ' ' .
         'WHERE ' . $wpdb->terms . '.term_id= ' . $wpdb->term_taxonomy . '.term_id ' .
         'AND ' . $wpdb->term_taxonomy . '.taxonomy=%s ' . 
         'AND ' . $wpdb->terms . '.slug=%s';
    $qs = $wpdb->prepare( $q, $tax, strtolower( $term ) );

    // Return term count
    return (int)$wpdb->get_var( $qs );
}

//----------------------------------------------
//  Post Type Functions
//----------------------------------------------

/**
 * Get a list of posts by type
 *
 * @param   string  $type
 * @param   string|array $status default 'publish'
 * @return  array
 */
function ipress_get_posts( $post_type, $status='publish' ) {

    // Statuses
    $statuses = [ 
        'publish',
        'future',
        'draft',
        'pending', 
        'pending', 
        'private', 
        'trash'        
    ];
    
    // No type?
    if ( empty( $post_type ) ) { return false; }

    // Bad status
    if ( $status === 'all' ) {
        $status = $statuses;
    } else {
        if ( is_array( $status ) ) {
            foreach ( $status as $s ) {
                if ( !in_array( $s, $statuses ) ) { return false; }
            }
        } else {        
            if ( !in_array( $status, $statuses ) ) { return false; }
        }
    }
    
    // Set up the query args
    $args = [  
        'post_type'         => $post_type,
        'post_status'       => $status,
        'posts_per_page'    => -1 
    ];

    // Get the posts
    $the_query = new WP_Query( $args );

    // Return the posts
    return $the_query->get_posts();
}

/**
 * Post count by post type 
 *
 * @param   string  $type
 * @param   string  $status default 'publish'
 * @return  integer|boolean
 */
function ipress_post_count( $post_type, $status='publish' ){

    // Statuses
    $statuses = [ 
        'publish',
        'future',
        'draft',
        'pending', 
        'pending', 
        'private', 
        'trash'        
    ];

    // Bad status
    if ( !in_array( $status, $statuses ) ) { return false; }
    
    // Get post count by type
    $num_posts = wp_count_posts( $post_type );

    // Retrieve post count
    return (int)$num_posts->$status;
}

/**
 * Return list of the custom post type  
 *
 * @global  $post
 * @param   string  $type
 * @param   string|array $status
 * @return  array
 */
function ipress_get_post_list( $post_type, $status='publish' ) {

    global $post;

    // Statuses
    $statuses = [ 
        'publish',
        'future',
        'draft',
        'pending', 
        'pending', 
        'private', 
        'trash'        
    ];
    
    // No type?
    if ( empty( $post_type ) ) { return false; }

    // Bad status
    if ( $status === 'all' ) {
        $status = $statuses;
    } else {
        if ( is_array( $status ) ) {
            foreach ( $status as $s ) {
                if ( !in_array( $s, $statuses ) ) { return false; }
            }
        } else {        
            if ( !in_array( $status, $statuses ) ) { return false; }
        }
    }

    $posts = [];

    // Set up query
    $args = [ 
        'post_type'      => $post_type,
        'post_status'    => $status,
        'posts_per_page' => -1 
    ];
    $the_query = new WP_Query( $args );

    // The loop
    $posts = [];
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $posts[$post->ID] = $post->post_title;
        }
    }
    wp_reset_postdata();

    // Return posts
    return $posts;
}

//----------------------------------------------
//  Page Functions
//----------------------------------------------

/**
 * Output post/page id by name
 * 
 * @param string post slug
 */
function ipress_the_id_by_name( $name ) {
    echo get_page_by_title( $name, OBJECT, 'post' )->ID;
}

/**
 * Get post/page id by name
 * 
 * @param string post slug
 * @return integer id
 */
function ipress_get_id_by_name( $name ) {
    return get_page_by_title( $name, OBJECT, 'post' )->ID;
}

/**
 * Returns the post type by slug
 * 
 * @param string $type
 * @param string $name
 * @return integer
 */
function ipress_id_by_type_name( $type, $name ) {
    get_page_by_path( $name, OBJECT, $type )->ID;
}

//----------------------------------------------
//  User Data
//----------------------------------------------

/**
 * Get current user ID
 *
 * @global  $userdata
 * @return  object
 */
function ipress_get_user() {

    // Get the current user
    $current_user = wp_get_current_user();

    // Return user data
    return $current_user;
}

/**
 * Output current user ID
 */
function ipress_the_user_id() {
    echo ipress_get_user_id();
}

/**
 * Get current user ID
 *
 * @return integer
 */
function ipress_get_user_id() {

    // Get the current user
    $current_user = wp_get_current_user();

    // Return user id
    return (int)$current_user->ID;
}

/**
 * Get current user name
 */
function ipress_the_username() {
    echo ipress_get_username();
}

/**
 * Get current user name
 * 
 * @global  $userdata
 * @return string
 */
function ipress_get_username() {

    // Get the current user
    $current_user = wp_get_current_user();

    // Return user login name
    return $current_user->user_login;
}

/**
 * Output current user level
 */
function ipress_the_user_level() {
    echo ipress_get_user_level();
}

/**
 * Get current user level
 * 
 * @global  $userdata
 * @return  string
 */
function ipress_get_user_level() {

    // Get the current user
    $current_user = wp_get_current_user();

    // Return user level
    return $current_user->user_level;
}

/**
 * Output current user name
 */
function ipress_the_user_name( $full=true ) {
    echo ipress_get_user_name( $full );
}

/**
 * Get current user name
 * 
 * @global  $userdata
 * @return  string
 */
function ipress_get_user_name( $full=true ) {

    // Get the current user
    $current_user = wp_get_current_user();

    // Return user level
    return ( $full === false ) ? $current_user->display_name : $current_user->user_firstname . ' ' . $current_user->user_lastname;
}

//end
