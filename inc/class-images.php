<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Images
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

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

        // remove width and height dynamic attributes to thumbnail
        add_filter( 'post_thumbnail_html', [ $this, 'remove_thumbnail_dimensions' ], 10 );  
        add_filter( 'image_send_to_editor', [ $this, 'remove_thumbnail_dimensions' ], 10 );   

        // Custom avatar in settings > discussion
        add_filter( 'avatar_defaults', [ $this, 'gravatar' ] ); 
    }

    //----------------------------------------------
    //  Image & Media Action & Filter Hooks
    //----------------------------------------------

    /**
     * Image size media editor support
     * - should match custom images from add_images_size
     *
     * @see     https://codex.wordpress.org/Plugin_API/Filter_Reference/image_size_names_choose 
     * @param   array $sizes
     * @return  array
     */
    public function media_images( $sizes ) {

        // Filterable custom images 
        $custom_sizes = (array)apply_filters( 'ipress_media_images', [
            'image-in-post' => __( 'Image in Post', 'ipress' ),
            'full'          => __( 'Original size', 'ipress' )
        ] );

        // Test & return
        return ( empty($sizes) ) ? $sizes : array_merge( $sizes, $custom_sizes );
    }

    /**
     * Remove default image sizes
     * unset( $sizes['thumbnail'] );
     * unset( $sizes['medium'] );
     * unset( $sizes['large'] );
     *
     * @param   array
     * @return  array
     */
    public function remove_default_image_sizes( $sizes ) {
        return (array)apply_filters( 'ipress_media_images_sizes', $sizes );
    }

    /**
     * Allow svg mime type
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
            $existing_mimes[$k] = $v;
        }

        // Call the modified list of extensions
        return $existing_mimes;
    }

    /**
     * Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
     * - defaults to true
     *
     * @param  string
     * @return string
     */
    public function remove_thumbnail_dimensions( $html ) {

        // Filterable thumbnail dimensions
        $thumb_dimensions = (bool)apply_filters( 'ipress_remove_thumbnail_dimensions', '__return_true' ); 

        // Return formatted markup
        return ( $thumb_dimensions ) ? preg_replace( '/(width|height)=\"\d*\"\s/', '', $html ) : $html;
    }

    /**
     * Custom Gravatar in Settings > Discussion
     * - add as array ( 'name' => '', 'path' => '' )
     *
     * @param   array
     * @return  array
     */
    public function gravatar ( $avatar_defaults ) {

        // Filterable markup
        $custom_avatar = apply_filters( 'ipress_gravatar', '' );

        // Set avatar
        if ( is_array( $custom_avatar ) && !empty( $custom_avatar ) ) { 
            $avatar_path = esc_url( $custom_avatar['path'], false);
            $avatar_defaults[ $avatar_path ] = $custom_avatar['name'];
        }

        // Return avatar defaults
        return $avatar_defaults;
    }
}

// Instantiate Images Class
return new IPR_Images;

//end
