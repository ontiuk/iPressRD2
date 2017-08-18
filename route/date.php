<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying generic date archives
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <section class="content-header">
                <?php the_archive_title( '<h1 class="content-title date-archive">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
            </section>
        
        <?php if ( have_posts() ) : ?>
        
            <?php while ( have_posts() ) : the_post(); ?>
    
                <?php get_template_part( 'templates/content', get_post_format() ); ?>

            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>

        <?php else: ?>
    
            <?php get_template_part( 'templates/content', 'none' ); ?>

        <?php endif; ?>
        
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
