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

<?php
/**
 * Functions hooked in to ipress_page_content_before action.
 *
 * @hooked ipress_post_thumbnail - 10
 */
do_action( 'ipress_page_content_before' ); ?>

<section class="entry-content">
<?php
	the_content();

   	do_action( 'ipress_post_content_after' );

    wp_link_pages( [
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
		'after'  => '</div>',
	] );
?>
</section><!-- .entry-content -->
