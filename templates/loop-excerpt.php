<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop excerpt
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php /** @hooked ipress_post_thumbnail - 10 */
do_action( 'ipress_loop_excerpt_before' ); ?>

<section class="entry-summary">
	<?php the_excerpt(); ?>
</section><!-- .entry-summary -->
