<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Layout
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

/**
 * Initialise and set up Layout features
 */ 
final class IPR_Layout {

    /**
     * Class constructor. Set up hooks
     */
    public function __construct() {

        // Set the current theme direction
        add_action( 'init', [ $this, 'theme_direction' ] ); 

        // Add slug to body class
        add_filter( 'body_class', [ $this, 'body_class' ] ); 

        // Remove or amend the 'read more' link
        add_filter( 'the_content_more_link', [ $this, 'read_more_link' ] ); 

        // Add 'View Article' button instead of [...] for Excerpts
        add_filter( 'excerpt_more', [ $this, 'view_more' ] ); 

        // Wrapper for video embedding - generic & jetpack
        add_filter( 'embed_oembed_html', [ $this, 'embed_video_html' ], 10, 3 );
        add_filter( 'video_embed_html', [ $this, 'embed_video_html' ] ); 
    }

    //---------------------------------------------
    //  Layout Actions & Filters
    //---------------------------------------------

    /**
     * Control rtl - ltr theme layout at user level 
     *
     * @global $wp_locale
     * @global $wp_styles
     */
    public function theme_direction() {

        global $wp_locale, $wp_styles;

        // Filterable direction: ltr, rtl, none
        $direction = apply_filters( 'ipress_theme_direction', '' );     
        if ( empty( $direction ) ) { return; }

        // Get current user
        $uid = get_current_user_id();
    
        // Set direction data
        if ( $direction ) {
            update_user_meta( $uid, 'rtladminbar', $direction );
        } else {
            $direction = get_user_meta( $uid, 'rtladminbar', true );
            if ( false === $direction ) {
                $direction = isset( $wp_locale->text_direction ) ? $wp_locale->text_direction : 'ltr' ;
            }
        }   

        // Set styles setting
        $wp_locale->text_direction = $direction;
        if ( ! is_a( $wp_styles, 'WP_Styles' ) ) { $wp_styles = new WP_Styles(); }
        $wp_styles->text_direction = $direction;
    }

    /**
     * Add page slug to body class - Credit: Starkers Wordpress Theme
     *
     * @param   array
     * @return  array
     */
    public function body_class( $classes ) {

        global $post;

        // Set by page type restrictions
        if ( is_home() ) {
            $key = array_search( 'blog', $classes );
            if ( $key > -1 ) {
                unset($classes[$key]);
            }
        } elseif ( is_page() ) {
            $classes[] = sanitize_html_class( $post->post_name );
        } elseif ( is_singular() ) {
            $classes[] = sanitize_html_class( $post->post_name );
        }
    
        // Return attributes
        return $classes;
    }

    /**
     * Remove invalid rel attribute values in the category list - default true
     *
     * @param  string
     * @return string
     */
    public function remove_category_rel_from_category_list( $list ) {
        return ( !is_admin() ) ? str_replace( 'rel="category tag"', 'rel="tag"', $list ) : $list;
    }

    /**
     * Remove or amend the 'read more' link - defaults to remove
     *
     * @return string
     */
    public function read_more_link( $link ) { 
        $rml = apply_filters( 'ipress_read_more_link', '' ); 
        return ( $rml === false ) ? $link : $rml;
    }

    /**
     * Custom View Article link to Post
     *
     * @param string
     * @return $string
     */
    public function view_more( $more ) {

        global $post;

        // Get fiterable link & set markup
        $view_more = (bool)apply_filters( 'ipress_view_more', '__return_false' );
        $view_article = sprintf( '<a class="view-article" href="%s">%s</a>', get_permalink( $post->ID ), __( 'View Article', 'ipress' ) );

        // Return filterable markup
        return ( $view_more ) ? apply_filters( 'ipress_view_more_link', $view_article ) : $more;
    }

    /**
     * Video Embedding Wrapper
     *
     * @param   string
     * @return  string
     */
    public function embed_video_html( $html ) {
        return apply_filters( 'ipress_embed_video', sprintf( '<div class="video-container">%s</div>', esc_html( $html ) ), $html );
    }
}

// Instantiate Layout class
return new IPR_Layout;

//end
