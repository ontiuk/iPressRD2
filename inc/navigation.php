<?php 

/**
 * iPress - WordPress Base Theme                       
 * ==========================================================
 *
 * Theme navigation functions & functionality
 * 
 * @package     iPress\Navigation
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
//  Menu & Navigation Functionality
// 
// - ipress_has_nav_menu
// - ipress_has_nav_location_menu
// - ipress_has_menu
// - ipress_get_nav_menu_items
// - ipress_nav_menu_items
// - ipress_get_menu_nav
// - ipress_menu_nav
// - ipress_get_menu
// - ipress_menu
// - ipress_menu_subnav
// - ipress_nav_menu
// - ipress_get_nav_menu
// - ipress_nav_menu_location
// - ipress_mega_nav
// - ipress_get_mega_nav
// 
//----------------------------------------------

/**
 * Determine if a theme supports a particular menu location 
 * - Case sensitive, so camel-case location
 * - Alternative to has_nav_menu
 *
 * @param  string $location
 * @return boolean 
 */
function ipress_has_nav_menu( $location ) {

    // Set the menu name
    if ( empty( $location ) ) { return false; }

    // Retrieve registered menu locations
    $locations = array_keys( get_nav_menu_locations() );

    // Test location correctly registered
    return in_array( $location, $locations );
}

/**
 * Determine if a theme supports a particular menu location & menu combination
 * - Case sensitive, so camel-case location & menu
 *
 * @param   string $location
 * @param   string $menu 
 * @param   string $route slug or name default name
 * @return boolean 
 */
function ipress_has_nav_location_menu( $location, $menu, $route='name' ) {

    // Set the menu name
    if ( empty( $location ) || empty( $menu ) ) { return false; }

    // Retrieve registered menu locations
    $locations = get_nav_menu_locations();

    // Test location correctly registered
    if ( !array_key_exists( $location, $locations ) ) { return false; }

    // Get location menu 
    $term = get_term( (int)$locations[$location], 'nav_menu' );

    // Test menu
    return ( $route == 'slug' ) ? ( $term->slug === $menu ): ( $term->name === $menu ); 
}

/**
 * Determine if a theme has a particular menu registered
 * - Case sensitive, so camel-case menu
 *
 * @param  string $menu
 * @return boolean 
 */
function ipress_has_menu( $menu ) {

    // Set the menu name
    if ( empty( $menu ) ) { return false; }

    // Retrieve registered menu locations
    $menus = wp_get_nav_menus();

    // None registered
    if ( empty( $menus ) ) { return false; }

    // Registered
    foreach ( $menus as $m ) {
        if ( $menu === $m->name ) { return true; }
    }

    // Default
    return false;
}

/**
 * Retrieve menu items for a menu by location
 *
 * @param  string $menu Name of the menu location
 * @return array
 */
function ipress_get_nav_menu_items( $menu ) {

    // Set the menu name
    if ( empty( $menu ) ) { return false; }

    // Retrieve registered menu locations
    $locations = get_nav_menu_locations();

    // Test menu is correctly registered
    if ( !isset( $locations[ $menu ] ) ) { return false; }

    // Retrieve menu set against location
    $menu = wp_get_nav_menu_object( $locations[ $menu ] );
    if ( false === $menu ) { return false; }

    // Retrieve menu items from menu
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    // No menu items?
    return ( empty( $menu_items ) ) ? false : $menu_items;
}

/**
 * Output menu items for a menu by location
 *
 * @param  string $menu Name of the menu location
 * @return array
 */
function ipress_nav_menu_items( $menu ) {
    echo ipress_get_nav_menu_items( $menu );
}

/**
 * Navigation display via locations
 *
 * @param   string  $menu_name
 * @param   array   $args
 */
