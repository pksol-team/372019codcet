<?php
/**
 * Add filter taxonomy for Attachments
 */
function tz_add_attachment_filters() {
  $labels = array(
        'name'              => 'Gallery Filters',
        'singular_name'     => 'Gallery Filter',
        'search_items'      => 'Search Filters',
        'all_items'         => 'All Filters',
        'parent_item'       => 'Gallery Filter',
        'parent_item_colon' => 'Gallery Filter:',
        'edit_item'         => 'Edit Gallery Filter',
        'update_item'       => 'Update Gallery Filter',
        'add_new_item'      => 'Add New Gallery Filter',
        'new_item_name'     => 'New Gallery Filter Name',
        'menu_name'         => 'Filters',
  );

  $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'query_var' => 'true',
        'rewrite' => 'true',
        'show_admin_column' => 'true',
  );

  register_taxonomy( 'gallery-filter', 'attachment', $args );
}
add_action( 'init', 'tz_add_attachment_filters');


/**
 * Add Custom Labels taxonomy for Attachments
 */
function tz_add_custom_product_labels() {
  $labels = array(
        'name'              => 'Custom Labels',
        'singular_name'     => 'Custom Label',
        'search_items'      => 'Search Labels',
        'all_items'         => 'All Labels',
        'parent_item'       => 'Parent Custom Label',
        'parent_item_colon' => 'Parent Custom Label:',
        'edit_item'         => 'Edit Custom Label',
        'update_item'       => 'Update Custom Label',
        'add_new_item'      => 'Add New Custom Label',
        'new_item_name'     => 'New Custom Label Name',
        'menu_name'         => 'Custom Labels',
  );

  $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'query_var' => true,
        'rewrite' => true,
        'show_admin_column' => false,
  );

  register_taxonomy( 'product-custom-label', 'product', $args );
}
if ( class_exists('WooCommerce') ) {
  add_action( 'init', 'tz_add_custom_product_labels');

  function tz_the_term_image_taxonomy( $taxonomy ) {
		return array( 'product-custom-label' );
	}
	add_filter( 'taxonomy-term-image-taxonomy', 'tz_the_term_image_taxonomy' );
}
