<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying audio posts
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
	 * Functions hooked in to ipress_loop_post_audio action
	 *
	 * @hooked ipress_loop_sticky       - 5
	 * @hooked ipress_loop_header       - 10
	 * @hooked ipress_loop_audio   		- 20
	 * @hooked ipress_loop_footer 		- 30
	 */
	do_action( 'ipress_loop_post_audio' );
?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_loop_post_after' );
