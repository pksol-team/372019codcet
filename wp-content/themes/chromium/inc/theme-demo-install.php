<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'chromium_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function chromium_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'               => 'Themes Zone Feature Pack',
			'slug'               => 'tz-feature-pack',
			'source'             => get_template_directory() . '/dummy-data/tz-feature-pack.zip',
			'required'           => true,
			'version'            => '1.0.9',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),

		array(
			'name'      => 'Elementor',
			'slug'      => 'elementor',
			'required'  => true,
		),

		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		array(
			'name'      => 'Kirki Toolkit',
			'slug'      => 'kirki',
			'required'  => false,
		),

		array(
			'name'      => 'MailChimp',
			'slug'      => 'mailchimp',
			'required'  => false,
		),

		array(
			'name'      => 'Max Mega Menu',
			'slug'      => 'megamenu',
			'required'  => false,
		),

		array(
			'name'      => 'One Click Demo Import',
			'slug'      => 'one-click-demo-import',
			'required'  => false,
		),

		array(
			'name'      => 'Force Regenerate Thumbnails',
			'slug'      => 'force-regenerate-thumbnails',
			'required'  => false,
		),

		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),

		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),

		array(
			'name'      => 'AJAX Search for WooCommerce',
			'slug'      => 'ajax-search-for-woocommerce',
			'required'  => false,
		),

		array(
			'name'      => 'TM WooCommerce Compare & Wishlist',
			'slug'      => 'tm-woocommerce-compare-wishlist',
			'required'  => false,
		),

		array(
			'name'      => 'WCK - Custom Fields and Custom Post Types Creator',
			'slug'      => 'wck-custom-fields-and-custom-post-types-creator',
			'required'  => false,
		)

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'chromium',              // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                     // Message to output right before the plugins table.,                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                 // Message to output right before the plugins table.,                      // If 'dismissable' is false, this message will be output at top of nag.
	);

	tgmpa( $plugins, $config );
}

