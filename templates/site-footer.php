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
?>
<footer id="footer" class="site-footer" role="contentinfo">
    <div class="site-info">
        <span class="site-name">
			<?= sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'ipress' ), 'ipress', '<a href="http://ipress.uk/" rel="designer">iPress</a>' ); ?>
			<span class="sep"> | </span>
			<a href="<?= esc_url( __( 'https://wordpress.org/', 'ipress' ) ); ?>"><?= sprintf( esc_html__( 'Powered by %s', 'ipress' ), 'ipress' ); ?></a>
        </span>
        <span class="copy">&copy; <?= date('Y'); ?></span>
    </div>
</footer>
