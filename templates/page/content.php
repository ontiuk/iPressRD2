<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the page content
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php /** @hooked ipress_post_thumbnail - 10 */
do_action( 'ipress_page_content_before' ); ?>

<section class="entry-content">
<?php
	the_content();

    wp_link_pages( [
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
		'after'  => '</div>',
	] );
?>
</section><!-- .entry-content -->

<?php do_action( 'ipress_page_content_after' );
