<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop header
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php

if ( ! has_post_thumbnail() ) { return; }

$thumb_id   = get_post_thumbnail_id( get_the_ID() );
$image      = wp_get_attachment_image_src( $thumb_id, 'large' ); 

if ( $image ) :
    $meta = ipress_get_attachment_meta( $thumb_id, 'large' );

    $alt            = ( empty( $meta['alt'] ) ) ? '' : 'alt="' . $meta['alt'];
    $caption        = ( empty( $meta['caption'] ) ) ? '' : $meta['caption'];
    $description    = ( empty( $meta['description'] ) ) ? '' : $meta['description'];
    $src            = $meta['src'];
?>
<div class="thumbnail d-flex-align-items-center justify-content-center">
    <a href="<?= esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?= $image[0]; ?>" class="img-fluid" <?= $alt; ?> /></a>
</div>
<?php endif;
