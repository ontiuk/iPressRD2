<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying generic author archives
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

	<?php do_action( 'ipress_archive_before' ); ?>

	 <?php if ( have_posts() ) : the_post(); ?>

		<header class="page-header">
			<h1 class="page-title author-title"><?= sprintf( __( 'Author: <span class="vcard">%s</span>', 'ipress' ), get_the_author() ); ?></h1>
		</header><!-- .page-header -->

		<?php if ( get_the_author_meta( 'description' ) ) : ?>
		<section class="content-author">
			<?= wpautop( get_the_author_meta( 'description' ) ); ?>
		</section>	  
		<?php endif; ?>
	
		<?php rewind_posts(); ?>

		<?php get_template_part( 'templates/archive' ); ?>

	<?php else: ?>

		<?php get_template_part( 'templates/global/none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

<?php do_action( 'ipress_sidebar' ); ?>

<?php get_footer();
