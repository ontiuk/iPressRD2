<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop footer
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<footer class="entry-footer"> 
    <?php ipress_entry_footer(); ?> 
</footer><!-- .entry-footer --> 

<?php do_action( 'ipress_post_footer' );
