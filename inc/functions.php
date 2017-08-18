<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme functions & functionality
 * 
 * @package     iPress\Functions
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
//  Theme Functions
//
//  - ipress_is_home_page
//  - ipress_is_index
//  - ipress_code
//  - ipress_format_kses
//  - ipress_allowedtags
//  - ipress_pagination
//  - ipress_numeric_posts_nav
//  - ipress_prev_next_post_nav
//  - ipress_get_params
//  - ipress_get_permalink_by_page
//  - ipress_paged_post_url
//  - ipress_canonical_url
//  - ipress_index
//  - ipress_content
//  - ipress_truncate
//  - ipress_woocommerce_active
//  - ipress_product_archive
//----------------------------------------------

/**
 * Check if the root page of the site is being viewed
 *
 * is_front_page() returns false for the root page of a website when
 * - the WordPress 'Front page displays' setting is set to 'Static page'
 * - 'Front page' is left undefined
 * - 'Posts page' is assigned to an existing page
 *
 * @return boolean
 */
function ipress_is_home_page() {
    return ( is_front_page() || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) ) ? true : false;
}

/**
 * Check if the page being viewed is the index page
 *
 * @param   string  $page
 * @return  boolean
 */
function ipress_is_index( $page ) {
    return ( basename( $page ) === 'index.php' );
}

/**
 * Mark up content with code tags
 * - escapes all HTML, so `<` gets changed to `&lt;` and displays correctly
 *
 * @param   string $content Content to be wrapped in code tags
 * @return  string Content wrapped in code tags
 */
function ipress_code( $content ) {
    return '<code>' . esc_html( $content ) . '</code>';
}

/**
 * Wrapper for wp_kses() that can be used as a filter function
 *
 * @uses    ipress_format_allowedtags() List of allowed HTML elements
 * @param   string $string Content to filter through kses
 * @return  string
 */
function ipress_format_kses( $string ) {
    return wp_kses( $string, ipress_allowedtags() );
}

/**
 * Return an array of allowed tags for output formatting
 * - Used by wp_kses() for sanitizing output
 *
 * @return array
 */
function ipress_allowedtags() {

    // Return structured list
    return [
            'a'          => [ 'href' => [], 'title' => [] ],
            'b'          => [],
            'blockquote' => [],
            'br'         => [],
            'div'        => [ 'align' => [], 'class' => [], 'style' => [] ],
            'em'         => [],
            'i'          => [],
            'p'          => [ 'align' => [], 'class' => [], 'style' => [] ],
            'span'       => [ 'align' => [], 'class' => [], 'style' => [] ],
            'strong'     => []
    ];
}

//----------------------------------------------
// Pagination
//----------------------------------------------

/**
 * Pagination for archives 
 *
 * @global  $wp_query   WP_Query
 * @return  string
 */
function ipress_pagination() { 
    
    global $wp_query; 
    $big = 999999999; 

    // Get pagination links
    $pages = paginate_links( [
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => max( 1, get_query_var('paged') ),
            'total'     => $wp_query->max_num_pages,
            'type'      => 'array',
            'prev_text' => __( 'Prev', 'ipress' ),
            'next_text' => __( 'Next', 'ipress' )
    ] );

    // Get paged value
    $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

    // Generate list if set
    if ( is_array( $pages ) && $paged ) {
        $list = '<ul class="pagination">';
        foreach ( $pages as $page ) { $list .= sprintf( '<li>%d</li>', $page ); }
        $list .= '</ul>';
    } else { $list = ''; }

    // Return list
    return $list;
} 

/**
 * Echo archive pagination in Previous Posts / Next Posts format
 */
function ipress_prev_next_posts_nav() {

    // Get prev & next links
    $prev_link = get_previous_posts_link( '&#x000AB; ' . __( 'Previous', 'ipress' ) );
    $next_link = get_next_posts_link( __( 'Next', 'ipress' ) . ' &#x000BB;' );

    // Set link html
    $prev = $prev_link ? sprintf( '<div class="pagination-previous alignleft">%s</div>', $prev_link ) : '';
    $next = $next_link ? sprintf( '<div class="pagination-next alignright">%s</div>', $next_link ) : '';

    // Set link wrapper
    $nav = '<div class="pagination-wrap">';

    // Construct link
    $nav .= $prev . $next . '</div>';
    
    // Output if valid
    if ( $prev || $next ) { echo $nav; }
}

