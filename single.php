<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Display single post content
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

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-main" role="main">

    <?php do_action( 'ipress_single_before' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>

        <header class="page-header">
            <?php the_title( '<h1 class="page-title single-title">', '</h1>'); ?>
        </header><!-- .page-header -->

        <?php get_template_part( 'content', 'single' ); ?>

    <?php else: ?>
    
        <?php get_template_part( 'templates/content', 'none' ); ?>

    <?php endif; ?>

    <?php do_action( 'ipress_single_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

</div><!-- #primary -->

<?php do_action( 'ipress_sidebar' ); ?>
<?php get_footer(); ?>