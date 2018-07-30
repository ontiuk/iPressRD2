<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme specific custom post-type and taxonomy initialization
 * 
 * @package		iPress\Includes
 * @link		http://ipress.co.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Custom' ) ) :

	/**
	 * Set up custom post-types & taxonomies
	 */ 
	class IPR_Custom {

		/**
		 * Post Type Reserved Names
		 *
		 * @var array $post_type_reserved	
		 */
		protected $post_type_reserved = [ 
			'post', 'page', 'attachment', 'revision', 
			'nav_menu_item', 'custom_css', 'customize_changeset', 
			'action', 'author', 'order', 'theme'
		];

		/**
		 * Taxonomy Reserved Terms
		 *
		 * @var array $taxonomy_reserved
		 */
		protected $taxonomy_reserved = [
			'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat',
			'category', 'category__and', 'category__in', 'category__not_in', 'category_name',
			'comments_per_page', 'comments_popup', 'customize_messenger_channel', 'customized',
			'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'fields', 'hour', 'link_category',	
			'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nonce', 'nopaging', 'offset',
			'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post',
			'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag',
			'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots',
			's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id',
			'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in',
			'taxonomy', 'tb', 'term', 'theme', 'type', 'w', 'withcomments', 'withoutcomments', 'year'
		];

		/**
		 * Post Types
		 *
		 * @var array $post_types
		 */
		protected $post_types = [];

		/**
		 * Taxonomies
		 *
		 * @var array $taxonomies
		 */
		protected $taxonomies = [];

		/**
		 * Post Types Errors
		 *
		 * @var array $post_types
		 */
		protected $post_type_errors = [];

		/**
		 * Taxonomy Errors
		 *
		 * @var array $taxonomy_errors
		 */
		protected $taxonomy_errors = [];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'register_post_types' ] ); 

			// Generate & register taxonomies
			add_action( 'init', [ $this, 'register_taxonomies' ] ); 

			// Flush rewrite rules after theme activation
			add_action( 'after_switch_theme', [ $this, 'flush_rewrite_rules' ] );

			// Post-type & taxonomy error messages
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		}

		//----------------------------------------------
		//	Initialise Variables
		//----------------------------------------------
		
		/**
		 * Initialise Post Types & Taxonomies
		 *
		 * @param array $post_types
		 * @param array $taxonomies
		 */
		public function init( $post_types, $taxonomies ) {

			// Register post-types
			$this->post_types = (array) $post_types;

			// Register taxonomies
			$this->taxonomies = (array) $taxonomies;

			// Post-type - taxonomy columns & filters
			$this->taxonomy_columns();
		}
		
		//----------------------------------------------
		//	Register Custom Post Types
		//----------------------------------------------

		/**
		 * Register Custom Post Type
		 * @see https://codex.wordpress.org/Function_Reference/register_post_type
		 *
		 * $post_types = [ 'cpt' => [ 
		 *		 'name'			 => __( 'CPT', 'ipress' ), 
		 *		 'plural'		 => __( 'CPTs', 'ipress' ),
		 *		 'description'	 => __( 'This is the CPT post-type', 'ipress ), 
		 *		 'supports'		 => [ 'title', 'editor', 'thumbnail' ],
		 *		 'taxonomies	 => [ 'cpt_tax' ],
		 *		 'args'			 => [], 
		 * ] ];
		 */
		public function register_post_types() {

			// Iterate custom post-types...
			foreach ( $this->post_types as $k=>$v ) {

				// Sanitize post-type... a-z_- only
				$post_type = sanitize_key( str_replace( ' ', '_', $k ) );

				// Sanity checks - reserved words and max post-type length
				if ( in_array( $post_type, $this->post_type_reserved ) || strlen( $post_type ) > 20 ) { 
					$this->post_type_errors[] = $post_type;
					continue; 
				}		 

				// Set up singluar & plural
				$singular		= ( isset( $v['name'] ) && !empty( $v['name'] ) ) ? ucwords( $v['name'] ) : ucwords( str_replace( '_', ' ', $post_type ) );
				$plural			= ( isset( $v['plural'] ) && !empty( $v['plural'] ) ) ? ucwords( $v['plural'] ) : $singular . 's'; 
				$description	= ( isset( $v['description'] ) && !empty( $v['description'] ) ) ? ucfirst( $v['description'] ) : 'This is the ' . $singular . ' post-type';
			
				// Set up post-type labels - Rename to suit, common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
				$labels = [
					'name'					=> sprintf( _x( '%s', 'Post type general name', 'ipress' ), $plural ),
					'singular_name'			=> sprintf( _x( '%s', 'Post type singular name', 'ipress' ), $singular ),
					'menu_name'				=> sprintf( _x( '%s', 'Admin menu text', 'ipress' ), $plural ),
					'add_new'				=> sprintf( _x( 'Add New', '%s', 'ipress' ), $singular ),
					'add_new_item'			=> sprintf( __( 'Add New %s', 'ipress' ), $singular ),
					'edit_item'				=> sprintf( __( 'Edit %s', 'ipress' ), $singular ),
					'new_item'				=> sprintf( __( 'New %s', 'ipress' ), $singular ),
					'view_item'				=> sprintf( __( 'View %s', 'ipress' ), $singular ),
					'view_items'			=> sprintf( __( 'View %s', 'ipress' ), $plural ),
					'search_items'			=> sprintf( __( 'Search %s', 'ipress' ), $plural ),
					'not_found'				=> sprintf( __( 'No %s found', 'ipress' ), $plural ),
					'not_found_in_trash'	=> sprintf( __( 'No %s found in Trash', 'ipress' ), $plural ),
					'parent_item_colon'		=> sprintf( __( 'Parent %s:', 'ipress' ), $singular ),
					'all_items'				=> sprintf( __( 'All %s', 'ipress' ), $plural ), 
					'archives'				=> sprintf( __( '%s Archives', 'ipress' ), $singular ),
					'attributes'			=> sprintf( __( '%s Attributes', 'ipress' ), $singular ),
					'insert_into_item'		=> sprintf( __( 'Insert into %s', 'ipress' ), $singular ),
					'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'ipress' ), $singular ),
					'featured_image'		=> sprintf( __( '%s Featured Image', 'ipress' ), $singular ),
					'set_featured_image'	=> sprintf( __( 'Set %s Featured Image', 'ipress' ), $singular ),
					'remove_featured_image' => sprintf( __( 'Remove %s Featured Image', 'ipress' ), $singular ),
					'use_featured_image'	=> sprintf( __( 'Use %s Featured Image', 'ipress' ), $singular ),
					'filter_items_list'		=> sprintf( __( 'Filter %s list', 'ipress' ), $plural ),
					'items_list_navigation' => sprintf( __( '%s list navigation', 'ipress' ), $plural ), 
					'items_list'			=> sprintf( __( '%s list', 'ipress' ), $plural ),
					'name_admin_bar'		=> sprintf( __( '%s', 'ipress' ), $singular )
				];

				// Set up post-type support - default: 'title', 'editor', 'thumbnail'
				$supports = ( isset( $v['supports'] ) && is_array( $v['supports'] ) && !empty( $v['supports'] ) ) ? $v['supports'] : [
					'title',
					'editor',
					'thumbnail'
				];
		
				// Set up post-type args - common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
				$defaults = ( isset( $v['args'] ) && is_array( $v['args'] ) && ! empty( $v['args'] ) ) ? $v['args'] : [];
				$args = array_merge( [
					'labels'		=> $labels,
					'public'		=> true,
					'has_archive'	=> sanitize_title( $plural ),
					'supports'		=> $supports
				], $defaults );
		
				// Associated taxonomies... still need to explicitly register with 'register_taxonomy'
				$taxonomies = ( isset( $v['taxonomies'] ) && is_array( $v['taxonomies'] ) && ! empty( $v['taxonomies'] ) ) ? $v['taxonomies'] : '';
				if ( ! empty( $taxonomies ) ) {
					$args['taxonomies'] = $taxonomies;
				}
		
				// Register new post-type
				register_post_type( $post_type, $args );
			}
		}

		//----------------------------------------------
		//	Register Taxonomies
		//----------------------------------------------

		/**
		 * Register taxonomies & assign to post-types
		 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
		 * 
		 *	$taxonomies = [ 'cpt_tax' => [ 
		 *		'name'			=> __( 'Tax Name', 'ipress' ), 
		 *		'plural'		=> __( 'Taxes', 'ipress' ),
		 *		'description'	=> __( 'This is the Taxonomy name', 'ipress' ), 
		 *		'post_types'	=> [ 'cpt' ], 
		 *		'args'			=> [],
		 *		'column'		=> true, //optional
		 *		'sortable'		=> true, //optional
		 *		'filter'		=> true  //optional
		 *	] ];
		 */
		public function register_taxonomies() {

			// Iterate taxonomies...
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Sanity checks - reserved words and maximum taxonomy length
				if ( in_array( $taxonomy, $this->taxonomy_reserved ) || strlen( $taxonomy ) > 32 ) { 
					$this->taxonomy_errors[] = $taxonomy;
					continue; 
				}

				// Set up singluar & plural
				$singular	 = ( isset( $v['name'] ) && ! empty( $v['name'] ) ) ? ucwords( $v['name'] ) : ucwords( str_replace( [ '_', '-' ], ' ', $taxonomy ) );
				$plural		 = ( isset( $v['plural'] ) && !empty( $v['plural'] ) ) ? ucwords( $v['plural'] ) : $singular . 's'; 
				$description = ( isset( $v['description'] ) && ! empty( $v['description'] ) ) ? ucfirst( $v['description'] ) : 'This is the ' . $singular . ' taxonomy';
	 
				// Set up taxonomy labels
				$labels = [
					'name'				=> sprintf( _x( '%s', 'ipress' ), $plural ), 
					'singular_name'		=> sprintf( _x( '%s', 'ipress' ), $singular ), 
					'menu_name'			=> sprintf( __( '%s', 'ipress' ), $singular ), 
					'all_items'			=> sprintf( __( 'All %s', 'ipress' ), $plural ), 
					'edit_item'			=> sprintf( __( 'Edit %s', 'ipress' ), $singular ), 
					'view_item'			=> sprintf( __( 'View %s', 'ipress' ), $singular ), 
					'update_item'		=> sprintf( __( 'Update %s', 'ipress' ), $singular ), 
					'add_new_item'		=> sprintf( __( 'Add New %s', 'ipress' ), $singular ), 
					'new_item_name'		=> sprintf( __( 'New %s Name', 'ipress' ), $singular ), 
					'parent_item'		=> sprintf( __( 'Parent %s', 'ipress' ), $singular ), 
					'parent_item_colon' => sprintf( __( 'Parent %s:', 'ipress' ), $singular ), 
					'search_items'		=> sprintf( __( 'Search %s', 'ipress' ), $plural ), 
					'popular_items'		=> sprintf( __( 'Popular %s', 'ipress' ), $plural ), 
					'not_found'			=> sprintf( __( 'No %s found', 'ipress' ), $plural ), 
					'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'ipress' ), $plural ), 
					'add_or_remove_items'		 => sprintf( __( 'Add or remove %s', 'ipress' ), $plural ), 
					'choose_from_the_most_used'  => sprintf( __( 'Chose from the most used %s', 'ipress' ), $plural ) 
				];

				// Set up taxonomy args
				$defaults = ( isset( $v['args'] ) && is_array( $v['args'] ) && ! empty( $v['args'] ) ) ? $v['args'] : [];
				$args = array_merge( [
					'label'				=> $plural,
					'labels'			=> $labels,
					'public'			=> true,
					'description'		=> $description, 
					'rewrite'			=> [ 'slug' => sprintf( __( '%s', 'ipress' ), $taxonomy ), 'with_front' => false ]
				], $defaults );

				// Post-type taxonomy column
				if ( isset( $v['column'] ) && $v['column'] === true ) {
					$args['show_admin_column'] = true;			
				}

				// Assign to post-types?
				$post_types = ( isset( $v['post_types'] ) && is_array( $v['post_types'] ) && ! empty( $v['post_types'] ) ) ? $v['post_types'] : [];

				// Register taxonomy
				register_taxonomy( $taxonomy, $post_types, $args );
			}	
		}

		//----------------------------------------------
		//	Post Type Taxonomy Columns & Filters
		//----------------------------------------------
		
		/**
		 * Taxonomy columns and filters
		 */
		protected function taxonomy_columns() {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k=>$v ) {

				// Assign to post-types required
				if ( ! isset( $v['post_types'] ) || ! is_array( $v['post_types'] ) || empty( $v['post_types'] ) ) { continue; }
				  
				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Post-type taxonomy column
				if ( isset( $v['column'] ) && $v['column'] === true ) {

					// Sortable?
					if ( isset( $v['sortable'] ) && $v['sortable'] === true ) {

						// Get post-types
						foreach ( $v['post_types'] as $post_type ) {
				
							// Sanitize post-type... a-z_- only
							$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

							add_filter( 'manage_edit-' . $post_type . '_sortable_columns', [ $this, 'sortable_columns' ] ); 
							add_filter( 'posts_clauses', [ $this, 'sort_column' ], 10, 2 );
						}
					}
				}

				// Post-type taxonomy filter
				if ( isset( $v['filter'] ) && $v['filter'] === true ) {
					add_action( 'restrict_manage_posts', [ $this, 'post_type_filter' ] ); 
					add_filter( 'parse_query', [ $this, 'post_type_filter_query' ] );
				}
			}
		}

		/**
		 * Make filter column sortable
		 * 
		 * @param	array $columns
		 * @return	array
		 */
		public function sortable_columns( $columns ) {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Post-type taxonomy column
				if ( isset( $v['column'] ) && $v['column'] === true ) {

					// Sortable?
					if ( isset( $v['sortable'] ) && $v['sortable'] === true ) {

						// Set column key
						$column_key = 'taxonomy-' . $taxonomy;

						// Add filter column to sortable list
						$columns[ $column_key ] = $taxonomy;		
					}
				}
			}
			
			return $columns;	
		}

		/** 
		 * Sort custom taxonomy columns as required 
		 * 
		 * @param array $pieces 
		 * @param array $wp_query 
		 * 
		 * @return array 
		 */ 
		public function sort_column( $pieces, $query ) { 

			global $wpdb; 

			// Ordering set?
			$orderby = $query->get( 'orderby' ); 
			if ( empty( $orderby ) ) { return $pieces; }
				
			// Only if admin main query
			if ( is_admin() && $query->is_main_query() ) {

				// Taxonomy columns & filters
				foreach ( $this->taxonomies as $k=>$v ) {

					// Sanitize taxonomy... a-z_- only
					$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

					// Filter?
					if ( isset( $v['filter'] ) && $v['filter'] === true ) {

						// Matching taxonomy
						if ( $orderby === $taxonomy ) { 
							
							$order = ( strtoupper( $query->get( 'order' ) ) != 'DESC' ) ? 'ASC': 'DESC';

							// Construct sql
							$pieces['join'] .= ' LEFT OUTER JOIN ' . $wpdb->term_relationships . ' as tr ON ' . $wpdb->posts . '.ID = tr.object_id
												 LEFT OUTER JOIN ' . $wpdb->term_taxonomy . ' as tt USING (term_taxonomy_id)
												 LEFT OUTER JOIN ' . $wpdb->terms . ' as t USING (term_id)';
							$pieces['where']	.= ' AND ( tt.taxonomy = "' . $taxonomy . '" OR tt.taxonomy IS NULL)';
							$pieces['groupby']	= 'tr.object_id';
							$pieces['orderby']	= 'GROUP_CONCAT( t.name ORDER BY name ASC) ';
							$pieces['orderby'] .= $order;	

							// Matched...
							break;
						}  
					}
				}
			}

			// Get pieces
			return $pieces; 
		} 

		//----------------------------------------------
		//	Taxonomy Filters
		//----------------------------------------------

		/**
		 * Add taxonomy type post list filtering
		 * - Called via restrict_manage_posts action
		 *
		 * @return void
		 */
		public function post_type_filter() {

			global $typenow, $wp_query; 

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Assign to post-types required
				if ( ! isset( $v['post_types'] ) || ! is_array( $v['post_types'] ) || empty( $v['post_types'] ) ) { continue; }
				  
				// Get post-types
				foreach ( $v['post_types'] as $post_type ) {
				
					// Sanitize post-type... a-z_- only
					$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

					// Only if current post-type			
					if ( $typenow !== $post_type ) { continue; }

					// Get current taxonomy			
					$current_taxonomy = get_taxonomy( $taxonomy ); 

					// Only if query_var
					if ( empty( $current_taxonomy->query_var ) ) { continue; }

					// Terms & term count
					$tax_terms = get_terms( $taxonomy );
					$tax_term_count = (int)sizeof( $tax_terms );
			
					// Need terms...
					if ( $tax_term_count === 0 ) { continue; }

					// Dropdown select
					wp_dropdown_categories(
						[ 
							'show_option_all' =>  sprintf( __( 'Show All %s', 'ipress' ), $current_taxonomy->label ), 
							'taxonomy'		  =>  $taxonomy,	 
							'name'			  =>  $current_taxonomy->name, 
							'orderby'		  =>  'name', 
							'selected'		  =>  ( isset( $wp_query->query[$taxonomy] ) ) ? $wp_query->query[$taxonomy] : '', 
							'hierarchical'	  =>  true, 
							'depth'			  =>  3, 
							'show_count'	  =>  true, 
							'hide_empty'	  =>  true 
						]
					); 
				}
			}
		}

		/**
		 * Filter query for post_type taxonomy
		 * Called via parse_query filter
		 *
		 * @param object $query
		 * @return void
		 */
		public function post_type_filter_query( $query ) {

			global $pagenow; 

			// Test page
			if ( $pagenow !== 'edit.php' ) { return; }

			// Set filter 
			$vars = &$query->query_vars;

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Edit page & matching taxonomy
				if ( $pagenow == 'edit.php' && isset( $vars[ $taxonomy ] ) && is_numeric( $vars[$taxonomy] ) ) {
					 $term = get_term_by( 'id', $vars[ $taxonomy ], $taxonomy );
					 if ( $term ) { $vars[ $taxonomy ] = $term->slug; }
				}
			}
		}

		//----------------------------------------------
		//	Rewrite Rules
		//----------------------------------------------

		/**
		 * Flush rewrite rules for custom post-types & taxonomies after switching theme
		 */
		public function flush_rewrite_rules() { 
			$this->register_post_types();
			$this->register_taxonomies();
			flush_rewrite_rules(); 
		}

		//----------------------------------------------
		//	Admin Error Notices
		//----------------------------------------------

		/**
		 * Post-Type and Taxonomy Error Notices
		 */
		public function admin_notices() {
			
			// Post-Type Errors
			if ( !empty( $this->post_type_errors ) ) {
				$message = sprintf( __( 'Error: Bad Post Types [%s]', 'ipress' ), join( ', ', $this->post_type_errors ) ); 
				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) ); 
			}

			// Taxonomy Errors
			if ( !empty( $this->taxonomy_errors ) ) {
				$message = sprintf( __( 'Error: Bad Taxonomies [%s]', 'ipress' ), join( ', ', $this->taxonomy_errors ) );
				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) ); 
			}
		}
	}

