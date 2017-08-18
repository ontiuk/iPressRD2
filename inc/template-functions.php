<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme standalone functions
 * 
 * @package     iPress\Template-Functions
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
// Theme Template Support
//----------------------------------------------  

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ipress_posted_on() {
    
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'ipress' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'ipress' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo sprintf( '<span class="posted-on">%s</span><span class="byline">%s</span>', $posted_on, $byline );
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ipress_entry_footer() {

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'ipress' ) );
		if ( $categories_list && ipress_has_categories() ) {
			echo sprintf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ipress' ) . '</span>', $categories_list ); 
		}

		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'ipress' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ipress' ) . '</span>', $tags_list ); 
		}
	}

    // Comments open?
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo sprintf( '%s %s %s', '<span class="comments-link">', comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ipress' ), [ 'span' => [ 'class' => [] ] ] ), get_the_title() ) ), '</span>' );
	}

    // Construct link
	edit_post_link(
		sprintf(
			esc_html__( 'Edit %s', 'ipress' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

//----------------------------------------------  
// Custom Template Funcions
//----------------------------------------------  

//end
