<?php

// register action hooks

add_action( 'woocommerce_after_shop_loop_item', 'tm_woocompare_add_button_loop', 12 );

add_action( 'woocommerce_single_product_summary', 'tm_woocompare_add_button_single', 35 );

/**
 * Renders appropriate button for a loop product.
 *
 * @since 1.0.0
 * @action woocommerce_after_shop_loop_item
 */
function tm_woocompare_add_button_loop( $args ) {

	if ( 'yes' === get_option( 'tm_woocompare_show_in_catalog' ) ) {

		tm_woocompare_add_button( $args );
	}
}

/**
 * Renders appropriate button for a product.
 *
 * @since 1.0.0
 */
function tm_woocompare_add_button( $args ) {

	$id      = get_the_ID();
	$id      = tm_wc_compare_wishlist()->get_original_product_id( $id );
	$classes = array( 'button', 'tm-woocompare-button', 'btn', 'btn-default' );
	$nonce   = wp_create_nonce( 'tm_woocompare' . $id );

	if ( in_array( $id, tm_woocompare_get_list() ) ) {

		$text      = get_option( 'tm_woocompare_remove_text', __( 'Remove from Compare', 'tm-wc-compare-wishlist' ) );
		$classes[] = ' in_compare';

	} else {

		$text = get_option( 'tm_woocompare_compare_text', __( 'Add to Compare', 'tm-wc-compare-wishlist' ) );
	}
	$text      = '<span class="tm_woocompare_product_actions_tip"><span class="text">' . esc_html( $text ) . '</span></span>';
	$preloader = apply_filters( 'tm_wc_compare_wishlist_button_preloader', '' );

	if( $single = ( is_array( $args ) && isset( $args['single'] ) && $args['single'] ) ) {

		$classes[] = 'tm-woocompare-button-single';
	}
	$html = sprintf( '<button type="button" class="%s" data-id="%s" data-nonce="%s">%s</button>', implode( ' ', $classes ), $id, $nonce, $text . $preloader );

	echo apply_filters( 'tm_woocompare_button', $html, $classes, $id, $nonce, $text, $preloader );

	if( in_array( $id, tm_woocompare_get_list() ) && $single ) {

		echo tm_woocompare_page_button();
	}
}

/**
 * Renders appropriate button for a single product.
 *
 * @since 1.0.0
 * @action woocommerce_single_product_summary
 */
function tm_woocompare_add_button_single( $args ) {

	if ( 'yes' === get_option( 'tm_woocompare_show_in_single' ) ) {

		if( empty( $args ) ) {

			$args = array();
		}
		$args['single'] = true;

		tm_woocompare_add_button( $args );
	}
}

/**
 * Renders wishlist page button for a product.
 *
 * @since 1.0.0
 */
function tm_woocompare_page_button() {

	$link    = tm_woocompare_get_page_link();
	$classes = array( 'button', 'tm-woocompare-page-button', 'btn', 'btn-primary', 'alt' );
	$text    = __( 'View compare', 'tm-wc-compare-wishlist' );
	$html    = sprintf( '<a class="%s" href="%s">%s</a>', implode( ' ', $classes ), $link, $text );

	return apply_filters( 'tm_woocompare_page_button', $html, $classes, $link, $text );
}