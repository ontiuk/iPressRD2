<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme header - displays <head> section content and content container
 * 
 * @package		iPress
 * @link		http://ipress.uk
 * @see			https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license		GPL-2.0+
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">

	<?php do_action( 'ipress_before' ); ?>

	<div id="page" class="site-container">

	<?php 
	/**
	 * Functions hooked in to ipress_before_header
	 *
	 * @hooked ipress_skip_links - 10
	 */
	do_action( 'ipress_before_header' ); ?>

	<header id="masthead" class="site-header" <?php ipress_header_style(); ?> itemscope itemtype="https://schema.org/WPHeader">
		<?php do_action( 'ipress_header_before' ); ?>

		<div class="wrap">
			<?php 
			/**
			 * Functions hooked into honeycomb_header action
			 *
			 * @hooked ipress_site_branding			   - 10
			 * @hooked ipress_primary_navigation	   - 20
			*/
			do_action( 'ipress_header' ); ?>
		</div>

		<?php do_action( 'ipress_header_after' ); ?>

	</header><!-- .site-header -->

	<?php do_action( 'ipress_after_header' ); ?>

	<div id="content" class="site-content">
