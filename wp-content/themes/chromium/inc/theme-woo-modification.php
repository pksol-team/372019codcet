<?php
/*------- Woocommerce modifications ----------*
 * - Remove woocommerce styles
 * - Extra body class for product layout
 * - Wrappers for woocommerce pages
 * - Product Listing Modifications
 * - Products per page filter
 * - Strings for shop tooltips on hover
 * - List/grid view
 * - Extra gallery for list-view mode
 * - Adding attributes dropdowns to product loop
 * - Breadcrumbs
 * - Change woocommerce pagination args
 * - Wrapper for shop view controls
 * - Single Product Page Modifications
 * - Cart Page Modifications
 * - Checkout Modifications
 * - Output Custom Product Labels on single product
 * - Output Share Buttons on single product
 * - Add primary category to product archive view
 * - Change "Choose an option" text
*/

/* Remove woocommerce styles */
if ( !function_exists('chromium_remove_woo_styles') ) {
	function chromium_remove_woo_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
		unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		return $enqueue_styles;
	}
	add_filter( 'woocommerce_enqueue_styles', 'chromium_remove_woo_styles' );
}


/* Extra body class for product layout */
if (!function_exists('chromium_product_extra_class')) {
	function chromium_product_extra_class( $classes ) {
		if( is_singular( 'product' ) ) {
			$classes[] = get_theme_mod( 'single_product_layout', 'col3-col3' );
			$classes[] = get_theme_mod( 'single_product_style', 'product-chrom-style' );
			if ( true == get_theme_mod( 'grid_variations', true ) ) {
				$classes[] = 'grid-variations';
			}
			if ( true == get_theme_mod( 'one_row_related_up_sells', false ) ) {
				$classes[] = 'one-row-related-upsells';
			}
		}
		if ( is_woocommerce() && ('one' == get_theme_mod( 'mobile_products_qty', 'one' )) ) {
			$classes[] = 'mobile-one-col-products';
		}
		$classes[] = 'chromium-product-' . get_theme_mod( 'store_product_style', 'style-3');
		return $classes;
	}
	add_filter( 'body_class', 'chromium_product_extra_class' );
}


/* Wrappers for woocommerce pages */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('chromium_store_wrapper_start')) {
function chromium_store_wrapper_start() { ?>
    <main class="site-content store-content" itemscope="itemscope" itemprop="mainContentOfPage" role="main"><!-- Main content -->
		<?php }
		add_action('woocommerce_before_main_content', 'chromium_store_wrapper_start', 10);
		}

		if (!function_exists('chromium_store_wrapper_end')) {
		function chromium_store_wrapper_end() { ?>
    </main><!-- end of Main content -->
<?php }
	add_action('woocommerce_after_main_content', 'chromium_store_wrapper_end', 10);
}


/* Product Listing Modifications */

