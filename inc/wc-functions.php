<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Woocommerce functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	WooCommerce Functions
//	
//	- ipress_woocommerce_active
//	- ipress_is_product_archive
//----------------------------------------------

/**
 * Query WooCommerce activation
 *
 * @return boolean true if WooCommerce plugin active
 */
function ipress_woocommerce_active() {
	return ( class_exists( 'WooCommerce' ) ) ? true : false;
}

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
function ipress_is_product_archive() {

	// No woocommerce
	if ( ! ipress_woocommerce_active() ) { return false; }

	// Product archive
	return ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ? true : false;
}

//end
