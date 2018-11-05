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
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ipress' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	?>
	</footer><!-- .entry-footer -->
<?php endif; ?>

<?php do_action( 'ipress_page_footer' );
