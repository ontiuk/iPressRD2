<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying a post not found message
 * 
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<section class="no-results not-found">
	<header class="page-header">
        <h1 class="page-title page-none"><?= esc_html__( 'Sorry, nothing to display.', 'ipress' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( ipress_is_home_page() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php
                printf( 
                    wp_kses( 
                        /* translators: 1: link to WP admin new post page. */ 
                        __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ipress' ), 
                        [ 
                            'a' => [ 
                                'href' => [], 
                            ], 
                        ] 
                    ), 
                    esc_url( admin_url( 'post-new.php' ) ) 
                ); 
             ?></p> 

        <?php elseif ( is_search() ) : ?>

            <p><?= esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ipress' ); ?></p>
            <?php get_search_form(); ?>

        <?php else : ?>
			<p><?= esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ipress' ); ?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