// Remove default product link
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// Product link wrapped around product title
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
// Add new inner wrappers
if (!function_exists('chromium_inner_product_wrapper_start')) {
	function chromium_inner_product_wrapper_start() {
		global $product;
		$attachment_ids = $product->get_gallery_image_ids();
		$extra_gallery_class = '';
		if ( $attachment_ids ) {
			$extra_gallery_class = ' with-extra-gallery';
		}
		echo '<div class="inner-wrapper'.esc_attr($extra_gallery_class).'"><div class="img-wrapper">';
	}
	add_action( 'woocommerce_before_shop_loop_item', 'chromium_inner_product_wrapper_start', 5 );
}
if (!function_exists('chromium_inner_product_wrapper_end')) {
	function chromium_inner_product_wrapper_end() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'chromium_inner_product_wrapper_end', 20 );
}
if (!function_exists('chromium_close_img_wrapper')) {
	function chromium_close_img_wrapper() {
		echo '</div>';
	}
	add_action( 'woocommerce_shop_loop_item_title', 'chromium_close_img_wrapper', 1 );
}
if (!function_exists('chromium_product_excerpt_wrapper_start')) {
	function chromium_product_excerpt_wrapper_start() {
		echo '<div class="excerpt-wrapper">';
	}
	add_action( 'woocommerce_shop_loop_item_title', 'chromium_product_excerpt_wrapper_start', 2 );
}
if (!function_exists('chromium_product_excerpt_wrapper_end')) {
	function chromium_product_excerpt_wrapper_end() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'chromium_product_excerpt_wrapper_end', 15 );
}
// Moving sale Badge
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 5 );
// Add badge style class to product class
if (!function_exists('chromium_product_badge_class')) {
	function chromium_product_badge_class($classes) {
		global $post;
		if ( 'style-2' == get_theme_mod( 'store_badges_style', 'style-2') ) {
			$classes[] = 'badges-style-2';
		}
		if ( 'style-3' == get_theme_mod( 'store_badges_style', 'style-2') ) {
			$classes[] = 'badges-style-3';
		}
		return $classes;
	}
	add_filter( 'post_class', 'chromium_product_badge_class' );
}
// Link to product wrapper around product image
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
// Add review counter
if (!function_exists('chromium_product_reviews_counter')) {
	function chromium_product_reviews_counter() {
		global $product;
		$review_count = $product->get_review_count();
		if ( $review_count && ('yes' === get_option( 'woocommerce_enable_review_rating' )) ) {
			echo '<div class="reviews-wrapper">';
			echo '<span>';
			printf( esc_html( _n( '(%1$s review)', '(%1$s reviews)', $review_count, 'chromium' ) ), esc_html( $review_count ) );
			echo '</span>';
			echo '</div>';
		} elseif ( !$review_count && ('yes' === get_option( 'woocommerce_enable_review_rating' )) ) {
			echo '<div class="star-rating"></div>';
			echo '<div class="reviews-wrapper">';
			echo '<span>';
			esc_html_e( '(0 reviews)', 'chromium' );
			echo '</span>';
			echo '</div>';
		}
	}
	add_action( 'woocommerce_after_shop_loop_item_title', 'chromium_product_reviews_counter', 6 );
}
// Add product buttons wrapper with add to cart, compare, wishlist links
if (!function_exists('chromium_product_buttons_wrapper_start')) {
	function chromium_product_buttons_wrapper_start() {
		echo '<div class="buttons-wrapper">';
		echo '<span class="product-tooltip"></span>';
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'chromium_product_buttons_wrapper_start', 13 );
}
// compare & wishlist
if ( class_exists('TM_WC_Compare_Wishlist') ) {
	if ( (get_option('tm_woocompare_enable') == true) && (get_option('tm_woocompare_show_in_catalog') == true) ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'tm_woocompare_add_button_loop', 12 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'tm_woocompare_add_button_loop', 15 );
	}
	if ( (get_option('tm_woowishlist_enable') == true) && (get_option('tm_woowishlist_show_in_catalog') == true) ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'tm_woowishlist_add_button_loop', 12 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'tm_woowishlist_add_button_loop', 14 );
	}
}
// add to cart
if ( 'style-1' == get_theme_mod( 'store_product_style', 'style-3') ) {
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 16);
}
// Close button wrapper
if (!function_exists('chromium_product_buttons_wrapper_end')) {
	function chromium_product_buttons_wrapper_end() {
		echo '</div>';
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'chromium_product_buttons_wrapper_end', 17 );
}
// Add percentage label to sale products price
if (!function_exists('chromium_sale_product_percentage_label')) {
	function chromium_sale_product_percentage_label(){
		global $product;
		$regular_price = $product->get_regular_price();
		$sale_price    = $product->get_sale_price();
		if( !empty($sale_price) ) {
			// Percentage calculation
			echo '<span class="save-percent">-' . round( ( ( $regular_price -  $sale_price ) / $regular_price ) * 100 ) . '%</span>';
		}
	}
	$store_product_style = get_theme_mod( 'store_product_style', 'style-3');
	if ( $store_product_style == 'style-1' || $store_product_style == 'style-2' ) {
		add_action('woocommerce_after_shop_loop_item','chromium_sale_product_percentage_label', 11 );
	}
}


/* Price wrappers */
if ( !function_exists('chromium_product_price_wrapper_start') ) {
	function chromium_product_price_wrapper_start(){
		echo '<div class="price-wrapper">';
	}
	add_action('woocommerce_after_shop_loop_item_title','chromium_product_price_wrapper_start', 9 );
}
if ( !function_exists('chromium_product_price_wrapper_end') ) {
	function chromium_product_price_wrapper_end(){
		echo '</div>';
	}
	add_action('woocommerce_after_shop_loop_item','chromium_product_price_wrapper_end', 12 );
}



