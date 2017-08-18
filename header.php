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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-container">

    <?php get_template_part( 'templates/site-header' ); ?>

    <div id="content" class="site-content">
