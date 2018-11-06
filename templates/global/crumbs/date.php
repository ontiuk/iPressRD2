<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for Page breadcrumb
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
if ( is_year() ) {
	$date_type 	= 'Year';
	$date_item	= get_the_date( _x( 'Y', 'yearly archives date format' ) );
} elseif ( is_month() ) {
	$date_type 	= 'Month';
	$data_item	= get_the_date( _x( 'F Y', 'monthly archives date format' ) );
} elseif ( is_day() ) {
	$date_type 	= 'Day';
	$date_item	= get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
}
?>
<!-- Breadcrumb Section-->
<section class="hero-crumb py-2 mb-0">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?= $date_type; ?></a></li>
			<li class="breadcrumb-item active"><?= $date_item; ?></li>
		</ul>
	</div>
</section>
