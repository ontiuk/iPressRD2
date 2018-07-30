<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying page content in page.php.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php 
if ( has_post_thumbnail() ) :
    $image_id = get_post_thumbnail_id( get_the_ID() );
    $image = wp_get_attachment_image_src( $image_id, $thumb_size ); 
    if ( $image ) :
?>
<div class="entry-image">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?= $image[0]; ?>" /></a>
</div>
<?php   
    endif; 
endif;
