<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article"><!-- Article ID-<?php the_ID(); ?> -->

	<?php if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'chromium' ) );
	} ?>

	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="thumbnail-wrapper" itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject"><!-- Article's Featured Image -->
			<?php $featured_image_size = 'post-thumbnail';
					if ( get_theme_mod( 'grid_blog', false ) ) {
						$featured_image_size = 'chromium-grid-blog-m';
					}
					the_post_thumbnail( esc_attr($featured_image_size), array('itemprop'=>'url') );
						$post_thumb_extra_data = wp_get_attachment_image_src( get_post_thumbnail_id(), esc_attr($featured_image_size) );
						if ( is_array($post_thumb_extra_data) && $post_thumb_extra_data !='') {
								echo '<meta itemprop="width" content="'.esc_attr($post_thumb_extra_data['1']).'">';
								echo '<meta itemprop="height" content="'.esc_attr($post_thumb_extra_data['2']).'">';
						} ?>
			<?php if ( function_exists('chromium_entry_custom_label') ) { chromium_entry_custom_label( get_the_ID() ); } ?>
			<?php /* New position for meta Counters when in Grid mode */
			if ( get_theme_mod( 'grid_blog', false ) ) : ?>
				<div class="meta-counters"><?php if ( function_exists('chromium_entry_comments_counter') && (false == get_theme_mod( 'blog_hide_comments', false )) ) { echo chromium_entry_comments_counter( get_the_ID() ); } ?><?php if ( function_exists('tz_entry_likes_counter') && (false == get_theme_mod( 'blog_hide_likes', false )) ) { echo tz_entry_likes_counter( get_the_ID() ); } ?><?php if ( function_exists('tz_feature_pack_entry_post_views') && (false == get_theme_mod( 'blog_hide_views', false )) ) { echo tz_feature_pack_entry_post_views( get_the_ID() ); } ?></div>
				<div class="post-date-wrapper">
					<?php printf('<span class="border"><span class="day">%1$s</span>%2$s</span>', esc_html(get_the_date('j')), esc_html(get_the_date('M')) );?>
				</div>
			<?php endif; ?>
		</div><!-- end Article's Featured Image -->
	<?php endif; ?>

	<?php if ( 'style-2' == get_theme_mod( 'blog_style', 'style-1' ) ) {
		get_template_part( 'template-parts/post-header-2' );
	} else {
		get_template_part( 'template-parts/post-header' );
	} ?>
    <div class="grid-content">
	<div class="entry-content" itemprop="articleBody"><!-- Article's Content -->
		<?php
		if ( has_excerpt() ) {
			the_excerpt();
		} else {
			if ( get_theme_mod( 'blog_output_excerpt', false ) ) {
				$excerpt = get_the_content();
				$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
				$excerpt = strip_shortcodes($excerpt);
				$excerpt = strip_tags($excerpt);
				$excerpt = substr($excerpt, 0, apply_filters( 'chromium-blog-posts-excerpt', 300 ));
				$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
				$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
				$excerpt = $excerpt.' [...]';
				echo wp_kses_post( $excerpt );
			} else {
				the_content( chromium_continue_reading_text() );
			}
		}

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'chromium' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'chromium' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div><!-- end of Article's Content -->
    </div>
	<?php if ( 'style-2' == get_theme_mod( 'blog_style', 'style-1' ) ) {
		get_template_part( 'template-parts/post-footer-2' );
	} else {
		get_template_part( 'template-parts/post-footer' );
	} ?>

</article><!-- end of Article ID-<?php the_ID(); ?> -->
