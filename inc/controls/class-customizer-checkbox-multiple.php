<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Multiple checkbox customizer
 *  
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
 * Multiple checkbox customize control class
 * 
 * @package iPress\Controls
 */
class WP_Customize_Checkbox_Multiple_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered
     * 
     * @var string $type
     */
    public $type = 'checkbox-multiple';

    /**
     * Displays the control content
     */
    public function render_content() {

        // No options?
        if ( empty( $this->choices ) ) { return; }

		$name = '_customize-checkbox-multiple-' . $this->id; 
?>

        <?php if ( !empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?= sprintf( esc_html( '%s', 'ipress' ), $this->label ); ?></span>
        <?php endif; ?>

        <?php if ( !empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?= sprintf( '%s', $this->description ); ?></span>
        <?php endif; ?>

        <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

        <ul>
            <?php foreach ( $this->choices as $value => $label ) : ?>

                <li>
                    <label>
                        <input type="checkbox" name="<?= $this->type . '-' . $value; ?>" id="<?= esc_attr( $this->id . '_' . $value ); ?>" class="<?= $this->type; ?>" value="<?= esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
                        <?= esc_html( $label ); ?>
                    </label>
                </li>

            <?php endforeach; ?>
        </ul>

        <input type="hidden" id="<?= $this->id; ?>" <?php $this->link(); ?> class="<?= $this->type . '-hidden'; ?>" value="<?= esc_attr( implode( ',', $multi_values ) ); ?>" />
<?php 
    }

    /**
     * Enqueue scripts/styles
     */
    public function enqueue() {
        wp_enqueue_script( 'customizer-checkbox-multiple', IPRESS_CONTROLS_DIR . '/js/checkbox-multiple.js', [ 'jquery' ] );
    }
}

//end
