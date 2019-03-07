<?php

if ( is_admin() ) {
	require_once TM_WC_COMPARE_WISHLIST_PATH . 'includes/wishlist/settings.php';
}

if ( 'yes' !== get_option( 'tm_woowishlist_enable' ) ) {

	return;
}
require_once 'buttons.php';

if ( ! is_admin() ) {

	require_once 'shortcode.php';
}
require_once 'widget.php';

// register action hooks
add_action( 'wp_enqueue_scripts', 'tm_woowishlist_setup_plugin' );

add_action( 'wp_ajax_tm_woowishlist_add', 'tm_woowishlist_process_button_action' );
add_action( 'wp_ajax_nopriv_tm_woowishlist_add', 'tm_woowishlist_process_button_action' );

add_action( 'wp_ajax_tm_woowishlist_remove', 'tm_woowishlist_process_remove_button_action' );
add_action( 'wp_ajax_nopriv_tm_woowishlist_remove', 'tm_woowishlist_process_remove_button_action' );

add_action( 'wp_ajax_tm_woowishlist_update', 'tm_woowishlist_process_ajax' );
add_action( 'wp_ajax_nopriv_tm_woowishlist_update', 'tm_woowishlist_process_ajax' );

add_action( 'init', 'tm_woowislist_session_to_db' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @action wp_enqueue_scripts
 */
function tm_woowishlist_setup_plugin() {

	wp_enqueue_style( 'tm-woowishlist' );
	wp_enqueue_script( 'tm-woowishlist' );

	$include_bootstrap_grid = apply_filters( 'tm_woocommerce_include_bootstrap_grid', true );

	if ( $include_bootstrap_grid ) {

		wp_enqueue_style( 'bootstrap-grid' );
	}
}

/**
 * Returns wishlist list.
 *
 * @sicne 1.0.0
 *
 * @return array The array of product ids to wishlist.
 */
function tm_woowishlist_get_list() {

	if( is_user_logged_in() ) {

		$id   = get_current_user_id();
		$list = get_user_meta( $id, 'tm_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );

		} else {

			$list = array();
		}
	} else {

		$list = ! empty( $_SESSION['tm-woowishlist'] ) ? $_SESSION['tm-woowishlist'] : array();

		if ( ! empty( $list ) ) {

			$list  = explode( ':', $list );
			$nonce = array_pop( $list );

			if ( ! wp_verify_nonce( $nonce, implode( $list ) ) ) {

				$list = array();
			}
		}
	}
	return $list;
}

/**
 * Sets new list of products to wishlist.
 *
 * @since 1.0.0
 *
 * @param array $list The new array of products to wishlist.
 */
function tm_woowishlist_set_list( $list ) {

	$nonce                      = wp_create_nonce( implode( $list ) );
	$value                      = implode( ':', array_merge( $list, array( $nonce ) ) );
	if ( ! session_id() ) {

		session_start();
	}
	$_SESSION['tm-woowishlist'] = $value;
}

/**
 * Returns wishlist page link.
 *
 * @since 1.0.0
 *
 * @return string The wishlist page link on success, otherwise FALSE.
 */
function tm_woowishlist_get_page_link() {

	$page_id = intval( get_option( 'tm_woowishlist_page', '' ) );

	if ( ! $page_id ) {

		return false;
	}
	$page_link = get_permalink( $page_id );

	if ( ! $page_link ) {

		return false;
	}
	return trailingslashit( $page_link );
}

/**
 * Processes buttons actions.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_tm_woowishlist_add_to_list
 */
function tm_woowishlist_process_button_action() {

	$id = filter_input( INPUT_POST, 'pid' );

	if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce' ), 'tm_woowishlist' . $id ) ) {

		wp_send_json_error();
	}
	$button = json_decode( filter_input( INPUT_POST, 'single' ) ) ? tm_woowishlist_page_button() : false;

	tm_woowishlist_add( $id );

	wp_send_json_success( array(
		'action'          => $action,
		'wishlistPageBtn' => $button
	) );
}

/**
 * Returns message when is no products in wishlist.
 *
 * @since 1.0.0
 *
 * @return string The message
 */
function tm_woowishlist_empty_message() {

	$empty_text = get_option( 'tm_woowishlist_empty_text', __( 'No products added to wishlist.', 'tm-wc-compare-wishlist' ) );

	return apply_filters( 'tm_woowishlist_empty_message', sprintf( '<p class="tm-woowishlist-empty">%s</p>', $empty_text ), $empty_text );
}

