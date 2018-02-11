<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Includes
 * @link        http://ipress.co.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * Set up theme styles
 */ 
final class IPR_Load_Styles {

    /**
     * Core styles
     *
     * @var array $core
     */
    private $core = [];

    /**
     * Header styles
     *
     * @var array $header
     */
    private $header = [];

    /**
     * Plugin styles
     *
     * @var array $plugins
     */
    private $plugins = [];

    /**
     * Page styles
     *
     * @var array $page
     */
    private $page = [];

    /**
     * Theme styles
     *
     * @var array $theme
     */
    private $theme = [];

    /**
     * Theme fonts
     *
     * @var array $fonts
     */
    private $fonts = [];

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Customiser custom css
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customizer_styles' ] );

        // Add Editor Styles
        add_action( 'admin_init', [ $this, 'editor_styles' ] );

        // Front-end only
        if ( is_admin() ) { return; }

        // Main styles 
        add_action( 'wp_enqueue_scripts', [ $this, 'load_styles' ] ); 

        // Fonts & typography 
        add_action( 'wp_enqueue_scripts', [ $this, 'load_fonts' ] ); 

        // Conditional header styles
        add_action( 'wp_enqueue_scripts', [ $this, 'conditional_styles' ] ); 

        // Header Inline CSS
        add_action( 'wp_head', [ $this, 'header_styles' ], 12 );
    }

    /**
     * Initialise main styles
     *
     * @param array $styles
     * @param array $fonts
     */
    public function init( $styles, $fonts ) {

        // Core styles: [ 'style-name', 'style-name' ... ];
        $this->core = $this->set_key( $styles, 'core' );

        // Header styles: [ 'label' => [ 'path_url', (array)depn, 'version' ] ... ]
        $this->header = $this->set_key( $styles, 'header' );

        // Plugin styles: [ 'label' => [ 'path_url', (array)depn, 'version' ] ... ]
        $this->plugins = $this->set_key( $styles, 'plugins' );

        // Page styles: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
        $this->page = $this->set_key( $styles, 'page' );

        // Theme styles: [ 'label' => [ 'path_url', (array)depn, 'version' ] ... ];
        $this->theme = $this->set_key( $styles, 'theme' );

        // Theme fonts: [ 'label' => [ 'path_url', (array)depn, 'version' ] ... ];
        $this->fonts = ( is_array( $fonts ) && !empty( $fonts ) ) ? $fonts : [];
    }

    /**
     * Validate and set key
     *
     * @param array $styles
     * @param string $key
     * @return array
     */
    private function set_key( $styles, $key ) {
        return ( isset ( $styles[$key] ) && is_array( $styles[$key] ) && !empty( $styles[$key] ) ) ? $styles[$key] : [];
    }

    //----------------------------------------------
    //  Scripts, Styles & Fonts
    //----------------------------------------------

    /**
     * Load CSS styles files
     */
    public function load_styles() { 

        // Register & enqueue core css in order
        foreach ( $this->core as $k=>$v ) { 
            wp_register_style( $k, $v[0], $v[1], $v[2] ); 
            wp_enqueue_style( $k ); 
        }

        // Register & enqueue css in order
        foreach ( $this->header as $k=>$v ) {
            wp_register_style( $k, $v[0], $v[1], $v[2] ); 
            wp_enqueue_style( $k ); 
        }
    
        // Register & enqueue plugin styles 
        foreach ( $this->plugins as $k=>$v ) { 
            wp_register_style( $k, $v[0], $v[1], $v[2] ); 
            wp_enqueue_style( $k ); 
        }

        // Page templates in footer head
        foreach ( $this->page as $k=>$v ) {
            if ( is_page_template( $v[0] ) ) {
                wp_register_style( $k, $v[1], $v[2], $v[3] ); 
                wp_enqueue_style( $k );
            }
        }

        // Register & enqueue core styles last
        foreach ( $this->theme as $k=>$v ) { 
            wp_register_style( $k, $v[0], $v[1], $v[2] ); 
            wp_enqueue_style( $k ); 
			wp_style_add_data( $k, 'rtl', 'replace' );
        }
    }

    //----------------------------------------------
    // Load Theme Fonts
    //----------------------------------------------

    /**
     * Load custom front-end fonts 
     */
    public function load_fonts() { 

        $fonts_url = '';

        // No fonts set?
        if ( !isset( $this->fonts['family'] ) || empty( $this->fonts['family'] ) ) { return; }

        // Construct font: family
		$query_args = [
            'family' => ( is_array( $this->fonts['family'] ) ) ? join( '|', $this->fonts['family'] ) : $this->fonts['family']
        ];

        // Construct font: subset - 'latin,latin-ext'
        if ( isset( $this->fonts['subset'] ) && !empty( $this->fonts['subset'] ) ) { 
            $query_args['subset'] = urlencode( $this->fonts['subset'] );
        }

        // Set fonts url
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

        // Register a css style file for later use 
        wp_register_style( 'ipress-fonts', esc_url_raw( $fonts_url ), [], null ); 
        
        // Enqueue css style
        wp_enqueue_style( 'ipress-fonts' ); 
    }

    //----------------------------------------------
    // Conditional Styles 
    //----------------------------------------------

    /**
     * Load conditional styles
     */
    public function conditional_styles() {

        global $wp_styles;

        // A bit outdated now...
        $show_conditional = apply_filters( 'ipress_show_conditional', false );
        if ( ! $show_conditional ) { return false; }

        // Load our stylesheet for IE9
        wp_enqueue_style( 'ie9', IPRESS_CSS_URL . '/ie9.css', [] );

        // Add to global styles list
        $wp_styles->add_data( 'ie9', 'conditional', 'IE 9' );
    }

    //----------------------------------------------
    //  Header & Footer Styles
    //----------------------------------------------

    /**
     * Load inline header css
     * - Must be full css text inside <style></style> wrapper
     */
    public function header_styles() {

        // Use filter to add styles
        $styles = apply_filters( 'ipress_header_styles', '' );
        if ( empty( $styles ) ) { return; }
        
        // Capture output   
        echo $styles;
    }

    //----------------------------------------------
    // Customizer Styles 
    //----------------------------------------------

    /**
     * Load customiser styles
     */
    public function customizer_styles() {
        wp_enqueue_style( 'ipress-customize', IPRESS_CSS_URL . '/customizer.css' );
    }

    //----------------------------------------------
    // Visual Editor Style
    //----------------------------------------------

    /**
     * Style the Visual Editor
     */
    public function editor_styles() {
        add_editor_style( IPRESS_CSS_URL . '/editor.css' );
    }
}

// Instantiate Styles Loader class
return new IPR_Load_Styles;

//end
