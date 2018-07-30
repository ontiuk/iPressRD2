<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

/**
 * Theme
 * Pagination
 * Miscellaneous
 * Images & Media
 * Menu & Navigation
 * WooCommerce
 */

//----------------------------------------------
//	Theme
//	
//	- ipress_is_home_page
//	- ipress_is_index
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
 * @param	string	$page
 * @return	boolean
 */
function ipress_is_index( $page ) {
	return ( basename( $page ) === 'index.php' );
}

//----------------------------------------------
// Pagination 
// 
//  - ipress_prev_next_posts_nav
//	- ipress_prev_next_post_nav
//	- ipress_pagination
//	- ipress_numeric_posts_nav
//----------------------------------------------

/**
 * Generate pagination in Previous / Next Posts format
 *
 * @param 	boolean $echo default true
 * @return 	string
 */
function ipress_prev_next_posts_nav( $echo = true ) {

	global $wp_query; 

    if ( ! $wp_query->max_num_pages > 1 ) { return; } 

	// Previous Next Context
	$older = apply_filters( 'ipress_next_nav_link', '&larr; Older' );
	$newer = apply_filters( 'ipress_prev_nav_link', 'Newer &rarr;' );

	// Get nav links
	ob_start()
?>
	<section id="pagination" class="paginate posts-paginate">';
		<nav class="pagination" role="navigation"> 
			<div class="nav-next nav-left"><?php echo get_next_posts_link( $older ); ?></div> 
			<div class="nav-previous nav-right"><?php echo get_previous_posts_link( $newer ); ?></div> 
		</nav> 
	</section>
<?php	
	$output = ob_get_clean();

	// Send output
	if ( $echo ) { echo $output; } else { return $output; }
}

/**
 * Display links to previous and next post from a single post
 *
 * @param	boolean $echo
 * @return	string
 */
function ipress_prev_next_post_nav() {

	// Single post only
	if ( ! is_singular() ) { return; }

	// Previous Next Context
	$older = apply_filters( 'ipress_single_next_nav_link', '&larr; Older' );
	$newer = apply_filters( 'ipress_single_prev_nav_link', 'Newer &rarr;' );

	// Get nav links
	ob_start()
?>
	<section id="pagination" class="paginate single-paginate">';
		<nav class="pagination" role="navigation"> 
			<div class="nav-next nav-left"><?php echo get_next_post_link( $next ); ?></div> 
			<div class="nav-previous nav-right"><?php echo get_previous_post_link( $prev ); ?></div> 
		</nav> 
	</section>
<?php	
	$output = ob_get_clean();

	// Send output
	if ( $echo ) { echo $output; } else { return $output; }
}

/**
 * Pagination for archives 
 *
 * @global	$wp_query	WP_Query
 * @return	string
 */
function ipress_pagination( $echo = true ) { 
	
	global $wp_query; 
	$big = 999999999; 

	$total_pages = $wp_query->max_num_pages;
	if ( $total_pages <= 1 ) { return; }

	// Get pagination links
	$pages = paginate_links( [
			'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'	=> '?paged=%#%',
			'current'	=> max( 1, get_query_var('paged') ),
			'total'		=> $wp_query->max_num_pages,
			'type'		=> 'array',
			'prev_text' => __( 'Prev', 'ipress' ),
			'next_text' => __( 'Next', 'ipress' )
	] );

	// Get paged value
	$paged = ( get_query_var('paged') == 0 ) ? 1 : absint( get_query_var('paged') );

	// Generate list if set
	if ( is_array( $pages ) && $paged ) {
		$list = '<nav class="pagination">';
		foreach ( $pages as $page ) { $list .= sprintf( '<div class="nav-links>%d</div>', $page ); }
		$list .= '</nav>';
	} else { $list = ''; }

	// Send output
	if ( $echo ) { echo $list; } else { return $list; }

} 

/**
 * Archive pagination in page numbers format
 *
 * - Links ordered as:
 *	- previous page arrow
 *	- first page
 *	- up to two pages before current page
 *	- current page
 *	- up to two pages after the current page
 *	- last page
 *	- next page arrow
 *
 * @param	boolean		$echo
 * @return	string
 * @global	WP_Query	$wp_query Query object
 */
function ipress_numeric_posts_nav( $echo = true ) {

	global $wp_query;

	// archives only
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
	$output = '<section id="pagination" class="paginate loop-paginate">';

	// Start list
	$output .= '<nav>';

	// Previous post link
	if ( get_previous_posts_link() ) {
		$output .= sprintf( '<div class="pagination-previous">%s</div>', get_previous_posts_link( '&#x000AB; ' . __( 'Previous Page', 'ipress' ) ) );
	}

	// Link to first page, plus ellipses if necessary
	if ( ! in_array( 1, $links ) ) {

		$class = ( 1 == $paged )? ' class="active"' : '';
		$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( 1 ) ), ' ' . '1' );

		if ( ! in_array( 2, $links ) ) {
			$output .= '<div class="pagination-omission">&#x02026;</div>';
		}
	}

	// Link to current page, plus 2 pages in either direction if necessary
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = ( $paged == $link ) ? ' class="active"  aria-label="' . __( 'Current page', 'ipress' ) . '"' : '';
		$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $link ) ), ' ' . $link );
	}

	// Link to last page, plus ellipses if necessary
	if ( ! in_array( $max, $links ) ) {

		if ( ! in_array( $max - 1, $links ) ) {
			$output .= sprintf( '<div class="pagination-omission">%s</div>', '&#x02026;' );
		}

		$class = $paged == $max ? ' class="active"' : '';
		$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $max ) ), ' ' . $max );
	}

	// Next post link
	if ( get_next_posts_link() ) {
		$output .= sprintf( '<div class="pagination-next">%s</div>', get_next_posts_link( __( 'Next Page', 'ipress' ) . ' &#x000BB;' ) );
	}

	// Generate output
	$output .= '</nav></section>';

	// Send output
	if ( $echo ) { echo $output; } else { return $output; }
}

