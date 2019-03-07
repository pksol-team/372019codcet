<?php /* The template for displaying image attachments */

get_header(); ?>

	<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

		<?php // Start the Loop.
			while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemprop="ImageObject"><!-- Article ID-<?php the_ID(); ?> -->

				<div class="attachment-img"><!-- Img Wrapper -->
					<?php echo wp_get_attachment_image( $post->ID, 'large', false, array('itemprop' => 'thumbnail') ); ?>
				</div><!-- end of Img Wrapper -->

				<div class="attachment-description">
					<div class="entry-header"><!-- Article's Header -->
						<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
					</div><!-- end of Article's Header -->

					<div class="entry-content"><!-- Content -->

						<?php if ( has_excerpt() ) : ?>
							<div class="entry-caption" itemprop="caption">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $post->post_content ) ) : ?>
							<div class="entry-description">
								<?php echo wp_kses_post($post->post_content); ?>
							</div>
						<?php endif; ?>

					</div><!-- end of Content -->

					<div class="entry-data"><!-- Attachment Data -->
						<div class="date">
							<strong><?php esc_html_e('Posted: ', 'chromium'); ?></strong>
							<?php if (function_exists('chromium_entry_publication_time')) { chromium_entry_publication_time(); } ?>
						</div>

						<?php $special_filters = get_the_terms( $id, 'gallery-filter' );
						if ( is_array($special_filters) && !empty($special_filters) ) {
							foreach($special_filters as $special_filter){
								$special_filter_cleared[] = $special_filter->name;
							}
							unset($special_filter);
							?>
								<div class="tags">
									<strong><?php esc_html_e('Tags: ', 'chromium'); ?></strong>
									<?php echo esc_html(implode(' / ', $special_filter_cleared)); ?>
								</div>
							<?php
						} ?>

						<div class="source">
							<strong><?php esc_html_e('Source Image: ', 'chromium'); ?></strong>
							<?php
								$metadata = wp_get_attachment_metadata();
								printf( '<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s" itemprop="contentUrl">%3$s (%4$s &times; %5$s)</a></span>',
									esc_url( wp_get_attachment_url() ),
									esc_attr__( 'Link to full-size image', 'chromium' ),
									esc_html__( 'Full resolution', 'chromium' ),
									esc_html($metadata['width']),
									esc_html($metadata['height'])
								);
							 ?>
						</div>
					</div><!-- end of Article's Footer -->
				</div>

				<footer class="entry-meta"><!-- Article's Footer -->
					<div class="meta-counters">
                        <?php if ( function_exists('chromium_entry_comments_counter') && (false == get_theme_mod( 'single_hide_comments', false )) ) { echo chromium_entry_comments_counter( get_the_ID() ); } ?>
						<?php if ( function_exists('tz_feature_pack_entry_post_views') && (false == get_theme_mod( 'single_hide_views', false )) ) { echo tz_feature_pack_entry_post_views( get_the_ID() ); } ?>
						<?php if ( function_exists('tz_output_like_button') && (false == get_theme_mod( 'single_hide_likes', false )) ) { tz_output_like_button( get_the_ID() ); } ?>
						<?php if ( function_exists('tz_share_buttons_output') && (false == get_theme_mod( 'single_hide_shares', false )) ) { tz_share_buttons_output( get_the_ID() ); } ?>
					</div>
				</footer><!-- end of Article's Footer -->

				<?php
					$previous = get_post( get_post()->post_parent );
					$next     = get_adjacent_post( false, '', false );
					if ( ! $next && ! $previous ) {
						return;
					} else { ?>
					<nav class="navigation post-navigation"><!-- Post Nav -->
						<h1 class="screen-reader-text"><?php esc_html_e( 'Image navigation', 'chromium' ); ?></h1>
						<div class="nav-links">
							<?php
								previous_image_link( false , '<span><i class="chromium-icon-arrow-right mirror"></i>'.esc_html__( ' Previous Image', 'chromium' ).'</span>' );
								next_image_link( false , '<span>'.esc_html__( 'Next Image ', 'chromium' ).'<i class="chromium-icon-arrow-right"></i></span>' );
							?>
						</div>
					</nav><!-- end of Post Nav -->
				<?php } ?>

			</article><!-- end of Article ID-<?php the_ID(); ?> -->

			<?php comments_template(); ?>

		<?php endwhile; // end of the loop. ?>

	</main><!-- end of Main content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
