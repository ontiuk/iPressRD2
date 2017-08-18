<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying generic author archives
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : the_post();?>

            <section class="content-header">
                <h1 class="content-title author-archive"><?= sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' ); ?></h1>
            </section>

            <?php if ( get_the_author_meta( 'description' ) ) : ?>
            <section class="content-author">
                <?= wpautop( get_the_author_meta( 'description' ) ); ?>
            </section>    
            <?php endif; ?>
    
            <?php rewind_posts(); ?>

            <?php while ( have_posts() ) : the_post(); ?>
    
                <?php get_template_part( 'templates/content', get_post_format() ); ?>

            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>

        <?php else: ?>

            <section class="content-header">
                <h1 class="content-title author-archive"><?= sprintf( __( 'Author: %s' ), 'No author details found.'; ?></h1>
            </section>

            <?php get_template_part( 'templates/content', 'none' ); ?>

        <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
