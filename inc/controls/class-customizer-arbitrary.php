<?php
/**
 * Class to create a custom arbitrary html control for dividers etc
 *
 * @author      WooThemes
 * @package     iPress\Controls
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
 * The arbitrary control class
 * 
 * @package iPress\Controls
 */
class WP_Customize_Control_Arbitrary_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered
     * 
     * @var string $type
     */
    public $type = 'arbitrary';

	/**
	 * Renter the control
	 *
	 * @return void
	 */
	public function render_content() {
		switch ( $this->type ) {
			default:
			case 'text' :
				echo '<p class="description">' . wp_kses_post( $this->description ) . '</p>';
			break;

			case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
			break;

			case 'divider' :
				echo '<hr style="margin: 1em 0;" />';
			break;
		}
	}
}
