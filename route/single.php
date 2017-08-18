<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Display single post content
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
                <?= get_the_title( '<h1 class="content-title">', '</h1>'); ?>
            </section>

            <?php if ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'templates/content', get_post_format() ); ?>

                <?php if ( comments_open() || get_comments_number() ) :	comments_template(); endif; ?>

            <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
