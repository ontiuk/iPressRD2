<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Set up and load theme requirements
 * 
 * @package     iPress\Bootstrap
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

//----------------------------------------------
//  Theme Defines
//----------------------------------------------

// Theme Name & Versioning
define( 'IPRESS_THEME_NAME', 'iPress' );
define( 'IPRESS_THEME_VERSION', '1.0.3' );
define( 'IPRESS_THEME_RELEASE_DATE', date_i18n( 'F j, Y', '1483574400' ) );
define( 'IPRESS_THEME_WP', 4.7 );
define( 'IPRESS_THEME_PHP', 5.4 );

// Directory Structure
define( 'IPRESS_DIR', get_parent_theme_file_path() );
define( 'IPRESS_ROUTE_DIR',     IPRESS_DIR . '/route' );
define( 'IPRESS_TEMPLATES_DIR', IPRESS_DIR . '/templates' );
define( 'IPRESS_PARTIALS_DIR',  IPRESS_DIR . '/partials' );
define( 'IPRESS_LANG_DIR',      IPRESS_DIR . '/languages' );
define( 'IPRESS_IMAGES_DIR',    IPRESS_DIR . '/images' );
define( 'IPRESS_INCLUDES_DIR',  IPRESS_DIR . '/inc' );
define( 'IPRESS_LIB_DIR',       IPRESS_DIR . '/lib' );
define( 'IPRESS_ADMIN_DIR',     IPRESS_DIR . '/admin' );

// Includes Directory Structure
define( 'IPRESS_JS_DIR',            IPRESS_INCLUDES_DIR . '/js' );
define( 'IPRESS_CSS_DIR',           IPRESS_INCLUDES_DIR . '/css' );
define( 'IPRESS_FONTS_DIR',         IPRESS_INCLUDES_DIR . '/fonts' );
define( 'IPRESS_CONTROLS_DIR',      IPRESS_INCLUDES_DIR . '/controls' );
define( 'IPRESS_CONTROLS_JS_DIR',   IPRESS_CONTROLS_DIR . '/js' );
define( 'IPRESS_SHORTCODES_DIR',    IPRESS_INCLUDES_DIR . '/shortcodes' );
define( 'IPRESS_WIDGETS_DIR',       IPRESS_INCLUDES_DIR . '/widgets' );

// Directory Paths
define( 'IPRESS_URL',           get_parent_theme_file_uri() );
define( 'IPRESS_ROUTE_URL',     IPRESS_URL . '/route' );
define( 'IPRESS_TEMPLATES_URL', IPRESS_URL . '/templates' );
define( 'IPRESS_PARTIALS_URL',  IPRESS_URL . '/partials' );
define( 'IPRESS_LANG_URL',      IPRESS_URL . '/languages' );
define( 'IPRESS_IMAGES_URL',    IPRESS_URL . '/images' );
define( 'IPRESS_INCLUDES_URL',  IPRESS_URL . '/inc' );
define( 'IPRESS_LIB_URL',       IPRESS_URL . '/lib' );
define( 'IPRESS_ADMIN_URL',     IPRESS_URL . '/admin' );

// Includes Directory Paths
define( 'IPRESS_JS_URL',            IPRESS_INCLUDES_URL . '/js' );
define( 'IPRESS_CSS_URL',           IPRESS_INCLUDES_URL . '/css' );
define( 'IPRESS_FONTS_URL',         IPRESS_INCLUDES_URL . '/fonts' );
define( 'IPRESS_CONTROLS_URL',      IPRESS_INCLUDES_URL . '/controls' );
define( 'IPRESS_CONTROLS_JS_URL',   IPRESS_CONTROLS_URL . '/js' );
define( 'IPRESS_SHORTCODES_URL',    IPRESS_INCLUDES_URL . '/shortcodes' );
define( 'IPRESS_WIDGETS_URL',       IPRESS_INCLUDES_URL . '/widgets' );

//----------------------------------------------
//  Includes - Functions
//----------------------------------------------

// Functions
require_once( IPRESS_INCLUDES_DIR . '/functions.php' );
require_once( IPRESS_INCLUDES_DIR . '/helper.php' );

// Images & Media template functions
require_once( IPRESS_INCLUDES_DIR . '/images.php' );

// Navigation template functions
require_once( IPRESS_INCLUDES_DIR . '/navigation.php' );

// Shortcodes functionality
require_once( IPRESS_INCLUDES_DIR . '/shortcodes.php' );

// Functions: theme functions, actions & filters
require_once( IPRESS_INCLUDES_DIR . '/template-functions.php' );

//----------------------------------------------
//  Includes - Classes
//----------------------------------------------

// Initiate Main Registry, Scripts & Styles
$ipress = (object)[

    // Set theme
    'theme'     => wp_get_theme( 'IPRESS_THEME_NAME' ),

    // Load scripts & styles
    'scripts'   => require_once( IPRESS_INCLUDES_DIR . '/class-load-scripts.php' ),
    'styles'    => require_once( IPRESS_INCLUDES_DIR . '/class-load-styles.php' ),
    
    // Custom Post-Types & Taxonomies 
    'custom'    => require_once( IPRESS_INCLUDES_DIR . '/class-custom.php' )
];

// Theme compatibility
require_once( IPRESS_INCLUDES_DIR . '/class-compat.php' );

// Theme setup
require_once( IPRESS_INCLUDES_DIR . '/class-theme.php' );

// Theme setup
require_once( IPRESS_INCLUDES_DIR . '/class-init.php' );

// Cron Support: actions & filters
require_once( IPRESS_INCLUDES_DIR . '/class-cron.php' );

// Core hooks repository
require_once( IPRESS_INCLUDES_DIR . '/class-hooks.php' );

// Main query manipulation
require_once( IPRESS_INCLUDES_DIR . '/class-query.php' );

// WordPress Customizer support
require_once( IPRESS_INCLUDES_DIR . '/class-customizer.php' );

// Admin functionlity
if ( is_admin() ) {
    require_once( IPRESS_INCLUDES_DIR . '/class-admin.php' );
}

// Layout template functions
require_once( IPRESS_INCLUDES_DIR . '/class-layout.php' );

// Images & Media template functions
require_once( IPRESS_INCLUDES_DIR . '/class-images.php' );

// Navigation template functions
require_once( IPRESS_INCLUDES_DIR . '/class-navigation.php' );

// Redirect template functions
require_once( IPRESS_INCLUDES_DIR . '/class-redirect.php' );

// Rewrites template functions
require_once( IPRESS_INCLUDES_DIR . '/class-rewrites.php' );

// Sidebars functionality
require_once( IPRESS_INCLUDES_DIR . '/class-sidebars.php' );

// Template functionality
require_once( IPRESS_INCLUDES_DIR . '/class-template.php' );

// Widgets functionality
require_once( IPRESS_INCLUDES_DIR . '/class-widgets.php' );

// Page Support: actions & filters
require_once( IPRESS_INCLUDES_DIR . '/class-page.php' );

// User Support: actions & filters
require_once( IPRESS_INCLUDES_DIR . '/class-user.php' );

// Ajax Functions: actions & filters
require_once( IPRESS_INCLUDES_DIR . '/class-ajax.php' );

//----------------------------------------------
//  Libraries
//----------------------------------------------

//end