//---------------------------------------------
//	Miscellaneous
//	
//	- ipress_canonical_url
//	- ipress_paged_post_url
//	- ipress_get_permalink_by_page
//	- ipress_excerpt
//	- ipress_content
//	- ipress_truncate
//---------------------------------------------

/**
 * Calculate and return the canonical URL
 * 
 * @global	$wp_query	WP_Query
 * @return	string		The canonical URL, if one exists
 */
function ipress_canonical_url() {

	global $wp_query;
	$canonical = '';

	// Pagination values
	$paged = absint( get_query_var( 'paged' ) );	
	$page  = absint( get_query_var( 'page' ) );

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
		$canonical = ( $paged ) ? get_pagenum_link( $paged ) : get_term_link( (int)$id, $taxonomy );
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
 * Create the Custom Excerpt 
 *
 * @param	string $length_callback
 * @param	string $more_callback
 * @param	boolean $wrap
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
 * @param	string $text 
 * @param	integer $max_chara
 * @return	string 
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
 * @param	array|string $args 
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
 * @param	boolean $additional
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
 */
function ipress_post_thumbnail_url( $size = 'full' ) { 
	$thumb_id = (int) get_post_thumbnail_id(); 
	return ( $thumb_id > 0 ) ? wp_get_attachment_image_src( $thumb_id, $size, true )[0] : ''; 
} 

/**
 * Get site title or logo
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
 * @param	string
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

//----------------------------------------------
//	Menu & Navigation
// 
// - ipress_has_nav_menu
// - ipress_has_nav_location_menu
// - ipress_has_menu
// - ipress_get_nav_menu_items
//----------------------------------------------

/**
 * Determine if a theme supports a particular menu location 
 * - Case sensitive, so camel-case location
 * - Alternative to has_nav_menu
 *
 * @param  string $location
 * @return boolean 
 */
function ipress_has_nav_menu( $location ) {

	// Set the menu name
	if ( empty( $location ) ) { return false; }

	// Retrieve registered menu locations
	$locations = array_keys( get_nav_menu_locations() );

	// Test location correctly registered
	return in_array( $location, $locations );
}

/**
 * Determine if a theme supports a particular menu location & menu combination
 * - Case sensitive, so camel-case location & menu
 *
 * @param	string $location
 * @param	string $menu 
 * @param	string $route slug or name default name
 * @return boolean 
 */
function ipress_has_nav_location_menu( $location, $menu, $route='name' ) {

	// Set the menu name
	if ( empty( $location ) || empty( $menu ) ) { return false; }

	// Retrieve registered menu locations
	$locations = get_nav_menu_locations();

	// Test location correctly registered
	if ( !array_key_exists( $location, $locations ) ) { return false; }

	// Get location menu 
	$term = get_term( (int)$locations[$location], 'nav_menu' );

	// Test menu
	return ( 'slug' == $route ) ? ( $term->slug === $menu ) : ( $term->name === $menu ); 
}

/**
 * Determine if a theme has a particular menu registered
 * - Case sensitive, so camel-case menu
 *
 * @param  string $menu
 * @return boolean 
 */
function ipress_has_menu( $menu ) {

	// Set the menu name
	if ( empty( $menu ) ) { return false; }

	// Retrieve registered menu locations
	$menus = wp_get_nav_menus();

	// None registered
	if ( empty( $menus ) ) { return false; }

	// Registered
	foreach ( $menus as $m ) {
		if ( $menu === $m->name ) { return true; }
	}

	// Default
	return false;
}

/**
 * Retrieve menu items for a menu by location
 *
 * @param  string $menu Name of the menu location
 * @return array
 */
function ipress_get_nav_menu_items( $menu ) {

	// Set the menu name
	if ( empty( $menu ) ) { return false; }

	// Retrieve registered menu locations
	$locations = get_nav_menu_locations();

	// Test menu is correctly registered
	if ( !isset( $locations[ $menu ] ) ) { return false; }

	// Retrieve menu set against location
	$menu = wp_get_nav_menu_object( $locations[ $menu ] );
	if ( false === $menu ) { return false; }

	// Retrieve menu items from menu
	$menu_items = wp_get_nav_menu_items( $menu->term_id );

	// No menu items?
	return ( empty( $menu_items ) ) ? false : $menu_items;
}

//----------------------------------------------
//	WooCommerce Functions
//	
//	- ipress_woocommerce_active
//	- ipress_is_product_archive
//----------------------------------------------

/**
 * Query WooCommerce activation
 *
 * @return boolean true if WooCommerce plugin active
 */
function ipress_woocommerce_active() {
	return ( class_exists( 'WooCommerce' ) ) ? true : false;
}

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
function ipress_is_product_archive() {

	// No woocommerce
	if ( ! ipress_woocommerce_active() ) { return false; }

	// Product archive
	return ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ? true : false;
}

//end
