<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Main page template
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

    <?php if ( have_posts() ) : the_post(); ?>

        <header class="page-header">
             <h1 class="page-title single-title"><?= get_the_title(); ?></h1>
        </header><!-- .page-header -->

        <?php get_template_part( 'templates/content', 'page' ); ?>
    
        <?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

    <?php else: ?>
    
        <?php get_template_part( 'templates/content', 'none' ); ?>

    <?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
