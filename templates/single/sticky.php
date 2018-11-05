<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the post loop sticky tag
 * 
 * @package     iPress\Templates
 * @see         http://codex.wordpress.org/The_Loop
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php if ( is_sticky() && is_home() ) : ?>
    <div class="sticky-post"></div>
<?php endif;
