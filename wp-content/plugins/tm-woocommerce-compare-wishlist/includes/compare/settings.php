<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {

	header( 'HTTP/1.0 404 Not Found', true, 404 );

	exit;
}

// register action hooks
add_action( 'woocommerce_settings_start', 'tm_woocompare_register_settings' );
add_action( 'woocommerce_settings_tm_woocompare_list', 'tm_woocompare_render_settings_page' );
add_action( 'woocommerce_update_options_tm_woocompare_list', 'tm_woocompare_update_options' );

// register filter hooks
add_filter( 'woocommerce_settings_tabs_array', 'tm_woocompare_register_settings_tab', PHP_INT_MAX );

/**
 * Returns array of the plugin settings, which will be rendered in the
 * WooCommerce settings tab.
 *
 * @since 1.0.0
 *
 * @return array The array of the plugin settings.
 */
function tm_woocompare_get_settings() {

	return array(
		array(
			'id'    => 'general-options',
			'type'  => 'title',
			'title' => __( 'General Options', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woocompare_enable',
			'title'   => __( 'Enable compare', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable compare functionality.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'  => 'single_select_page',
			'id'    => 'tm_woocompare_page',
			'class' => 'chosen_select_nostd',
			'title' => __( 'Select compare page', 'tm-wc-compare-wishlist' ),
			'desc'  => '<br>' . __( 'Select a page which will display compare list.', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woocompare_show_in_catalog',
			'title'   => __( 'Show in catalog', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable compare functionality for catalog list.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woocompare_show_in_single',
			'title'   => __( 'Show in products page', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable compare functionality for single product page.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_compare_text',
			'title'   => __( 'Compare button text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the add to compare button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Add to Compare', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_remove_text',
			'title'   => __( 'Remove button text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the remove from compare button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Remove from Compare', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_page_btn_text',
			'title'   => __( 'Page button text' , 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the compare page button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Compare products' , 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_empty_btn_text',
			'title'   => __( 'Empty button text' , 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the empty compare button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Empty compare' , 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_empty_text',
			'title'   => __( 'Empty compare list text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the compare page when is nothing to compare.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'No products found to compare.', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_page_template',
			'title'   => __( 'Page template', 'tm-wc-compare-wishlist' ),
			'default' => __( 'page.tmpl', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woocompare_widget_template',
			'title'   => __( 'Widget template', 'tm-wc-compare-wishlist' ),
			'default' => __( 'widget.tmpl', 'tm-wc-compare-wishlist' ),
		),
		array( 'type' => 'sectionend', 'id' => 'general-options' ),
	);
}

/**
 * Registers plugin settings in the WooCommerce settings array.
 *
 * @since 1.0.0
 * @action woocommerce_settings_start
 *
 * @global array $woocommerce_settings WooCommerce settings array.
 */
function tm_woocompare_register_settings() {

	global $woocommerce_settings;

	$woocommerce_settings['tm_woocompare_list'] = tm_woocompare_get_settings();
}

/**
 * Registers WooCommerce settings tab which will display the plugin settings.
 *
 * @since 1.0.0
 * @filter woocommerce_settings_tabs_array PHP_INT_MAX
 *
 * @param array $tabs The array of already registered tabs.
 * @return array The extended array with the plugin tab.
 */
function tm_woocompare_register_settings_tab( $tabs ) {

	$tabs['tm_woocompare_list'] = esc_html__( 'TM Compare List', 'tm-wc-compare-wishlist' );

	return $tabs;
}

/**
 * Renders plugin settings tab.
 *
 * @since 1.0.0
 * @action woocommerce_settings_tm_woocompare_list
 *
 * @global array $woocommerce_settings The aggregate array of WooCommerce settings.
 * @global string $current_tab The current WooCommerce settings tab.
 */
function tm_woocompare_render_settings_page() {

	global $woocommerce_settings, $current_tab;

	if ( function_exists( 'woocommerce_admin_fields' ) ) {

		woocommerce_admin_fields( $woocommerce_settings[$current_tab] );
	}
}

/**
 * Updates plugin settings after submission.
 *
 * @since 1.0.0
 * @action woocommerce_update_options_tm_woocompare_list
 */
function tm_woocompare_update_options() {

	if ( function_exists( 'woocommerce_update_options' ) ) {

		woocommerce_update_options( tm_woocompare_get_settings() );
	}
}