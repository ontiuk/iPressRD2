<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying footer widgets
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php

if ( is_active_sidebar( 'footer-4' ) ) {
    $widget_columns = apply_filters( 'ipress_footer_widget_regions', 4 );
} elseif ( is_active_sidebar( 'footer-3' ) ) {
    $widget_columns = apply_filters( 'ipress_footer_widget_regions', 3 );
} elseif ( is_active_sidebar( 'footer-2' ) ) {
    $widget_columns = apply_filters( 'ipress_footer_widget_regions', 2 );
} elseif ( is_active_sidebar( 'footer-1' ) ) {
    $widget_columns = apply_filters( 'ipress_footer_widget_regions', 1 );
} else {
    $widget_columns = apply_filters( 'ipress_footer_widget_regions', 0 );
}

if ( $widget_columns === 0 ) { return; }
?>

<div class="footer-widgets col-<?php echo intval( $widget_columns ); ?> fix">

<?php
	$i = 0;
	while ( $i < $widget_columns ) : $i++;
		if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

			<div class="block footer-widget-<?php echo intval( $i ); ?>">
				<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
			</div>

		<?php endif;
	endwhile; ?>

</div><!-- /.footer-widgets  -->
