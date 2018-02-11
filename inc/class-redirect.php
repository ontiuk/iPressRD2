<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
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
 * Set up redirect features
 */ 
final class IPR_Redirect {

    /**
     * Class constructor
     * - set up hooks
     */
    public function __construct() {
    
        // Login page overrides
//      add_action( 'init',                 [ $this, 'redirect_login_page' ] );
//      add_action( 'wp_login_failed',      [ $this, 'custom_login_failed' ] );
//      add_filter( 'authenticate',         [ $this, 'verify_user_pass' ], 1, 3 );
//      add_action( 'wp_logout',            [ $this, 'logout_redirect'] );
    
    }

    //----------------------------------------------
    //  Redirect Functionality
    //----------------------------------------------

        
    //----------------------------------------------
    //  Custom Login Page
    //----------------------------------------------

    /** 
     * Main redirection of the default login page 
     */
    public function redirect_login_page() {
        
        $login_page  = home_url( '/login/' );
	    $page_viewed = basename($_SERVER['REQUEST_URI']);

    	if ( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    		wp_redirect($login_page);
	    	exit;
	    }
    }

    /**
     * Where to go if a login failed 
     */
    public function custom_login_failed() {
    	$login_page  = home_url( '/login/' );
	    wp_redirect($login_page . '?login=failed');
	    exit;
    }

    /**
     * Where to go if any of the fields were empty 
     */
    public function verify_user_pass( $user, $username, $password ) {
    	$login_page  = home_url( '/login/' );
	    if ( $username == "" || $password == "" ) {
    		wp_redirect( $login_page . "?login=empty" );
	    	exit;
	    }
    }

    /**
     * What to do on logout 
     */
    public function logout_redirect() {
    	$login_page  = home_url( '/login/' );
	    wp_redirect($login_page . "?login=false");
	    exit;
    }
}

// Instantiate Redirect Class
return new IPR_Redirect;

//end