/* Products per page filter */
if ( ! function_exists( 'chromium_show_products_per_page' ) ) {
	function chromium_show_products_per_page() {
		if (isset($_GET['chromium-qty-switcher'])) {
			setcookie('chromium-qty-switcher', $_GET['chromium-qty-switcher'], time()+3600);
			return ($_GET['chromium-qty-switcher'] == 'all' ? '-1' : $_GET['chromium-qty-switcher'] );
		}
		if (isset($_COOKIE['chromium-qty-switcher'])) {
			return ( $_COOKIE['chromium-qty-switcher'] == 'all' ? '-1' : $_COOKIE['chromium-qty-switcher'] );
		}
		return get_theme_mod( 'products_per_page', '9' );
	}
	add_filter('loop_shop_per_page', 'chromium_show_products_per_page', 20 );
}


/* Strings for shop tooltips on hover */
if (!function_exists('chromium_shop_tooltips')) {
	function chromium_shop_tooltips() {
		?>
        <script>
            var msg_add_cart = '<?php esc_html_e('Add to Cart', 'chromium') ?>';
            var msg_select_options = '<?php esc_html_e('Select Options', 'chromium') ?>';
            var msg_compare = '<?php esc_html_e('Add to Compare', 'chromium') ?>';
            var msg_compare_added = '<?php esc_html_e('Already Added. Remove?', 'chromium') ?>';
            var msg_wish = '<?php esc_html_e('Add to WishList', 'chromium') ?>';
            var msg_wish_added = '<?php esc_html_e('Already in WishList', 'chromium') ?>';
        </script>
		<?php
	}
	add_action( 'wp_footer', 'chromium_shop_tooltips');
}


/* List/grid view */
if (!function_exists('chromium_view_switcher')) {
	function chromium_view_switcher() {
		$default = get_theme_mod( 'default_products_view', 'grid' ); ?>
        <div class="list-grid-switcher">
            <span class="grid<?php if($default=='grid') echo ' active';?>" title="<?php esc_attr_e('Grid View', 'chromium'); ?>"><i class="fa fa-th" aria-hidden="true"></i></span>
            <span class="list<?php if($default=='list') echo ' active';?>" title="<?php esc_attr_e('List View', 'chromium'); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></span>
        </div>
	<?php }
}
if ( true == get_theme_mod( 'list_grid_switcher', false ) ) {
	add_action( 'woocommerce_before_shop_loop', 'chromium_view_switcher', 35 );
}


/* Extra gallery for list-view mode */
if (!function_exists('chromium_product_extra_imgs')) {
	function chromium_product_extra_imgs() {
		global $product;
		// Adding extra gallery if turned on
		$attachment_ids = $product->get_gallery_image_ids();
		if ( $attachment_ids ) {
			$gallery_images = array();
			$count = 0;
			$main_thumb = wp_get_attachment_image( get_post_thumbnail_id($product->get_id()), 'shop_thumbnail' );
			$main_link = wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id()), 'shop_catalog' );
			$gallery_images[] = array(
				'thumb' => $main_thumb,
				'link' => $main_link[0],
			);

			foreach ($attachment_ids as $attachment_id) {
				if ($count > 1 ) {
					continue;
				}
				$thumb = wp_get_attachment_image( $attachment_id, 'shop_thumbnail' );
				$link = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
				$gallery_images[] = array(
					'thumb' => $thumb,
					'link' => $link[0],
				);
				$count++;
			}
			if ( !empty($gallery_images) ) {
				echo '<ul class="extra-gallery-thumbs">';
				foreach ($gallery_images as $gallery_image) {
					echo '<li><a href="'.esc_url($gallery_image['link']).'">'.$gallery_image['thumb'].'</a></li>';
				}
				echo '</ul>';
			}
		}
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'chromium_product_extra_imgs', 12 );
}


// Adding short description
if (!function_exists('chromium_product_description')) {
	function chromium_product_description() {
		global $product;
		if ( $product->get_short_description() ) : ?>
            <div class="short-description">
				<?php echo apply_filters( 'woocommerce_short_description', wp_kses_post($product->get_short_description()) ); ?>
            </div>
		<?php endif;
	}
	add_action( 'woocommerce_shop_loop_item_title', 'chromium_product_description', 16);
}


