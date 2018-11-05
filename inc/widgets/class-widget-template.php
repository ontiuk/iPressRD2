<?php


// Creating the widget 
class IPR_Widget extends WP_Widget {

	/**
	 * Widget class constructor
	 */
	public function __construct() {

		// Set up widget options
		$widget_ops = [
			'classname' 	=> 'ipr_widget',
			'description' 	=> __( 'iPress Widget Template', 'ipress' ),
			'customize_selective_refresh' => true
		];
		
		// Initiate core widget features
		parent::__construct(

			// Base ID of your widget
			'ipr_widget', 
 
			// Widget name to appear in UI
			__('iPress Widget', 'ipress'), 
 
			// Widget options
			$widget_ops
		);
	}
 
	/**
	 * Output widget front-end
	 *
	 * @param 	array 	$args     	Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param 	array 	$instance 	Settings for the current Navigation Menu widget instance.
 	*/
	public function widget( $args, $instance ) {

		// Filterable wrapper args by widget ID
		$args = apply_filters( 'widget_args_' . $this->id_base, $args );

		// Set up widget title
		$title = ( empty( $instance['title'] ) ) ? '' : $instance['title'];

		// Filterable widget title
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		// text
		$text = ( empty( $instance['text'] ) ) ? '' : $instance['text'];

		// text area
		$textarea = ( empty( $instance['textarea'] ) ) ? '' : $instance['textarea'];

		// Select
		$select = ( empty( $instance['select'] ) ) ? '' : $instance['select'];

		// Count
		$count = ( empty( $instance['count'] ) ) ? : '0' : '1';

		// Before widget wrapper
		echo $args['before_widget'];

		// Output widget title?
		if ( ! empty( $title ) ) {
			echo sprintf( '%s%s%s', $args['before_title'], $title, $args['after_title'] );
		}

		// Output text
		if ( ! empty( $text ) ) { echo $text; }

		// Output textarea
		if ( ! empty( $textarea ) ) { echo $textarea; }
		
		// Output select value
		if ( ! empty( $select ) ) { echo $select; }

		// Output widget Code - with template?
//		set_query_var( 'widget_title', $title );
//		set_query_var( 'widget_text', $text );
//		set_query_var( 'widget_textarea', $textarea );
//		set_query_var( 'widget_select', $select );
//		get_template_part( 'path/ti/template' );

		// After widget wrapper
		echo $args['after_widget'];
	}
         
	/**
	 * Widget UI form output
	 * 
	 * @param 	array 	$instance 	Current settings
	 */
	public function form( $instance ) {

		// Set title		
		$title 	= ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : '';

		// Other widget settings
		$text 		= isset( $instance['text'] ) ? $instance['text'] : '';
		$textarea 	= isset( $instance['textarea'] ) ? $instance['textarea'] : '';
		$select		= isset( $instance['select'] ) ? $instance['select'] : '';

		// Optional select fields
		$fields = apply_filters( 'ipr_widget_fields', [ 
			'field 1' => __( 'Field 1', 'ipress' ),
			'field 2' => __( 'Field 2', 'ipress' ),
			'field 3' => __( 'Field 3', 'ipress' ),
			'field 4' => __( 'Field 4', 'ipress' )
		] );

		// Widget UI form
	?>
		<p>
			<label for="<?= $this->get_field_id( 'title' ); ?>"><?= __( 'Title:', 'ipress' ); ?></label> 
			<input type="text" class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" value="<?= esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?= $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ) ?></label>
			<input type="text" class="widefat" id="<?= $this->get_field_id( 'text' ); ?>" name="<?= $this->get_field_name( 'text' ); ?>" value="<?= esc_attr( $text ); ?>" />
		</p>
		<p>
			<label for="<?= $this->get_field_id( 'select' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
			<select id="<?= $this->get_field_id( 'select' ); ?>" name="<?= $this->get_field_name( 'select' ); ?>">
				<option value=""><?php _e( '&mdash; Select Field &mdash;' ); ?></option>
				<?php foreach ( $fields as $k=>$v ) : ?>
					<option value="<?= esc_attr( $k ); ?>" <?php selected( $select, $k ); ?>>
						<?=esc_html( $v ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $instance['count'] ); ?> id="<?= $this->get_field_id('count'); ?>" name="<?= $this->get_field_name('count'); ?>" /> <label for="<?= $this->get_field_id('count'); ?>"><?= __('Count', 'ipress'); ?></label>
		</p>

	<?php 
	}
     
	/**
	 * Update widget instance
	 *
	 * @param 	array 	$new_instance 		New settings for this instance as input by the user via WP_Widget::form()
	 * @param 	array 	$old_instance 		Old settings for this instance
	 * @return 	array 	Updated settings
	 */
	public function update( $new_instance, $old_instance ) {

		// Set up new instance
		$instance = [];

		// Widget form values
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['text'] ) ) {
			$instance['text'] = sanitize_text_field( $new_instance['text'] );
		}
		if ( ! empty( $new_instance['textarea'] ) ) {
			$instance['textarea'] = sanitize_text_field( $new_instance['textarea'] );
		}
		if ( ! empty( $new_instance['select'] ) ) {
			$instance['select'] = sanitize_text_field( $new_instance['select'] );
		}

		$instance['count'] = ( $new_instance['count'] ) ? 1 : 0;
	
		return $instance;
	}
} // Class IPR_Widget ends here


// Register and load the widget
function ipr_load_widget() {
    register_widget( 'IPR_Widget' );
}
//add_action( 'widgets_init', 'wpb_load_widget' );
 
