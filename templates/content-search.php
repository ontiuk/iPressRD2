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
?>
<?php do_action( 'ipress_loop_post_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php
	/**
	 * Functions hooked in to ipress_loop_post action.
	 *
	 * @hooked ipress_loop_header       - 10
	 * @hooked ipress_loop_meta         - 20
	 * @hooked ipress_loop_excerpt      - 30
	 * @hooked ipress_loop_footer       - 40
	 */
    do_action( 'ipress_loop_search' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_loop_post_after' );