/**
 * Archive pagination in page numbers format
 *
 * - Links ordered as:
 *  - previous page arrow
 *  - first page
 *  - up to two pages before current page
 *  - current page
 *  - up to two pages after the current page
 *  - last page
 *  - next page arrow
 *
 * @param   boolean     $echo
 * @return  string
 * @global  WP_Query    $wp_query Query object
 */
function ipress_numeric_posts_nav( $echo = true ) {

    global $wp_query;

    // Single post only
    if ( is_singular() ) { return; }

    // Stop execution if there's only 1 page
    if( $wp_query->max_num_pages <= 1 ) { return; }

    // Get pagination values
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    // Add current page to the array
    if ( $paged >= 1 ) { $links[] = $paged; }

    // Add the pages around the current page to the array
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    // Add the pages around the current page to the array
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    // Generate wrapper
    $output = '<div class="pagination-wrap">';

    // Start list
    $output .= '<ul>';

    // Previous post link
    if ( get_previous_posts_link() ) {
        $output .= sprintf( '<li class="pagination-previous">%s</li>' . PHP_EOL, get_previous_posts_link( '&#x000AB; ' . __( 'Previous Page', 'ipress' ) ) );
    }

    // Link to first page, plus ellipses if necessary
    if ( ! in_array( 1, $links ) ) {

        $class = ( 1 == $paged )? ' class="active"' : '';
        $output .= sprintf( '<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url( get_pagenum_link( 1 ) ), ' ' . '1' );

        if ( ! in_array( 2, $links ) ) {
            $output .= '<li class="pagination-omission">&#x02026;</li>' . PHP_EOL;
        }
    }

    // Link to current page, plus 2 pages in either direction if necessary
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = ( $paged == $link ) ? ' class="active"  aria-label="' . __( 'Current page', 'ipress' ) . '"' : '';
        $output .= sprintf( '<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url( get_pagenum_link( $link ) ), ' ' . $link );
    }

    // Link to last page, plus ellipses if necessary
    if ( ! in_array( $max, $links ) ) {

        if ( ! in_array( $max - 1, $links ) ) {
            $output .= sprintf( '<li class="pagination-omission">%s</li>', '&#x02026;' ) . PHP_EOL;
        }

        $class = $paged == $max ? ' class="active"' : '';
        $output .= sprintf( '<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url( get_pagenum_link( $max ) ), ' ' . $max );
    }

    // Next post link
    if ( get_next_posts_link() ) {
        $output .= sprintf( '<li class="pagination-next">%s</li>' . PHP_EOL, get_next_posts_link( __( 'Next Page', 'ipress' ) . ' &#x000BB;' ) );
    }

    // Generate output
    $output .= '</ul></div>' . PHP_EOL;

    // Send output
    if ( $echo ) { echo $output; } else { return $output; }
}

/**
 * Display links to previous and next post from a single post
 *
 * @param   boolean $echo
 * @return  string
 */
function ipress_prev_next_post_nav() {

    // Single post only
    if ( ! is_singular( 'post' ) ) { return; }

    // Start wrapper
    $output = '<div class="pagination-wrap">';

    // Generate output
    $output .= sprintf( '<div class="pagination-previous alignleft">%s</div>', previous_post_link() );
    $output .= sprintf( '<div class="pagination-next alignright">%s</div></div>', next_post_link() );

    // Send output
    if ( $echo ) { echo $output; } else { return $output; }
}

//---------------------------------------------
//  Miscellaneous Functions          
//---------------------------------------------

/**
 * Retrieve function parameters
 *
 * @param  array|string $args
 * @return  array
 */
function ipress_get_params( $args ) {

    // Passed as normal array or as regular url-compatible arguments - handle associative array for options
    if ( is_array( $args ) && !empty( $args ) ) {
        foreach( array_keys( $args ) as $key ) { $params[strtolower( $key )] = $args[$key]; }
    } else {
        parse_str( $args, $params );
    }
    
    // Return contruct
    return $params;
}

/**
 * Get url by page template 
 *
 * @param   string $template
 * @return  string
 */
function ipress_get_permalink_by_page( $template ) {

    // Get pages
    $page = get_pages( [
        'meta_key'      => '_wp_page_template',
        'meta_value'    => $template . '.php'
    ] );

    // Get the url
    return ( empty( $page ) ) ? '' : get_permalink( $page[0]->ID );
}

/**
 * Return the special URL of a paged post 
 * - adapted from _wp_link_page() in WP core
 *
 * @param   int     $i The page number to generate the URL from
 * @param   int     $post_id The post ID
 * @return  string  Unescaped URL
 */
function ipress_paged_post_url( $i, $post_id = 0 ) {

    global $wp_rewrite;

    // Get post by ID
    $post = get_post( $post_id );

    // Paged?
    if ( 1 == $i ) {
        $url = get_permalink( $post_id );
    } else {
        if ( '' == get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
            $url = add_query_arg( 'page', $i, get_permalink( $post_id ) );
        } elseif ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
            $url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $i, 'single_paged' );
        } else {
            $url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $i, 'single_paged' );
        }
    }

    // Return link
    return $url;
}

