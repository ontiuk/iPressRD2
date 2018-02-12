iPress RD - WordPress Theme Framework 
=======================================

http://on.tinternet.co.uk

## About

iPress-RD is a Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton such as underscores, bones, and html5blank, as well as the latest default WordPress themes, this uses in the best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Bloat of standard theme initialization configurable.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Simple default theme that can be easily replaced with your own.
- Lots of helpful stuff: helper functions, shortcodes, menus etc.

Note: this was intended primarily a development version for personal & client projects and for understanding how a WordPress theme is structured. 
While it contains a very basic template, it's likely this will be replace all or in part by a more detailed template such as with Bootstrap. 
It's there primarily to show the theme structure and to keep up with WordPress developments.

## Install

1. Upload the theme folder via FTP to your wp-content/themes/ directory.
2. Go to your WordPress dashboard and select Appearance.

## User Manual

I'll be updating this asap with details of available filters.

## Widget Areas

* Primary Sidebar - This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar - This is the widgeted area for the top right of the header.

## Support

Please visit the github page: https://github.com/ontiuk.

## Folder Structure

Out of the box it works as a standard theme with a very basic template. 
Uses a template restructure to move primary files to the route directory.
See https://core.trac.wordpress.org/ticket/13239 for potential/hopeful changes on template structure.

## Other Stuff

This is he precursor to 3 additional themes:
iPress-PT   - Parent Theme. As iPress-RD but with filterable / customisable theme options and a more refined file structure. To be used as a parent theme with customization / setup / styling via a child theme
iPress-PT2  - Parent Theme. As iPress-PT but primary options moved to the theme customizer for greater admin micro management.
iPress-NGx  - Theme Framework integrating iPress with Angular and the WosrPress WP-API

## Hooks - Filters

class-admin.php
-----------------
'ipress_dashboard_post_types' 
- filter: add post-types to "At a glance" Dashboard widget - default []

class-content.php
-----------------
'ipress_starter_content'
- filter: Construct theme starter content - default []

class-customizer.php
-----------------
'ipress_custom_logo_args'
- filter: default args for add_theme_support( 'custom_logo' )

'ipress_custom_header_args'
- filter: default args for add_theme_support( 'custom-header' )

'ipress_custom_background_args'
- filter: default args for add_theme_support( 'custom-background' )

class-content.php
-----------------
'ipress_default_layout'
- filter: content layout - default 'left' or 'right'

class-images.php
-----------------
'ipress_media_images'
- filter: Image size media editor support - default []

'ipress_media_images_sizes'
- filter: Default image sizes support - default sizes []

'ipress_upload_mimes'
- filter: Mime type support - default [] add svg

'ipress_gravatar'
- filter: (Gr)Avatar support - default []


class-init.php
-------------------
'ipress_header_clean'
- filter: Activate the WP header clean up - default false

'ipress_login_info'
- filter: failed login security message - default string

'ipress_disable_emojicons' 
- filter: disable theme emojicon support - default true 

'ipress_admin_bar'
- filter: hide the admin bar - default false

class-jetpack.php
-------------------
'ipress_jetpack_site_logo_args'
- filter: default args for add_theme_support( 'site-logo' )

'ipress_jetpack_infinite_scroll'
- filter: default args for add_theme_support( 'infinite-scroll' )

class-layout.php
-------------------
'ipress_theme_direction'
- filter: theme layout direction - default ''

'ipress_body_class'
- filter: add body class attributes - default []

'ipress_read_more_link'
- filter: read more link - default false

'ipress_view_more'
filter - custom view more link - default false

'ipress_view_more_link'
filter - custom view more link - default false

'ipress_embed_video'
filter - embed video html - default false

class-load-scripts.php
-----------------------
'ipress_header_scripts'
- filter: Apply header scripts - default ''

'ipress_footer_scripts'
- filter: Apply footer scripts - default ''

'ipress_analytics_scripts'
- filter: Apply analytics scripts - default ''

class-load-styles.php
-----------------------
'ipress_show_conditional' ( deprecated )
- filter: Apply contitional styles - default false

'ipress_header_styles'
- filter: Apply inline header styles - default ''

class-page.php
-------------------
'ipress_page_excerpt'
filter - page excerpt support: default false

'ipress_page_tags'
filter - page tags support: default false

'ipress_page_tags_query', false
filter - add page tags to query: default false

'ipress_search_types'
filter - add post-types to WordPress front search - default []

class-query.php
-------------------
'ipress_query_post_type_archives'
filter - pre_get_posts customize search query for post-type taxonomy terms - default []

'ipress_exclude_category'
- filter - Exclude categories from display - default Uncategorised ['-1']

'ipress_query_search_include'
- filter - Include post-types in search query - default []

class-rewrites.php
-------------------
'ipress_query_vars'
- filter: add new query vars - default []

class-sidebars.php
-------------------
'ipress_sidebar_xxx_defaults'
filter - dynamic sidebar defaults 

'ipress_default_sidebars'
filter - default sidebars: default [ primary...]

'ipress_footer_sidebars'
filter - footer sidebars: default []

'ipress_custom_sidebars'
filter - custom sidebars: default []

class-theme.php
-------------------
'ipress_content_width'
- filter: content width: default 840

'ipress_post_thumb_size'
- filter: Set thumbnail default size: width, height, crop - default []

'ipress_image_size_default'
- filter: Core image sizes overrides - default []

'ipress_add_image_size'
- filter: Add custom image sizes - default []

'ipress_nav_menus'
- filter: Register navigation menu locations - default [ 'primary' ]

'ipress_html5'
- filter: Enable support for HTML5 markup - default [x6]

'ipress_document_title_separator'
- filter: document title separator - default '-'

'ipress_home_doctitle_append'
- filter: append site description to title on homepage - default true

'ipress_doctitle_separator'
- filter: title separator - default ''

'ipress_append_site_name'
filter: append site name to inner pages - default true

class-widgets.php
-------------------
'ipress_widgets'
filter: custom widgets - default []

