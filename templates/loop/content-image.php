<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the post loop content
 * 
 * @package     iPress\Templates
 * @see         http://codex.wordpress.org/The_Loop
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<section class="entry-content">
<?php
    /**
     * Functions hooked in to ipress_post_content_before action.
     *
     * @hooked ipress_post_thumbnail - 10
     */
    do_action( 'ipress_post_content_before' );

    // Only show content if is a single post, or if there's no featured image. 
    if ( is_single() || '' === get_the_post_thumbnail() ) { 
        the_content( sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ipress' ), get_the_title() ) ); 
    }

    do_action( 'ipress_post_content_after' );

    wp_link_pages( [
	    'before'        => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
	    'after'         => '</div>',
   	    'link_before'   => '<span class="page-number">',
   	    'link_after'    => '</span>',
    ] );
?>
</section><!-- .entry-content -->
