<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme header - displays <head> section content and content container
 * 
 * @package     iPress
 * @link        http://ipress.uk
 * @see         https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license     GPL-2.0+
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php 
	/**
	 * Functions hooked in to ipress_before_header
	 *
	 * @hooked ipress_skip_links - 10
	 */
    do_action( 'ipress_before_header' ); ?>

    <header id="masthead" class="site-header" role="banner" <?php ipress_header_style(); ?>>
        <div class="wrap">
            <?php 
            /**
             * Functions hooked into honeycomb_header action
             *
             * @hooked ipress_site_branding            - 10
             * @hooked ipress_primary_navigation       - 20
            */
            do_action( 'ipress_header' ); ?>
        </div>
    </header>

    <?php do_action( 'ipress_before_content' ); ?>

    <div id="content" class="site-content" tabindex="-1">

		<?php do_action( 'ipress_content_top' );
