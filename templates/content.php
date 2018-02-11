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
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        elseif ( is_front_page() && is_home() ) :
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );        
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
    ?>        
	</header><!-- .entry-header -->

	<?php if ( 'post' == get_post_type() ) : ?>
	<section class="entry-meta">
        <?php
            ipress_posted_on();
            ipress_posted_by();
        ?>
	</section>
	<?php endif; // 'post' ?>

    <?php ipress_post_thumbnail(); ?>

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

    <footer class="entry-footer"> 
        <?php ipress_entry_footer(); ?> 
    </footer><!-- .entry-footer --> 

    <?php ipress_init_structured_data(); ?>

</article><!-- #post-<?php the_ID(); ?> -->
