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
<?php if ( get_edit_post_link() ) : ?>
	<footer class="entry-footer">
	<?php
		edit_post_link(
			sprintf(
				esc_html__( 'Edit %s', 'ipress' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	?>
	</footer><!-- .entry-footer -->
<?php endif; ?>

<?php ipress_init_structured_data();
