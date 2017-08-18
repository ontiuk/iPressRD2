<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying search content
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php global $wp_query; ?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <section class="content-header">
                <h1 class="content-title search-archive"><?= sprintf( __( 'Search: %s Results for ', 'ipress' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
            </section>

            <?php while ( have_posts() ) : the_post(); ?>
    
                <?php get_template_part( 'templates/content', 'search' ); ?>

            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>

        <?php else: ?>
    
            <?php get_template_part( 'templates/content', 'none' ); ?>

        <?php endif; ?>
        
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