/* Adding attributes dropdowns to product loop */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
if ( ! function_exists( 'chromium_output_variables' ) ) {
	function chromium_output_variables() {
		global $product;
		if( $product->get_type() == "variable" && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) ){
			woocommerce_variable_add_to_cart();
			wc_get_template_part( 'loop/add-to-cart.php' );
		} else {
			wc_get_template_part( 'loop/add-to-cart.php' );
		}
	}
	add_action( 'woocommerce_after_shop_loop_item', 'chromium_output_variables', 10 );
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}


/* Breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 6 );

if (!function_exists('chromium_custom_breadcrumbs')) {
	function chromium_custom_breadcrumbs() {
		return array(
			'delimiter' => '<span><i class="fa fa-angle-right" aria-hidden="true"></i>
 </span>',
			'wrap_before' => '<nav class="woocommerce-breadcrumb">',
			'wrap_after' => '</nav>',
			'before' => '',
			'after' => '',
			'home' => esc_html_x( 'Home', 'breadcrumb', 'chromium' ),
		);
	}
	add_filter( 'woocommerce_breadcrumb_defaults', 'chromium_custom_breadcrumbs' );
}


/* Change woocommerce pagination args */
if (!function_exists('chromium_woo_pagination')) {
	function chromium_woo_pagination( $args ) {
		$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
		$args['next_text'] = '<i class="fa fa-angle-right"></i>';
		return $args;
	}
	add_filter( 'woocommerce_pagination_args', 	'chromium_woo_pagination' );
}


/* Wrapper for shop view controls */
if (!function_exists('chromium_shop_view_controls_wrapper_start')) {
	function chromium_shop_view_controls_wrapper_start() {
		echo '<div class="view-controls-wrapper">';
	}
	add_action( 'woocommerce_before_shop_loop', 'chromium_shop_view_controls_wrapper_start', 10 );
}
if (!function_exists('chromium_shop_view_controls_wrapper_end')) {
	function chromium_shop_view_controls_wrapper_end() {
		echo '</div>';
	}
	add_action( 'woocommerce_before_shop_loop', 'chromium_shop_view_controls_wrapper_end', 40 );
}


/* Single Product Page Modifications */
// Add woocommerce image gallery
if ( true == get_theme_mod( 'woocommerce_zoom', true ) ) {
	add_theme_support( 'wc-product-gallery-zoom' );
}
if ( true == get_theme_mod( 'woocommerce_lightbox', true ) ) {
	add_theme_support( 'wc-product-gallery-lightbox' );
}
if ( true == get_theme_mod( 'woocommerce_slider', true ) ) {
	add_theme_support( 'wc-product-gallery-slider' );
}
// Wrapper for product images
if ( ! function_exists( 'chromium_product_images_wrapper_start' ) ) {
	function chromium_product_images_wrapper_start() {
		echo '<div class="product-images-wrapper">';
	}
	add_action('woocommerce_before_single_product_summary', 'chromium_product_images_wrapper_start', 1);
}
if ( ! function_exists( 'chromium_product_images_wrapper_end' ) ) {
	function chromium_product_images_wrapper_end() {
		echo '</div>';
	}
	add_action('woocommerce_before_single_product_summary', 'chromium_product_images_wrapper_end', 21);
}
// Replacing Title & meta
if ( 'product-chrom-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {

	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

	if ( 'product-title-classic'  == get_theme_mod( 'single_product_title_position', 'product-title-classic' ) ) {
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 11);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 13);
	} else {
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 2);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
		add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_rating', 4);
	}


}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

if ( 'product-classic-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {
	add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 5);
}

