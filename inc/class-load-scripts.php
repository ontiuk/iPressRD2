<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package     iPress\Loader
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
 * Set up theme scripts
 */ 
final class IPR_Load_Scripts {

    /**
     * core scripts
     *
     * @var array $core
     */
    private $core = [];

    /**
     * header scripts
     *
     * @var array $header
     */
    private $header = [];

    /**
     * footer scripts
     *
     * @var array $footer
     */
    private $footer = [];

    /**
     * plugin scripts
     *
     * @var array $plugins
     */
    private $plugins = [];

    /**
     * page scripts
     *
     * @var array $page
     */
    private $page = [];

    /**
     * conditional scripts
     *
     * @var array $conditional
     */
    private $conditional = [];

    /**
     * front page scripts
     *
     * @var array $front
     */
    private $front = [];

    /**
     * custom scripts
     *
     * @var array $custom
     */
    private $custom = [];

    /**
     * localize scripts
     *
     * @var array $local
     */
    private $local = [];

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {

        // Front end only
        if ( is_admin() ) { return; }

        // Load scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] ); 

        // Conditional header scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'conditional_scripts' ] ); 

        // Inline header scripts 
        add_action( 'wp_head', [ $this, 'header_scripts' ], 99 );

        // Footer Scripts
        add_action( 'wp_footer', [ $this, 'footer_scripts' ], 99 );

        // Analytics
        add_action( 'wp_head', [ $this, 'analytics_script' ], 100 );
    }

    /**
     * Initialise main scripts
     *
     * @param array $scripts
     */
    public function init( $scripts ) {

        // Core scripts: [ 'script-name', 'script-name2' ... ]
        $this->core = ( isset ( $scripts['core'] ) && is_array( $scripts['core'] ) ) ? $scripts['core'] : [];

        // Header scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
        $this->header = ( isset ( $scripts['header'] ) && is_array( $scripts['header'] ) ) ? $scripts['header'] : [];

        // Footer scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
        $this->footer = ( isset ( $scripts['footer'] ) && is_array( $scripts['footer'] ) ) ? $scripts['footer'] : [];

        // Plugin scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
        $this->plugins = ( isset ( $scripts['plugins'] ) && is_array( $scripts['plugins'] ) ) ? $scripts['plugins'] : [];

        // Page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
        $this->page = ( isset ( $scripts['page'] ) && is_array( $scripts['page'] ) ) ? $scripts['page'] : [];

        // Conditional scripts: [ 'label' => [ [ 'callback', [ args ] ], 'path_url', (array)dependencies, 'version' ] ... ];
        $this->conditional = ( isset ( $scripts['conditional'] ) && is_array( $scripts['conditional'] ) ) ? $scripts['conditional'] : [];

        // Front Page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
        $this->front = ( isset ( $scripts['front'] ) && is_array( $scripts['front'] ) ) ? $scripts['front'] : [];

        // Custom scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ];
        $this->custom = ( isset ( $scripts['custom'] ) && is_array( $scripts['custom'] ) ) ? $scripts['custom'] : [];

        // Localize scripts: [ 'label' => [ 'name' => name, trans => function/path ] ]
        $this->local = ( isset ( $scripts['local'] ) && is_array( $scripts['local'] ) ) ? $scripts['local'] : [];
    }

    //----------------------------------------------
    //  Scripts, Styles & Fonts
    //----------------------------------------------