/**
 * Calculate and return the canonical URL
 * 
 * @global  $wp_query   WP_Query
 * @return  string      The canonical URL, if one exists
 */
function ipress_canonical_url() {

    global $wp_query;
    $canonical = '';

    // Pagination values
    $paged = intval( get_query_var( 'paged' ) );
    $page  = intval( get_query_var( 'page' ) );

    // Front page / home page
    if ( is_front_page() ) {
        $canonical = ( $paged ) ? get_pagenum_link( $paged ) : trailingslashit( home_url() );
    }

    // Single post
    if ( is_singular() ) {
        $numpages = substr_count( $wp_query->post->post_content, '<!--nextpage-->' ) + 1;
        if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
        $canonical = ( $numpages > 1 && $page > 1 ) ? ipress_paged_post_url( $page, $id ) : get_permalink( $id );
    }

    // Archive
    if ( is_category() || is_tag() || is_tax() ) {
        if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
        $taxonomy = $wp_query->queried_object->taxonomy;
        $canonical = ( $paged ) ? get_pagenum_link( $paged ) : get_term_link( (int) $id, $taxonomy );
    }

    // Author
    if ( is_author() ) {
        if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
        $canonical = ( $paged ) ? get_pagenum_link( $paged ) : get_author_posts_url( $id );
    }

    // Search
    if ( is_search() ) {
        $canonical = get_search_link();
    }

    // Return generated code
    return $canonical;
}

/**
 * Custom Excerpt - callback for index page excerpts
 *
 * @param   integer
 * @return  integer
 */
function ipress_index( $length ) { return absint( $length ); } 
  
/**
 * Create the Custom Excerpt 
 *
 * @param   string $length_callback
 * @param   string $more_callback
 * @param   boolean $wrap
 */
function ipress_excerpt( $length_callback = '', $more_callback = '', $wrap=true ) { 
    
    global $post; 

    // Excerpt length    
    if ( !empty( $length_callback ) && function_exists( $length_callback ) ) { 
        add_filter( 'excerpt_length', $length_callback ); 
    } 

    // Excerpt more
    if ( !empty( $more_callback ) && function_exists( $more_callback ) ) { 
        add_filter( 'excerpt_more', $more_callback ); 
    } 

    // Get the excerpt
    $output = get_the_excerpt(); 
    $output = apply_filters( 'wptexturize', $output ); 
    $output = apply_filters( 'convert_chars', $output ); 

    // Output the excerpt
    echo ( $wrap ) ? sprintf( '<p>%s</p>', $output ) : $output; 
} 

/**
 * Trim the content by word count
 * 
 * @param  integer
 * @param  string
 * @param  string
 */
function ipress_content( $length=54, $before='', $after='' ) {

    // Get the content
    $content = get_the_content();

    // Trim to word count and output
    echo sprintf( '%s', $before . wp_trim_words( $content, $length, '...' ) . $after );
}

/**
 * Return a phrase shortened in length to a maximum number of characters
 * - Truncated at the last white space in the original string
 *
 * @param   string $text 
 * @param   integer $max_chara
 * @return  string 
 */
function ipress_truncate( $text, $max_char ) {

    // Sanitize
    $text = trim( $text );

    // Test text length
    if ( strlen( $text ) > $max_char ) {

        // Truncate $text to $max_characters + 1
        $text = substr( $text, 0, $max_char + 1 );

        // Truncate to the last space in the truncated string
        $text = trim( substr( $text, 0, strrpos( $text, ' ' ) ) );
    }

    // Return truncated text
    return $text;
}

//----------------------------------------------
//  WooCommerce Functions
//----------------------------------------------

/**
 * Query WooCommerce activation
 *
 * @return boolean true if WooCommerce plugin active
 */
function ipress_is_woocommerce() {
	return ( class_exists( 'WooCommerce' ) ) ? true : false;
}

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
function ipress_is_product_archive() {

    // No woocommerce
    if ( ! ipress_is_woocommerce() ) { return false; }

    // Product archive
    return ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ? true : false;
}

//end
