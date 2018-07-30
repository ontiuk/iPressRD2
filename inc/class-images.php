<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Images' ) ) :

	/**
	 * Set up navigation features
	 */ 
	final class IPR_Images {

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {

			// Image size media editor support
			add_filter( 'image_size_names_choose', [ $this, 'media_images' ] );

			// Remove default image sizes
			add_filter( 'intermediate_image_sizes_advanced', [ $this, 'remove_default_image_sizes' ] );

			// Enable SVG mime type plus filterable other types
			add_filter( 'upload_mimes', [ $this, 'custom_upload_mimes' ] );			 

			// Custom avatar in settings > discussion
			add_filter( 'avatar_defaults', [ $this, 'gravatar' ] ); 

			// Responsive image sizes for theme images
			add_filter( 'wp_calculate_image_sizes', [ $this, 'image_sizes' ], 10, 2 );

			// Responsive image sizes for thumbnails
			add_filter( 'wp_get_attachment_image_attributes', [ $this, 'post_thumbnail_sizes' ], 10, 3 );
		}

		//----------------------------------------------
		//	Image & Media Action & Filter Hooks
		//----------------------------------------------

		/**
		 * Image size media editor support
		 * - should match custom images from add_images_size
		 *
		 * @see		https://codex.wordpress.org/Plugin_API/Filter_Reference/image_size_names_choose 
		 * @param	array $sizes
		 * @return	array
		 */
		public function media_images( $sizes ) {

			// Filterable custom images 
			$custom_sizes = (array) apply_filters( 'ipress_media_images', [
				'image-in-post' => __( 'Image in Post', 'ipress' ),
				'full'			=> __( 'Original size', 'ipress' )
			] );

			// Test & return
			return ( empty( $custom_sizes ) ) ? $sizes : array_merge( $sizes, $custom_sizes );
		}

		/**
		 * Remove default image sizes
		 * unset( $sizes['thumbnail'] );
		 * unset( $sizes['medium'] );
		 * unset( $sizes['large'] );
		 *
		 * @param	array
		 * @return	array
		 */
		public function remove_default_image_sizes( $sizes ) {
			return (array) apply_filters( 'ipress_media_images_sizes', $sizes );
		}

		/**
		 * Allow additional mime-types
		 * - default to add SVG support
		 *
		 * - For example, the following line allows PDF uploads 
		 * - $existing_mimes['pdf'] = 'application/pdf'; 
		 *
		 * @param  array
		 * @return array
		 */
		public function custom_upload_mimes ( $existing_mimes = [] ) {

			// Add the file extension to the array
			$new_mimes = apply_filters( 'ipress_upload_mimes', [ 'svg' => 'mime/type' ] ); 

			// Add the file extension to the current mimes
			foreach ( $new_mimes as $k=>$v ) {
				if ( array_key_exists( $k, $existing_mimes ) ) { continue; }
				$existing_mimes[$k] = sanitize_text_field( $v );
			}

			// Return the modified list of extensions / mime-types
			return $existing_mimes;
		}

		/**
		 * Custom Gravatar in Settings > Discussion
		 * - add as array ( 'name' => '', 'path' => '' )
		 *
		 * @param	array
		 * @return	array
		 */
		public function gravatar ( $avatar_defaults ) {

			// Filterable markup
			$custom_avatar = apply_filters( 'ipress_gravatar', '' );

			// Set avatar
			if ( is_array( $custom_avatar ) && ! empty( $custom_avatar ) ) { 
				$avatar_path = esc_url( $custom_avatar['path'], false);
				$avatar_defaults[ $avatar_path ] = $custom_avatar['name'];
			}

			// Return avatar defaults
			return $avatar_defaults;
		}

		/**
		 * Modify custom image sizes attribute for responsive image functionality
		 * 
		 * @param	string $sizes A source size value for use in a 'sizes' attribute
		 * @param	array  $size  Image size [ width, height ]
		 * @return	string 
		 */
		public function image_sizes( $sizes, $size ) {
			
			global $content_width;

			$width = $size[0]; 
			return ( is_null( $content_width ) || $width < $content_width ) ? $sizes : '(min-width: ' . $content_width . 'px) ' . $content_width . 'px, 100vw'; 
		}

		/**
		 * Modify post thumbnail image sizes attribute for responsive image functionality
		 *
		 * @param	array $attr		  Attributes for the image markup
		 * @param	int   $attachment Image attachment ID
		 * @param	array $size		  Registered image size or [ height, width ]
		 * @return	array 
		 */
		public function post_thumbnail_sizes( $attr, $attachment, $size ) {
			return $attr;
		}
	}

endif;

// Instantiate Images Class
return new IPR_Images;

//end
