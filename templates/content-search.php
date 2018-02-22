<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying results in search pages
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
	/**
	 * Functions hooked in to ipress_loop_post action.
	 *
	 * @hooked ipress_post_header       - 10
	 * @hooked ipress_post_meta         - 20
	 * @hooked ipress_post_excerpt      - 30
	 * @hooked ipress_post_footer       - 40
	 */
    do_action( 'ipress_loop_search' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
