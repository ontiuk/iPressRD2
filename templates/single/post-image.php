<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the post image
 * 
 * @package     iPress\Templates
 * @see         http://codex.wordpress.org/The_Loop
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php if ( ! has_post_thumbnail() ) { return; } ?>

<?php
$image_id = get_post_thumbnail_id( get_the_ID() );
$image = wp_get_attachment_image_src( $image_id, $thumb_size ); 
if ( $image ) : 
?>
<div class="entry-image">
    <a href="<?= esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><img src="<?= $image[0]; ?>" /></a>
</div>
<?php 
endif; 
