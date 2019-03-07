<?php
// Page Layouts for Theme

function chromium_get_default_layouts() {

	$layouts = get_theme_support( 'chromium-layouts' );

	if (isset( $layouts[0] )){
		return $layouts[0];
	} else {
		esc_html__('Specify layouts first!', 'chromium');};
};

function chromium_get_term_layout( $term_id ) {
	/* Get the post layout. */
	$layout = get_term_meta( $term_id, '-chromium-layout', true );
	/* Return the layout if one is found.  Otherwise, return 'default'. */
	return ( !empty( $layout ) ? $layout : 'default' );
	return $layout;
}

function chromium_get_post_layout( $post_id ) {
	/* Get the post layout. */
	$layout = get_post_meta( $post_id, '-chromium-layout', true );
	/* Return the layout if one is found.  Otherwise, return 'default'. */
	return ( !empty( $layout ) ? $layout : 'default' );
	return $layout;
}

function chromium_show_layout() {
	global $wp_query;

	/* Set the layout to default. */
	$layout = 'one-col';

	/* Get vendor store pages */
	$vendor_shop = '';
	if ( class_exists('WCV_Vendors') ) {
		$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
	}

	/* Page variable */
	$current_page = '';
	// if front page
	if (is_page() && is_front_page()) {
		$current_page = 'front_page';
	}
	// if simple page
	elseif (is_page() && ! ( class_exists('WooCommerce') && ( is_cart() || is_checkout() ) ) ) {
		$current_page = 'page';
	}
	// if single post
	elseif ( is_single() && !( class_exists('WooCommerce') && is_product() ) && !$vendor_shop ) {
		$current_page = 'single_post';
	}
	// if shop page
	elseif ( ( class_exists('WooCommerce') && is_shop() && !$vendor_shop ) ||
			 ( is_archive() && class_exists('WooCommerce') && is_shop() && !$vendor_shop ) ||
			 ( class_exists('WooCommerce') && is_product_category() ) ||
			 ( class_exists('WooCommerce') && is_product_tag() ) ||
			 ( class_exists('WooCommerce') && is_product_taxonomy() )
		   ) {
		$current_page = 'shop_page';
	}

	elseif ( class_exists('WooCommerce') && ( is_cart() || is_checkout() ) ) {
		$current_page = 'checkout';
	}
	// if single product
	elseif ( ( class_exists('WooCommerce') && is_product() ) ||
			 ( is_singular() && class_exists('WooCommerce') && is_product() )
		   ) {
		$current_page = 'single_product';
	}
	// if vendor page
	elseif ( $vendor_shop && $vendor_shop !='' )
		     {
		$current_page = 'vendor_store';
	}
	// if blog pages (blog, archives, search, etc)
	elseif ( is_home() || is_category() || is_tag() || is_tax() || is_archive() || is_search() ) {
		$current_page = 'blog_page';
	}


  /* Global layout options from admin panel */
	$global_shop_layout = get_theme_mod( 'shop_layout', $layout );
	$global_product_layout = get_theme_mod( 'product_layout', $layout );
	$global_front_layout = get_theme_mod( 'front_layout', $layout );
	$global_page_layout = get_theme_mod( 'page_layout', $layout );
	$global_blog_layout = get_theme_mod( 'blog_layout', $layout );
	$global_single_layout = get_theme_mod( 'single_layout', $layout );

	switch ($current_page) {
		case 'front_page':
			if ( isset($global_front_layout)  ) {
				$layout = $global_front_layout;
			}

			if ( ! is_active_sidebar( 'sidebar-blog' ) && ! is_active_sidebar( 'sidebar-front' ) ) $layout = 'one-col';

			break;
		case 'page':
			if ( isset($global_page_layout) ) {
				$layout = $global_page_layout;
			}

			if ( ! is_active_sidebar( 'sidebar-blog' ) && ! is_active_sidebar( 'sidebar-pages' ) ) $layout = 'one-col';

			break;
		case 'single_post':
			$layout = $global_single_layout;
			if ( ! is_active_sidebar( 'sidebar-blog' ) ) $layout = 'one-col';
			break;
		case 'single_product':
			$layout = $global_product_layout;
			if ( ! is_active_sidebar( 'sidebar-product' ) ) $layout = 'one-col';
			break;
		case 'shop_page':
			if ( isset($global_shop_layout) ) {
				$layout = $global_shop_layout;
			}
			if ( ! is_active_sidebar( 'sidebar-shop' ) ) $layout = 'one-col';
			break;

		case 'checkout':
			$layout = 'one-col';
			break;

		case 'blog_page':
			if ( isset($global_blog_layout) ) {
				$layout = $global_blog_layout;
			}

			if ( ! is_active_sidebar( 'sidebar-blog' ) ) $layout = 'one-col';

			break;
		default:
			$layout = 'one-col';

	}

	/* Return the layout and allow plugin/theme developers to override it. */
	return esc_attr( apply_filters( 'get_theme_layout', "layout-{$layout}" ) );
}

function chromium_layout_body_class( $classes ) {

	/* Adds the layout to array of body classes. */
	$classes[] = sanitize_html_class( chromium_show_layout() );

	/* Return the $classes array. */
	return $classes;
}
add_filter( 'body_class', 'chromium_layout_body_class' );
