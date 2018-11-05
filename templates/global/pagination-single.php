<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying main pagination
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

global $wp_query;

$older = apply_filters( 'ipress_single_next_nav_link', '&larr; Older' );
$newer = apply_filters( 'ipress_single_prev_nav_link', 'Newer &rarr;' );
	
if ( $wp_query->max_num_pages > 1 ) : 
?>
<!-- pagination --> 
<section id="pagination" class="paginate post-paginate">

	<nav class="pagination" role="navigation"> 
		<div class="nav-prev nav-left"><?= get_next_post_link( $older, $wp_query->max_num_pages ); ?></div> 
		<div class="nav-next nav-right"><?= get_previous_post_link( $newer ); ?></div> 
	</nav>

</section>
<!-- //pagination --> 
<?php endif;
