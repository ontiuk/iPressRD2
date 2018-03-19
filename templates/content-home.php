<?php 
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the home page content
 * 
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_home_content_before' ); ?>

<div id="content-home" class="content-home"><?php the_content(); ?></div>

<?php do_action( 'ipress_home_content_after' );
