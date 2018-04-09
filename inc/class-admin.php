<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme admin UI functionality
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
 * Set up admin functionality
 */ 
final class IPR_Admin {

	/**
	 * Class constructor
	 * - set up hooks
	 */
	public function __construct() {

		// Add to dashboard
		add_filter( 'dashboard_glance_items', [ $this, 'dashboard_post_type_count' ], 10, 1 );
	}

	//----------------------------------------------
	//	Admin UI Functions
	//----------------------------------------------

	//----------------------------------------------
	//	Dashboard
	//----------------------------------------------

	/**
	 * Add post-type count to the "At a glance" Dashboard box
	 *
	 * return array
	 */
	public function dashboard_post_type_count() {

		// Set post types
		$post_types = apply_filters( 'ipress_dashboard_post_types', [] );

		// Iterate through post types
		$items = [];
		foreach( $post_types as $post_type ) {
		
			// Valid post types only
			if ( ! post_type_exists( $post_type ) ) { continue; }

			// Post type stats
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts ) { 
				$published = intval( $num_posts->publish );
				$post_object = get_post_type_object( $post_type );
				$text = _n( '%s ' . $post_object->labels->singular_name, '%s ' . $post_object->labels->name, $published, 'ipress' );
				$text = sprintf( $text, number_format_i18n( $published ) );

				$items[] = ( current_user_can( $post_object->cap->edit_posts ) ) ? sprintf( '%2$s', $post_type, '<a href="' . admin_url() . 'edit.php?post_type=' . $post_type . '">' . $text . '</a>' ) . PHP_EOL :																		   sprintf( '<span class="%1$s-count">%2$s</span>', $post_type, $text ) . PHP_EOL;
			}	
		}

		// Return items
		return $items;
	}
}

// Instantiate Admin class
return new IPR_Admin;

//end
