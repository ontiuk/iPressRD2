<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site info & credits
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<div class="site-info">
    <?php echo sprintf( '<span class="copy">&copy; %s %s</span>', esc_html ( get_bloginfo( 'name' ) ), date('Y') ) ; ?>
    <span class="site-name">
        <?php echo sprintf( esc_attr__( 'Theme %1$s by %2$s.', 'ipress' ), 'iPress', '<a href="https://ipress.uk" title="iPress - WordPress Theme Framework" rel="author">iPress</a>' ); ?>
    </span>
</div>