function ipress_get_menu_nav( $location, $args=[] ) {

    $defaults = [
        'class'         => '',
        'itemclass'     => '',
        'subclass'      => '',
        'submenuclass'  => '',
        'subclass2'     => '',
        'submenuclass2' => ''
    ];

    // Set the menu name
    if ( empty( $location ) ) { return; }

    // Parse args and merge with defaults
    $args = wp_parse_args( $args, $defaults );

    // Retrieve registered menu locations
    $locations = get_nav_menu_locations();

    // Registered menu at location
    if ( ! has_nav_menu( $location ) ) { return; }

    // Retrieve menu set against location
    $menu = wp_get_nav_menu_object( $locations[ $location ] );
    if ( false === $menu ) { return; }

    // Retrieve menu items from menu
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    // No menu items?
    if ( empty( $menu_items ) ) { return; }

    // Structure list class
    if ( !empty( $args['class'] ) ) {
        $class = ( is_array( $args['class'] ) ) ? join( ' ', $args['class'] ) : trim( $args['class'] );
        $class = ( empty( $class ) ) ? '' : sprintf( 'class="%s">', $class );
    } else { $class = ''; }
    
    // Start menu... modify classes
    $menu_wrap_open = sprintf( '<ul id="menu-%s" %s>', $menu->name, $class );
    $menu_wrap_close = '</ul>'; 

    // Add list items
    $count = 0; 
    $menu_list = '';
    foreach ( (array) $menu_items as $key => $menu_item ) {        

        // Parent?
        if ( $menu_item->menu_item_parent > 0 ) { continue; }

        // Submenu?
        $submenu = ipress_menu_subnav( $menu_items, $menu_item->ID );
        
        // Menu class
        $item_class = ( empty( $args['itemclass'] ) ) ? array_filter( $menu_item->classes ) : [ $args['itemclass'] ];

        // Submenu?
        if ( $submenu ) {
            $subclass = ( isset( $args['subclass'] ) && !empty( $args['subclass'] ) ) ? $args['subclass'] : '';
            $submenuclass = ( isset( $args['submenuclass'] ) && !empty( $args['submenuclass'] ) ) ? sprintf( ' class="%s"', $args['submenuclass'] ) : '';
            $item_class[] = $subclass;
        }

        // Set up class
        $class  = ( empty( $item_class ) ) ? '' : sprintf( ' class="%s"', join( ' ', $item_class ) );

        // Menu construct
        $menu_list_item  = sprintf( '<li%s>', $class );
        $menu_list_item .= sprintf( '<a href="%s">%s</a>', $menu_item->url, $menu_item->title );

        // Submenu?
        if ( $submenu ) {
            $menu_list_item2 = sprintf( '<ul%s>', $submenuclass );
            foreach ( $submenu as $k=>$m ) {

                // Submenu2?
                $submenu2 = ipress_menu_subnav( $menu_items, $m->ID );
                if ( $submenu2 ) {
                    $subclass2 = ( isset( $args['subclass2'] ) && !empty( $args['subclass2'] ) ) ? sprintf( ' class="%s"', $args['subclass2'] ) : '';
                    $submenuclass2 = ( isset( $args['submenuclass2'] ) && !empty( $args['submenuclass2'] ) ) ? sprintf( ' class="%s"', $args['submenuclass2'] ) : '';
                }

                // Menu construct
                $menu_list_item2 .= ( $submenu2 ) ? sprintf( '<li%s>', $subclass2 ) : '<li>';
                $menu_list_item2 .= sprintf( '<a href="%s">%s</a>', $m->url, $m->title );

                // Submenu2?
                if ( $submenu2 ) {
                    $menu_list_item3 = sprintf( '<ul%s>', $submenuclass2 );
                    foreach ( $submenu2 as $k2=>$m2 ) {
                        $menu_list_item3 .= sprintf( '<li><a href="%s">%s</a></li>', $m2->url, $m2->title );
                    }
                    $menu_list_item2 .= $menu_list_item3 . '</ul>';
                }

                $menu_list_item2 .= '</li>';
            }
            $menu_list_item .= $menu_list_item2 . '</ul>';
        }

        $menu_list .= $menu_list_item . '</li>';
    }

    // Construct nav output
    $nav_output = $menu_wrap_open . $menu_list . $menu_wrap_close;
    $filter_location = sprintf( 'ipress_%s_menu_nav', $location );

    // filter the navigation markup
    return apply_filters( $filter_location, $nav_output, $location, $args );
}