/* Sample Data Installation filter */
if (class_exists('OCDI_Plugin')) {
	function chromium_import_sample_data() {
	 return array(
			 array(
					 'import_file_name'             => 'Chromium Demo (Local Shop)',
					 'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'dummy-data/demo1/chromium-widgets.wie',
					 'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'dummy-data/demo1/chromium-customizer.dat',
				     'local_import_file'            => trailingslashit( get_template_directory() ) . 'dummy-data/demo1/chromium-content.xml',
					 'import_preview_image_url'     => 'http://chromium.themes.zone/wp-content/uploads/2018/05/Chromium_page1.jpg',
					 'import_notice'                => esc_html__( "Don't forget to rebuild all of your thumbnails after import.", 'chromium' ),
			 ),
			 array(
					 'import_file_name'             => 'Chromium Demo (Marketplace)',
					 'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'dummy-data/demo2/chromium-widgets.wie',
					 'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'dummy-data/demo2/chromium-customizer.dat',
				     'local_import_file'            => trailingslashit( get_template_directory() ) . 'dummy-data/demo2/chromium-content.xml',
					 'import_preview_image_url'     => 'http://chromium.themes.zone/wp-content/uploads/2018/05/Chromium_page2.jpg',
					 'import_notice'                => esc_html__( "Don't forget to rebuild all of your thumbnails after import.", 'chromium' ),
			 ),

			 array(
					 'import_file_name'             => 'Chromium Demo (Supermarket)',
					 'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'dummy-data/demo3/chromium-widgets.wie',
					 'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'dummy-data/demo3/chromium-customizer.dat',
				     'local_import_file'            => trailingslashit( get_template_directory() ) . 'dummy-data/demo3/chromium-content.xml',
					 'import_preview_image_url'     => 'http://chromium.themes.zone/wp-content/uploads/2018/05/Chromium_page3.jpg',
					 'import_notice'                => esc_html__( "Don't forget to rebuild all of your thumbnails after import.", 'chromium' ),
			 ),

			 array(
				 'import_file_name'             => 'Chromium Demo (Portal)',
				 'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'dummy-data/demo4/chromium-widgets.wie',
				 'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'dummy-data/demo4/chromium-customizer.dat',
				 'local_import_file'            => trailingslashit( get_template_directory() ) . 'dummy-data/demo4/chromium-content.xml',
				 'import_preview_image_url'     => 'http://chromium.themes.zone/wp-content/uploads/2018/08/Chromium_portal_opt.jpg',
				 'import_notice'                => esc_html__( "Don't forget to rebuild all of your thumbnails after import.", 'chromium' ),
			 ),
	 );
 }
 add_filter( 'pt-ocdi/import_files', 'chromium_import_sample_data' );

 add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

 function chromium_change_time_of_single_ajax_call() {
	return 20;
 }
 add_action( 'pt-ocdi/time_for_one_ajax_call', 'chromium_change_time_of_single_ajax_call' );

 /* New Intro text for Data Installer */
 function chromium_intro_text( $default_text ) {
    $default_text .= '
		<div class="ocdi__intro-text">
				<p>'.esc_html__('PHP Requirements', 'chromium').':</p>
				<ul>
					<li><strong>upload_max_filesize</strong> - 256M</li>
					<li><strong>max_input_time</strong> - 300</li>
					<li><strong>memory_limit</strong> - 256M</li>
					<li><strong>max_execution_time</strong> - 300</li>
					<li><strong>post_max_size</strong> - 512M</li>
				</ul>
				<p>'.esc_html__('You can always restore default values for PHP variables after installing sample data.','chromium').'</p>
				<p><b>'.esc_html__('IMPORTANT', 'chromium').'</b> '.esc_html__('Most of the images used for demo data are stock photos. If you wish to reuse those images on your live site please acquire a license. The list of resources is provided in the themes documentation.', 'chromium').'</p>
				<p>
				<hr><b>'.esc_html__('IMPORTANT', 'chromium').'</b> '.esc_html__('If your server does not have required resources to import Demo Data it will result in corrupted content, in this case you can import Demo Data manually though WordPress importer (Contact our Support if you don\'t know how to).', 'chromium').'</p>
		</div>';
    return $default_text;
	}
	add_filter( 'pt-ocdi/plugin_intro_text', 'chromium_intro_text' );

	/* Update theme mod before widgets setup */
	function chromium_before_widgets_import( $selected_import ) {
		if ( 'Chromium Demo (Supermarket)' === $selected_import['import_file_name'] ) {
			set_theme_mod( 'primary_nav_widgets_position', 'right');
			set_theme_mod( 'primary_nav_widgets', true);
		}
	}
	add_action( 'pt-ocdi/before_widgets_import', 'chromium_before_widgets_import' );

 /* Update wp options after data installation complete */
 function chromium_after_import_setup( $selected_import ) {

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Front Page' );
    $blog_page_id  = get_page_by_title( 'Blog' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
		update_option( 'posts_per_page', 4 );

		// Update default options for Woocommerce Wishlist/Compare
		if ( class_exists('TM_WC_Compare_Wishlist') ) {
			$compare_page_id  = get_page_by_title( 'Compare' );
			$wishlist_page_id  = get_page_by_title( 'Wishlist' );
			update_option( 'tm_woocompare_enable', 'yes' );
			update_option( 'tm_woocompare_show_in_catalog', 'yes' );
			update_option( 'tm_woocompare_show_in_single', 'yes' );
			update_option( 'tm_woocompare_compare_text', 'Add to Compare' );
			update_option( 'tm_woocompare_remove_text', 'Added. Remove?' );
			update_option( 'tm_woocompare_page_btn_text', 'Compare products' );
			update_option( 'tm_woocompare_empty_btn_text', 'Empty compare' );
			update_option( 'tm_woocompare_empty_text', 'No products found to compare.' );
			update_option( 'tm_woocompare_page_template', 'page.tmpl' );
			update_option( 'tm_woocompare_widget_template', 'widget.tmpl' );
			update_option( 'tm_woocompare_page', $compare_page_id->ID );

			update_option( 'tm_woowishlist_enable', 'yes' );
			update_option( 'tm_woowishlist_show_in_catalog', 'yes' );
			update_option( 'tm_woowishlist_show_in_single', 'yes' );
			update_option( 'tm_woowishlist_add_text', 'Add to Wishlist' );
			update_option( 'tm_woowishlist_added_text', 'Already Added' );
			update_option( 'tm_woowishlist_page_btn_text', 'Go to my wishlist' );
			update_option( 'tm_woowishlist_empty_text', 'No products added to wishlist.' );
			update_option( 'tm_woowishlist_cols', '3' );
			update_option( 'tm_woowishlist_page_template', 'page.tmpl' );
			update_option( 'tm_woowishlist_widget_template', 'widget.tmpl' );
			update_option( 'tm_woowishlist_page', $wishlist_page_id->ID );
		}

		// Update woocommerce options
		if ( class_exists( 'WooCommerce' ) ) {
			$shop_page = get_page_by_title( 'Shop' );
			$cart_page = get_page_by_title( 'Cart' );
			$checkout_page = get_page_by_title( 'Checkout' );
			$my_account_page = get_page_by_title( 'My Account' );
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
			update_option( 'woocommerce_myaccount_page_id', $my_account_page->ID );
			update_option( 'woocommerce_cart_page_id', $cart_page->ID );
			update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}

		// Update Search options
		if ( class_exists('DGWT_WC_Ajax_Search') ) {
			$search_defaults = array (
				"suggestions_limit"=>"10",
				"min_chars"=>"3",
				"show_submit_button"=>"on",
				"search_submit_text"=>"Search",
				"search_placeholder"=>"Search by Title, Brand, Category ...",
				"show_details_box"=>"on",
				"search_in_product_content"=>"on",
				"search_in_product_excerpt"=>"on",
				"search_in_product_sku"=>"on",
				"exclude_out_of_stock"=>"off",
				"show_matching_categories"=>"on",
				"show_matching_tags"=>"off",
				"show_product_image"=>"on",
				"show_product_price"=>"on",
				"show_product_desc"=>"off",
				"show_product_sku"=>"off",
				"show_for_tax"=>"all",
				"orderby_for_tax"=>"date",
				"order_for_tax"=>"desc",
				"details_box_position"=>"right",
				"bg_input_color"=>"#ffffff",
				"text_input_color"=>"#9eadb6",
				"border_input_color"=>"#bec8ce",
				"bg_submit_color"=>"#212121",
				"text_submit_color"=>"#ffffff",
				"sug_bg_color"=>"#f6f6f6",
				"sug_hover_color"=>"#ffffff",
				"sug_text_color"=>"#626262",
				"sug_highlight_color"=>"#fdb819",
				"sug_border_color"=>"#bec8ce",
				"sug_width"=>"",
				"show_preloader"=>"on",
				"preloader_url"=>"",
			);
			update_option( 'dgwt_wcas_settings', $search_defaults );
		}

		// Update Woo Currency options
		if ( class_exists('WOOCS_STARTER') ) {
			update_option( 'woocs_drop_down_view', 'no' );
		}

		// Enable Yoast breadcrumbs
		if ( class_exists('WPSEO_Installation') ) {
			$seo_defaults = get_option('wpseo_titles');
			$seo_defaults['breadcrumbs-enable'] = true;
			update_option('wpseo_titles', $seo_defaults);
		}

		// Add different menus on different demo imports
		if ( 'Chromium Demo (Local Shop)' === $selected_import['import_file_name'] ) {
			// Assign menus to their locations.
			$main_menu = get_term_by( 'name', 'Demo Menu', 'nav_menu' );
			set_theme_mod( 'nav_menu_locations', array(
							'primary-nav' => $main_menu->term_id,
					)
			);
			// Update megamenu options
			if ( class_exists( 'Mega_Menu' ) ) {
				$megamenu_chromium_localstore_defaults = array (
					"prefix"=>"enabled",
					"descriptions"=>"enabled",
					"second_click"=>"close",
					"mobile_behaviour"=>"standard",
					"css"=>"fs",
					"unbind"=>"enabled",
					"primary-nav"=>array(
						"enabled"=>"1",
						"event"=>"hover",
						"effect"=>"fade_up",
						"effect_speed"=>"200",
						"effect_mobile"=>"slide",
						"effect_speed_mobile"=>"200",
						"theme"=>"chromium",
					),
					"instances"=>array(
						"primary-nav"=>"0",
					),
				);
				update_option( 'megamenu_settings', $megamenu_chromium_localstore_defaults );
			}

			/* Import Revolution Slider */
			if ( class_exists( 'RevSlider' ) ) {
				$filepath = get_template_directory()."/dummy-data/chromium-slider-a.zip";
				$slider = new RevSlider();
				$slider->importSliderFromPost(true,true,$filepath);
			}
		}
		elseif ( 'Chromium Demo (Marketplace)' === $selected_import['import_file_name'] ) {
			// Assign menus to their locations.
			$main_menu = get_term_by( 'name', 'Demo Menu', 'nav_menu' );
			set_theme_mod( 'nav_menu_locations', array(
							'logo-group-nav' => $main_menu->term_id,
					)
			);
			// Update megamenu options
			if ( class_exists( 'Mega_Menu' ) ) {
				$megamenu_chromium_marketplace_defaults = array (
					"prefix"=>"enabled",
					"descriptions"=>"enabled",
					"second_click"=>"close",
					"mobile_behaviour"=>"standard",
					"css"=>"fs",
					"unbind"=>"enabled",
					"logo-group-nav"=>array(
						"enabled"=>"1",
						"event"=>"hover",
						"effect"=>"fade_up",
						"effect_speed"=>"200",
						"effect_mobile"=>"slide",
						"effect_speed_mobile"=>"200",
						"theme"=>"chromium_logo_group",
					),
					"instances"=>array(
						"logo-group-nav"=>"0",
					),
				);
				update_option( 'megamenu_settings', $megamenu_chromium_marketplace_defaults );
			}
			/* Import Revolution Slider */
			if ( class_exists( 'RevSlider' ) ) {
				$filepath = get_template_directory()."/dummy-data/chromium-slider-c.zip";
				$slider = new RevSlider();
				$slider->importSliderFromPost(true,true,$filepath);
			}
		}
		elseif ( 'Chromium Demo (Supermarket)' === $selected_import['import_file_name'] ) {
			// Assign menus to their locations.
			$main_menu = get_term_by( 'name', 'Demo Menu', 'nav_menu' );
			set_theme_mod( 'nav_menu_locations', array(
							'primary-nav' => $main_menu->term_id,
					)
			);
			// Update megamenu options
			if ( class_exists( 'Mega_Menu' ) ) {
				$megamenu_chromium_supermarket_defaults = array (
					"prefix"=>"enabled",
					"descriptions"=>"enabled",
					"second_click"=>"close",
					"mobile_behaviour"=>"standard",
					"css"=>"fs",
					"unbind"=>"enabled",
					"primary-nav"=>array(
						"enabled"=>"1",
						"event"=>"hover",
						"effect"=>"fade_up",
						"effect_speed"=>"200",
						"effect_mobile"=>"slide",
						"effect_speed_mobile"=>"200",
						"theme"=>"chromium_white",
					),
					"instances"=>array(
						"primary-nav"=>"0",
					),
				);
				update_option( 'megamenu_settings', $megamenu_chromium_supermarket_defaults );
			}
			/* Import Revolution Slider */
			if ( class_exists( 'RevSlider' ) ) {
				$filepath = get_template_directory()."/dummy-data/chromium-slider-b.zip";
				$slider = new RevSlider();
				$slider->importSliderFromPost(true,true,$filepath);
			}
		} elseif ( 'Chromium Demo (Portal)' === $selected_import['import_file_name'] ) {
		 // Assign menus to their locations.
		 $main_menu = get_term_by( 'name', 'Demo Menu', 'nav_menu' );
		 set_theme_mod( 'nav_menu_locations', array(
				 'primary-nav' => $main_menu->term_id,
			 )
		 );
		 // Update megamenu options
		 if ( class_exists( 'Mega_Menu' ) ) {
			 $megamenu_chromium_localstore_defaults = array (
				 "prefix"=>"enabled",
				 "descriptions"=>"enabled",
				 "second_click"=>"close",
				 "mobile_behaviour"=>"standard",
				 "css"=>"fs",
				 "unbind"=>"enabled",
				 "primary-nav"=>array(
					 "enabled"=>"1",
					 "event"=>"hover",
					 "effect"=>"fade_up",
					 "effect_speed"=>"200",
					 "effect_mobile"=>"slide",
					 "effect_speed_mobile"=>"200",
					 "theme"=>"chromium_portal_menu",
				 ),
				 "instances"=>array(
					 "primary-nav"=>"0",
				 ),
			 );
			 update_option( 'megamenu_settings', $megamenu_chromium_localstore_defaults );
		 }

		 /* Import Revolution Slider */
		 if ( class_exists( 'RevSlider' ) ) {
			 $filepath = get_template_directory()."/dummy-data/chromium-slider-a.zip";
			 $slider = new RevSlider();
			 $slider->importSliderFromPost(true,true,$filepath);
		 }
	 }

	}
	add_action( 'pt-ocdi/after_import', 'chromium_after_import_setup' );
}

/* Chromium Themes for Mega Menu */
if ( class_exists( 'Mega_Menu' ) ) {

	function megamenu_add_theme_chromium($themes) {

		/* Menu Theme for Local Shop */
		$themes["chromium"] = array(
			'title' => 'Chromium',
			'container_background_from' => 'rgb(253, 184, 25)',
			'container_background_to' => 'rgb(253, 184, 25)',
			'container_padding_left' => '15px',
			'container_padding_right' => '15px',
			'arrow_up' => 'dash-f343',
			'arrow_down' => 'dash-f347',
			'arrow_left' => 'dash-f341',
			'arrow_right' => 'dash-f345',
			'menu_item_background_from' => 'rgb(253, 184, 25)',
			'menu_item_background_to' => 'rgb(253, 184, 25)',
			'menu_item_background_hover_from' => 'rgb(33, 33, 33)',
			'menu_item_background_hover_to' => 'rgb(33, 33, 33)',
			'menu_item_link_height' => '50px',
			'menu_item_link_color' => 'rgb(33, 33, 33)',
			'menu_item_link_weight' => 'inherit',
			'menu_item_link_text_transform' => 'uppercase',
			'menu_item_link_color_hover' => 'rgb(255, 255, 255)',
			'menu_item_link_weight_hover' => 'inherit',
			'menu_item_link_padding_left' => '20px',
			'menu_item_link_padding_right' => '20px',
			'menu_item_border_color' => 'rgb(255, 255, 255)',
			'menu_item_border_right' => '0',
			'menu_item_border_color_hover' => 'rgb(255, 255, 255)',
			'panel_background_from' => 'rgb(241, 245, 247)',
			'panel_background_to' => 'rgb(241, 245, 247)',
			'panel_width' => '1170px',
			'panel_header_color' => 'rgb(40, 41, 41)',
			'panel_header_text_transform' => 'none',
			'panel_header_font_size' => '15px',
			'panel_header_font_weight' => 'inherit',
			'panel_header_padding_bottom' => '10px',
			'panel_header_margin_bottom' => '20px',
			'panel_header_border_color' => 'rgb(213, 221, 226)',
			'panel_header_border_bottom' => '1px',
			'panel_padding_left' => '0',
			'panel_padding_right' => '0',
			'panel_padding_top' => '0',
			'panel_padding_bottom' => '0',
			'panel_widget_padding_left' => '0',
			'panel_widget_padding_right' => '0',
			'panel_widget_padding_top' => '0',
			'panel_widget_padding_bottom' => '0',
			'panel_font_size' => '13px',
			'panel_font_color' => 'rgb(98, 98, 98)',
			'panel_font_family' => 'inherit',
			'panel_second_level_font_color' => 'rgb(40, 41, 41)',
			'panel_second_level_font_color_hover' => 'rgb(254, 80, 0)',
			'panel_second_level_text_transform' => 'none',
			'panel_second_level_font' => 'inherit',
			'panel_second_level_font_size' => '15px',
			'panel_second_level_font_weight' => 'inherit',
			'panel_second_level_font_weight_hover' => 'inherit',
			'panel_second_level_text_decoration' => 'none',
			'panel_second_level_text_decoration_hover' => 'none',
			'panel_second_level_margin_bottom' => '10px',
			'panel_second_level_border_color' => '#555',
			'panel_third_level_font_color' => 'rgb(98, 98, 98)',
			'panel_third_level_font_color_hover' => 'rgb(254, 80, 0)',
			'panel_third_level_font' => 'inherit',
			'panel_third_level_font_size' => '13px',
			'panel_third_level_padding_bottom' => '5px',
			'flyout_width' => '200px',
			'flyout_menu_background_from' => 'rgb(255, 255, 255)',
			'flyout_menu_background_to' => 'rgb(255, 255, 255)',
			'flyout_border_color' => 'rgb(245, 245, 245)',
			'flyout_menu_item_divider' => 'on',
			'flyout_menu_item_divider_color' => 'rgb(212, 221, 226)',
			'flyout_padding_top' => '10px',
			'flyout_padding_right' => '15px',
			'flyout_padding_bottom' => '10px',
			'flyout_padding_left' => '15px',
			'flyout_link_padding_left' => '0px',
			'flyout_link_padding_right' => '0px',
			'flyout_link_padding_top' => '5px',
			'flyout_link_padding_bottom' => '5px',
			'flyout_link_height' => '26px',
			'flyout_background_from' => 'rgb(255, 255, 255)',
			'flyout_background_to' => 'rgb(255, 255, 255)',
			'flyout_background_hover_from' => 'rgb(255, 255, 255)',
			'flyout_background_hover_to' => 'rgb(255, 255, 255)',
			'flyout_link_size' => '14px',
			'flyout_link_color' => 'rgb(33, 33, 33)',
			'flyout_link_color_hover' => 'rgb(253, 184, 25)',
			'flyout_link_family' => 'inherit',
			'responsive_breakpoint' => '768px',
			'line_height' => '1.5',
			'shadow' => 'on',
			'shadow_vertical' => '2px',
			'shadow_blur' => '8px',
			'shadow_spread' => '0',
			'transitions' => 'on',
			'mobile_columns' => '1',
			'toggle_background_from' => 'rgb(253, 184, 25)',
			'toggle_background_to' => 'rgb(253, 184, 25)',
			'toggle_font_color' => 'rgb(49, 53, 59)',
			'toggle_bar_height' => '60px',
			'mobile_background_from' => 'rgb(241, 245, 247)',
			'mobile_background_to' => 'rgb(241, 245, 247)',
			'mobile_menu_item_link_font_size' => '15px',
			'mobile_menu_item_link_color' => 'rgb(33, 33, 33)',
			'mobile_menu_item_link_text_align' => 'left',
			'mobile_menu_item_link_color_hover' => 'rgb(33, 33, 33)',
			'mobile_menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			'mobile_menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			'custom_css' => '/** Custom Styles **/

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-right-aligned-promo {
  float: right !important;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-right-aligned-promo > a.mega-menu-link {
  text-transform: uppercase;
  padding: 0 15px;
  color: #fff;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-menu-item.mega-departments-link > a.mega-menu-link:before {
  margin: 0 20px 0 0;
  font-size: 24px;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-departments-link > a.mega-menu-link {
  background-color: #212121;
  color: #fff;
  text-transform: uppercase;
  padding: 0 30px 0 20px;
  line-height: 52px;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item ul.mega-sub-menu {
  left: calc(100% + 15px);
  top: -10px;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link {
  background-color: #fdb819;
  color: #212121;
  position: relative;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:before, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:before, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:before {
  display: inline-block;
 
  width: calc(100% - 40px);
  height: 1px;
  background-color: #212121;
  position: absolute;
  bottom: 15px;
  left: 20px;
}

/* Mobile overrides */
@media screen and (max-width: 768px) {
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:before,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:before,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:before {
	display: none;
  }
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.right-aligned-promo {
    float: none !important;
    background-color: #fdb819;
  }
  #mega-menu-wrap-primary-nav .mega-menu-toggle + #mega-menu-primary-nav li.mega-menu-item > ul.mega-sub-menu {
    padding: 0 15px;
  }
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link{
	line-height: 51px;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-menu-item-has-children > a.mega-menu-link:after{
transform: rotate(0);
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-departments-link > a.mega-menu-link:after{
	transform: translateX(10px) rotate(0);
}',
    );

		/* Menu Theme for Marketplace */
		$themes["chromium_logo_group"] = array(
			'title' => 'Chromium (logo group)',
			        'container_background_from' => 'rgb(255, 255, 255)',
			        'container_background_to' => 'rgb(255, 255, 255)',
			        'container_padding_left' => '15px',
			        'container_padding_right' => '45px',
			        'container_border_radius_top_left' => '0',
			        'container_border_radius_top_right' => '0',
			        'container_border_radius_bottom_left' => '0',
			        'container_border_radius_bottom_right' => '0',
			        'arrow_up' => 'dash-f343',
			        'arrow_down' => 'dash-f347',
			        'arrow_left' => 'dash-f341',
			        'arrow_right' => 'dash-f345',
			        'menu_item_align' => 'right',
			        'menu_item_background_from' => 'rgb(255, 255, 255)',
			        'menu_item_background_to' => 'rgb(255, 255, 255)',
			        'menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			        'menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			        'menu_item_spacing' => '10px',
			        'menu_item_link_font_size' => '15px',
			        'menu_item_link_color' => 'rgb(37, 37, 37)',
			        'menu_item_link_weight' => 'inherit',
			        'menu_item_link_color_hover' => 'rgb(37, 37, 37)',
			        'menu_item_link_weight_hover' => 'inherit',
			        'menu_item_link_padding_left' => '15px',
			        'menu_item_link_padding_right' => '15px',
			        'menu_item_link_border_radius_top_left' => '2px',
			        'menu_item_link_border_radius_top_right' => '2px',
			        'menu_item_link_border_radius_bottom_left' => '2px',
			        'menu_item_link_border_radius_bottom_right' => '2px',
			        'menu_item_border_color' => 'rgb(255, 255, 255)',
			        'menu_item_border_right' => '0',
			        'menu_item_border_color_hover' => 'rgb(255, 255, 255)',
			        'panel_background_from' => 'rgb(246, 246, 246)',
			        'panel_background_to' => 'rgb(246, 246, 246)',
			        'panel_width' => '1170px',
			        'panel_header_color' => 'rgb(40, 41, 41)',
			        'panel_header_text_transform' => 'none',
			        'panel_header_font_size' => '15px',
			        'panel_header_font_weight' => 'inherit',
			        'panel_header_padding_bottom' => '10px',
			        'panel_header_margin_bottom' => '20px',
			        'panel_header_border_color' => 'rgb(213, 221, 226)',
			        'panel_header_border_bottom' => '1px',
			        'panel_padding_left' => '0',
			        'panel_padding_right' => '0',
			        'panel_padding_top' => '0',
			        'panel_padding_bottom' => '0',
			        'panel_widget_padding_left' => '0',
			        'panel_widget_padding_right' => '0',
			        'panel_widget_padding_top' => '0',
			        'panel_widget_padding_bottom' => '0',
			        'panel_font_size' => '13px',
			        'panel_font_color' => 'rgb(98, 98, 98)',
			        'panel_font_family' => 'inherit',
			        'panel_second_level_font_color' => 'rgb(40, 41, 41)',
			        'panel_second_level_font_color_hover' => 'rgb(254, 80, 0)',
			        'panel_second_level_text_transform' => 'none',
			        'panel_second_level_font' => 'inherit',
			        'panel_second_level_font_size' => '15px',
			        'panel_second_level_font_weight' => 'inherit',
			        'panel_second_level_font_weight_hover' => 'inherit',
			        'panel_second_level_text_decoration' => 'none',
			        'panel_second_level_text_decoration_hover' => 'none',
			        'panel_second_level_margin_bottom' => '10px',
			        'panel_second_level_border_color' => '#555',
			        'panel_third_level_font_color' => 'rgb(98, 98, 98)',
			        'panel_third_level_font_color_hover' => 'rgb(254, 80, 0)',
			        'panel_third_level_font' => 'inherit',
			        'panel_third_level_font_size' => '13px',
			        'panel_third_level_padding_bottom' => '5px',
			        'flyout_width' => '200px',
			        'flyout_menu_background_from' => 'rgb(246, 246, 246)',
			        'flyout_menu_background_to' => 'rgb(246, 246, 246)',
			        'flyout_border_color' => 'rgb(245, 245, 245)',
			        'flyout_border_radius_top_right' => '2px',
			        'flyout_border_radius_bottom_left' => '2px',
			        'flyout_border_radius_bottom_right' => '2px',
			        'flyout_menu_item_divider' => 'on',
			        'flyout_menu_item_divider_color' => 'rgb(212, 221, 226)',
			        'flyout_padding_top' => '15px',
			        'flyout_padding_right' => '15px',
			        'flyout_padding_bottom' => '15px',
			        'flyout_padding_left' => '15px',
			        'flyout_link_padding_left' => '0px',
			        'flyout_link_padding_right' => '0px',
			        'flyout_link_padding_top' => '5px',
			        'flyout_link_padding_bottom' => '5px',
			        'flyout_link_height' => '26px',
			        'flyout_background_from' => 'rgba(245, 245, 245, 0)',
			        'flyout_background_to' => 'rgba(245, 245, 245, 0)',
			        'flyout_background_hover_from' => 'rgba(245, 245, 245, 0)',
			        'flyout_background_hover_to' => 'rgba(245, 245, 245, 0)',
			        'flyout_link_size' => '14px',
			        'flyout_link_color' => 'rgb(33, 33, 33)',
			        'flyout_link_color_hover' => 'rgb(255, 168, 0)',
			        'flyout_link_family' => 'inherit',
			        'responsive_breakpoint' => '768px',
			        'line_height' => '1.5',
			        'shadow_vertical' => '2px',
			        'shadow_blur' => '8px',
			        'shadow_spread' => '2px',
			        'transitions' => 'on',
			        'mobile_columns' => '1',
			        'toggle_background_from' => 'rgb(253, 184, 25)',
			        'toggle_background_to' => 'rgb(253, 184, 25)',
			        'toggle_font_color' => 'rgb(49, 53, 59)',
			        'toggle_bar_height' => '60px',
			        'mobile_background_from' => 'rgb(255, 255, 255)',
			        'mobile_background_to' => 'rgb(255, 255, 255)',
			        'mobile_menu_item_link_font_size' => '15px',
			        'mobile_menu_item_link_color' => 'rgb(49, 53, 59)',
			        'mobile_menu_item_link_text_align' => 'left',
			        'mobile_menu_item_link_color_hover' => 'rgb(49, 53, 59)',
			        'mobile_menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			        'mobile_menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			        'custom_css' => '/** Custom Styles **/

			#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item > a.mega-menu-link,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item.mega-toggle-on > a.mega-menu-link,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item > a.mega-menu-link:hover,
#mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav > li.mega-menu-item > a.mega-menu-link:focus {
  font-weight: 500;
}

/* Mobile overrides */
@media screen and (max-width: 768px) {
  #mega-menu-wrap-logo-group-nav .mega-menu-toggle + #mega-menu-logo-group-nav li.mega-menu-item > ul.mega-sub-menu {
    padding: 10px 15px;
  }
  #mega-menu-wrap-logo-group-nav .mega-menu-toggle,
  #mega-menu-wrap-logo-group-nav #mega-menu-logo-group-nav li.mega-align-bottom-left.mega-toggle-on > a.mega-menu-link{
    border-radius: 0;
  }
}',
		);

		/* Menu Theme for Supermarket */
		$themes["chromium_white"] = array(
			'title' => 'Chromium (white)',
			        'container_background_from' => 'rgb(255, 255, 255)',
			        'container_background_to' => 'rgb(255, 255, 255)',
			        'container_padding_left' => '15px',
			        'container_padding_right' => '45px',
			        'container_border_radius_top_left' => '0',
			        'container_border_radius_top_right' => '0',
			        'container_border_radius_bottom_left' => '0',
			        'container_border_radius_bottom_right' => '0',
			        'arrow_up' => 'dash-f343',
			        'arrow_down' => 'dash-f347',
			        'arrow_left' => 'dash-f341',
			        'arrow_right' => 'dash-f345',
			        'menu_item_background_from' => 'rgb(255, 255, 255)',
			        'menu_item_background_to' => 'rgb(255, 255, 255)',
			        'menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			        'menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			        'menu_item_spacing' => '10px',
			        'menu_item_link_font_size' => '15px',
			        'menu_item_link_color' => 'rgb(37, 37, 37)',
			        'menu_item_link_weight' => 'inherit',
			        'menu_item_link_color_hover' => 'rgb(37, 37, 37)',
			        'menu_item_link_weight_hover' => 'inherit',
			        'menu_item_link_padding_left' => '15px',
			        'menu_item_link_padding_right' => '15px',
			        'menu_item_link_border_radius_top_left' => '2px',
			        'menu_item_link_border_radius_top_right' => '2px',
			        'menu_item_link_border_radius_bottom_left' => '2px',
			        'menu_item_link_border_radius_bottom_right' => '2px',
			        'menu_item_border_color' => 'rgb(255, 255, 255)',
			        'menu_item_border_right' => '0',
			        'menu_item_border_color_hover' => 'rgb(255, 255, 255)',
			        'panel_background_from' => 'rgb(241, 245, 247)',
			        'panel_background_to' => 'rgb(241, 245, 247)',
			        'panel_width' => '1170px',
			        'panel_header_color' => 'rgb(40, 41, 41)',
			        'panel_header_text_transform' => 'none',
			        'panel_header_font_size' => '15px',
			        'panel_header_font_weight' => 'inherit',
			        'panel_header_padding_bottom' => '10px',
			        'panel_header_margin_bottom' => '20px',
			        'panel_header_border_color' => 'rgb(213, 221, 226)',
			        'panel_header_border_bottom' => '1px',
			        'panel_padding_left' => '0',
			        'panel_padding_right' => '0',
			        'panel_padding_top' => '0',
			        'panel_padding_bottom' => '0',
			        'panel_widget_padding_left' => '0',
			        'panel_widget_padding_right' => '0',
			        'panel_widget_padding_top' => '0',
			        'panel_widget_padding_bottom' => '0',
			        'panel_font_size' => '13px',
			        'panel_font_color' => 'rgb(98, 98, 98)',
			        'panel_font_family' => 'inherit',
			        'panel_second_level_font_color' => 'rgb(40, 41, 41)',
			        'panel_second_level_font_color_hover' => 'rgb(254, 80, 0)',
			        'panel_second_level_text_transform' => 'none',
			        'panel_second_level_font' => 'inherit',
			        'panel_second_level_font_size' => '15px',
			        'panel_second_level_font_weight' => 'inherit',
			        'panel_second_level_font_weight_hover' => 'inherit',
			        'panel_second_level_text_decoration' => 'none',
			        'panel_second_level_text_decoration_hover' => 'none',
			        'panel_second_level_margin_bottom' => '10px',
			        'panel_second_level_border_color' => '#555',
			        'panel_third_level_font_color' => 'rgb(98, 98, 98)',
			        'panel_third_level_font_color_hover' => 'rgb(254, 80, 0)',
			        'panel_third_level_font' => 'inherit',
			        'panel_third_level_font_size' => '13px',
			        'panel_third_level_padding_bottom' => '5px',
			        'flyout_width' => '200px',
			        'flyout_menu_background_from' => 'rgb(246, 246, 246)',
			        'flyout_menu_background_to' => 'rgb(246, 246, 246)',
			        'flyout_border_color' => 'rgb(212, 221, 226)',
			        'flyout_menu_item_divider' => 'on',
			        'flyout_menu_item_divider_color' => 'rgb(212, 221, 226)',
			        'flyout_padding_top' => '15px',
			        'flyout_padding_right' => '15px',
			        'flyout_padding_bottom' => '15px',
			        'flyout_padding_left' => '15px',
			        'flyout_link_padding_left' => '0px',
			        'flyout_link_padding_right' => '0px',
			        'flyout_link_padding_top' => '5px',
			        'flyout_link_padding_bottom' => '5px',
			        'flyout_link_height' => '28px',
			        'flyout_background_from' => 'rgb(245, 245, 245)',
			        'flyout_background_to' => 'rgb(245, 245, 245)',
			        'flyout_background_hover_from' => 'rgb(245, 245, 245)',
			        'flyout_background_hover_to' => 'rgb(245, 245, 245)',
			        'flyout_link_size' => '14px',
			        'flyout_link_color' => 'rgb(33, 33, 33)',
			        'flyout_link_color_hover' => 'rgb(255, 168, 0)',
			        'flyout_link_family' => 'inherit',
			        'responsive_breakpoint' => '768px',
			        'line_height' => '1.5',
			        'shadow' => 'on',
			        'shadow_vertical' => '2px',
			        'shadow_blur' => '8px',
			        'transitions' => 'on',
			        'mobile_columns' => '1',
			        'toggle_background_from' => 'rgb(255, 255, 255)',
			        'toggle_background_to' => 'rgb(255, 255, 255)',
			        'toggle_font_color' => 'rgb(37, 37, 37)',
			        'toggle_bar_height' => '50px',
			        'mobile_background_from' => 'rgb(255, 255, 255)',
			        'mobile_background_to' => 'rgb(255, 255, 255)',
			        'mobile_menu_item_link_font_size' => '15px',
			        'mobile_menu_item_link_color' => 'rgb(33, 33, 33)',
			        'mobile_menu_item_link_text_align' => 'left',
			        'mobile_menu_item_link_color_hover' => 'rgb(33, 33, 33)',
			        'mobile_menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			        'mobile_menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			        'custom_css' => '/** Custom Styles **/

			#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-toggle-on > a.mega-menu-link,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link:hover,
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link:focus {
  font-weight: 500;
}

/* Mobile overrides */
@media screen and (max-width: 768px) {
  #mega-menu-wrap-primary-nav .mega-menu-toggle + #mega-menu-primary-nav li.mega-menu-item > ul.mega-sub-menu {
    padding: 10px 15px;
  }
  #mega-menu-wrap-primary-nav .mega-menu-toggle,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-align-bottom-left.mega-toggle-on > a.mega-menu-link{
    border-radius: 0;
  }
}',);



		$themes["chromium_portal_menu"] = array(
			'title' => 'Chromium Primary Portal Menu',
			'container_background_from' => 'rgb(244, 244, 244)',
			'container_background_to' => 'rgb(244, 244, 244)',
			'container_padding_left' => '15px',
			'container_padding_right' => '15px',
			'arrow_up' => 'dash-f343',
			'arrow_down' => 'dash-f347',
			'arrow_left' => 'dash-f341',
			'arrow_right' => 'dash-f345',
			'menu_item_background_from' => 'rgb(244, 244, 244)',
			'menu_item_background_to' => 'rgb(244, 244, 244)',
			'menu_item_background_hover_from' => 'rgb(33, 33, 33)',
			'menu_item_background_hover_to' => 'rgb(33, 33, 33)',
			'menu_item_link_height' => '50px',
			'menu_item_link_color' => 'rgb(33, 33, 33)',
			'menu_item_link_weight' => 'inherit',
			'menu_item_link_text_transform' => 'uppercase',
			'menu_item_link_color_hover' => 'rgb(255, 255, 255)',
			'menu_item_link_weight_hover' => 'inherit',
			'menu_item_link_padding_left' => '20px',
			'menu_item_link_padding_right' => '20px',
			'menu_item_border_color' => 'rgb(255, 255, 255)',
			'menu_item_border_right' => '0',
			'menu_item_border_color_hover' => 'rgb(255, 255, 255)',
			'panel_background_from' => 'rgb(241, 245, 247)',
			'panel_background_to' => 'rgb(241, 245, 247)',
			'panel_width' => '1170px',
			'panel_header_color' => 'rgb(40, 41, 41)',
			'panel_header_text_transform' => 'none',
			'panel_header_font_size' => '15px',
			'panel_header_font_weight' => 'inherit',
			'panel_header_padding_bottom' => '10px',
			'panel_header_margin_bottom' => '20px',
			'panel_header_border_color' => 'rgb(213, 221, 226)',
			'panel_header_border_bottom' => '1px',
			'panel_padding_left' => '0',
			'panel_padding_right' => '0',
			'panel_padding_top' => '0',
			'panel_padding_bottom' => '0',
			'panel_widget_padding_left' => '0',
			'panel_widget_padding_right' => '0',
			'panel_widget_padding_top' => '0',
			'panel_widget_padding_bottom' => '0',
			'panel_font_size' => '13px',
			'panel_font_color' => 'rgb(98, 98, 98)',
			'panel_font_family' => 'inherit',
			'panel_second_level_font_color' => 'rgb(40, 41, 41)',
			'panel_second_level_font_color_hover' => 'rgb(254, 80, 0)',
			'panel_second_level_text_transform' => 'none',
			'panel_second_level_font' => 'inherit',
			'panel_second_level_font_size' => '15px',
			'panel_second_level_font_weight' => 'inherit',
			'panel_second_level_font_weight_hover' => 'inherit',
			'panel_second_level_text_decoration' => 'none',
			'panel_second_level_text_decoration_hover' => 'none',
			'panel_second_level_margin_bottom' => '10px',
			'panel_second_level_border_color' => '#555',
			'panel_third_level_font_color' => 'rgb(98, 98, 98)',
			'panel_third_level_font_color_hover' => 'rgb(254, 80, 0)',
			'panel_third_level_font' => 'inherit',
			'panel_third_level_font_size' => '13px',
			'panel_third_level_padding_bottom' => '5px',
			'flyout_width' => '200px',
			'flyout_menu_background_from' => 'rgb(255, 255, 255)',
			'flyout_menu_background_to' => 'rgb(255, 255, 255)',
			'flyout_border_color' => 'rgb(245, 245, 245)',
			'flyout_menu_item_divider' => 'on',
			'flyout_menu_item_divider_color' => 'rgb(212, 221, 226)',
			'flyout_padding_top' => '10px',
			'flyout_padding_right' => '15px',
			'flyout_padding_bottom' => '10px',
			'flyout_padding_left' => '15px',
			'flyout_link_padding_left' => '0px',
			'flyout_link_padding_right' => '0px',
			'flyout_link_padding_top' => '5px',
			'flyout_link_padding_bottom' => '5px',
			'flyout_link_height' => '26px',
			'flyout_background_from' => 'rgb(255, 255, 255)',
			'flyout_background_to' => 'rgb(255, 255, 255)',
			'flyout_background_hover_from' => 'rgb(255, 255, 255)',
			'flyout_background_hover_to' => 'rgb(255, 255, 255)',
			'flyout_link_size' => '14px',
			'flyout_link_color' => 'rgb(33, 33, 33)',
			'flyout_link_color_hover' => 'rgb(253, 184, 25)',
			'flyout_link_family' => 'inherit',
			'responsive_breakpoint' => '768px',
			'line_height' => '1.5',
			'shadow' => 'on',
			'shadow_vertical' => '2px',
			'shadow_blur' => '8px',
			'shadow_spread' => '0',
			'transitions' => 'on',
			'mobile_columns' => '1',
			'toggle_background_from' => 'rgb(253, 184, 25)',
			'toggle_background_to' => 'rgb(253, 184, 25)',
			'toggle_font_color' => 'rgb(49, 53, 59)',
			'toggle_bar_height' => '60px',
			'mobile_background_from' => 'rgb(241, 245, 247)',
			'mobile_background_to' => 'rgb(241, 245, 247)',
			'mobile_menu_item_link_font_size' => '15px',
			'mobile_menu_item_link_color' => 'rgb(33, 33, 33)',
			'mobile_menu_item_link_text_align' => 'left',
			'mobile_menu_item_link_color_hover' => 'rgb(33, 33, 33)',
			'mobile_menu_item_background_hover_from' => 'rgb(253, 184, 25)',
			'mobile_menu_item_background_hover_to' => 'rgb(253, 184, 25)',
			'custom_css' => '/** Custom Styles **/

nav.main-navigation{
border-top:#ebebeb 1px solid;
border-bottom:#ebebeb 1px solid;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-right-aligned-promo {
  float: right !important;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-right-aligned-promo > a.mega-menu-link {
  text-transform: uppercase;
  padding: 0 15px;
  color: #000;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-right-aligned-promo > a.mega-menu-link:hover{
	color: #fff;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-menu-item.mega-departments-link > a.mega-menu-link:before {
  margin: 0 20px 0 0;
  font-size: 24px;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-departments-link > a.mega-menu-link {
  background-color: #fdb819;
  color: #000;
  text-transform: uppercase;
  padding: 0 30px 0 20px;
  line-height: 52px;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-departments-link > a.mega-menu-link:hover{
color: #fff;
background-color: #000;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item ul.mega-sub-menu {
  left: calc(100% + 15px);
  top: -10px;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link {
  background-color: #f4f4f4;
  color: #212121;
  position: relative;
}
#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:before, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:before, #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:before {
  display: inline-block;
 
  width: calc(100% - 40px);
  height: 1px;
  background-color: #212121;
  position: absolute;
  bottom: 15px;
  left: 20px;
}

/* Mobile overrides */
@media screen and (max-width: 768px) {
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:before,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:before,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:before {
	display: none;
  }
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item.right-aligned-promo {
    float: none !important;
    background-color: #fdb819;
  }
  #mega-menu-wrap-primary-nav .mega-menu-toggle + #mega-menu-primary-nav li.mega-menu-item > ul.mega-sub-menu {
    padding: 0 15px;
  }
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link{
	line-height: 51px;
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-menu-item-has-children > a.mega-menu-link:after{
transform: rotate(0);
}

#mega-menu-wrap-primary-nav #mega-menu-primary-nav li.mega-departments-link > a.mega-menu-link:after{
	transform: translateX(10px) rotate(0);
}',
		);

    return $themes;
	}
	add_filter("megamenu_themes", "megamenu_add_theme_chromium");

}
