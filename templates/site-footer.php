<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site footer
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
<footer id="footer" class="site-footer" role="contentinfo">
    <div class="wrap">
        <div class="site-info">
            <?php echo sprintf( '<span class="copy">&copy; %s %s</span>', esc_html ( get_bloginfo( 'name' ) ), date('Y') ) ; ?>
            <span class="site-name">
                <?= sprintf( esc_attr__( 'Theme %1$s by %2$s.', 'ipress' ), 'iPress', '<a href="https://ipress.uk" title="iPress - WordPress Theme Framework" rel="author">iPress</a>' ); ?>
            </span>
        </div>
    </div>
</footer>