/**
 * Processes main ajax handler.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_tm_woowishlist_update
 */
function tm_woowishlist_process_ajax() {

	$is_page   = json_decode( filter_input( INPUT_POST, 'isWishlistPage' ) );
	$is_widget = json_decode( filter_input( INPUT_POST, 'isWidget' ) );
	$json      = array();
	$atts      = json_decode( filter_input( INPUT_POST, 'wishListData' ), true );

	if ( $is_page ) {

		$json['wishList'] = tm_woowishlist_render_table( $atts );
	}
	if ( $is_widget ) {

		$json['widget'] = tm_woowishlist_render_widget();
	}
	wp_send_json_success( $json );
}

/**
 * Processes remove button action.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_tm_woowishlist_remove
 */
function tm_woowishlist_process_remove_button_action() {

	$id = filter_input( INPUT_POST, 'pid' );

	if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce' ), 'tm_woowishlist' . $id ) ) {

		wp_send_json_error();
	}
	tm_woowishlist_remove( $id );

	tm_woowishlist_process_ajax();
}

/**
 * Adds product to wishlist.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to add to the wishlist.
 */
function tm_woowishlist_add( $id ) {

	$id = intval( $id );

	if( is_user_logged_in() ) {

		$user_id = get_current_user_id();
		$list    = get_user_meta( $user_id, 'tm_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );

		} else {

			$list = array();
		}
		$list[] = $id;
		$list   = array_unique( $list );
		$list   = serialize( $list );

		update_user_meta( $user_id, 'tm_woo_wishlist_items', $list );

	} else {

		$list   = tm_woowishlist_get_list();
		$list[] = $id;
		$list   = array_unique( $list );

		tm_woowishlist_set_list( $list );
	}
}

/**
 * Removes product from wishlist list.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to remove from wishlist.
 */
function tm_woowishlist_remove( $id ) {

	$id = intval( $id );

	if( is_user_logged_in() ) {

		$user_id = get_current_user_id();
		$list    = get_user_meta( $user_id, 'tm_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );
			$key  = array_search( $id, $list );

			if ( false !== $key ) {

				unset( $list[$key] );
			}
			$list = serialize( $list );

			update_user_meta( $user_id, 'tm_woo_wishlist_items', $list );

		}

	} else {

		$list = tm_woowishlist_get_list();
		$key  = array_search( $id, $list );

		if ( false !== $key ) {

			unset( $list[$key] );
		}
		tm_woowishlist_set_list( $list );
	}
}

/**
 * Get products added to wishlist.
 *
 * @since 1.0.0
 *
 * @param array $list The array of products ids.
 * @return object The list of products
 */
function tm_woowishlist_get_products( $list ) {

	$args = array(
		'post_type'      => 'product',
		'post__in'       => $list,
		'orderby'        => 'post__in',
		'posts_per_page' => -1
	);
	$products = new WP_Query( $args );

	wp_reset_query();

	return $products;
}

/**
 * Renders wishlist.
 *
 * @since 1.0.0
 *
 * @return string Wishlist HTML.
 */
function tm_woowishlist_render( $atts = array() ) {

	$content                = array();
	$class                  = isset( $atts['class'] ) && ! empty( $atts['class'] ) ? $atts['class'] : '';
	$tm_wc_compare_wishlist = tm_wc_compare_wishlist();
	$data_atts              = $tm_wc_compare_wishlist->build_html_dataattributes( $atts );
	$content[]              = '<div class="woocommerce tm-woowishlist ' . $class . '"' . $data_atts . '>';
	$content[]              = '<div class="woocommerce tm-woowishlist-wrapper">';
	$content[]              = tm_woowishlist_render_table( $atts );
	$content[]              = '</div>';
	$content[]              = $tm_wc_compare_wishlist->get_loader();
	$content[]              = '</div>';

	return implode( "\n", $content );
}

/**
 * Renders wishlist widget.
 *
 * @since 1.0.0
 *
 * @return string Wishlist widget HTML.
 */
