<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying audio posts.
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
            ipress_posted_on();
            the_title( '<h1 class="entry-title">', '</h1>' );
        elseif ( is_front_page() && is_home() ) :
            ipress_posted_on();
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );        
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            if ( 'post' === get_post_type() ) :
                ipress_posted_on();
            endif;
        endif;
    ?>        
	</header><!-- .entry-header -->

<?php 
    // Get audio from the content if a playlist isn't present
    $content = apply_filters( 'the_content', get_the_content() ); 
    $audio = ( false === strpos( $content, 'wp-playlist-script' ) ) ? get_media_embedded_in_content( $content, array( 'audio' ) ) : false;
?> 

	<section class="entry-content">

    <?php if ( has_post_thumbnail() ) :
        $image_id = get_post_thumbnail_id( get_the_ID() );
        $image = wp_get_attachment_image_src( $image_id, 'thumbnail' ); 
        if ( $image ) : ?>
        <div class="entry-image">
            <a href="<?= esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><img src="<?= $image[0]; ?>" /></a>
        </div>
    <?php   
        endif; 
    endif; 
    ?>

    <?php
        // If not a single post, highlight the audio file. 
        if ( ! is_single() ) { 
	        if ( ! empty( $audio ) ) { 
                foreach ( $audio as $audio_html ) { ?>
        <div class="entry-audio"><?= $audio_html; ?></div><!-- .entry-audio -->
    <?php   
                } 
            } 
        }
    ?>
        
    <?php 
        if ( is_single() || empty( $audio ) {

    		the_content( sprintf(
	    		__( 'Continue reading <span class="screen-reader-text">%s</span><span class="meta-nav">&rarr;</span>', 'ipress' ),
		    	get_the_title()
		    ) );

			wp_link_pages( [
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
				'after'  => '</div>',
    			'link_before' => '<span class="page-number">',
	    		'link_after'  => '</span>',
			] );
        } 
    ?>
	</section><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ipress_entry_footer(); ?>
	</footer><!-- .entry-footer -->

    <?php ipress_init_structured_data(); ?>

</article><!-- #post-## -->
