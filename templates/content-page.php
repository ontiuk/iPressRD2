<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying page content in page.php.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php
	/**
	 * Functions hooked in to ipress_page add_action
	 *
	 * @hooked ipress_page_header       - 10
	 * @hooked ipress_page_content      - 20
	 * @hooked ipress_page_footer       - 30
	 */
	do_action( 'ipress_page' );	?>

</article><!-- #post-<?php the_ID(); ?> -->