    /**
     * Load core, header & footer scripts 
     */
    public function load_scripts() { 
 
        // Register & enqueue core scripts
        foreach ( $this->core as $k=>$v ) { wp_enqueue_script( $v ); }

        // Register & enqueue header scripts
        foreach ( $this->header as $k=>$v ) { 
            wp_register_script( $k, $v[0], $v[1], $v[2], false ); 
            if ( array_key_exists( $k, $this->local ) ) {
                $this->localize( $k );
            }
            wp_enqueue_script( $k );
        }

        // Register & enqueue footer scripts
        foreach ( $this->footer as $k=>$v ) { 
            wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
            if ( array_key_exists( $k, $this->local ) ) {
                $this->localize( $k );
            }
            wp_enqueue_script( $k );
        }

        // Register & enqueue plugin scripts
        foreach ( $this->plugins as $k=>$v ) { 
            wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
            if ( array_key_exists( $k, $this->local ) ) {
                $this->localize( $k );
            }
            wp_enqueue_script( $k );
        }

        // Page templates in footer head
        foreach ( $this->page as $k=>$v ) {
            if ( is_page_template( $v[0] ) ) {
                wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
                if ( array_key_exists( $k, $this->local ) ) {   
                    $this->localize( $k );
                } 
                wp_enqueue_script( $k );
            }
        }

        // Conditional templating in footer
        foreach ( $this->conditional as $k=>$v ) {
            $callback = $v[0];
            if ( is_array( $callback ) ) {
                $r = ( isset( $callback[1] ) ) ? call_user_func_array ( $callback[0] , (array)$callback[1] ) : call_user_func ( $callback[0] );
            } else {
                $r = call_user_func ( $callback );
            }
            if ( $r ) {
                wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
                wp_enqueue_script( $k );
            }
        }

        // Front page scripts
        foreach ( $this->front as $k=>$v ) {
            switch( $v[0] ) {
                case 'front' :
                    if ( is_front_page() ) { 
                        wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
                        if ( array_key_exists( $k, $this->local ) ) {
                            $this->localize( $k );
                        }
                        wp_enqueue_script( $k );
                    }
                    break;
                case 'home' :
                    if ( is_home() ) { 
                        wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
                        if ( array_key_exists( $k, $this->local ) ) {
                            $this->localize( $k );
                        }
                        wp_enqueue_script( $k );
                    }
                    break;
                case 'front-home' :
                case 'home-front' :
                    if ( is_home() && is_front_page() ) { 
                        wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
                        if ( array_key_exists( $k, $this->local ) ) {
                            $this->localize( $k );
                        }
                        wp_enqueue_script( $k );
                    }
                    break;
                default: //NOWORK
            }
        }

        // Add base footer scripts
        foreach ( $this->custom as $k=>$v ) { 
            wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
            if ( array_key_exists( $k, $this->local ) ) {
                $this->localize( $k );
            }
            wp_enqueue_script( $k );
        }

        // Comments
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		    wp_enqueue_script( 'comment-reply' );
	    }
    }

    /**
     * Localize script
     *
     * @param string $key
     * @return void
     */
    private function localize( $key ) {

        // Get local key
        $h = $this->local[$key]; 

        // Validate
        if ( !isset( $h['name'] ) || !isset( $h['trans'] ) ) { return; } 

        // Localize
        wp_localize_script( $key, $h['name'], $h['trans'] ); 
    }

    //----------------------------------------------
    // IE Conditional Scripts 
    //----------------------------------------------

    /**
     * Load IE conditional header scripts
     *
     * @global  $wp_version
     * @global  $wp_scripts
     */
    public function conditional_scripts() {

        global $wp_scripts;
        
        // Enqueue scripts
        wp_enqueue_script( 'html5-shiv', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', [], NULL );
        wp_enqueue_script( 'respond-min', 'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js', [], NULL );

        // Add to global scripts list
        $wp_scripts->add_data( 'html5-shiv', 'conditional', 'lt IE 9' );
        $wp_scripts->add_data( 'respond-min', 'conditional', 'lt IE 9' );
    }

    //----------------------------------------------
    //  Header & Footer Scripts
    //----------------------------------------------

    /**
     * Load inline header scripts
     * - Must have <script></script> wrapper
     */
    public function header_scripts() {

        // Set?
        $scripts = apply_filters( 'ipress_header_scripts', '' );
        if ( empty( $scripts ) ) { return; }
        
        // Capture output
        echo $scripts;
    }

    /**
     * freeform footer scripts
     * - must be full text inside <script></script> wrapper
     */
    public function footer_scripts() {

        // Set?
        $scripts = apply_filters( 'ipress_footer_scripts', '' );
        if ( empty( $scripts ) ) { return; }

        // Capture output
        echo $scripts;
    }

    //----------------------------------------------
    //  Analytics Scripts
    //----------------------------------------------

    /**
     * Load analytics scripts
     * - Must be valid analytics identifier: UA-XXXX
     * - See https://google.com/analytics
     */
    public function analytics_script() {
    
        // Default Analytics code block
        $ga = get_template_part( 'templates/analytics' );

        // Theme mod set? Filterable identifier
        $analytics = apply_filters( 'ipress_analytics', get_theme_mod( 'ipress_analytics', $ga ) );

        // Test valid identifier
        if ( empty( $analytics ) || !preg_match( '/^UA-/', $analytics ) ) { return; }

        // OK, output analytics code
        echo sprintf( $ga, $analytics );
    }
}

// Instantiate Script Loader class
return new IPR_Load_Scripts;

//end
