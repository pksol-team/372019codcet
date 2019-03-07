<?php
/**
 * Template part for displaying results in search pages
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article"><!-- Article ID-<?php the_ID(); ?> -->

	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="thumbnail-wrapper" itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject"><!-- Article's Featured Image -->
			<?php the_post_thumbnail('post-thumbnail', array('itemprop'=>'url') );
						$post_thumb_extra_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
						if ( is_array($post_thumb_extra_data) && $post_thumb_extra_data !='') {
								echo '<meta itemprop="width" content="'.esc_attr($post_thumb_extra_data['1']).'">';
								echo '<meta itemprop="height" content="'.esc_attr($post_thumb_extra_data['2']).'">';
						} ?>
			<?php if ( function_exists('chromium_entry_custom_label') ) { chromium_entry_custom_label( get_the_ID() ); } ?>
			<?php /* New position for meta Counters when in Grid mode */
			if ( get_theme_mod( 'grid_blog', false ) ) : ?>
				<div class="meta-counters">
					<?php if ( function_exists('chromium_entry_comments_counter') && (false == get_theme_mod( 'blog_hide_comments', false )) ) { echo chromium_entry_comments_counter( get_the_ID() ); } ?>
					<?php if ( function_exists('tz_entry_likes_counter') && (false == get_theme_mod( 'blog_hide_likes', false )) ) { echo tz_entry_likes_counter( get_the_ID() ); } ?>
					<?php if ( function_exists('tz_feature_pack_entry_post_views') && (false == get_theme_mod( 'blog_hide_views', false )) ) { echo tz_feature_pack_entry_post_views( get_the_ID() ); } ?>
				</div>
			<?php endif; ?>
		</div><!-- end Article's Featured Image -->
	<?php endif; ?>

	<header class="entry-header"><!-- Article's Header -->
		<?php $title = get_the_title();?>
		<h1 class="entry-title search-title" itemprop="headline">
			<?php if ($title) : ?><a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr_e( sprintf( esc_attr__( 'Click to read more about %s', 'chromium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark" itemprop="url"><?php echo wp_kses_post($title); ?></a>
            <?php else : ?>
                <a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr_e( 'Click to read more', 'chromium' ); ?>" rel="bookmark" itemprop="url"><?php esc_html_e( 'Click here to see post content', 'chromium' ) ?></a>
            <?php endif; ?>
		</h1>
	</header><!-- end of Article's Header -->

	<div class="entry-summary" itemprop="articleBody"><!-- Excerpt -->
		<?php // Only display Excerpts for Search
			$excerpt = get_the_excerpt();
			echo wp_kses_post($excerpt); ?>
	</div><!-- end of Excerpt -->

	<?php get_template_part( 'template-parts/post-footer' ); ?>

</article><!-- end of Article ID-<?php the_ID(); ?> -->
