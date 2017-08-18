<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site header & menu
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<header id="masthead" class="site-header" role="banner">
    <div class="site-branding">
        <?php if ( ipress_is_home_page() ) : ?>
            <h1 class="site-title"><a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php else : ?>
            <p class="site-title"><a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php endif; ?>

        <?php $description = get_bloginfo( 'description', 'display' ); ?>
        <?php if ( $description ) : ?>
            <h2 class="site-description"><?= $description; ?></h2>
        <?php endif; ?>
	</div><!-- .site-branding -->
    <aside class="header-search">
        <?php get_search_form(); ?>
    </aside>
</header><!-- header -->

<nav id="site-navigation" class="main-navigation" role="navigation">
    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ipress' ); ?></button>
    <?php wp_nav_menu( [ 
        'theme_location' => 'primary', 
        'menu_id'        => 'primary-menu' 
    ] ); ?>
</nav>
