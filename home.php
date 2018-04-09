<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * The home page template, which is the front page by default. 
 * When a static front page is set this is the template for displaying the post list. 
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
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

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-main" role="main">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php if ( have_posts() ) : ?>
   
		<header class="page-header">
			<h1 class="page-title single-title"><?php single_post_title(); ?></h1>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/loop' ); ?>

	<?php else: ?>
	
		<?php get_template_part( 'templates/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

</div><!-- #primary -->

<?php do_action( 'ipress_sidebar' ); ?>
<?php get_footer(); ?>