/**
 * Navigation display via locations 
 *
 * @param   string  $menu_name
 * @param   array   $args
 */
function ipress_menu_nav( $location = '', $args = [] ) {
    echo ipress_get_menu_nav( $location, $args );
}

/**
 * Navigation display via locations
 *
 * @param   string  $menu_name
 * @param   array   $args
 */
function ipress_get_menu( $menu_name, $args = [] ) {

    $defaults = [
        'class'         => '',
        'subclass'      => '',
        'submenuclass'  => '',
        'subclass2'     => '',
        'submenuclass2' => ''
    ];

    // Set the menu name
    if ( empty( $menu_name ) ) { return; }

    // Parse args and merge with defaults
    $args = wp_parse_args( $args, $defaults );

    // Registered menu
    if ( ! ipress_has_menu( $menu_name ) ) { return; }

    // Retrieve menu set against location
    $menu = wp_get_nav_menu_object( $menu_name );
    if ( false === $menu ) { return; }

    // Retrieve menu items from menu
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    // No menu items?
    if ( empty( $menu_items ) ) { return; }

    // Structure list class
    if ( !empty( $args['class'] ) ) {
        
        // Array or string
        $class = ( is_array( $args['class'] ) ) ? join( ' ', $args['class'] ) : trim( $args['class'] );
        $class = ( empty( $class ) ) ? '' : sprintf( 'class="%s">', $class );

    } else { $class = ''; }

    // Start menu... modify classes
    $menu_wrap_open = sprintf( '<ul id="menu-%s" %s>', $menu_name, $class );
    $menu_wrap_close = '</ul>'; 

    // Add list items
    $count = 0; 
    $menu_list = '';
    foreach ( (array) $menu_items as $key => $menu_item ) {        

        // Parent?
        if ( $menu_item->menu_item_parent > 0 ) { continue; }

        // Submenu?
        $submenu = ipress_menu_subnav( $menu_items, $menu_item->ID );
        
        // Menu class
        $item_class = array_filter( $menu_item->classes );

        // Submenu?
        if ( $submenu ) {
            $subclass = ( isset( $args['subclass'] ) && !empty( $args['subclass'] ) ) ? $args['subclass'] : '';
            $submenuclass = ( isset( $args['submenuclass'] ) && !empty( $args['submenuclass'] ) ) ? sprintf( ' class="%s"', $args['submenuclass'] ) : '';
            $item_class[] = $subclass;
        }

        // Set up class
        $class  = ( empty( $item_class ) ) ? '' : sprintf( ' class="%s"', join( ' ', $item_class ) );

        // Menu construct
        $menu_list_item  = sprintf( '<li%s>', $class );
        $menu_list_item .= sprintf( '<a href="%s">%s</a>', $menu_item->url, $menu_item->title );

        // Submenu?
        if ( $submenu ) {

            // Menu construct
            $menu_list_item2 = sprintf( '<ul%s>', $submenuclass );
            foreach ( $submenu as $k=>$m ) {

                // Submenu2?
                $submenu2 = ipress_menu_subnav( $menu_items, $m->ID );
                if ( $submenu2 ) {
                    $subclass2 = ( isset( $args['subclass2'] ) && !empty( $args['subclass2'] ) ) ? sprintf( ' class="%s"', $args['subclass2'] ) : '';
                    $submenuclass2 = ( isset( $args['submenuclass2'] ) && !empty( $args['submenuclass2'] ) ) ? sprintf( ' class="%s"', $args['submenuclass2'] ) : '';
                }

                // Menu construct
                $menu_list_item2 .= ( $submenu2 ) ? sprintf( '<li%s>', $subclass2 ) : '<li>';
                $menu_list_item2 .= sprintf( '<a href="%s">%s</a>', $m->url, $m->title );

                // Submenu2?
                if ( $submenu2 ) {
                    $menu_list_item3 = sprintf( '<ul%s>', $submenuclass2 );
                    foreach ( $submenu2 as $k2=>$m2 ) {
                        $menu_list_item3 .= sprintf( '<li><a href="%s">%s</a></li>', $m2->url, $m2->title );
                    }
                    $menu_list_item2 .= $menu_list_item3 . '</ul>';
                }

                $menu_list_item2 .= '</li>';
            }
            $menu_list_item .= $menu_list_item2 . '</ul>';
        }

        $menu_list .= $menu_list_item . '</li>';
    }

    // Construct nav output
    $nav_output = $menu_wrap_open . $menu_list . $menu_wrap_close;
    $filter_location = sprintf( 'ipress_%s_menu', $menu_name );

    // Filter the navigation markup.
    return apply_filters( $filter_location, $nav_output, $menu_name, $args );
}

