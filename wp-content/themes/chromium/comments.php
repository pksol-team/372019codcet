<?php /* The template for displaying Comments */

if ( post_password_required() ) {
	return;
} ?>

<aside id="comments" class="comments-area"><!-- comments -->

	<?php if ( have_comments() ) { ?>

		<h2 class="comments-title entry-title" itemprop="interactionCount">
			<?php $comments_title = sprintf( esc_html( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'chromium' ) ), number_format_i18n( get_comments_number() ) );
			echo apply_filters( 'chromium-single-post-titles', esc_html($comments_title) ); ?>
		</h2>

		<div class="comments-list">
			<?php wp_list_comments( array('walker' => new chromium_comments_walker() ) ); ?>
		</div>

		<?php /* Comments pagination */
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
		  <nav class="navigation comment-navigation"><!-- Comments Nav -->
		    <h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comments navigation', 'chromium' ); ?></h1>
		    <div class="prev"><?php previous_comments_link( '<i class="fa fa-angle-left"></i>' . esc_html__( ' Older Comments', 'chromium' ) ); ?></div>
		    <div class="next"><?php next_comments_link( esc_html__( 'Newer Comments ', 'chromium' ) . '<i class="fa fa-angle-right"></i>' ); ?></div>
		  </nav><!-- end of Comments Nav -->
		<?php }
	} ?>

	<?php if ( ! comments_open() ) { ?>
		<p class="no-comments"><i class="fa fa-ban" aria-hidden="true"></i><?php esc_html_e( 'Comments are closed.', 'chromium' ); ?></p>
	<?php } ?>

	<?php /* Custom comment form */

comment_form( array(
	'title_reply'       => '<span>'.esc_html__('Leave', 'chromium').'</span> '.esc_html__( 'a Reply', 'chromium' ),
	'title_reply_to'    => '<span>'.esc_html__('Leave', 'chromium').'</span> '.esc_html__( 'a Reply to %', 'chromium' ),
) );?>

</aside><!-- end of comments -->