// SKU
if (!function_exists('chromium_new_sku')) {
	function chromium_new_sku() {
		global $product;
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <div class="product_meta alt">
                <span class="sku_wrapper"><?php esc_html_e( 'Code:', 'chromium' ); ?> <span class="sku" itemprop="sku"><?php echo ( esc_attr($sku = $product->get_sku()) ) ? $sku : esc_html__( 'N/A', 'chromium' ); ?></span></span>
            </div>
		<?php endif;
	}
	if (  'product-chrom-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {
		if ( 'product-title-classic'  == get_theme_mod( 'single_product_title_position', 'product-title-classic' ) ) {
			add_action('woocommerce_single_product_summary', 'chromium_new_sku', 12);
		} else {
			add_action('woocommerce_before_single_product_summary', 'chromium_new_sku', 3);
		}

	}
}
// Availability block
if ( ! function_exists( 'chromium_availability_product_meta' ) ) {
	function chromium_availability_product_meta() {
		global $product;
		$availability = $product->get_availability();
		if ( empty( $availability['availability'] ) && $product->is_in_stock() ) {
			$availability['availability'] = esc_html__('In Stock', 'chromium');
		}
		if ( $product->is_in_stock() ) {
			echo '<span class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>';
		}
	}
	add_action('woocommerce_single_product_summary', 'chromium_availability_product_meta', 26);
}
// Wrapper for TM Wishlist & Compare
if ( ! function_exists( 'chromium_wishlist_compare_wrapper_start' ) ) {
	function chromium_wishlist_compare_wrapper_start() {
		if ( class_exists('TM_WC_Compare_Wishlist') ) {
			echo '<div class="wishlist-compare-wrapper">';
		}
	}
	add_action('woocommerce_single_product_summary', 'chromium_wishlist_compare_wrapper_start', 34);
}
if ( ! function_exists( 'chromium_wishlist_compare_wrapper_end' ) ) {
	function chromium_wishlist_compare_wrapper_end() {
		if ( class_exists('TM_WC_Compare_Wishlist') ) {
			echo '</div>';
		}
	}
	add_action('woocommerce_single_product_summary', 'chromium_wishlist_compare_wrapper_end', 36);
}
// New Meta wrapper for single product
if (!function_exists('chromium_product_meta_wrapper_start')) {
	function chromium_product_meta_wrapper_start() {
		echo '<div class="single-product-meta-wrapper">';
	}
	if (  'product-chrom-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {
		add_action('woocommerce_single_product_summary', 'chromium_product_meta_wrapper_start', 10);
	} else {
		add_action('woocommerce_after_single_product_summary', 'chromium_product_meta_wrapper_start', 1);
	}
}
if (!function_exists('chromium_product_meta_wrapper_end')) {
	function chromium_product_meta_wrapper_end() {
		echo '</div>';
	}
	if (  'product-chrom-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {
		add_action('woocommerce_single_product_summary', 'chromium_product_meta_wrapper_end', 40);
	} else {
		add_action('woocommerce_after_single_product_summary', 'chromium_product_meta_wrapper_end', 9);
	}
}


/* Related, Up-Sells, Cross-Sells */
// Related Products
if (!function_exists('chromium_output_related_products')) {
	function chromium_output_related_products($args) {
		if ( true == get_theme_mod( 'one_row_related_up_sells', false ) ) {
			$related_qty = 2;
		} else {
			if ( chromium_show_layout()!='layout-one-col' ) {
				$related_qty = 3;
			} else {
				$related_qty = 4;
			}
		}
		$args['posts_per_page'] = apply_filters('chromium_related_products_qty', esc_html($related_qty));
		$args['columns'] = apply_filters('chromium_related_products_cols', esc_html($related_qty));
		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'chromium_output_related_products' );
}
// Up-Sell Products
if (!function_exists('chromium_output_upsell_products')) {
	function chromium_output_upsell_products($args) {
		if ( true == get_theme_mod( 'one_row_related_up_sells', false ) ) {
			$upsells_qty = 2;
		} else {
			if ( chromium_show_layout()!='layout-one-col' ) {
				$upsells_qty = 3;
			} else {
				$upsells_qty = 4;
			}
		}
		$args['posts_per_page'] = apply_filters('chromium_upsell_products_qty', esc_html($upsells_qty));
		$args['columns'] = apply_filters('chromium_updell_products_cols', esc_html($upsells_qty));
		return $args;
	}
	add_filter( 'woocommerce_upsell_display_args', 'chromium_output_upsell_products' );
}


