<?php
/**
 * Template part for displaying article's footer
 */
?>

	<footer class="entry-meta"><!-- Article's Footer -->
		<?php
		global $post;
		if ( strpos( $post->post_content, '<!--more-->' ) || has_excerpt() || get_theme_mod( 'blog_output_excerpt', false ) ) : ?>
            <a class="link-to-post button" href="<?php esc_url(the_permalink()); ?>" title="<?php echo esc_attr( sprintf( esc_attr__( 'Click to read more about %s', 'chromium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark" itemprop="url"><?php esc_html_e( chromium_continue_reading_text() ); ?></a>
		<?php endif; ?>
		<?php if ( ! get_theme_mod( 'grid_blog', false ) ) : ?>
			<div class="meta-counters">
				<?php if ( function_exists('chromium_entry_comments_counter') && (false == get_theme_mod( 'blog_hide_comments', true )) ) { echo chromium_entry_comments_counter( get_the_ID() ); } ?>
				<?php if ( function_exists('tz_entry_likes_counter') && (false == get_theme_mod( 'blog_hide_likes', false )) ) { echo tz_entry_likes_counter( get_the_ID() ); } ?>
				<?php if ( function_exists('tz_feature_pack_entry_post_views') && (false == get_theme_mod( 'blog_hide_views', false )) ) { echo tz_feature_pack_entry_post_views( get_the_ID() ); } ?>
			</div>
		<?php endif; ?>
	</footer><!-- end of Article's Footer -->
</div><!-- end of div.flex-wrapper -->
