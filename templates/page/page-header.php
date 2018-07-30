<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the page content header
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_page_header_before' ); ?>

<header class="entry-header page-header">
	<?php the_title( '<h1 class="entry-title page-title">', '</h1>' ); ?>
</header><!-- .entry-header -->
