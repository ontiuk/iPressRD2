<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Main page template
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php get_header(); ?>

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-main">

	<?php do_action( 'ipress_page_before' ); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/page' ); ?>
	
	<?php else: ?>
	
		<?php get_template_part( 'templates/global/none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_page_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

<?php do_action( 'ipress_sidebar' ); ?>

<?php get_footer();
