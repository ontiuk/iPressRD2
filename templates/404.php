<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the main 404 page content
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

?>
<section class="error-404 not-found">
	<div id="post-404" class="page-content">

    	<header class="page-header">
	    	<h1 class="page-title"><?= esc_html__( 'Oops! That page can&rsquo;t be found.', 'ipress' ); ?></h1>
            <p><a href="<?= home_url(); ?>"><?= __( 'Return home?', 'ipress' ); ?></a></p>
	    </header><!-- .page-header -->

		<p><?= esc_html__( 'Nothing found at this location.', 'ipress' ); ?></p>

    </div><!-- .page-content -->
</section><!-- .error-404 -->
