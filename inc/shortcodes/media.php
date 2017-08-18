<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Images and media shortcodes
 *
 * @package     iPress\Shortcodes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

//---------------------------------------------
// Images and Media Shortcodes 
//---------------------------------------------

/**
 * Retrieve attachment meta data
 *
 * @param   array|string $atts 
 * @return  string
 */
function ipress_attachment_meta_shortcode( $atts ) {

    $defaults = [
        'after'         => '',
        'before'        => '',
        'attachment'    => '',
        'size'          => ''
    ];

    // Get shortcode attributes
    $atts = shortcode_atts( $defaults, $atts, 'ipress_attachment_meta' );

    // Attachment ID required
    if ( empty( $attachemnt_id ) ) { return false; }

    // Get attachment data
    $attachment = get_post( $atts['attachment_id'] );

    // Not valid
    if ( empty( $attachment ) ) { return false; }

    // Get attachment data
    $attachment = get_post( $attachment_id );
    if ( empty( $attachment ) ) { return false; }

    // Set thumbnail if available  
    $att_data_thumb = wp_get_attachment_image_src( $attachment_id, $size );
    if ( !$att_data_thumb ) { return false; }
    
    // Generate attachment data
    $data = [];
    $data['alt']            = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
    $data['caption']        = $attachment->post_excerpt;
    $data['description']    = $attachment->post_content;
    $data['href']           = $attachment->guid;
    $data['src']            = $att_data_thumb[0];
    $data['title']          = $attachment->post_title;

    // Generate output
    $output = sprintf( '<span class="attachment-meta">%s</span>', $atts['before'] . print_r( $data, true ) . $atts['after'] );

    // Return filterable output
    return apply_filters( 'ipress_attachment_meta_shortcode', $output, $atts );
}

// Attachment meta data shortcode
add_shortcode( 'ipress_attachment_meta', 'ipress_attachment_meta_shortcode' );

/**
 * Get post attachements by attachement mime type 
 *
 * @param   array|string $atts 
 * @return  string
 */
function ipress_post_attachments_shortcode( $atts ) {

    $defaults = [
        'after'             => '',
        'before'            => '',
        'post_mime_type'    => '',
        'numberposts'       => -1,
        'post_parent'       => ''
    ];

    // Get shortcode attributes
    $atts = shortcode_atts( $defaults, $atts, 'ipress_post_attachments' );

    // Parent & type required
    if ( empty( $atts['post_parent'] ) || empty( $atts['post_mime_type'] ) ) { return false; }

    // Get attachment data if available
    $attachments = get_posts( [
        'post_type'         => 'attachment',
        'post_mime_type'    => $atts['post_mime_type'],
        'numberposts'       => $atts['numberposts'],
        'post_parent'       => $atts['post_parent']
    ] );
    if ( !$attachments ) { return false; }

    // Generate output
    $output = sprintf( '<span class="post-attachment">%s</span>', $atts['before'] . print_r( $attachments, true ) . $atts['after'] );

    // Return filterable output
    return apply_filters( 'ipress_post_attachments_shortcode', $output, $atts );
}

// Attachments by post ID shortcode
add_shortcode( 'ipress_post_attachments', 'ipress_post_attachments_shortcode' );

/**
 * Convert color form hex to rgb
 *
 * @param   array|string $atts 
 * @return  string
 */
function ipress_image_hex_to_rgb_shortcode( $atts ) {

    $defaults = [
        'after'     => '',
        'before'    => '',
        'hex'       => ''
    ];

    // Get shortcode attributes
    $atts = shortcode_atts( $defaults, $atts, 'ipress_image_hex_to_rgb' );

    // Hex code required
    if ( empty( $atts['hex'] ) ) { return false; }

    // Convert hex code...
    $hex = str_replace( '#', '', $atts['hex'] );

    // ...to rgb data
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    $rgb = $r . ',' . $g . ',' . $b; 

    // Generate output
    $output = sprintf( '<span class="image-hex-to-rgb">%s</span>', $atts['before'] . esc_html( $rgb ) . $atts['after'] );

    // Return filterable output
    return apply_filters( 'ipress_image_hex_to_rgb_shortcode', $output, $atts );
}

// Hex Colour Code shortcode
add_shortcode( 'ipress_image_hex_to_rgb', 'ipress_image_hex_to_rgb_shortcode' );

//end