/**
 * Navigation display via menu
 *
 * @param   string  $menu_name
 * @param   array   $args
 */
function ipress_menu( $menu = '', $args = [] ) {
    echo ipress_get_menu( $menu, $args );
}

/**
 * Submenu items for parent menu
 *
 * @param   array   $menu
 * @param   string  $menu
 */  
function ipress_menu_subnav( $menu, $parent ) {

    // Subnav items
    $nav = [];

    // Has parent?        
    foreach ( $menu as $k=>$m ) {
        if ( (int)$m->menu_item_parent === $parent ) { 
            $nav[] = $menu[$k]; 
        }
    }

    // Has menu
    return ( empty( $nav ) ) ? false : $nav;   
}

/**
 * Navigation display via generic menu function
 *
 * @param   array $args
 */
function ipress_nav_menu( $args = [] ) {
    echo ipress_get_nav_menu( $args );
}

/**
 * Navigation display via generic menu function
 *
 * @param   array $args
 * @return  string
 */
function ipress_get_nav_menu( $args = [] ) {

    $defaults = [
        'theme_location' => '',
        'menu'           => '',
        'container'      => '',
        'menu_class'     => 'menu nav-menu',
        'link_before'    => '<span class="nav-link">',
        'link_after'     => '</span>',
        'nav-wrap'       => false,
        'echo'           => false
    ];

    // Parse args and merge with defaults
    $args = wp_parse_args( $args, $defaults );

    // No menu assigned to theme location?
    if ( ! has_nav_menu( $args['theme_location'] ) ) { return; }

    // Slugify the location for css
    $location = sanitize_key( $args['theme_location'] );

    // Generic nav menu functionality
    $nav = wp_nav_menu( $args );

    // No nav?
    if ( ! $nav ) { return; }

    // Nav container override
    if ( empty( $args['container'] ) ) {
        $nav_markup_open    = sprintf( '<nav %s>', 'nav-' . $location );
        $nav_markup_close   = '</nav>';
    } else {
        $nav_markup_open = $nav_markup_open = '';
    }

    // Construct nav output
    $nav_output = ( $args['nav-wrap'] ) ? $nav_markup_open . $nav . $nav_markup_close : $nav;
    $filter_location = sprintf( 'ipress_%s_nav_menu', $location );

    // Filter the navigation markup
    return apply_filters( $filter_location, $nav_output, $nav, $args );
}

/**
 * Navigation display via generic menu function
 *
 * @param   string  menu location
 */
function ipress_nav_menu_location( $route ) {

    // Defaults    
    $args = [
        'theme_location' => $route,
        'menu_class'     => sprintf( 'menu nav-menu menu-%s', $route ),
        'nav-wrap'       => false
    ];

    // Output nav menu
    echo ipress_get_nav_menu( $args );
}