/* Cart Page Modifications */
// Clear Cart Button
if (!function_exists('chromium_clear_cart_url')) {
	function chromium_clear_cart_url() {
		global $woocommerce;
		if (isset($_REQUEST['empty-cart']) && $_REQUEST['empty-cart'] == 'clearcart') {
			$woocommerce->cart->empty_cart();
		}
	}
	add_action( 'init', 'chromium_clear_cart_url' );
}
if (!function_exists('chromium_clear_cart_html_button')) {
	function chromium_clear_cart_html_button() {
		global $woocommerce;
		$cart_url = $woocommerce->cart->wc_get_cart_url;
		if ( empty($_GET) ) {
			echo '<a class="button empty-cart" href="' . esc_url( $cart_url ) . '?empty-cart=clearcart">'. esc_html__( 'Delete All', 'chromium' ) .'</a>';
		} else {
			echo '<a class="button empty-cart" href="' . esc_url( $cart_url ) . '?empty-cart=clearcart">'. esc_html__( 'Delete All', 'chromium' ) .'</a>';
		}
	}
	add_action( 'woocommerce_before_cart', 'chromium_clear_cart_html_button', 10 );
}
// Custom Sidebar for Cart Page
if (!function_exists('chromium_custom_cart_sidebar')) {
	function chromium_custom_cart_sidebar() {
		if ( is_active_sidebar( 'sidebar-cart' ) ) : ?>
            <aside id="sidebar-cart" class="widget-area sidebar cart<?php if( true == get_theme_mod( 'grid_cart_widgets', true ) ) { echo ' grid'; } ?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-cart' ); ?>
            </aside>
		<?php endif;
	}
	if ( true == get_theme_mod( 'add_cart_sidebar', true ) ) {
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_cart_collaterals', 'chromium_custom_cart_sidebar', 5 );
	}
}
// Back to store button in cart
if (!function_exists('chromium_return_to_shop_cart_btn')) {
	function chromium_return_to_shop_cart_btn() {
		$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
		echo '<a class="link-to-shop" href="'.esc_url($shop_page_url).'" rel="nofollow">'.esc_html__('Continue Shopping', 'chromium').'<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
	}
	add_action('woocommerce_cart_actions', 'chromium_return_to_shop_cart_btn');
}


/* Checkout Modifications */
// Add special wrappers for coupon & login forms
if (!function_exists('chromium_checkout_login_wrap_start')) {
	function chromium_checkout_login_wrap_start() {
		if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
			return;
		}
		echo '<div class="login-wrapper">';
	}
	add_action('woocommerce_before_checkout_form', 'chromium_checkout_login_wrap_start', 9);
}
if (!function_exists('chromium_checkout_login_wrap_end')) {
	function chromium_checkout_login_wrap_end() {
		if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
			return;
		}
		echo '</div>';
	}
	add_action('woocommerce_before_checkout_form', 'chromium_checkout_login_wrap_end', 11);
}
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 13);
if (!function_exists('chromium_checkout_coupon_wrap_start')) {
	function chromium_checkout_coupon_wrap_start() {
		echo '<div class="coupon-wrapper">';
	}
	add_action('woocommerce_before_checkout_form', 'chromium_checkout_coupon_wrap_start',12);
}
if (!function_exists('chromium_checkout_coupon_wrap_end')) {
	function chromium_checkout_coupon_wrap_end() {
		echo '</div>';
	}
	add_action('woocommerce_before_checkout_form', 'chromium_checkout_coupon_wrap_end',14);
}
// Add wrapper for Order Review
if (!function_exists('chromium_order_review_wrap_start')) {
	function chromium_order_review_wrap_start() {
		echo '<div class="order-wrapper">';
	}
	add_action('woocommerce_checkout_after_customer_details', 'chromium_order_review_wrap_start');
}
if (!function_exists('chromium_order_review_wrap_end')) {
	function chromium_order_review_wrap_end() {
		echo '</div>';
	}
	add_action('woocommerce_checkout_after_order_review', 'chromium_order_review_wrap_end');
}
// Add product image to review order
if ( !function_exists('chromium_checkout_product_img') ) {
	function chromium_checkout_product_img( $title, $values, $cart_item_key ) {
		if ( is_checkout() ) {
			return '<span class="img">'.$values[ 'data' ]->get_image().'</span>'. $title;
		} else {
			return $title;
		}
	}
	add_filter( 'woocommerce_cart_item_name', 'chromium_checkout_product_img', 20, 3);
}
// payment methods title
if (!function_exists('chromium_checkout_review_order_table_wrap_end')) {
	function chromium_checkout_review_order_table_wrap_end() {
		echo '<h3 class="payments-title">'.esc_html__('Payment Methods', 'chromium').'</h3>';
	}
	add_action('woocommerce_checkout_order_review', 'chromium_checkout_review_order_table_wrap_end',15);
}
// Remove repeatable auth form
if (function_exists('oa_social_login_render_login_form')) {
	remove_action ('woocommerce_before_checkout_form', 'oa_social_login_render_custom_form_login');
}


