<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the excerpt post content
 * 
 * @package     iPress\Templates
 * @see         http://codex.wordpress.org/The_Loop
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<section class="entry-summary">
<?php
    /**
     * Functions hooked in to ipress_post_content_before action.
     *
     * @hooked ipress_post_thumbnail - 10
     */
    do_action( 'ipress_post_content_before' );

    the_excerpt(); 
?>
</section><!-- .entry-summary --> 
