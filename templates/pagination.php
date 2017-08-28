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

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

global $wp_query;

if ( $wp_query->max_num_pages > 1 ) : ?>
<!-- pagination --> 
<section id="pagination" class="paginate">
    <ul class="pager">
        <li class="previous pull-left">
            <?= get_next_posts_link( 'More', $wp_query->max_num_pages ); ?>
        </li>
        <li class="next pull-right">
            <?= get_previous_posts_link( 'Back' ); ?>        
        </li>
    </ul>
</section>
<!-- //pagination --> 
<?php endif; ?>
