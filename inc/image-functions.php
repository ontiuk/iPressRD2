<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Image and Media functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Images & Media
//
//	- ipress_post_image_id
//	- ipress_post_image
//	- ipress_additional_image_sizes
//	- ipress_image_sizes
//	- ipress_get_attachment_meta
//	- ipress_get_post_attachement
//	- ipress_post_thumbnail_url
//	- ipress_site_title_or_logo
//	- ipress_hex2rgb
//----------------------------------------------

/**
 * Pull an attachment ID from a post, if one exists
 *
 * @param  integer $index 
 * @param  integer $post_id 
 * @return integer|boolean 
 */
function ipress_post_image_id( $index = 0, $post_id = null ) {

	// Get image_ids for current or passed post
	$image_ids = array_keys(
		get_children(
			[
				'post_parent'	 => $post_id ? $post_id : get_the_ID(),
				'post_type'		 => 'attachment',
				'post_mime_type' => 'image',
				'orderby'		 => 'menu_order',
				'order'			 => 'ASC',
			]
		)
	);

	// Set or not?
	return ( isset( $image_ids[ $index ] ) ) ? $image_ids[ $index ] : false;
}

/**
 * Return an image pulled from the media gallery
 *
 * Supported $args keys are:
 *
 *	- format   - string, default is 'html'
 *	- size	   - string, default is 'full'
 *	- num	   - integer, default is 0
 *	- attr	   - string, default is ''
 *	- fallback - mixed, default is 'first-attached'
 *
 * Applies ipress_post_image_args, ipress_pre_post_image and ipress_get_image filters.
 *
 * @uses	ipress_post_image_id() 
 * @param	array|string 	$args 
 * @return	string|boolean 
 */
function ipress_post_image( $args = [] ) {

	$defaults = [
		'post_id'  => null,
		'format'   => 'html',
		'size'	   => 'full',
		'num'	   => 0,
		'attr'	   => '',
		'fallback' => 'first-attached',
		'context'  => '',
		'echo'	   => false
	];

	// Filter default parameters used by ipress_post_image()
	$defaults = apply_filters( 'ipress_post_image_args', $defaults, $args );
	$args = wp_parse_args( $args, $defaults );

	// Allow child theme to short-circuit this function
	$pre = apply_filters( 'ipress_pre_post_image', false, $args, get_post() );
	if ( false !== $pre ) { return $pre; }

	// If post thumbnail exists, use its id
	if ( has_post_thumbnail( $args['post_id'] ) && ( $args['num'] === 0 ) ) {
		$id = get_post_thumbnail_id( $args['post_id'] );
	}

	// Else if the first (default) image attachment is the fallback, use its id
	elseif ( 'first-attached' === $args['fallback'] ) {
		$id = ipress_post_image_id( $args['num'], $args['post_id'] );
	}

	// Else if fallback id is supplied, use it
	elseif ( is_int( $args['fallback'] ) ) {
		$id = $args['fallback'];
	}

	// If we have an id, get the html and url
	if ( isset( $id ) && is_int( $id ) ) {
		$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
		list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
	}

	// Else if fallback html and url exist, use them
	elseif ( is_array( $args['fallback'] ) ) {
		$id   = 0;
		$html = $args['fallback']['html'];
		$url  = $args['fallback']['url'];
	}

	// Else, return false (no image)
	else { return false; }

	// Source path, relative to the root
	$src = str_replace( home_url(), '', $url );

	// Determine output
	if ( 'html' === strtolower( $args['format'] ) ) {
		$output = $html;
	} elseif ( 'url' === strtolower( $args['format'] ) ) {
		$output = $url;
	} else {
		$output = $src;
	}

	// Return false if $url is blank
	if ( empty( $url ) ) { $output = false; }

	// Return data, filtered
	$output = apply_filters( 'ipress_post_image', $output, $args, $id, $html, $url, $src );

	// Output or return
	if ( $echo ) {
		if ( $image ) {
			echo $image;
		} else {
			return false;
		}
	} else {  
		return $output;
	}  
}

/**
 * Returns additionally registered image sizes via add_image_size: width, height and crop sub-keys
 *
 * @global array $_wp_additional_image_sizes 
 * @return array 
 */
function ipress_additional_image_sizes() {
	global $_wp_additional_image_sizes;
	return ( $_wp_additional_image_sizes ) ? $_wp_additional_image_sizes : [];
}

