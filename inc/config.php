<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme config file: actions, filters etc
 * 
 * @package		iPress\Config
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Retrieve theme settings
global $ipress;

//----------------------------------------------
//	Theme SetUp & Configuration
//----------------------------------------------

//----------------------------------------------
//	Theme Scripts
//----------------------------------------------

// Set up scripts - filterable array. See definitions for structure
$ipress_scripts = [

	// Core scripts: [ 'script-name', 'script-name2' ... ]
	'undo' => [],

	// Core scripts: [ 'script-name', 'script-name2' ... ]
	'core' => [ 'jquery' ],

	// External scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
	'external' => [],

	// Header scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
	'header' => [],

	// Footer scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
	'footer' => [],

	// Plugin scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
	'plugins' => [],

	// Page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
	'page' => [],

	// Front page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
	'front' => [],

	// Custom scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ];
	'custom' => [
		'theme' => [ IPRESS_JS_URL . '/theme.js', [ 'jquery' ], NULL ] 
	],

	// Localize scripts: [ 'label' => [ 'name' => name, trans => function/path_url ] ]
	'local' => [
		'theme'		=> [ 
			'name'	=> 'theme', 
			'trans' => [ 
				'home_url' => home_url(), 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'rest_url' => rest_url( '/' ) 
			] 
		]
	]
];

// Initialise scripts
$ipress->scripts->init( $ipress_scripts );

//----------------------------------------------
//	Theme Styles & Fonts
//----------------------------------------------

// Set up scripts - filterable array. See definitions for structure
$ipress_styles = [

	// Core styles: [ 'script-name', 'script-name2' ... ]
	'core' => [],

	// External styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
	'external' => [],

	// Header styles: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ] 
	// 'normalize'	=> [ IPRESS_CSS_URL . '/normalize.min.css', [], NULL ]
	'header' => [],

	// Plugin styles: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
	'plugins' => [],

	// Page styles: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version' ] ... ];
	'page' => [],

	// Theme styles
	'theme'  => [ 
		'ipress' => [ IPRESS_URL . '/style.css', [], NULL ]
	]
];

// Set up custom fonts
$ipress_fonts = [
	
	// Font families: 'OpenSans:300,300i,400,400i,600,600i,800,800i|Roboto:500,700';
	'family' => '',
	
	// Subset: 'latin,latin-ext'
	'subset' => ''
];

// Initialise styles & fonts
$ipress->styles->init( $ipress_styles, $ipress_fonts );

//----------------------------------------------
//	Theme Custom Post Types & Taxonomies
//	
//	@see https://codex.wordpress.org/Function_Reference/register_post_type
//	@see https://codex.wordpress.org/Function_Reference/register_taxonomy
//	
//	$post_types = [ 'cpt' => [ 
//		'name'			=> __( 'CPT', 'ipress' ), 
//		'plural'		=> __( 'CPTs', 'ipress' ),
//		'description'	=> __( 'This is the CPT post type', 'ipress' ), 
//		'supports'		=> [ 'title', 'editor', 'thumbnail' ],
//		'taxonomies'	=> [ 'cpt_tax' ],
//		'args'			=> [], 
//	] ];
//
//	$taxonomies = [ 'cpt_tax' => [ 
//		'name'			=> __( 'Tax Name', 'ipress' ), 
//		'plural'		=> __( 'Taxes', 'ipress' ),
//		'description'	=> __( 'This is the Taxonomy name', 'ipress' ), 
//		'post_types'	=> [ 'cpt' ], 
//		'args'			=> [],
//		'column'		=> true, //optional
//		'sortable'		=> true, //optional
//		'filter'		=> true  //optional
//	] ];
//----------------------------------------------

// Set up custom post types & taxonomies
$post_types = $taxonomies = [];

// Initialise custom post types & taxonomies
$ipress->custom->init( $post_types, $taxonomies );

//----------------------------------------------
//	Shortcode Configuration
//	- Terms & conditions
//	- Privacy
//	- Cookies
//----------------------------------------------

//----------------------------------------------
//	Sidebars Configuration
//----------------------------------------------

//----------------------------------------------
//	Widgets Configuration
//----------------------------------------------

//----------------------------------------------
//	Custom Hooks & Filters
//----------------------------------------------

//------------------------------
// Plugins
// - Woocommerce
// - ACF 
//------------------------------

//--------------------------------------
// Google 
// - Analytics 
// - Adwords Tracking
//--------------------------------------

//end
