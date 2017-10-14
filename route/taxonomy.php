<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying taxonomy archives
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

<?php $tax = get_taxonomy( get_queried_object()->taxonomy ); ?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

        <section class="page-header">
            <h1 class="page-title taxonomy-title"><?= sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) ); ?></h1>
            <?php the_archive_description( '<div class="archive-description taxonomy-archive">', '</div>' ); ?>
        </section>
   
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