<?php /* The default template for displaying single post content. */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article"><!-- Article ID-<?php the_ID(); ?> -->

	<?php /* Post Thumbnail Section */
	$featured_gallery = get_post_meta( get_the_ID(), 'chromium_post_gallery_ids', true);
	$featured_quote = get_post_meta( get_the_ID(), 'chromium_featured_quote', true);
	$featured_video = get_post_meta( get_the_ID(), 'chromium_featured_video', true);
	/* Featured Gallery */
	if ( has_post_format('gallery') && $featured_gallery && class_exists('Tz_Feature_Pack') ) {
		echo '<div class="thumbnail-wrapper" data-owl="container" data-owl-type="content-carousel" data-owl-slides="1" data-owl-arrows="yes" data-owl-margin="0">';
		echo '<span class="carousel-loader"></span>';
		echo '<div class="carousel-container">';
		foreach ($featured_gallery as $image) {
		  echo wp_get_attachment_image( $image, 'post-thumbnail' );
		}
		echo '</div>';
		if ( function_exists('chromium_entry_custom_label') ) { chromium_entry_custom_label( get_the_ID() ); }
		echo '</div>';
	} /* Featured Quote */
	elseif ( has_post_format('quote') && $featured_quote && $featured_quote!='' ) {
		echo '<div class="thumbnail-wrapper quote">';
		if ( has_post_thumbnail() && ! post_password_required() ) { the_post_thumbnail( 'post-thumbnail' ); }
		if ( function_exists('chromium_entry_featured_quote') ) { chromium_entry_featured_quote( get_the_ID() ); }
		if ( function_exists('chromium_entry_custom_label') ) { chromium_entry_custom_label( get_the_ID() ); }
		echo '</div>';
	} /* Featured Video */
	elseif ( has_post_format('video') && $featured_video && $featured_video!='' ) {
		echo '<div class="thumbnail-wrapper video">';
		if ( function_exists('chromium_entry_featured_video') ) { chromium_entry_featured_video( get_the_ID() ); }
		if ( function_exists('chromium_entry_custom_label') ) { chromium_entry_custom_label( get_the_ID() ); }
		echo '</div>';
	} /* Featured Image */
	elseif ( has_post_thumbnail() && ! post_password_required() ) { ?>
		<div class="thumbnail-wrapper" itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject">
			<?php the_post_thumbnail('post-thumbnail', array('itemprop'=>'url') );
						$post_thumb_extra_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
						if ( is_array($post_thumb_extra_data) && $post_thumb_extra_data !='') {
								echo '<meta itemprop="width" content="'.esc_attr($post_thumb_extra_data['1']).'">';
								echo '<meta itemprop="height" content="'.esc_attr($post_thumb_extra_data['2']).'">';
						} ?>
		</div>
	<?php } ?>

	<header class="entry-header"><!-- Article's Header -->
		<?php $title = get_the_title();
			if ( empty($title) || $title = '' ) { ?>
				<h1 class="entry-title" itemprop="headline">
					<meta itemprop="mainEntityOfPage" content="<?php echo esc_url(the_permalink()); ?>">
					<?php esc_html_e( 'Click here to read more', 'chromium' ); ?>
				</h1>
			<?php } else {
				echo '<meta itemprop="mainEntityOfPage" content="'.esc_url(get_permalink()).'"/>';
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
		} ?>
		<div class="entry-header-meta">
			<?php
			if ( 'style-2' == get_theme_mod( 'blog_style', 'style-1' ) ) {
				// Date
				if ( function_exists('chromium_entry_publication_time') && (false == get_theme_mod( 'single_hide_date', false )) ) { chromium_entry_publication_time(); }
				// Author
				if ( function_exists('chromium_entry_author') && (false == get_theme_mod( 'single_hide_author', false )) ) { chromium_entry_author(); }
			} else {
				// Author
				if ( function_exists('chromium_entry_author') && (false == get_theme_mod( 'single_hide_author', false )) ) { chromium_entry_author(); }
				// Date
				if ( function_exists('chromium_entry_publication_time') && (false == get_theme_mod( 'single_hide_date', false )) ) { chromium_entry_publication_time(); }
			}
			// Categories
			if ( function_exists('chromium_entry_post_cats') && (false == get_theme_mod( 'single_hide_categories', false )) ) { chromium_entry_post_cats(); }

			// Edit link
			edit_post_link(sprintf( __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'chromium' ), esc_html(get_the_title()) ), '<span class="edit-link">','</span>' );
			?>
		</div>

	</header><!-- end of Article's Header -->

	<div class="entry-content" itemprop="articleBody"><!-- Article's Content -->
		<?php
		the_content();

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
	<footer class="entry-meta"><?php if ( function_exists('chromium_entry_post_tags') && (false == get_theme_mod( 'blog_hide_tags', false )) ) { chromium_entry_post_tags(); } ?><?php if (
		       (false == get_theme_mod( 'single_hide_comments', false ))
            || (false == get_theme_mod( 'single_hide_views', false ))
            || (false == get_theme_mod( 'single_hide_shares', false ))
        ):?><div class="meta-counters">
			<?php if ( function_exists('chromium_entry_comments_counter') && ( false == get_theme_mod( 'single_hide_comments', false )) ) { echo chromium_entry_comments_counter( get_the_ID() ); } ?>
			<?php if ( function_exists('tz_feature_pack_entry_post_views') && (false == get_theme_mod( 'single_hide_views', false )) ) { echo tz_feature_pack_entry_post_views( get_the_ID() ); } ?>
			<?php if ( function_exists('tz_output_like_button') && (false == get_theme_mod( 'single_hide_views', false )) ) { tz_output_like_button( get_the_ID() ); } ?>
			<?php if ( function_exists('tz_share_buttons_output') && (false == get_theme_mod( 'single_hide_shares', false )) ) { tz_share_buttons_output( get_the_ID() ); } ?></div><?php endif; ?></footer><!-- end of Article's Footer -->
	<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) {
		get_template_part( 'template-parts/author-bio' );
	} ?>

	<?php
		$previous = get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( true == get_theme_mod( 'single_post_nav', true ) && ( $previous || $next ) ) { ?>
		<nav class="navigation post-navigation"><!-- Post Nav -->
			<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'chromium' ); ?></h1>
			<div class="nav-links">
				<?php
					previous_post_link( '<span><i class="chromium-icon-arrow-right mirror"></i>%link</span>', esc_html__( ' Previous Post', 'chromium' ) );
					next_post_link( '<span>%link<i class="chromium-icon-arrow-right"></i></span>', esc_html__( 'Next Post ', 'chromium' ) );
				?>
			</div>
		</nav><!-- end of Post Nav -->
	<?php } ?>

</article><!-- end of Article ID-<?php the_ID(); ?> -->
