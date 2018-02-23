<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme header - displays <footer> section content and containers
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
    	<?php do_action( 'ipress_after_content' ); ?>

    </div><!-- #content -->

    <?php do_action( 'ipress_before_footer' ); ?>

    <footer id="footer" class="site-footer" role="contentinfo">
        <?php do_action( 'ipress_footer_top' ); ?>
        <div class="wrap">
			<?php
			/**
			 * Functions hooked in to ipress_footer action
			 *
			 * @hooked ipress_footer_widgets - 10
			 * @hooked ipress_credit         - 20
			 */
			do_action( 'ipress_footer' ); ?>
        </div>
        <?php do_action( 'ipress_footer_bottom' ); ?>
    </footer>

    <?php do_action( 'ipress_after_footer' ); ?>

<?php wp_footer(); ?>

</body>
</html>
