<?php

// add shortcode hooks
add_shortcode( 'tm_woo_compare_table', 'tm_woocompare_shortcode' );

/**
 * Renders compare list shortcode.
 *
 * @since 1.0.0
 * @shortcode tm_woo_compare_table
 */
function tm_woocompare_shortcode( $atts ) {

	wp_enqueue_style( 'tablesaw' );
	wp_enqueue_script( 'tablesaw-init' );

	return tm_woocompare_list_render();
}