<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the 404 page
 * 
 * @see https://codex.wordpress.org/Creating_an_Error_404_Page
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

            <?php get_template_part( 'templates/404' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>