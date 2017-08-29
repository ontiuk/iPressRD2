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

    <section class="entry-summary">

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

    <?php the_excerpt(); ?>

    </section><!-- .entry-summary --> 

 <?php ipress_init_structured_data(); ?>

</article><!-- #post-## -->
