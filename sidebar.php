<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Sidebar containing the main widget area
 * 
 * @package     iPress
 * @link        http://ipress.uk
 * @see         https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

?>

<?php if ( !is_active_sidebar( 'primary' ) ) { return; } ?>

<aside id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'primary' ); ?>
</aside><!-- #secondary -->
