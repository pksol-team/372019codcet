<?php

// add shortcode hooks
add_shortcode( 'tm_woo_wishlist_table', 'tm_woowishlist_shortcode' );

/**
 * Renders wishlist shortcode.
 *
 * @since 1.0.0
 *
 * @param array $atts The array of shortcode attributes.
 */
function tm_woowishlist_shortcode( $atts ) {

	$atts = apply_filters( 'shortcode_atts_tm_woo_wishlist_table', $atts );

	return tm_woowishlist_render( $atts );
}