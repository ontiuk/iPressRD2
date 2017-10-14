<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site menu
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
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'ipress' ); ?>">
    <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?= esc_attr( 'Menu', 'ipress' ); ?></span></button>
    <?php 
        wp_nav_menu( [
            'theme_location'    => 'primary', 
            'container_class'	=> 'primary-navigation'
        ] ); 
    ?>
</nav>