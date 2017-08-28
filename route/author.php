<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying generic author archives
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

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

     <?php if ( have_posts() ) : the_post();?>

        <section class="page-header">
            <h1 class="page-title author-title"><?= sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' ); ?></h1>
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

        <?php get_template_part( 'templates/content', 'none' ); ?>

    <?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
