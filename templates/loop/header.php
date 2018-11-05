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

<?php do_action( 'ipress_post_header_before' ); ?>

<header class="entry-header">
<?php
	if ( is_singular() ) :
        the_title( '<h1 class="entry-title single-title">', '</h1>' );
	else :
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	endif;
?>        
</header><!-- .entry-header -->