endif;

if ( ! class_exists( 'IPR_Custom_Child' ) ) :

	/**
	 * Example child class if wanting to extend messages / contextual help
	 * @see https://codex.wordpress.org/Function_Reference/register_post_type
	 */
	class IPR_Custom_Child extends IPR_Custom {

		/**
		 * Class Constructor
		 */
		public function __construct() {
			
			// Call parent class
			parent::__construct();

			// Setup Messages Callback
			add_filter( 'post_updated_messages', [ $this, 'messages' ] );

			// Setup Contextual Help
			add_action( 'contextual_help', [ $this, 'contextual_help' ], 10, 3 );
		}

		//----------------------------------------------
		//	Messages
		//----------------------------------------------

		/**
		 * Messages Callback
		 *
		 * @param	array $messages
		 * @return	array
		 */
		public function messages( $messages ) { 
			return $messages; 
		}

		//----------------------------------------------
		//	Contextual Help
		//----------------------------------------------

		/**
		 * Contextual Help Callback
		 *
		 * @param	string $contextual_help
		 * @param	object $screen_id
		 * @param	string $screen
		 * @return	array
		 */
		public function contextual_help( $contextual_help, $screen_id, $screen ) { 
			return $contextual_help; 
		}
	}

endif;

// Instantiate Custom Class
return new IPR_Custom;

//end
