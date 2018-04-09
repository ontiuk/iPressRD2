<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Front page template when static file / page set as home page in settings > display 
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

<?php do_action( 'ipress_homepage' ); ?>

<div id="primary" class="content-area">

<?php do_action( 'ipress_home_before' ); ?>

	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : the_post(); ?>

		<header class="page-header">
			 <h1 class="page-title single-title"><?php echo get_the_title(); ?></h1>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/content', 'home' ); ?>
	
	<?php endif; ?>
		
	</main><!-- #main -->

	<?php do_action( 'ipress_home_after' ); ?>

</div><!-- #primary -->

<?php do_action( 'ipress_homepage_after' ); ?>

<?php get_footer(); ?>
