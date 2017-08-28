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

/**
 * Post structured data
 */
function ipress_init_structured_data() {

    global $ipress;

    // Init data
    $json = [];

	// Post & page structured data
	if ( is_home() || is_category() || is_date() || is_search() || is_single() ) {

        $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
		$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

		$json['@type']            = 'BlogPosting';

		$json['mainEntityOfPage'] = array(
			'@type'                 => 'webpage',
			'@id'                   => get_the_permalink(),
		);

		$json['publisher']        = array(
			'@type'                 => 'organization',
			'name'                  => get_bloginfo( 'name' ),
			'logo'                  => array(
				'@type'               => 'ImageObject',
				'url'                 => $logo[0],
				'width'               => $logo[1],
				'height'              => $logo[2],
			),
		);

		$json['author']           = array(
			'@type'                 => 'person',
			'name'                  => get_the_author(),
		);

		if ( $image ) {
			$json['image']            = array(
				'@type'                 => 'ImageObject',
				'url'                   => $image[0],
				'width'                 => $image[1],
				'height'                => $image[2],
			);
		}

		$json['datePublished']    = get_post_time( 'c' );
		$json['dateModified']     = get_the_modified_date( 'c' );
		$json['name']             = get_the_title();
		$json['headline']         = $json['name'];
		$json['description']      = get_the_excerpt();

	} elseif ( is_page() ) {
		$json['@type']            = 'WebPage';
		$json['url']              = get_the_permalink();
		$json['name']             = get_the_title();
		$json['description']      = get_the_excerpt();
	}

    // Set if ok
	if ( !empty( $json ) ) {
		$ipress->main->set_structured_data( apply_filters( 'ipress_structured_data', $json ) );
	}
}

/**
 * Apply background image to header
 *
 * @uses  get_header_image()
 */
function ipress_header_style() {

    // Header image?
    $is_header_image = get_header_image();
    if ( ! $is_header_image ) { return; }

    // Filterable output
	$styles = apply_filters( 'ipress_header_style', [
		'background-image' => 'url(' . esc_url( $is_header_image ) . ')'
    ] );
    if ( !is_array( $styles ) || empty( $styles ) ) { return; }

    // Set header style
    ob_start();
    foreach ( $styles as $style => $value ) {
  		echo esc_attr( $style . ': ' . $value . '; ' );
    }
    $attr = ob_get_clean();
    echo 'style="' . $attr . '"';
}

//----------------------------------------------  
// Custom Template Funcions
//----------------------------------------------  

//end
