<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying posts.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

    <?php if ( is_sticky() && is_home() ) : ?>
        <div class="sticky-post"></div>
    <?php endif; ?>

	<header class="entry-header">
	<?php
        if ( is_single() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
            ipress_posted_on();
        elseif ( is_front_page() && is_home() ) :
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );        
            ipress_posted_on();
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            if ( 'post' === get_post_type() ) :
                ipress_posted_on();
            endif;
        endif;
    ?>        
	</header><!-- .entry-header -->

	<section class="entry-content">

    <?php if ( has_post_thumbnail() ) :
        $image_id = get_post_thumbnail_id( get_the_ID() );
        $image = wp_get_attachment_image_src( $image_id, 'full' ); 
        if ( $image ) : ?>
        <div class="entry-image">
            <a href="<?= esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><img src="<?= $image[0]; ?>" /></a>
        </div>
    <?php   
        endif; 
    endif; 
    ?>

    <?php
        // Only show content if is a single post, or if there's no featured image. 
	    if ( is_single() || '' === get_the_post_thumbnail() ) { 
            the_content( sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ipress' ), get_the_title() ) ); 
			wp_link_pages( [
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
				'after'  => '</div>',
    			'link_before' => '<span class="page-number">',
	    		'link_after'  => '</span>',
            ] );
        }
	?>
	</section><!-- .entry-content -->

    <?php ipress_init_structured_data(); ?>

</article><!-- #post-## -->
