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
?>
<?php do_action( 'ipress_article_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/CreativeWork">

	<?php
	/**
	 * Functions hooked into ipress_single_post add_action
	 *
	 * @hooked ipress_post_header       - 10
	 * @hooked ipress_post_meta         - 20
	 * @hooked ipress_post_content      - 30
	 * @hooked ipress_footer            - 40
	 */
	do_action( 'ipress_single' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_article_after' );
