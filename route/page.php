<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Main page template
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php global $post; ?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <section class="content-header">
                 <h1 class="content-title page-archive"><?= get_the_title( $post->ID ); ?></h1>
            </section>

        <?php if ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'templates/content', 'page' ); ?>
    
            <?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

        <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
