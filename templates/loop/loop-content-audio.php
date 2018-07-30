<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the audio post content
 * 
 * @package     iPress\Templates
 * @see         http://codex.wordpress.org/The_Loop
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
    // Get audio from the content if a playlist isn't present
    $content = apply_filters( 'the_content', get_the_content() ); 
    $audio = ( false === strpos( $content, 'wp-playlist-script' ) ) ? get_media_embedded_in_content( $content, [ 'audio' ] ) : false;
?> 

<section class="entry-content">
<?php

    /**
     * Functions hooked in to ipress_post_content_before action.
     *
     * @hooked ipress_post_thumbnail - 10
     */
    do_action( 'ipress_post_content_before' );

     // If not a single post, highlight the audio file. 
     if ( ! is_single() ) : 
        if ( ! empty( $audio ) ) : 
            foreach ( $audio as $audio_html ) : 
                echo sprintf( '<div class="entry-audio">%s</div><!-- .entry-audio -->', $audio_html );
            endforeach; 
        endif;
    endif;
 
    if ( is_single() || empty( $audio ) :
    	the_content( sprintf(
	   		__( 'Continue reading <span class="screen-reader-text">%s</span><span class="meta-nav">&rarr;</span>', 'ipress' ),
	    	get_the_title()
	    ) );
    endif; 

    do_action( 'ipress_post_content_after' );

    wp_link_pages( [
	    'before'        => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
	    'after'         => '</div>',
   	    'link_before'   => '<span class="page-number">',
   	    'link_after'    => '</span>',
    ] );
?>
</section><!-- .entry-content -->