/* Output Custom Product Labels on single product */
if ( ! function_exists('chromium_output_custom_labels' ) ) {
	function chromium_output_custom_labels() {
		global $post;
		$post_terms = get_the_terms( $post, 'product-custom-label');
		if ( ! is_array ( $post_terms ) ) $post_terms = [];
		$default = get_theme_mod( 'product_default_labels' );
		if ( is_array( $default ) && count ( $default ) ) {
		    $term_query = new WP_Term_Query( array( 'taxonomy' => 'product-custom-label', 'slug' => $default ) );
            $default_terms = $term_query->terms;
		} else $default_terms = [];

		if ( ( is_array($post_terms) && count( $post_terms ) ) || ( is_array( $default_terms ) && count( $default_terms ) ) ) {
		    if ( count( $default_terms ) )
                $terms = array_unique ( array_merge ($post_terms, $default_terms), SORT_REGULAR);
			else $terms = $post_terms;
		    echo '<div class="product-custom-labels-wrapper">';
			foreach ($terms as $term) {
				echo '<div class="single-label">';
				if ( isset($term->term_image) ) {
					echo wp_get_attachment_image( $term->term_image, 'thumbnail' );
				}
				if ( isset($term->name) ) echo '<span>' . esc_html($term->name) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
	}
	if ( 'product-classic-style' == get_theme_mod( 'single_product_style', 'product-chrom-style' ) ) {
		add_action('woocommerce_after_single_product_summary', 'chromium_output_custom_labels', 6);
	} else {
		add_action('woocommerce_single_product_summary', 'chromium_output_custom_labels', 45);
	}
}


/* Output Share Buttons on single product */
if (!function_exists('chromium_output_product_shares')) {
	function chromium_output_product_shares() {
		if ( function_exists('tz_share_buttons_output') ) :
			echo '<div class="product-shares-wrapper">';
			tz_share_buttons_output( get_the_ID() );
			echo '</div>';
		endif;
	}
	if ( true == get_theme_mod( 'product_shares', true ) ) {
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
		add_action('woocommerce_single_product_summary', 'chromium_output_product_shares', 50);
	}
}


/* Add primary category to product archive view */
if (!function_exists('chromium_primary_cat_output')) {
	function chromium_primary_cat_output() {
		$category = get_the_terms( get_the_ID(), 'product_cat' );
		/* SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY */
		if ( is_array($category) && count($category) && class_exists('WPSEO_Primary_Term') ) {
			$wpseo_primary_term = new WPSEO_Primary_Term( 'product_cat', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if ( !is_wp_error($term) ) {
				echo '<a class="primary-cat" href="'.esc_url(get_category_link( $term->term_id )).'">'.esc_html($term->name).'</a>';
			} else {
				echo '<a class="primary-cat" href="'.esc_url(get_category_link( $category[0]->term_id )).'">'.esc_html($category[0]->name).'</a>';
			}
		} elseif ( is_array($category) && count($category) )  {
			echo '<a class="primary-cat" href="'.esc_url(get_category_link( $category[0]->term_id )).'">'.esc_html($category[0]->name).'</a>';
		}
	}
	if ( true == get_theme_mod( 'primary_category_output', true ) ) {
		add_action( 'woocommerce_shop_loop_item_title', 'chromium_primary_cat_output', 3 );
	}
}


/* Change "Choose an option" text */
if (!function_exists('chromium_change_select_text')) {
	function chromium_change_select_text($html, $args){
		$html = str_replace('Choose an option', esc_html__('Select option', 'chromium'), $html);
		return $html;
	}
	add_filter('woocommerce_dropdown_variation_attribute_options_html', 'chromium_change_select_text', 10, 2);
}

// Catalog Mode

$catalog_mode = get_theme_mod( 'catalog_mode', false );

if ( $catalog_mode ) :

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
	remove_action('woocommerce_after_shop_loop_item','chromium_sale_product_percentage_label', 11 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

endif;