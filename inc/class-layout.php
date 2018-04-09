<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress Layout features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

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
		add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] ); 

		// Wrapper for video embedding - generic & jetpack
		add_filter( 'embed_oembed_html', [ $this, 'embed_video_html' ], 10, 3 );
		add_filter( 'video_embed_html', [ $this, 'embed_video_html' ] ); 
	}

	//---------------------------------------------
	//	Layout Actions & Filters
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
	 * @param	array
	 * @return	array
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

		// Add class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Add class if we're viewing the Customizer
		if ( is_customize_preview() ) {
			$classes[] = 'is-customizer';
		}
	
		// Widgetless main sidebar? adjust to full-width layout
		if ( ! is_active_sidebar( 'primary' ) ) {
			$classes[] = 'full-width-content';
		}

		// Add class on static front page
		if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
			$classes[] = 'is-front-page';
		}

		// Add a class if there is a custom header
		if ( has_header_image() ) {
			$classes[] = 'has-header-image';
		}

		// Return attributes
		return apply_filters( 'ipress_body_class', $classes );
	}

	/**
	 * Remove or amend the 'read more' link - defaults to remove
	 *
	 * @return string
	 */
	public function read_more_link( $link ) { 
		$rml = apply_filters( 'ipress_read_more_link', false ); 
		return ( $rml === false || empty( $rml ) ) ? $link : $rml;
	}

	/**
	 * Custom View Article link to Post
	 *
	 * @param string
	 * @return $string
	 */
	public function excerpt_more( $more ) {

		if ( is_admin() ) { return $more; }

		// Get fiterable link & set markup
		$view_more = (bool)apply_filters( 'ipress_view_more', false );
		$view_article = sprintf( '<a class="view-article" href="%s">%s</a>', 
			esc_url( get_permalink( get_the_ID() ) ), 
			__( 'View Article', 'ipress' ) );

		// Return filterable markup
		return ( $view_more ) ? apply_filters( 'ipress_view_more_link', $view_article ) : $more;
	}

	/**
	 * Video Embedding Wrapper
	 *
	 * @param	string
	 * @return	string
	 */
	public function embed_video_html( $html ) {
		return apply_filters( 'ipress_embed_video', sprintf( '<div class="video-container">%s</div>', esc_html( $html ) ), $html );
	}
}

// Instantiate Layout class
return new IPR_Layout;

//end