/**
 * MegaNav via locations & menu
 *
 * @param   string  $menu_name
 * @param   array   $args
 * @return  string
 */
function ipress_mega_nav( $menu_name, $args = [] ) {
    echo ipress_get_mega_nav( $menu_name, $args );
}

/**
 * MegaNav via locations & menu
 *
 * @param   string  $menu_name
 * @param   array   $args
 * @return  string
 */
function ipress_get_mega_nav( $menu_name, $args = [] ) {

    // Defaults
    $defaults = [
        'class'         => '',
        'subclass'      => '',
        'submenuclass'  => '',
        'cols'          => 4
    ];

    // Set the menu name
    if ( empty( $menu_name ) ) { return; }

    // Parse args and merge with defaults
    $args = wp_parse_args( $args, $defaults );

    // Registered menu
    if ( ! ipress_has_menu( $menu_name ) ) { return; }

    // Retrieve menu set against location
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    if ( false === $menu ) { return; }

    // Retrieve menu items from menu
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    // No menu items?
    if ( empty( $menu_items ) ) { return; }

    // Structure list class
    if ( !empty( $args['class'] ) ) {
        $class = ( is_array( $args['class'] ) ) ? join( ' ', $args['class'] ) : trim( $args['class'] );
        $class = ( empty( $class ) ) ? '' : sprintf( 'class="%s">', $class );

    } else { $class = ''; }

    // Start menu... modify classes
    $menu_list_open = sprintf( '<ul id="menu-%s" %s>', $menu_name, $class );
    $menu_list_close = '</ul>'; 

    // Add list items
    $count = 0;
    $menu_list = '';
    foreach ( (array) $menu_items as $key => $menu_item ) {        

        // Parent?
        if ( $menu_item->menu_item_parent > 0 ) { continue; }

        // Submenu?
        $submenu = ipress_menu_subnav( $menu_items, $menu_item->ID );
        
        // Menu class
        $item_class = array_filter( $menu_item->classes );

        // Submenu?
        if ( $submenu ) {
            $subclass = 'class="column-' . $args['cols'] . '"'; 
            $item_class[] = 'has-mega-menu';
            if ( isset( $args['subclass'] ) && !empty( $args['subclass'] ) ) {  
                $item_class[] = $args['subclass']; 
            }
        }

        // Set up class
        $class  = ( empty( $item_class ) ) ? '' : sprintf( ' class="%s"', join( ' ', $item_class ) );

        // Menu construct
        $menu_list_item  = sprintf( '<li%s>', $class );

        // Start list
        if ( $submenu ) {
            $menu_list_item .= sprintf( '<a href=#>%s</a>', $menu_item->title );
            $menu_list_item2 = '<div class="mega-menu">';

            // Calculate rows
            $items = count( $submenu );
            $rows = ( $items%$args['cols'] == 0 ) ? intval( $items / $args['cols'] ) : intval( $items / $args['cols'] ) + 1;

            for( $c=0; $c < $args['cols']; $c++ ) {
            
                $menu_list_item3 = sprintf( '<ul %s>', $subclass );

                for ( $r=0; $r < $rows; $r++ ) {
                    $mc = ( $c ) + ( $r * $args['cols'] );
                    if ( $mc >= $items ) { break; }
                    $menu_list_item3 .= sprintf( '<li><a href="%s">%s</a></li>', $submenu[$mc]->url, $submenu[$mc]->title );
                }
                
                $menu_list_item3 .= '</ul>';
                $menu_list_item2 .= $menu_list_item3;      
            }
            $menu_list_item .= $menu_list_item2 . '</div>';

        } else {
            $menu_list_item .= sprintf( '<a href="%s">%s</a>', $menu_item->url, $menu_item->title );
        }

        $menu_list .= $menu_list_item . '</li>';
    }

    // Finish menu    
    $menu_list .= '</ul>';

    // Output menu
    echo $menu_list;
}

//end
