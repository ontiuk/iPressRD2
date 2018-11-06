<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for Author breadcrumb
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
			<li class="breadcrumb-item"><?= __( 'Author', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?= get_the_author(); ?></li>
		</ul>
	</div>
</section>
