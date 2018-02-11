<?php
/**
 * The template for displaying comments
 *
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     iPress/Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

// Password protected?
if ( post_password_required() ) { return; }

?>
<div id="comments" class="comments-area" aria-label="Post Comments">

	<?php
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
		<?php
            echo sprintf( // WPCS: XSS OK.
				esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'honeycomb' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
		<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
            ] );
		?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation();

		// Comments closed massage
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ipress' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	$args = apply_filters( 'ipress_comment_form_args', [
		'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</span>',
    ] );
	comment_form( $args );
	?>

</div><!-- #comments -->
