<?php /* The sidebar containing the main widget area. */ ?>

<?php /* Disable sidebars if layout one-col */
	$current_layout = chromium_show_layout();
	if ( $current_layout != 'layout-one-col') :
		/* Get extra style for widgets */
		$blog_sidebar_style = ' ' . get_theme_mod('blog_sidebar_style', 'style-1');
		$front_page_sidebar_style = ' ' . get_theme_mod('front_page_sidebar_style', 'style-3');
		$store_sidebar_style = ' ' . get_theme_mod('store_sidebar_style', 'style-2');
?>

<?php if (class_exists('WooCommerce')) {
	if ( is_home() ||
		 ( is_single() && !is_product() ) ||
		 ( is_category() && !is_product_category() ) ||
		 ( is_tag() && !is_product_tag() ) ||
		 ( is_tax() && !is_product_taxonomy() ) ||
		 ( is_archive() && !is_woocommerce() ) ||
			 is_search() && !is_woocommerce() ) : ?>

			 <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
				 <aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
					 <?php dynamic_sidebar( 'sidebar-blog' ); ?>
				 </aside>
			 <?php endif; ?>

<?php elseif ( (is_page() && is_front_page() && !is_shop()) ||
							 (is_page() && is_page_template( 'page-templates/front-page.php' ) ) ) : ?>

			 <?php if ( is_active_sidebar( 'sidebar-front' ) ) : ?>
				 <aside id="sidebar-front" class="widget-area site-sidebar<?php echo esc_attr($front_page_sidebar_style); ?>" role="complementary">
					 <?php dynamic_sidebar( 'sidebar-front' ); ?>
				 </aside>
            <?php elseif ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                <aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                </aside>
            <?php endif; ?>

<?php elseif ( is_page() && !is_shop() ) : ?>

			 <?php if ( is_active_sidebar( 'sidebar-pages' ) ) : ?>
				 <aside id="sidebar-pages" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
					 <?php dynamic_sidebar( 'sidebar-pages' ); ?>
				 </aside>
            <?php elseif ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                <aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                </aside>
            <?php endif; ?>

<?php elseif ( ( is_front_page() && is_shop() ) || is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) : ?>

			 <?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
				 <aside id="sidebar-shop" class="widget-area site-sidebar<?php echo esc_attr($store_sidebar_style); ?>" role="complementary">
					 <?php dynamic_sidebar( 'sidebar-shop' ); ?>
				 </aside>
			 <?php endif; ?>

<?php elseif ( is_product() ) : ?>

			 <?php if ( is_active_sidebar( 'sidebar-product' ) ) : ?>
				 <aside id="sidebar-product" class="widget-area site-sidebar<?php echo esc_attr($store_sidebar_style); ?>" role="complementary">
					 <?php dynamic_sidebar( 'sidebar-product' ); ?>
				 </aside>
			 <?php endif; ?>

<?php endif; ?>

<?php } else { ?>

<?php if ( is_home() || is_single() || is_category() || is_tag() || is_tax() || is_archive()  || is_search() ) : ?>

				<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
					<aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
						<?php dynamic_sidebar( 'sidebar-blog' ); ?>
					</aside>
				<?php endif; ?>

<?php elseif ( is_page() && is_front_page() ) : ?>

				<?php if ( is_active_sidebar( 'sidebar-front' ) ) : ?>
					<aside id="sidebar-front" class="widget-area site-sidebar<?php echo esc_attr($front_page_sidebar_style); ?>" role="complementary">
						<?php dynamic_sidebar( 'sidebar-front' ); ?>
					</aside>
                <?php elseif ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                    <aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                    </aside>
                <?php endif; ?>

<?php elseif ( is_page() ) : ?>

				<?php if ( is_active_sidebar( 'sidebar-pages' ) ) : ?>
					<aside id="sidebar-pages" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
						<?php dynamic_sidebar( 'sidebar-pages' ); ?>
					</aside>
                <?php elseif ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                    <aside id="sidebar-blog" class="widget-area site-sidebar<?php echo esc_attr($blog_sidebar_style); ?>" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                    </aside>
				<?php endif; ?>

<?php endif; ?>

<?php } /* end of if (class_exists('WooCommerce')) */ ?>

<?php endif; /* end of if ($current_layout!='layout-one-col') */ ?>
