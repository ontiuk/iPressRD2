<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying the 500 page if possible
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

		<?php get_template_part( 'templates/global/500' ); ?>

	</main><!-- #main -->

<?php do_action( 'ipress_after_main_content' ); ?>

</div><!-- #primary -->

<?php get_footer();
