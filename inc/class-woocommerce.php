<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core Woocommerce features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Woocommerce' ) ) :

	/**
	 * iPress Woocommerce Support
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/ 
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0 
	 */
	final class IPR_Woocommerce {

		// Class Constructor
		public function __construct() {

			// Include Woocommerce support
			add_action( 'after_setup_theme', [ $this, 'woocommerce_setup' ] );

			// Disable default Woocommerce styles @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/ 
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' ); 

			// Woocommerce body class
			add_filter( 'body_class', [ $this, 'body_class' ] ); 

			// Related product settings
			add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products_args' ] ); 

			// Default WooCommerce wrapper
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 ); 
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 ); 
			add_action( 'woocommerce_before_main_content', [ $this, 'wrapper_before' ] ); 
			add_action( 'woocommerce_after_main_content',  [ $this, 'wrapper_after' ] ); 

			// Cart fragments
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_link_fragment' ], 10, 1 ); 
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_content_fragment' ], 10, 1 ); 

			// Single Product Page Hook Modifications
			add_action( 'init', [ $this, 'single_product_markup' ] );

			// Product Archive Pages Hook Modifications
			add_action( 'init', [ $this, 'product_archive_markup' ] );
		}

		//----------------------------------------------
		//	Core support
		//----------------------------------------------

		/**
		 * Woocommerce theme support
		 */
		public function woocommerce_setup() {
			
			// Add Woocommerce support, inc 3.x features
			add_theme_support( 'woocommerce' ); 

			$woo_gallery = apply_filters( 'ipress_wc_gallery', true );
			if ( $woo_gallery ) {
				add_theme_support( 'wc-product-gallery-zoom' ); 
				add_theme_support( 'wc-product-gallery-lightbox' ); 
				add_theme_support( 'wc-product-gallery-slider' ); 
			}
		}

		/** 
		 * Add 'woocommerce-active' class to the body tag if active
		 * 
		 * @param  array $classes
		 * @return array 
		 */ 
		public function body_class( $classes ) { 

			if ( ipress_woocommerce_active() ) {
				$classes[] = 'woocommerce-active'; 
			}
			return $classes; 
		} 
	 
		/** 
		 * Related Products Args. 
		 * 
		 * @param array $args related products args. 
		 * @return array $args related products args. 
		 */ 
		public function related_products_args( $args ) { 
			$defaults = [ 
				'posts_per_page' => 3, 
				'columns'		 => 3 
			]; 
	 
			$args = wp_parse_args( $defaults, $args ); 
			return $args; 
		} 

		/** 
		 * Product columns wrapper
		 * 
		 * @return	void 
		 */ 
		public function product_columns_wrapper() { 
			echo sprintf( '<div class="columns-%s">', absint( $this->loop_columns() ) ); 
		} 

		/** 
		 * Product columns wrapper close. 
		 * 
		 * @return	void 
		 */ 
		public function product_columns_wrapper_close() { 
			echo '</div>'; 
		} 

		/** 
		 * Before Content Woocommerce wrapper
		 * 
		 * @return void 
		 */ 
		public function wrapper_before() {
		   echo '<div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
		} 
		
		/** 
		 * After Content Woocommerce wrapper
		 * 
		 * @return void 
		 */ 
		public function wrapper_after() { 
			echo '</main><!-- #main --></div><!-- #primary -->';
		} 

		/** 
		 * Keep cart contents update when products are added to the cart via AJAX 
		 * 
		 * @param	array $fragments Fragments to refresh via AJAX
		 * @return	array
		 * @todo	This is template specific but use css attribute
		 * @uses	/woocommerce theme overwrite directory
		 */ 
		public function header_cart_link_fragment( $fragments ) { 

			$header_cart = apply_filters( 'ipress_wc_header_cart', false );
			if ( ! $header_cart ) { return $fragments; }

			ob_start(); 
			wc_get_template_part( 'header-cart-link' );
			$fragments['a.header-cart-link'] = ob_get_clean(); 
		 
			return $fragments; 
		} 

		/** 
		 * Keep cart contents update when products are added to the cart via AJAX 
		 * 
		 * @param	array $fragments Fragments to refresh via AJAX
		 * @return	array
		 * @todo	This is template specific but use css attribute
		 * @uses	/woocommerce theme overwrite directory
		 */ 
		public function header_cart_content_fragment( $fragments ) { 

			$header_cart = apply_filters( 'ipress_wc_header_cart', false );
			if ( ! $header_cart ) { return $fragments; }

			ob_start(); 
			wc_get_template_part( 'header-cart-content' );
			$fragments['div.header-cart-content'] = ob_get_clean(); 

			return $fragments; 
		} 

		//----------------------------------------------
		//	Single Product Page
		//----------------------------------------------
		
		/**
		 * Single Product Page Markup
		 *
		 * @return void
		 */
		public function single_product_markup() {}

		//----------------------------------------------
		//	Product Archive Pages
		//----------------------------------------------

		/**
		 * Product Archive Page Markup
		 *
		 * @return void
		 */
		public function product_archive_markup() {}

		//----------------------------------------------
		//	Other
		//----------------------------------------------
		
	}

endif;

// Initialize WC class
return new IPR_Woocommerce();

// End
