<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme compatibility functionality
 * 
 * @package     iPress\Includes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * Initialise and set up theme compatibility functionality
 *
 * - WP Version Check
 * - PHP Version Check
 */ 
final class IPR_Compat {

    /**
     * Versioning error
     *
     * @var $version_error default false
     */
    private $version_error = false;

    /**
     * Class Constructor
     * - set up hooks & checks
     */
    public function __construct() {

        // PHP versioning check
        if ( version_compare( phpversion(), IPRESS_THEME_PHP, '<' ) ) {

            // Prevent switching & activation 
            add_action( 'after_switch_theme', [ $this, 'switch_theme_php' ] );

            // Set the version error
            $this->version_error = true;
        }

        // WP versioning check
        if ( version_compare( $GLOBALS['wp_version'], IPRESS_THEME_WP, '<' ) ) {
            
            // Prevent switching & activation 
            add_action( 'after_switch_theme', [ $this, 'switch_theme_wp' ] );
            
            // Prevent the customizer from being loaded
            add_action( 'load-customize.php', [ $this, 'theme_customizer' ] );

            // Prevent the theme preview from being loaded
            add_action( 'template_redirect', [ $this, 'theme_preview' ] );

            // Set the version error
            $this->version_error = true;
        }
    }

    //----------------------------------------------
    //  PHP Version Control
    //----------------------------------------------

    /**
     * Process theme switching version control
     */
    public function switch_theme_php() {

        // Action switch & admin notice
        switch_theme( WP_DEFAULT_THEME );
        unset( $_GET['activated'] );
        add_action( 'admin_notices', [ $this, 'version_notice_php' ] );
    }

    /**
     * Adds a message for unsuccessful theme switch if version prior to theme required
     */
    public function version_notice_php() {
        $message = sprintf( __( 'PHP version <strong>%s</strong> is required You are using <strong>%s</strong>. Please update or contact your hosting company', 'ipress' ), phpversion(), IPRESS_THEME_PHP );
        echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
    }

    //----------------------------------------------
    //  WordPress Version Control
    //----------------------------------------------

    /**
     * Process theme switching version control
     */
    public function switch_theme_wp() {

        // Action switch & admin notice
        switch_theme( WP_DEFAULT_THEME );
        unset( $_GET['activated'] );
        add_action( 'admin_notices', [ $this, 'version_notice_wp' ] );
    }

    /**
     * Adds a message for unsuccessful theme switch if version prior to theme required
     *
     * @global string $wp_version WordPress version
     */
    private function version_notice_wp() {
        $message = sprintf( __( 'iPress requires at least WordPress version %s. You are running version %s.', 'ipress' ), IPRESS_THEME_WP, $GLOBALS['wp_version'] );
        echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
    }

    /**
     * Prevents the Customizer from being loaded on WordPress versions prior to theme required
     *
     * @global string $wp_version WordPress version.
     */
    public function theme_customizer() {
    	wp_die( sprintf( __( 'iPress requires at least WordPress version %s. You are running version %s.', 'ipress' ), IPRESS_THEME_WP, $GLOBALS['wp_version'] ), '', [ 'back_link' => true ] );
    }

    /**
     * Prevents the Theme Preview from being loaded on WordPress versions prior to theme required
     * 
     * @global string $wp_version WordPress version.
     */
    public function theme_preview() {
	    if ( isset( $_GET['preview'] ) ) {
		    wp_die( sprintf( __( 'iPress requires at least WordPress version %s. You are running version %s.', 'ipress' ), IPRESS_THEME_WP, $GLOBALS['wp_version'] ) );
	    }
    }

    //----------------------------------------------
    //  Version Error
    //----------------------------------------------

    /**
     * Get the version error state
     */
    public function get_error() {
        return $this->version_error;
    }
}

// Instantiate Compatibility Class
return new IPR_Compat;

// End
