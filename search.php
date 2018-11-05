<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying search results
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php global $wp_query; ?>

<?php get_header(); ?>

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-main">

	<?php do_action( 'ipress_search_before' ); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title search-title">
			<?php 
				/* translators: %s: search query. */
				echo sprintf( esc_html__( 'Search: %s Results for <span>%s</span>', 'ipress' ), $wp_query->found_posts, get_search_query() ); ?>
			</h1>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/search' ); ?>

	<?php else: ?>
	
		<?php get_template_part( 'templates/global/none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_search_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

<?php do_action( 'ipress_sidebar' ); ?>

<?php get_footer();
