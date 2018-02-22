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
?>

<?php $tax = get_taxonomy( get_queried_object()->taxonomy ); ?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title taxonomy-title"><?= sprintf( __( '%1$s: %2$s', 'ipress' ), $tax->labels->singular_name, single_term_title( '', false ) ); ?></h1>
            <?php the_archive_description( '<div class="archive-description taxonomy-archive">', '</div>' ); ?>
        </header><!-- .page-header -->
   
        <?php get_template_part( 'templates/loop' ); ?>

    <?php else: ?>

        <?php get_template_part( 'templates/content', 'none' ); ?>

    <?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php do_action( 'ipress_sidebar' ); ?>
<?php get_footer(); ?>
