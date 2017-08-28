<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying search content
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     iPress\Templates
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

<?php global $wp_query; ?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

        <section class="page-header">
            <h1 class="page-title search-title"><?= sprintf( __( 'Search: %s Results for ', 'ipress' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
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
