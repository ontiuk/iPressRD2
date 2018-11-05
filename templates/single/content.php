<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop content
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php /** @hooked ipress_post_thumbnail - 10 */
do_action( 'ipress_post_content_before' ); ?>

<section class="entry-content">

<?php
    the_content( sprintf( 
        wp_kses( 
            /* translators: %s: Name of current post. Only visible to screen readers */ 
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ipress' ), 
            [ 
                'span' => [ 
                    'class' => [], 
                ], 
            ] 
        ), 
        get_the_title() 
    ) ); 

	wp_link_pages( [
		'before'        => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
		'after'         => '</div>',
   		'link_before'   => '<span class="page-number">',
   		'link_after'    => '</span>',
	] );
?>

</section><!-- .entry-content -->

<?php do_action( 'ipress_post_content_after' );
