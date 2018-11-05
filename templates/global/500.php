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
?>
<section class="error-500 server-error">

   	<header class="page-header">
    	<h1 class="page-title"><?= esc_html__( 'Server Error', 'ipress' ); ?></h1>
        <p><a href="<?= home_url(); ?>"><?= __( 'Return home?', 'ipress' ); ?></a></p>
    </header><!-- .page-header -->

	<div id="post-500" class="page-content">
		<p><?= esc_html__( 'Oops, something went wrong.', 'ipress' ); ?></p>
    </div><!-- .page-content -->

</section><!-- .error-500 -->
