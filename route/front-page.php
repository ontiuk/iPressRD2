<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Post list template when static file set as home page
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title home-title"><?php __( 'Our Latest Posts', 'ipress' ); ?></h1>
            <?php the_archive_description( '<div class="archive-description home-archive">', '</div>' ); ?>
        </header><!-- .page-header -->

        <?php while ( have_posts() ) : the_post(); ?>
    
            <?php get_template_part( 'templates/content' ); ?>

        <?php endwhile; ?>

        <?php the_posts_navigation(); ?>

    <?php else: ?>
    
        <?php get_template_part( 'templates/content', 'none' ); ?>

    <?php endif; ?>
        
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>