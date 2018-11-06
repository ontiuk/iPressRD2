<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for Custom Post Type Archive breadcrumb
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
$post_type 			= get_post_type();
$post_type_object 	= get_post_type_object();
$post_type_name 	= get_post_type_labels( $post_type_object )->name;
?>
<!-- Breadcrumb Section-->
<section class="crumb">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?= $post_type_name; ?></li>
			<li class="breadcrumb-item active"><?php post_type_archive_title(); ?></li>
		</ul>
	</div>
</section>
