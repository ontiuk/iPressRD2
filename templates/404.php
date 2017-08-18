<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the main 404 page content
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title"><?= esc_html__( 'Oops! That page can&rsquo;t be found.', 'ipress' ); ?></h1>
        <p><a href="<?= home_url(); ?>"><?= __( 'Return home?', 'ipress' ); ?></a></p>
	</header><!-- .page-header -->

	<div id="post-404" class="page-content">
		<p><?= esc_html__( 'Nothing found at this location.', 'ipress' ); ?></p>

        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

        <?php if ( ipress_has_categories() ) : ?>
		<div class="widget widget_categories">
			<h2 class="widget-title"><?= esc_html__( 'Popular Categories', 'ipress' ); ?></h2>
			<ul>
			<?php
				wp_list_categories( [
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				] );
			?>
			</ul>
		</div><!-- .widget -->
        <?php endif; ?>

	</div><!-- .page-content -->
</section><!-- .error-404 -->
