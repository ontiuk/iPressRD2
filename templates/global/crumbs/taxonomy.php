<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for taxonomy breadcrumb
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php
if ( is_tax( 'post_format' ) ) {
	if ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Asides', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Galleries', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Images', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Videos', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Quotes', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Links', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Statuses', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Audio', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$tax_type = '';
		$tax_title = _x( 'Chats', 'post format archive title' );
	}
} elseif ( is_tax() ) {
	$tax 		= get_taxonomy( get_queried_object()->taxonomy );
	$tax_type 	= $tax->labels->singular_name;
	$tax_title	= single_term_title( '', false );
}
?>
<!-- Breadcrumb Section-->
<section class="hero-crumb py-2 mb-0">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<?php if ( ! empty( $tax_type ) ) : ?>
			<li class="breadcrumb-item"><?= $tax_type; ?></li>
			<?php endif; ?>
			<li class="breadcrumb-item active"><?= $tax_title; ?></li>
		</ul>
	</div>
</section>