/**
 * Return all registered image sizes arrays, including the standard sizes
 * - two-dimensional array of standard and additionally registered image sizes, with width, height and crop sub-keys
 *
 * @uses	ipress_additional_image_sizes()
 * @param	boolean 	$additional
 * @return	array 
 */
function ipress_image_sizes( $additional=true ) {

	$builtin_sizes = [
		'large'		=> [
			'width'  => get_option( 'large_size_w' ),
			'height' => get_option( 'large_size_h' ),
		],
		'medium'	=> [
			'width'  => get_option( 'medium_size_w' ),
			'height' => get_option( 'medium_size_h' ),
		],
		'thumbnail' => [
			'width'  => get_option( 'thumbnail_size_w' ),
			'height' => get_option( 'thumbnail_size_h' ),
			'crop'	 => get_option( 'thumbnail_crop' ),
		],
	];

	$additional_sizes = ( $additional ) ? ipress_additional_image_sizes() : [];
	return array_merge( $builtin_sizes, $additional_sizes );
}

/**
 * Get the image meta data
 *
 * @param	integer		$attachment_id
 * @param	string		$size
 * @return	array
 */
function ipress_get_attachment_meta( $attachment_id, $size = '' ){

	// Set up data
	$data = [
		'alt'			=> '',
		'caption'		=> '',
		'description'	=> '',
		'href'			=> '',
		'src'			=> '',
		'title'			=> ''
	];

	// Get attachment data
	$attachment = get_post( $attachment_id );

	// Not valid
	if ( empty( $attachment ) ) { return $data; }
	
	// Get image data
	$att_data_thumb = ( empty( $size ) ) ? wp_get_attachment_image_src( $attachment_id ) :
										   wp_get_attachment_image_src( $attachment_id, $size );
	if ( ! $att_data_thumb ) { return $data; }
	
	// Construct data
	$data['alt']			= get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
	$data['caption']		= $attachment->post_excerpt;
	$data['description']	= $attachment->post_content;
	$data['href']			= $attachment->guid;
	$data['src']			= $att_data_thumb[0];
	$data['title']			= $attachment->post_title;

	// Return image data	
	return $data;
}

/**
 * get post attachements by attachment mime type 
 *
 * @param	integer		$post_id
 * @param	string		$att_type
 * @return	array
 */
function ipress_get_post_attachment( $post_id, $att_type ){

	// Get attachment data
	$attachments = get_posts( [
		'post_type'			=> 'attachment',
		'post_mime_type'	=> $att_type,
		'numberposts'		=> -1,
		'post_parent'		=> $post_id
	] );

	// Return attachments	 
	return $attachments;
}

/**
 * Retrieve the post thumbnail url if set
 *
 * @param	string	$size
 * @return	array
 */
function ipress_post_thumbnail_url( $size = 'full' ) { 
	$thumb_id = (int) get_post_thumbnail_id(); 
	return ( $thumb_id > 0 ) ? wp_get_attachment_image_src( $thumb_id, $size, true )[0] : ''; 
} 

/**
 * Get site title or logo
 *
 * @param	boolean	$echo
 * @return	array|void
 */
function ipress_site_title_or_logo( $echo = true ) {
	if ( has_custom_logo() ) {
		$html = get_custom_logo();
	} else if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
		$logo	 = site_logo()->logo;
		$logo_id = get_theme_mod( 'custom_logo' ); 
		$logo_id = $logo_id ? $logo_id : $logo['id']; 
		$size	 = site_logo()->theme_size();
		$html	 = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
			esc_url( home_url( '/' ) ),
			wp_get_attachment_image(
				$logo_id,
				$size,
				false,
				[
					'class'		=> 'site-logo attachment-' . $size,
					'data-size' => $size,
					'itemprop'	=> 'logo'
				 ]
			)
		);

		$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
	} else {
		$tag = ( ipress_is_home_page() ) ? 'h1' : 'p';
		$html = sprintf( '<%s class="site-title"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url('/') ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) {
			$html .= sprintf( '<p class="site-description">%s</p>', esc_html( $description ) );
		} 
	}

	if ( ! $echo ) { return $html; }
	echo $html;
}

/**
 * convert color form hex to rgb 
 *
 * @param	string	$hex
 * @return	string
 */
function ipress_hex2rgb( $hex ) {

	// Convert hex...		 
	$hex = str_replace( '#', '', $hex );

	// ...to rgb
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Return rgb value
	return $r . ', ' . $g . ', ' . $b; 
}

//end
