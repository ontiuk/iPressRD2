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
<?php /** @hooked ipress_loop_image - 10 */
do_action( 'ipress_loop_content_before' ); ?>

<section class="entry-summary">
	<?php the_excerpt(); ?>
</section><!-- .entry-summary -->

<?php do_action( 'ipress_loop_content_after' );