function tm_woowishlist_render_widget() {

	$list = tm_woowishlist_get_list();

	if ( empty( $list ) ) {

		return tm_woowishlist_empty_message();
	}
	$templater = tm_wc_compare_wishlist_templater();
	$products  = tm_woowishlist_get_products( $list );
	$template  = get_option( 'tm_woowishlist_widget_template', 'widget.tmpl' );
	$template  = $templater->get_template_by_name( $template, 'tm-woowishlist' );

	if( ! $template ) {

		$template = $templater->get_template_by_name( 'widget.tmpl', 'tm-woowishlist' );
	}
	$content                = array();
	$tm_wc_compare_wishlist = tm_wc_compare_wishlist();

	if ( $products->have_posts() ) {

		$content[] = '<div class="tm-woowishlist-widget-products">' . "\n";

		while ( $products->have_posts() ) {

			$products->the_post();

			global $product;

			if ( empty( $product ) ) {

				continue;
			}
			$pid          = method_exists( $product, 'get_id' ) ? $product->get_id() : get_the_id();
			$pid          = $tm_wc_compare_wishlist->get_original_product_id( $pid );
			$nonce        = wp_create_nonce( 'tm_woowishlist' . $pid );
			$dismiss_icon = apply_filters( 'tm_woowishlist_dismiss_icon', '<span class="dashicons dashicons-dismiss"></span>' );
			$content[]    = '<div class="tm-woowishlist-widget-product">' . "\n";
			$content[]    = '<span class="tm-woowishlist-remove" data-id="' . $pid . '" data-nonce="' . $nonce . '">' . $dismiss_icon . '</span>';
			$content[]    = $templater->parse_template( $template );
			$content[]    = '</div>';
		}
		wp_reset_query();

		$content[] = '</div>';
		$content[] = tm_woowishlist_page_button( array( 'btn-default' ) );
		$content[] = $tm_wc_compare_wishlist->get_loader();
	}
	return implode( "\n", $content );
}

/**
 * Renders wishlist table.
 *
 * @since 1.0.0
 *
 * @param array $atts The wishlist table attributes.
 * @return string Wishlist table HTML.
 */
function tm_woowishlist_render_table( $atts = array() ) {

	$list = tm_woowishlist_get_list();

	if ( empty( $list ) ) {

		return tm_woowishlist_empty_message();
	}
	$html      = array();
	$templater = tm_wc_compare_wishlist_templater();
	$products  = tm_woowishlist_get_products( $list );
	$template  = isset( $atts['template'] ) && ! empty( $atts['template'] ) ? $atts['template'] : get_option( 'tm_woowishlist_page_template', 'page.tmpl' );
	$cols      = isset( $atts['cols'] )     && ! empty( $atts['cols'] )     ? $atts['cols']     : get_option( 'tm_woowishlist_cols', '1' );
	$cols      = 4 < $cols                                                  ? 4                 : $cols;
	$template  = $templater->get_template_by_name( $template, 'tm-woowishlist' );

	if( ! $template ) {

		$template = $templater->get_template_by_name( 'page.tmpl', 'tm-woowishlist' );
	}
	$html[] = '<div class="row">';
	$class  = apply_filters( 'tm_woowishlist_column_class', 'col-lg-' . round( 12 / $cols ) . ' col-xs-12', $cols );

	while ( $products->have_posts() ) {

		$products->the_post();

		global $product;

		if ( empty( $product ) ) {

			continue;
		}
		$pid           = method_exists( $product, 'get_id' ) ? $product->get_id() : get_the_id();
		$pid           = tm_wc_compare_wishlist()->get_original_product_id( $pid );
		$html[]       = '<div class="' . $class . '">';
		$html[]       = '<div class="tm-woowishlist-item">';
		$nonce        = wp_create_nonce( 'tm_woowishlist' . $pid );
		$dismiss_icon = apply_filters( 'tm_woowishlist_dismiss_icon', '<span class="dashicons dashicons-dismiss"></span>' );
		$html[]       = '<div class="tm-woowishlist-remove" data-id="' . $pid . '" data-nonce="' . $nonce . '">' . $dismiss_icon . '</div>';
		$html[]       = $templater->parse_template( $template, $atts );
		$html[]       = '</div>';
		$html[]       = '</div>';
	}
	wp_reset_query();

	$html[] = '</div>';

	return implode( "\n", $html );
}

function tm_woowislist_session_to_db() {

	if ( is_user_logged_in() ) {

		$list         = tm_woowishlist_get_list();
		$session_list = ! empty( $_SESSION['tm-woowishlist'] ) ? $_SESSION['tm-woowishlist'] : array();

		if ( ! empty( $session_list ) ) {

			$session_list = explode( ':', $session_list );
			$nonce        = array_pop( $session_list );
		}
		if ( ! empty( $session_list ) ) {

			foreach ( $session_list as $product_id ) {

				if( ! in_array( $product_id, $list ) ) {

					tm_woowishlist_add( $product_id );
				}
			}
			tm_woowishlist_set_list( array() );
		}
	}
}