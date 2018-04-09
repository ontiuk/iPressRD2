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
<section class="error-404 not-found">

   	<header class="page-header">
    	<h1 class="page-title"><?php echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'ipress' ); ?></h1>
        <p><a href="<?php echo home_url(); ?>"><?php echo __( 'Return home?', 'ipress' ); ?></a></p>
    </header><!-- .page-header -->

	<div id="post-404" class="page-content">
		<p><?php echo esc_html__( 'Nothing found at this location.', 'ipress' ); ?></p>
    </div><!-- .page-content -->

</section><!-- .error-404 -->
