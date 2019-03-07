<?php // Related Posts
	$categories = get_the_category( get_the_ID() );
	$mobile_qty = 1; /* number of slides shown in carousel on small devices */

	if ( chromium_show_layout()=='layout-one-col' ) {
			$per_row = 3;
	} else {
			$per_row = 2;
	}

	if ($categories) {
	  $category_ids = array();
	  foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

		$args = array(
			'category__in' => $category_ids,
			'post__not_in' => array( get_the_ID() ),
			'posts_per_page'=> $per_row,
			'ignore_sticky_posts'=> 1
		);

		$the_query = new wp_query( $args );
		  if ( $the_query->have_posts() ) : ?>
		    <aside class="related-posts" data-owl="container" data-owl-type="related" data-owl-slides="<?php echo esc_attr($mobile_qty); ?>">
		    	<h2 class="entry-title related-posts-title" itemprop="name"><?php echo apply_filters( 'chromium-single-post-titles', esc_html__('Related Posts', 'chromium') ); ?></h2>
					<ul class="post-list">
					<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li class="post" itemscope="itemscope" itemtype="http://schema.org/Article">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="thumb-wrapper">
									<?php the_post_thumbnail( 'chromium-recent-posts-thumb-s' ); ?>
								</div>
							<?php } ?>
							<div class="item-content">
								<div class="date-cat-wrapper">
									<?php echo '<span itemprop="datePublished">'.get_the_date().'</span>'; ?>
									<?php /* Get equal categories */
									$related_post_categories = get_the_category( get_the_ID() );
									foreach( $related_post_categories as $individual_post_category ) $related_category_ids[] = $individual_post_category->term_id;
									$result_ids = array_intersect( $category_ids, $related_category_ids );
									$i = 0;
									foreach ($result_ids as $result_id) {
										$term = get_term( $result_id );
										echo '<a class="related-categorie" rel="archive" href="'. esc_url( get_term_link( $result_id ) ) .'">'.esc_html($term->name).'</a>';
										if ( ++$i == apply_filters('chromium-related-posts-limit-cat-qty', 1) ) break;
									}
									?>
								</div>
								<?php $title = get_the_title();
									if ( empty($title) || $title = '' ) { ?>
										<h3 class="entry-title" itemprop="headline">
											<meta itemprop="mainEntityOfPage" content="<?php esc_url(the_permalink()); ?>">
											<a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr_e( 'Click here to read more', 'chromium' ); ?>" rel="bookmark" itemprop="url"><?php esc_html_e( 'Click here to read more', 'chromium' ); ?></a>
										</h3>
									<?php } else {
										echo '<meta itemprop="mainEntityOfPage" content="'.esc_url(get_permalink()).'">';
										the_title( '<h3 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h3>' );
								} ?>
                                <div class="entry-content">
                                    <?php
                                    $excerpt = get_the_content();
                                    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
                                    $excerpt = strip_shortcodes($excerpt);
                                    $excerpt = strip_tags($excerpt);
                                    $excerpt = substr($excerpt, 0, apply_filters( 'chromium-blog-posts-excerpt', 25 ));
                                    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
                                    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
                                    $excerpt = $excerpt.' ...';
                                    echo wp_kses_post( $excerpt );
                                    ?>
                                </div>
							</div>
						</li>
					<?php endwhile; ?>
					</ul>
				</aside>
		<?php endif;
		wp_reset_postdata();
	}
