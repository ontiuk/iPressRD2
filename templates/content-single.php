<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying a single post.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php
	do_action( 'ipress_single_post_top' );

	/**
	 * Functions hooked into ipress_single_post add_action
	 *
	 * @hooked ipress_post_header       - 10
	 * @hooked ipress_post_meta         - 20
	 * @hooked ipress_post_content      - 30
	 * @hooked ipress_footer            - 40
	 */
	do_action( 'ipress_single_post' );

	/**
	 * Functions hooked in to ipress_single_post_bottom action
	 *
	 * @hooked ipress_post_nav         - 10
	 * @hooked ipress_display_comments - 20
	 */
	do_action( 'ipress_single_post_bottom' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
