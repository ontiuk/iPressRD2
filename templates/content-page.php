<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying page content in page.php.
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
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <div class="entry-meta">
            <time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
                Posted On: <?php the_date(); ?> <?php the_time(); ?>
            </time>
        </div>
    </header><!-- .entry-header -->

    <?php 
    if ( has_post_thumbnail() ) :
        $image_id = get_post_thumbnail_id( get_the_ID() );
        $image = wp_get_attachment_image_src( $image_id, 'thumbnail' ); 
        if ( $image ) :
    ?>
    <div class="entry-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?= $image[0]; ?>" /></a>
    </div>
    <?php   
        endif; 
    endif;
    ?>

	<section class="entry-content">
		<?php
			the_content();
			wp_link_pages( [
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
				'after'  => '</div>',
			] );
		?>
	</section><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						esc_html__( 'Edit %s', 'ipress' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

    <?php ipress_init_structured_data(); ?>

</article><!-- #post-## -->
