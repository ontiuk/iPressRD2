<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for category breadcrumb
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<!-- Breadcrumb Section-->
<section class="crumb">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?= __( 'Category', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?= single_cat_title( '', false ); ?></li>
		</ul>
	</div>
</section>
