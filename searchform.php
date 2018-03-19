<?php
/**
 * Template for displaying search forms 
 *
 * @package     iPress
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo $unique_id; ?>"><?php echo _x( 'Search for:', 'label', 'ipress' ); ?></label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'ipress' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="search-submit"><?php echo _x( 'Search', 'ipress' ); ?><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'ipress' ); ?></span></button>
</form>
