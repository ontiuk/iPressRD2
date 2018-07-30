<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying tag archives
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area">

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-main" role="main">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title tag-title"><?php echo sprintf( __( 'Tag: %s', 'ipress' ), single_tag_title( '', false ) ); ?></h1>
			<?php the_archive_description( '<div class="archive-description tag-archive">', '</div>' ); ?>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/archive' ); ?>

	<?php else: ?>
	
		<?php get_template_part( 'templates/global/none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

</div><!-- #primary -->

<?php
do_action( 'ipress_sidebar' );
get_footer();
