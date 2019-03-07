<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {

	header( 'HTTP/1.0 404 Not Found', true, 404 );

	exit;
}

// register action hooks
add_action( 'woocommerce_settings_start', 'tm_woowishlist_register_settings' );
add_action( 'woocommerce_settings_tm_woowishlist', 'tm_woowishlist_render_settings_page' );
add_action( 'woocommerce_update_options_tm_woowishlist', 'tm_woowishlist_update_options' );

// register filter hooks
add_filter( 'woocommerce_settings_tabs_array', 'tm_woowishlist_register_settings_tab', PHP_INT_MAX );

/**
 * Returns array of the plugin settings, which will be rendered in the
 * WooCommerce settings tab.
 *
 * @since 1.0.0
 *
 * @return array The array of the plugin settings.
 */
function tm_woowishlist_get_settings() {

	return array(
		array(
			'id'      => 'general-options',
			'type'    => 'title',
			'title'   => __( 'General Options', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woowishlist_enable',
			'title'   => __( 'Enable wishlist', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable wishlist functionality.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'single_select_page',
			'id'      => 'tm_woowishlist_page',
			'class'   => 'chosen_select_nostd',
			'title'   => __( 'Select wishlist page', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Select a page which will display wishlist.', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woowishlist_show_in_catalog',
			'title'   => __( 'Show in catalog', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable wishlist button for catalog list.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'tm_woowishlist_show_in_single',
			'title'   => __( 'Show in products page', 'tm-wc-compare-wishlist' ),
			'desc'    => __( 'Enable wishlist button for single product page.', 'tm-wc-compare-wishlist' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_add_text',
			'title'   => __( 'Add to wishlist button text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the add to wishlist button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Add to Wishlist', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_added_text',
			'title'   => __( 'Added to wishlist button text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the add to wishlist button, when product is added.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Added to Wishlist', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_page_btn_text',
			'title'   => __( 'Wishlist page button text' , 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the wishlist page button.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'Go to my wishlist', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_empty_text',
			'title'   => __( 'Empty wishlist text', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the wishlist page when is no products.', 'tm-wc-compare-wishlist' ),
			'default' => __( 'No products added to wishlist.', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'select',
			'id'      => 'tm_woowishlist_cols',
			'title'   => __( 'Wishlist columns', 'tm-wc-compare-wishlist' ),
			'desc'    => '<br>' . __( 'Choose a number of columns.', 'tm-wc-compare-wishlist' ),
			'default' => '1',
			'options' => array(
				'1'   => '1',
				'2'   => '2',
				'3'   => '3',
				'4'   => '4',
			)
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_page_template',
			'title'   => __( 'Page template', 'tm-wc-compare-wishlist' ),
			'default' => __( 'page.tmpl', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'tm_woowishlist_widget_template',
			'title'   => __( 'Widget template', 'tm-wc-compare-wishlist' ),
			'default' => __( 'widget.tmpl', 'tm-wc-compare-wishlist' ),
		),
		array(
			'type'    => 'sectionend',
			'id'      => 'general-options'
		),
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
function tm_woowishlist_register_settings() {

	global $woocommerce_settings;

	$woocommerce_settings['tm_woowishlist'] = tm_woowishlist_get_settings();
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
function tm_woowishlist_register_settings_tab( $tabs ) {

	$tabs['tm_woowishlist'] = esc_html__( 'TM Wishlist', 'tm-wc-compare-wishlist' );

	return $tabs;
}

/**
 * Renders plugin settings tab.
 *
 * @since 1.0.0
 * @action woocommerce_settings_tm_woowishlist
 *
 * @global array $woocommerce_settings The aggregate array of WooCommerce settings.
 * @global string $current_tab The current WooCommerce settings tab.
 */
function tm_woowishlist_render_settings_page() {

	global $woocommerce_settings, $current_tab;

	if ( function_exists( 'woocommerce_admin_fields' ) ) {

		woocommerce_admin_fields( $woocommerce_settings[$current_tab] );
	}
}

/**
 * Updates plugin settings after submission.
 *
 * @since 1.0.0
 * @action woocommerce_update_options_tm_woowishlist
 */
function tm_woowishlist_update_options() {

	if ( function_exists( 'woocommerce_update_options' ) ) {

		woocommerce_update_options( tm_woowishlist_get_settings() );
	}
}