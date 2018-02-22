<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop meta data
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php if ( 'post' == get_post_type() ) : ?>
<section class="entry-meta">
<?php
    ipress_posted_on();
    ipress_posted_by();
?>
</section>
<?php endif;
