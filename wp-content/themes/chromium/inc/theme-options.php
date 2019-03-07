<?php
/*   Chromium Theme Options
 *   Contents:
 * - New Controls in "Site Identity" section
 * - TZ Feature Pack switchers
 * - Blog Options
 * - Single Post Options
 * - Gallery Options
 * - Header Options
 * - Footer Options
 * - Sidebar Options
 * - Page Layout
 * - Store options
 * - Product options
 * - Cart & Checkout options
 * - Typography and Colors
 */
if (class_exists('Chromium_Kirki')) {

	/* Add configuration */
	Chromium_Kirki::add_config( 'chromium', array(
	  'capability' => 'edit_theme_options',
	  'option_type' => 'theme_mod',
	) );
	function chromium_disable_kirki_google_fonts() {
		return array( 'disable_google_fonts' => true );
	}
	add_filter( 'kirki/config', 'chromium_disable_kirki_google_fonts' );

	/* Variables */
	$font_options = array(
		"Rubik" => "Rubik",
		"Open Sans" => "Open Sans",
		"Lato" => "Lato",
		"Roboto" => "Roboto",
	);
	if (class_exists('Kirki_Fonts')) {
		$font_options = Kirki_Fonts::get_font_choices();
	}
	$layout_options = array(
		'one-col'   => get_template_directory_uri() . '/assets/img/one-col.png',
		'two-col-left' => get_template_directory_uri() . '/assets/img/two-col-left.png',
		'two-col-right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
	);

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'select',
		'settings'    => 'site_logo_position',
		'label'       => esc_html__( 'Select position for logo', 'chromium' ),
		'section'     => 'title_tagline',
		'default'     => 'left',
		'choices'     => array(
			'left'  => esc_html__('Left', 'chromium'),
			'right' => esc_html__('Right', 'chromium'),
			'center-inside' => esc_html__('Center in between menu and sidebar', 'chromium'),
			'center-above' => esc_html__('Center above menu and sidebar', 'chromium'),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'     => 'select',
		'settings' => 'logo_font_family',
		'label'    => esc_html__( 'Logo font', 'chromium' ),
		'description' => esc_html__( "Specify font family for Logo if you don't use logo image", 'chromium' ),
		'section'  => 'title_tagline',
		'default'  => 'Rubik',
		'choices'  => $font_options,
		'output'   => array(
			array(
				'element'  => '.site-header h1.site-title',
				'property' => 'font-family'
			),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'logo_font_color',
		'label'    		=> esc_html__( 'Logo font color', 'chromium' ),
		'description' => esc_html__( "Specify font color for Logo if you don't use logo image", 'chromium' ),
		'section'     => 'title_tagline',
		'default'     => '#000000',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => '.site-header h1.site-title',
				'property' => 'color',
			),
		),
	) );


	/* TZ Feature Pack switchers */
	if ( class_exists('Tz_Feature_Pack') ) {
		Chromium_Kirki::add_section( 'tz-feature-pack-options', array(
			'title'          => esc_html__( 'TZ Feature Pack Options', 'chromium' ),
			'priority'       => 40,
		) );

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'switch',
			'settings'    => 'site_view_counters',
			'label'       => esc_html__( 'Enable Post/Products views', 'chromium' ),
			'description' => esc_html__( 'Enable this option to output number of views for posts/products', 'chromium' ),
			'section'     => 'tz-feature-pack-options',
			'default'     => '1',
			'choices'     => array(
				'on'  => esc_html__( 'Enable', 'chromium' ),
				'off' => esc_html__( 'Disable', 'chromium' ),
			),
		) );

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'switch',
			'settings'    => 'site_likes_system',
			'label'       => esc_html__( 'Enable Post/Products likes', 'chromium' ),
			'description' => esc_html__( 'Enable this option to add like buttons to single post', 'chromium' ),
			'section'     => 'tz-feature-pack-options',
			'default'     => '1',
			'choices'     => array(
				'on'  => esc_html__( 'Enable', 'chromium' ),
				'off' => esc_html__( 'Disable', 'chromium' ),
			),
		) );

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'switch',
			'settings'    => 'site_shares_system',
			'label'       => esc_html__( 'Enable Post/Products shares', 'chromium' ),
			'description' => esc_html__( 'Enable this option to add share buttons to single post', 'chromium' ),
			'section'     => 'tz-feature-pack-options',
			'default'     => '1',
			'choices'     => array(
				'on'  => esc_html__( 'Enable', 'chromium' ),
				'off' => esc_html__( 'Disable', 'chromium' ),
			),
		) );

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'multicheck',
			'settings'    => 'site_shares_socials',
			'label'       => esc_html__( 'Social networks', 'chromium' ),
			'description' => esc_html__( 'Check every networks you want to add to share section', 'chromium' ),
			'section'     => 'tz-feature-pack-options',
			'default'     => array( 'facebook', 'twitter', 'google', 'pinterest', 'linkedin', 'vk', 'tumblr', 'mail' ),
			'choices'     => array(
						'facebook' => 'Facebook',
						'twitter' => 'Twitter',
						'google' => 'Google +',
						'pinterest' => 'Pinterest',
						'linkedin' => 'LinkedIn',
						'vk' => 'Vkontakte',
						'tumblr' => 'Tumblr',
						'mail' => 'Mail',
			),
			'active_callback'  => array(
					array(
						'setting'  => 'site_shares_system',
						'operator' => '==',
						'value'    => 1,
					),
			)
		) );
	}

	/* Site Options */
	Chromium_Kirki::add_panel( 'chromium-theme-options', array(
	    'priority'    => 30,
	    'title'       => esc_html__( 'Theme Options', 'chromium' ),
	    'description' => esc_html__( 'Special Collection of Options for JShop Theme', 'chromium' ),
	) );


	/* Blog Options */
	Chromium_Kirki::add_section( 'chromium-blog', array(
		'title'       => esc_html__( 'Blog Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'blog_style',
	'label'       => esc_html__( 'Blog Style', 'chromium' ),
	'section'     => 'chromium-blog',
	'default'     => 'style-1',
	'choices'     => array(
			'style-1' => esc_html__( 'Classic', 'chromium' ),
			'style-2' => esc_html__( 'Modern', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'grid_blog',
		'label'       => esc_html__( 'Enable "Grid" layout for blog?', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'blog_grid_cols',
	'label'       => esc_html__( 'Columns qty for Blog Grid', 'chromium' ),
	'section'     => 'chromium-blog',
	'default'     => 'col-3',
	'choices'     => array(
			'col-3' => esc_html__( '3 Cols', 'chromium' ),
			'col-4' => esc_html__( '4 Cols', 'chromium' ),
			'col-5' => esc_html__( '5 Cols', 'chromium' ),
			'col-6' => esc_html__( '6 Cols', 'chromium' ),
		),
	'active_callback'  => array(
			array(
					'setting'  => 'grid_blog',
					'operator' => '==',
					'value'    => 1,
			),
	)
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'grid_vertical_alignment',
		'label'       => esc_html__( 'Vertical Alignment for Grid', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => 'start',
		'choices'     => array(
			'start'  => esc_html__('Top', 'chromium'),
			'center' => esc_html__('Middle', 'chromium'),
			'end' => esc_html__('Bottom', 'chromium'),
			'stretch' => esc_html__('Stretch', 'chromium'),
		),
		'active_callback'  => array(
				array(
					'setting'  => 'grid_blog',
					'operator' => '==',
					'value'    => 1,
				),
		),
		'output'      => array(
				array(
					'choice'   => 'grid_vertical_alignment',
					'element'  => array('.blog.blog-grid-posts .site-content'),
					'property' => 'align-items',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'totop_button',
		'label'       => esc_html__( 'Add "To Top" button?', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
		'choices'     => array(
			'on'  => esc_html__( 'Yes', 'chromium' ),
			'off' => esc_html__( 'No', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'blog_output_excerpt',
		'label'       => esc_html__( 'Enable excerpt output for post on archive pages?', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => 'off',
		'choices'     => array(
			'on'  => esc_html__( 'Yes', 'chromium' ),
			'off' => esc_html__( 'No', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'blog_sidebar_style',
	'label'       => esc_html__( 'Sidebar widgets style (for Blog, Single Post, Single Page)', 'chromium' ),
	'section'     => 'chromium-blog',
	'default'     => 'style-1',
	'choices'     => array(
			'style-1' => esc_html__( 'Style 1', 'chromium' ),
			'style-2' => esc_html__( 'Style 2', 'chromium' ),
			'style-3' => esc_html__( 'Style 3', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'separator_blog_posts',
		'section'     => 'chromium-blog',
		'default'     => '<div style="text-align: center; margin-top: 50px; padding: 10px; background-color: #333; color: #fff; border-radius: 6px;">' . esc_html__( 'Post meta options on Archive Pages', 'chromium' ) . '</div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_author',
		'label'       => esc_html__( 'Hide post Author (do not work with Grid Layout)', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_date',
		'label'       => esc_html__( 'Hide post Date', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_categories',
		'label'       => esc_html__( 'Hide post Categories', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_tags',
		'label'       => esc_html__( 'Hide post Tags', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_views',
		'label'       => esc_html__( 'Hide post Views Counter', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_likes',
		'label'       => esc_html__( 'Hide post Likes Counter', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'blog_hide_comments',
		'label'       => esc_html__( 'Hide post Comments Counter', 'chromium' ),
		'section'     => 'chromium-blog',
		'default'     => '1',
	) );


	/* Single Post Options */
	Chromium_Kirki::add_section( 'chromium-single-post', array(
		'title'       => esc_html__( 'Single Post Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'related_posts',
		'label'       => esc_html__( 'Enable output of related posts?', 'chromium' ),
		'description' => esc_html__( 'Enable this option to output related posts section located under single post content', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'single_post_nav',
		'label'       => esc_html__( 'Enable Prev/Next navigation for single post?', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '0',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'single_post_bg_color',
		'label'       => esc_html__( 'Single Post Background color', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '#f6f6f6',
		'choices'     => array(
			'alpha' => true,
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'separator_single_post',
		'section'     => 'chromium-single-post',
		'default'     => '<div style="text-align: center; margin-top: 50px; padding: 10px; background-color: #333; color: #fff; border-radius: 6px;">' . esc_html__( 'Post meta options on Single Post', 'chromium' ) . '</div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_author',
		'label'       => esc_html__( 'Hide post Author', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_date',
		'label'       => esc_html__( 'Hide post Date', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_categories',
		'label'       => esc_html__( 'Hide post Categories', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_tags',
		'label'       => esc_html__( 'Hide post Tags', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_views',
		'label'       => esc_html__( 'Hide post Views Counter', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_likes',
		'label'       => esc_html__( 'Hide post Likes', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_shares',
		'label'       => esc_html__( 'Hide post Shares', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'single_hide_comments',
		'label'       => esc_html__( 'Hide post Comments Counter', 'chromium' ),
		'section'     => 'chromium-single-post',
		'default'     => '1',
	) );


	/* Gallery Options */
	Chromium_Kirki::add_section( 'chromium-gallery', array(
		'title'       => esc_html__( 'Gallery Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'gallery_enable_filterizr',
		'label'       => esc_html__( 'Add Filter Navigation?', 'chromium' ),
		'description' => esc_html__( 'Check to enable filtering for gallery images', 'chromium' ),
		'section'     => 'chromium-gallery',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'gallery_fullwidth',
		'label'       => esc_html__( 'Fullwidth Gallery Container', 'chromium' ),
		'description' => esc_html__( 'Enable to stretch gallery container to fullwidth', 'chromium' ),
		'section'     => 'chromium-gallery',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'slider',
		'settings'    => 'gallery_column_gap',
		'label'       => esc_html__( 'Horizontal Gap for Images', 'chromium' ),
		'section'     => 'chromium-gallery',
		'default'     => 0,
		'choices'     => array(
			'min'  => '0',
			'max'  => '30',
			'step' => '1',
		),
		'output' => array(
			array(
				'element'  => '#chromium-gallery',
				'property' => 'grid-column-gap',
				'units' 	 => 'px'
			),
		),
		'active_callback' => array(
				array(
					'setting'  => 'gallery_enable_filterizr',
					'operator' => '!=',
					'value'    => 1,
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'slider',
		'settings'    => 'gallery_row_gap',
		'label'       => esc_html__( 'Vertical Gap for Images', 'chromium' ),
		'section'     => 'chromium-gallery',
		'default'     => 0,
		'choices'     => array(
			'min'  => '0',
			'max'  => '30',
			'step' => '1',
		),
		'output' => array(
			array(
				'element'  => '#chromium-gallery',
				'property' => 'grid-row-gap',
				'units' 	 => 'px'
			),
		),
		'active_callback' => array(
				array(
					'setting'  => 'gallery_enable_filterizr',
					'operator' => '!=',
					'value'    => 1,
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'gallery_filter_colors',
		'label'       => esc_html__( 'Filter Navigation Colors', 'chromium' ),
		'section'     => 'chromium-gallery',
		'choices'     => array(
				'color' => esc_html__( 'Text Color', 'chromium' ),
				'color-hover' => esc_html__( 'Text Color :hover', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'background-color-hover' => esc_html__( 'Background :hover', 'chromium' ),
		),
		'default'     => array(
				'color' => '#81858c',
				'color-hover' => '#212121',
				'background-color' => '#fff',
				'background-color-hover' => '#FDB819',
		),
		'output'      => array(
				array(
					'choice'   => 'color',
					'element'  => array('.filters-wrapper li'),
					'property' => 'color',
				),
				array(
					'choice'   => 'color-hover',
					'element'  => array('.filters-wrapper li:hover','.filters-wrapper li:focus','.filters-wrapper li:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'background-color',
					'element'  => array('.filters-wrapper li'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'background-color-hover',
					'element'  => array('.filters-wrapper li:hover','.filters-wrapper li:focus','.filters-wrapper li:active'),
					'property' => 'background-color',
				),
		),
	) );


	/* Header Options */
	Chromium_Kirki::add_section( 'chromium-header', array(
		'title'       => esc_html__( 'Header Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'add_header_background',
		'label'       => esc_html__( 'Custom Header background', 'chromium' ),
		'description' => esc_html__( 'Enable to add custom background color or image for header section', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => '0',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'background',
		'settings'    => 'header_background',
		'label'       => esc_html__( 'Choose your header background', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => array(
			'background-color'      => '#ffffff',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		),
		'output'      => array(
			 array(
				 'element' => '.site-header'
			)
		),
		'active_callback' => array(
				array(
					'setting'  => 'add_header_background',
					'operator' => '==',
					'value'    => 1,
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'     => 'select',
		'settings' => 'header_font_family',
		'label'    => __( 'Header font', 'chromium' ),
		'section'  => 'chromium-header',
		'default'  => 'Rubik',
		'choices'  => $font_options,
		'output'   => array(
			array(
					'element'  => '.site-header',
					'property' => 'font-family'
			)
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'header_top_panel_separator',
		'section'     => 'chromium-header',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'header_top_panel',
		'label'       => esc_html__( "Header's top panel", 'chromium' ),
		'description' => esc_html__( 'Enable this option to add widgetized area above header section', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'top_panel_bg_color',
		'label'       => esc_html__( 'Background color for header top panel', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => '#212121',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.header-top'),
				'property' => 'background-color',
			),
		),
		'active_callback'  => array(
				array(
					'setting'  => 'header_top_panel',
					'operator' => '==',
					'value'    => 1,
				),
		)
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'top_panel_text_color',
		'label'       => esc_html__( 'Text color for header top panel', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => '#8b8b8b',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.header-top','.tz-login-heading.inline .my-account:after'),
				'property' => 'color',
			),
		),
		'active_callback'  => array(
				array(
					'setting'  => 'header_top_panel',
					'operator' => '==',
					'value'    => 1,
				),
		)
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'primary_nav_separator',
		'section'     => 'chromium-header',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'primary_nav_bg_color',
		'label'       => esc_html__( 'Background color for primary nav container', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => '#fdb819',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.primary-nav'),
				'property' => 'background-color',
			),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'primary_nav_widgets',
		'label'       => esc_html__( 'Add Widget Area to primary nav', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => true,
		'choices'     => array(
			'on'  => esc_html__( 'Yes', 'chromium' ),
			'off' => esc_html__( 'No', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'primary_nav_widgets_position',
		'label'       => esc_html__( 'Primary nav widgets position', 'chromium' ),
		'section'     => 'chromium-header',
		'default'     => 'right',
		'choices'     => array(
			'left'  => esc_html__('Left', 'chromium'),
			'right' => esc_html__('Right', 'chromium'),
		),
		'active_callback'  => array(
				array(
					'setting'  => 'primary_nav_widgets',
					'operator' => '==',
					'value'    => 1,
				),
		)
	) );

	/* Footer Options */
	Chromium_Kirki::add_section( 'chromium-footer', array(
		'title'       => esc_html__( 'Footer Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'add_footer_background',
		'label'       => esc_html__( 'Custom Footer background', 'chromium' ),
		'description' => esc_html__( 'Enable to add custom background color or image for footer section', 'chromium' ),
		'section'     => 'chromium-footer',
		'default'     => '0',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'background',
		'settings'    => 'footer_background',
		'label'       => esc_html__( 'Choose your footer background', 'chromium' ),
		'section'     => 'chromium-footer',
		'default'     => array(
			'background-color'      => '#212121',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		),
		'output'      => array(
			 array(
				 'element' => '.site-footer'
			)
		),
		'active_callback' => array(
				array(
					'setting'  => 'add_footer_background',
					'operator' => '==',
					'value'    => 1,
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'footer_text_color',
		'label'       => esc_html__( 'Footer text color', 'chromium' ),
		'description' => esc_html__( 'Specify color for widget content located in footer section', 'chromium' ),
		'section'     => 'chromium-footer',
		'default'     => '#9a9a9a',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.site-footer'),
				'property' => 'color',
			),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'code',
		'settings'    => 'copyright_section_text',
		'label'       => esc_html__( 'Copyright Section Text', 'chromium' ),
		'section'     => 'chromium-footer',
		'default'     => '',
		'choices'     => array(
			'language' => 'html',
			'height'   => 250,
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'code',
		'settings'    => 'footer_shortcode_section',
		'label'       => esc_html__( 'Pre-Footer Shortcode Section', 'chromium' ),
		'section'     => 'chromium-footer',
		'default'     => '',
		'choices'     => array(
			'language' => 'php',
			'height'   => 250,
		),
	) );

	/* Front Page Options */
	Chromium_Kirki::add_section( 'chromium-front-page', array(
		'title'       => esc_html__( 'Front Page Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'     => 'textarea',
		'settings' => 'frontpage_shortcode',
		'label'    => esc_html__( 'Front Page shortcode Section', 'chromium' ),
		'description' => esc_html__( 'Shows shortcode content under primary nav menu before main content if shortcode added', 'chromium' ),
		'section'  => 'chromium-front-page',
		'default'  => '',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'select',
		'settings'    => 'front_page_sidebar_style',
		'label'       => esc_html__( 'Sidebar widgets style (for Front Page)', 'chromium' ),
		'section'     => 'chromium-front-page',
		'default'     => 'style-3',
		'choices'     => array(
				'style-1' => esc_html__( 'Style 1', 'chromium' ),
				'style-2' => esc_html__( 'Style 2', 'chromium' ),
				'style-3' => esc_html__( 'Style 3', 'chromium' ),
			),
	) );

	/* Page Layout */
	Chromium_Kirki::add_section( 'chromium-layouts', array(
	  'title'       => esc_html__( 'Page Layout', 'chromium' ),
	  'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'front_layout',
		'label'       => esc_html__( 'Set Front page layout', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the front page', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'one-col',
		'choices'     => $layout_options,
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'page_layout',
		'label'       => esc_html__( 'Set global layout for Pages', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the Pages of your site', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'one-col',
		'choices'     => $layout_options,
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'blog_layout',
		'label'       => esc_html__( 'Set Blog page layout', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the Blog page', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'two-col-right',
		'choices'     => $layout_options,
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'single_layout',
		'label'       => esc_html__( 'Set Single post view layout', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the single posts', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'two-col-right',
		'choices'     => $layout_options,
	) );

	if (class_exists('WooCommerce')) {
		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'radio-image',
			'settings'    => 'shop_layout',
			'label'       => esc_html__( 'Set Products page (Shop page) layout', 'chromium' ),
			'description' => esc_html__( 'Specify the location of sidebars about the content on the products page', 'chromium' ),
			'section'     => 'chromium-layouts',
			'default'     => 'two-col-left',
			'choices'     => $layout_options,
		) );

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'radio-image',
			'settings'    => 'product_layout',
			'label'       => esc_html__( 'Set Single Product pages layout', 'chromium' ),
			'description' => esc_html__( 'Specify the location of sidebars about the content on the single product pages', 'chromium' ),
			'section'     => 'chromium-layouts',
			'default'     => 'two-col-right',
			'choices'     => $layout_options,
		) );
	}

if (class_exists('WooCommerce')) {
	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'shop_layout',
		'label'       => esc_html__( 'Set Products page (Shop page) layout', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the products page', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'two-col-left',
		'choices'     => $layout_options,
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio-image',
		'settings'    => 'product_layout',
		'label'       => esc_html__( 'Set Single Product pages layout', 'chromium' ),
		'description' => esc_html__( 'Specify the location of sidebars about the content on the single product pages', 'chromium' ),
		'section'     => 'chromium-layouts',
		'default'     => 'one-col',
		'choices'     => $layout_options,
	) );


	/* Store options */
	Chromium_Kirki::add_section( 'chromium-store', array(
		'title'       => esc_html__( 'Store Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'number',
		'settings'    => 'products_per_page',
		'label'       => esc_html__( 'Enter qty of products visible on shop page', 'chromium' ),
		'description' => esc_html__( 'Control product quantity shown on shop page (max 40 per page)', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => 9,
		'choices'     => array(
			'min'  => 6,
			'max'  => apply_filters('chromium-max-products-shop', 40),
			'step' => 1,
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'mobile_products_qty',
		'label'       => esc_html__( 'Select how many products to show per row on mobile devices', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => 'one',
		'choices'     => array(
			'one'  => esc_html__('One per row', 'chromium'),
			'two' => esc_html__('Two per row', 'chromium'),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'select',
		'settings'    => 'store_sidebar_style',
		'label'       => esc_html__( 'Sidebar widgets style (for Shop Archives & Single Product Page)', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => 'style-2',
		'choices'     => array(
				'style-1' => esc_html__( 'Style 1', 'chromium' ),
				'style-2' => esc_html__( 'Style 2', 'chromium' ),
				'style-3' => esc_html__( 'Style 3', 'chromium' ),
			),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'catalog_mode',
		'label'       => esc_html__( 'Enable Catalog Mode', 'chromium' ),
		'description' => esc_html__( 'Enable this option to hide product prices and add to cart button', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => false,
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'list_grid_separator',
		'section'     => 'chromium-store',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'list_grid_switcher',
		'label'       => esc_html__( 'Add list/grid switcher to shop page', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => '0',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'default_products_view',
		'label'       => esc_html__( 'Select default products view', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => 'grid',
		'choices'     => array(
			'list'  => esc_html__('List', 'chromium'),
			'grid' => esc_html__('Grid', 'chromium'),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'product_styles_separator',
		'section'     => 'chromium-store',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'primary_category_output',
		'label'       => esc_html__( 'Output Primary Category before product title on archives', 'chromium' ),
		'description' => esc_html__( 'You can choose primary category if YOAST Seo Plugin installed, otherwise first assigned category will be outputed', 'chromium' ),
		'section'     => 'chromium-store',
		'default'     => '1',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'store_product_style',
	'label'       => esc_html__( 'Product Listing Hover Style', 'chromium' ),
	'section'     => 'chromium-store',
	'default'     => 'style-3',
	'choices'     => array(
			'style-1' => esc_html__( 'Style 1', 'chromium' ),
			'style-2' => esc_html__( 'Style 2', 'chromium' ),
			'style-3' => esc_html__( 'Style 3', 'chromium' ),
			'style-4' => esc_html__( 'Style 4', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'store_badges_style',
	'label'       => esc_html__( 'Product Sale Badges Style', 'chromium' ),
	'section'     => 'chromium-store',
	'default'     => 'style-2',
	'choices'     => array(
			'style-1' => esc_html__( 'Style 1', 'chromium' ),
			'style-2' => esc_html__( 'Style 2', 'chromium' ),
			'style-3' => esc_html__( 'Style 3', 'chromium' ),
		),
	) );

	/* Product options */
	Chromium_Kirki::add_section( 'chromium-product', array(
		'title'       => esc_html__( 'Product Page Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'color',
		'settings'    => 'product_page_bg_color',
		'label'       => esc_html__( 'Product Page Background color', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '#f6f6f6',
		'choices'     => array(
			'alpha' => true,
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	'type'        => 'select',
	'settings'    => 'single_product_layout',
	'label'       => esc_html__( 'Product Page Layout', 'chromium' ),
	'section'     => 'chromium-product',
	'default'     => 'col3-col3',
	'choices'     => array(
			'col3-col3' => esc_html__( '1/2 Images + 1/2 Description', 'chromium' ),
			'col2-col4' => esc_html__( '1/3 Images + 2/3 Description', 'chromium' ),
			'col4-col2' => esc_html__( '2/3 Images + 1/3 Description', 'chromium' ),
			'col3-col3 reverse' => esc_html__( '1/2 Description + 1/2 Images', 'chromium' ),
			'col2-col4 reverse' => esc_html__( '1/3 Description + 2/3 Images', 'chromium' ),
			'col4-col2 reverse' => esc_html__( '2/3 Description + 1/3 Images', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'single_product_style',
		'label'       => esc_html__( 'Select style for single product page', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => 'product-chrom-style',
		'choices'     => array(
			'product-classic-style' => esc_html__('Classic WooCommerce', 'chromium'),
			'product-chrom-style' => esc_html__('Chromium Style', 'chromium'),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'radio',
		'settings'    => 'single_product_title_position',
		'label'       => esc_html__( 'Select Product title location', 'chromium' ),
		'section'     => 'chromium-product',
		'active_callback' => array(
			'setting' => 'single_product_style',
			'operator' => '==',
			'value'    => 'product-chrom-style'
		),
		'default'     => 'product-title-classic',
		'choices'     => array(
			'product-title-classic' => esc_html__('Above Product Description', 'chromium'),
			'product-title-chrom' => esc_html__('Above Product Image', 'chromium'),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'product_gallery_separator',
		'section'     => 'chromium-product',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'woocommerce_slider',
		'label'       => esc_html__( 'WooCommerce Gallery Slider', 'chromium' ),
		'description' => esc_html__( 'Enable this option to add flex slider to product image gallery', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'woocommerce_lightbox',
		'label'       => esc_html__( 'WooCommerce Gallery Lightbox', 'chromium' ),
		'description' => esc_html__( 'Enable this option to add lightbox to product images', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'woocommerce_zoom',
		'label'       => esc_html__( 'WooCommerce Gallery Zoom', 'chromium' ),
		'description' => esc_html__( 'Enable this option for zooming product images', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'number',
		'settings'    => 'product_thumb_width',
		'label'       => esc_html__( 'Product Thumbnail Width', 'chromium' ),
		'description' => esc_html__( 'Set the width of the gallery thumbnails on product page', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => 85,
		'choices'     => array(
			'min'  => 50,
			'max'  => apply_filters('chromium-thumb-width', 170),
			'step' => 1,
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'product_content_options_separator',
		'section'     => 'chromium-product',
		'default'     => '<div style="margin: 15px 0 10px 0;background-color: #d4d2d2;height: 1px;width: 100%;"></div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'grid_variations',
		'label'       => esc_html__( 'Product Variations Grid View', 'chromium' ),
		'description' => esc_html__( 'Enable this option to change view for 2 col grid', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'product_shares',
		'label'       => esc_html__( 'Share buttons on single product', 'chromium' ),
		'description' => esc_html__( 'Enable this option to add share buttons to single product', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'product_related_products',
		'label'       => esc_html__( 'Add section with related products under product tabs?', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => true,
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'checkbox',
		'settings'    => 'one_row_related_up_sells',
		'label'       => esc_html__( 'Show Related Products & Up-Sells Products in one row?', 'chromium' ),
		'description' => esc_html__( 'Check to output two equal columns with Related Products & Up-Sells Products.', 'chromium' ),
		'section'     => 'chromium-product',
		'default'     => false,
	) );

	/* Cart & Checkout options */
	Chromium_Kirki::add_section( 'chromium-cart-checkout', array(
		'title'       => esc_html__( 'Cart & Checkout Options', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'add_cart_sidebar',
		'label'       => esc_html__( 'Add widget area instead of Cross-sells slider', 'chromium' ),
		'section'     => 'chromium-cart-checkout',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'switch',
		'settings'    => 'grid_cart_widgets',
		'label'       => esc_html__( 'Enable grid layout for widgets', 'chromium' ),
		'section'     => 'chromium-cart-checkout',
		'default'     => '1',
		'choices'     => array(
			'on'  => esc_html__( 'Enable', 'chromium' ),
			'off' => esc_html__( 'Disable', 'chromium' ),
		),
	) );

} /* endif woocommerce class active */

	/* Typography and Colors */
	Chromium_Kirki::add_section( 'chromium-colors', array(
		'title'       => esc_html__( 'Typography and Colors', 'chromium' ),
		'description' => '',
		'panel'				=> 'chromium-theme-options',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
    'type'        => 'custom',
    'settings'    => 'separator_1',
    'section'     => 'chromium-colors',
		'default'     => '<div style="text-align: center; padding: 10px; background-color: #333; color: #fff; border-radius: 6px;">' . esc_html__( 'Global Font Options', 'chromium' ) . '</div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'     		=> 'select',
		'settings'  	=> 'primary_font_family',
		'label'    		=> esc_html__( 'Primary Font-Family', 'chromium' ),
		'section'  		=> 'chromium-colors',
		'default'  		=> 'Rubik',
		'choices'  		=> $font_options,
		'output'   		=> array(
			array(
				'element' => array('body'),
				'property'=> 'font-family'
			)
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
    'type'        => 'multicolor',
    'settings'    => 'site_text_colors',
    'label'       => esc_html__( 'Text Colors', 'chromium' ),
    'section'     => 'chromium-colors',
    'choices'     => array(
        'primary'    => esc_html__( 'Primary', 'chromium' ),
        'secondary'  => esc_html__( 'Secondary', 'chromium' ),
        'decorative' => esc_html__( 'Decorative', 'chromium' ),
		'sec-decorative' => esc_html__( 'Decorative', 'chromium' ),
    ),
    'default'     => array(
        'primary'    => '#626262',
        'secondary'  => '#626262',
        'decorative' => '#fdb819',
				'sec-decorative' => '#ffa800',
    ),
		'output'      => array(
			  array(
			    'choice'   => 'primary',
			    'element'  => array('body','.tz-product-tabs .nav-tabs > li > a:hover','.tz-product-tabs .nav-tabs > li > a:focus',
															'.tz-product-tabs .nav-tabs > li > a:active','.tz-product-tabs .nav-tabs > li.active > a',
															'.tz-sales-carousel .sale-title-wrapper span','ul#shipping_method .amount'),
			    'property' => 'color',
			  ),
			  array(
			    'choice'   => 'secondary',
			    'element'  => array('.tz-categories-grid li:not(.show-all) a',
															'.tz-product-tabs .nav-tabs > li > a',
															'.widget .product_list_widget .price del','.elementor-widget .product_list_widget .price del',
															'.tz-sales-carousel .sale-description','.tz-sales-carousel .price-wrapper del',
															'.tz-sales-carousel .countdown-section::before','.widget_tz_shopping_cart ul.cart_list li a.remove',
															'.widget_tz_shopping_cart .widget_shopping_cart_content .total strong','.tz-login-form-wrapper p::after',
															'.shop_table.cart td.product-price','td.product-remove a','.form-row label','#ship-to-different-address',
															'.woocommerce-checkout-review-order-table tbody tr','ul#shipping_method li input + label',
															'.blog article.type-post','.site-breadcrumbs','.author-info .author-bio',
															'.comments-area .comment','.comments-area .pingback','.woocommerce-Reviews .description',
															'.widget_calendar','.tz-from-blog .entry-excerpt','.quantity input[type=number]',
															'.tz-hoverable-tabs p a'),
			    'property' => 'color',
			  ),
				array(
					'choice'   => 'secondary',
					'element'  => array('td.product-remove a'),
					'property' => 'border-color',
				),
				array(
			    'choice'   => 'secondary',
			    'element'  => array('.quantity .quantity-button:before','.quantity .quantity-button:after'),
			    'property' => 'background-color',
			  ),
			  array(
			    'choice'   => 'decorative',
			    'element'  => array('.widget_tz_shopping_cart .heading .cart-count-wrapper','.ui-slider-horizontal .ui-slider-range',
															'.product .save-percent','.product .onsale','.product .onsale:before','.tz-product-tabs .nav-tabs > li > a::before',
															'.widget .product_list_widget .save-percent','.elementor-widget .product_list_widget .save-percent',
															'.tz-sales-carousel .countdown-section','ul.tabs.wc-tabs > li > a::before',
															'article.type-post .custom-post-label','.site-sidebar.style-1 .widget .widget-title:after',
															'.tz-from-blog .item-content ul.post-categories a','.tz-like-wrapper .wrapper a:hover',
															'.site-header .compare-count-wrapper','.site-header .wishlist-count-wrapper',
															'.widget_tz_categories.alt-style .widget-title','.product.badges-style-3 .onsale',
															'.widget_tz_socials ul.inline-mode li i:hover','.blog-grid-posts  article.type-post .post-date-wrapper span.border'),
			    'property' => 'background-color',
			  ),
				array(
					'choice'   => 'decorative',
					'element'  => array('.tz-sales-carousel .sale-title-wrapper','.widget_tz_hot_offers .countdown-amount',
															'.tz-sales-carousel .amount','.widget_layered_nav_filters ul li a:before',
															'td.product-remove a:hover','td.product-remove a:focus','td.product-remove a:active',
															'.cart_totals tr.order-total td','.woocommerce-checkout-review-order-table .order-total td',
															'.wc-layered-nav-rating .star-rating span::before','.comment-form-rating p.stars a',
															'.entry-summary .button.tm-woowishlist-page-button:hover','.entry-summary .button.tm-woowishlist-page-button:focus',
															'.entry-summary .button.tm-woowishlist-page-button:active','.entry-summary .button.tm-woocompare-page-button:hover',
															'.entry-summary .button.tm-woocompare-page-button:focus','.entry-summary .button.tm-woocompare-page-button:active',
															'.chromium-product-style-3 li.product:hover .button.add_to_cart_button::before',
															'.chromium-product-style-3 li.product:hover .button.ajax_add_to_cart::before',
															'.chromium-product-style-4 li.product:hover .button.add_to_cart_button::before',
															'.chromium-product-style-4 li.product:hover .button.ajax_add_to_cart::before',
															'.tz-sales-carousel .countdown-wrapper.style-2 .countdown-amount',
															'.button.tm-woocompare-button-single:before','.button.tm-woowishlist-button-single:before',
															'blockquote:before','.date-cat-wrapper span','.post-date-wrapper span:not(.border)',
															'article.format-quote .quote-wrapper i::before', '.price ins .woocommerce-Price-amount'),
					'property' => 'color',
				),
				array(
					'choice'   => 'decorative',
					'element'  => array('.product .onsale:before','td.product-remove a:hover','td.product-remove a:focus',
															'td.product-remove a:active','.tz-product-tabs .tab-nav-wrapper .nav-tabs>li>a::after',
															'.widget_tz_categories.alt-style'),
					'property' => 'border-color',
				),
				array(
					'choice'   => 'sec-decorative',
					'element'  => array('article.type-post .entry-date','.related-posts .date','.entry-summary .button.tm-woowishlist-page-button',
															'.entry-summary .button.tm-woocompare-page-button','ul.posts-list .post-date','.tz-from-blog .time-wrapper',
															'.tab-content-grid a:hover','.tab-content-grid a:focus','.tab-content-grid a:active','.tab-content-grid ul li:first-child a:active',
															'.tab-content-grid ul li:first-child a:hover','.tab-content-grid ul li:first-child a:focus',
															'.chromium-product-style-2 li.product .buttons-wrapper .button','.product-shares-wrapper .tz-social-links .wrapper a:hover',
															'.product-shares-wrapper .tz-social-links .wrapper a:hover i::before',
															'.product .star-rating span:before',
															'.product_list_widget .star-rating span::before'),
					'property' => 'color',
				),
				array(
					'choice'   => 'sec-decorative',
					'element'  => array('.widget_layered_nav li.chosen a:before','.search .search-excerpt'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'sec-decorative',
					'element'  => array('.widget_layered_nav li.chosen a:before'),
					'property' => 'border-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_link_colors',
		'label'       => esc_html__( 'Link Colors', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'normal'    		 => esc_html__( 'Normal (Content)', 'chromium' ),
				'hover'  				 => esc_html__( 'Hover (Content)', 'chromium' ),
				'sidebar-normal' => esc_html__( 'Normal (Sidebar)', 'chromium' ),
				'sidebar-hover'  => esc_html__( 'Hover (Sidebar)', 'chromium' ),
				'top-panel-normal' => esc_html__( 'Normal (Header Top Panel)', 'chromium' ),
				'top-panel-hover'  => esc_html__( 'Hover (Header Top Panel)', 'chromium' ),
				'footer-normal' => esc_html__( 'Normal (Footer)', 'chromium' ),
				'footer-hover'  => esc_html__( 'Hover (Footer)', 'chromium' ),

		),
		'default'     => array(
				'normal'    		 => '#000000',
				'hover'  				 => '#fdb819',
				'sidebar-normal' => '#626262',
				'sidebar-hover'  => '#fdb819',
				'top-panel-normal' => '#81858c',
				'top-panel-hover'  => '#fdb819',
				'footer-normal' => '#9a9a9a',
				'footer-hover'  => '#fdb819',
		),
		'output'      => array(
				array(
					'choice'   => 'normal',
					'element'  => array('a','.site-sidebar .widget_calendar a','.button.tm-woocompare-button-single',
															'.button.tm-woowishlist-button-single','.show-all a:hover','.show-all a:focus',
															'.show-all a:active','.show-all a:hover i:before','.nav-links span i:before',
															'.widget.widget_tz_categories.alt-style a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'hover',
					'element'  => array( 'a:hover','a:focus','a:active','.tz-categories-grid li:not(.show-all) a:hover','.tz-categories-grid li:not(.show-all) a:focus',
															'.tz-categories-grid li:not(.show-all) a:active','.entry-title a:hover','.entry-title a:focus','.entry-title a:active',
															'.related-posts h3 a:hover','.related-posts h3 a:focus','.related-posts h3 a:active',
															'.comment-author a:hover','.comment-author a:focus','.comment-author a:active',
															'.site-sidebar .widget_calendar a:hover','.site-sidebar .widget_calendar a:focus',
															'.site-sidebar .widget_calendar a:active','.show-all a','.show-all a i:before',
															'.button.tm-woocompare-button-single:hover','.button.tm-woowishlist-button-single:hover','.button.tm-woocompare-button-single:focus',
															'.button.tm-woowishlist-button-single:focus','.button.tm-woocompare-button-single:active','.button.tm-woowishlist-button-single:active',
															'.tz-hoverable-tabs p a:hover','.tz-hoverable-tabs p a:focus','.tz-hoverable-tabs p a:active',
															'.nav-links span:hover i:before','.related-posts .related-categorie:hover','.related-posts .related-categorie:focus',
															'.related-posts .related-categorie:active','.blog-style-2 article.type-post .post-cats a:hover','
															article.type-post .grid-wrapper .post-tags a:hover','.blog-style-2 article.type-post .post-cats a:focus','
															article.type-post .grid-wrapper .post-tags a:focus','.blog-style-2 article.type-post .post-cats a:active','
															article.type-post .grid-wrapper .post-tags a:active','.widget.widget_tz_categories.alt-style a:hover',
															'.widget.widget_tz_categories.alt-style a:focus','.widget.widget_tz_categories.alt-style a:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'sidebar-normal',
					'element'  => array('.site-sidebar a','.woocommerce-MyAccount-navigation a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'sidebar-hover',
					'element'  => array('.site-sidebar a:hover','.site-sidebar a:focus','.site-sidebar a:active',
															'.woocommerce-MyAccount-navigation a:hover','.woocommerce-MyAccount-navigation a:focus',
															'.woocommerce-MyAccount-navigation a:active','.site-sidebar .comment-author-link a:hover',
															'.site-sidebar .comment-author-link a:focus','.site-sidebar .comment-author-link a:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'top-panel-normal',
					'element'  => array('.header-top a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'top-panel-hover',
					'element'  => array('.header-top a:hover','.header-top a:focus','.header-top a:active',
															'.header-top .tz-login-heading.inline a.login-button:hover','.tz-login-heading.inline a.my-account:hover',
															'.header-top .tz-login-heading.inline a.login-button:focus','.tz-login-heading.inline a.my-account:focus',
															'.header-top .tz-login-heading.inline a.login-button:active','.tz-login-heading.inline a.my-account:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'footer-normal',
					'element'  => array('.site-footer a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'footer-hover',
					'element'  => array('.site-footer a:hover','.site-footer a:focus','.site-footer a:active'),
					'property' => 'color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_headings_colors',
		'label'       => esc_html__( 'Heading Colors', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'header' 	=> esc_html__( 'Header', 'chromium' ),
				'content' => esc_html__( 'Content', 'chromium' ),
				'sidebar' => esc_html__( 'Sidebar', 'chromium' ),
				'footer' 	=> esc_html__( 'Footer', 'chromium' ),
		),
		'default'     => array(
				'header'    => '#626262',
				'content'    => '#000000',
				'sidebar'  => '#000000',
				'footer' => '#FFFFFF',
		),
		'output'      => array(
				array(
					'choice'   => 'header',
					'element'  => array('.site-header h1','.site-header h2','.site-header h3','.site-header h4',
															'.site-header h5','.site-header h6','.site-header .widget-heading'),
					'property' => 'color',
				),
				array(
					'choice'   => 'content',
					'element'  => array('.site-content h1','.site-content h2','.site-content h3','.site-content h4',
															'.site-content h5','.site-content h6','.single-label span','blockquote',
															'.product-shares-wrapper .tz-social-links .heading','div.product .price',
															'.site-sidebar .comment-author-link a','.product .price',
															'.site-sidebar .comment-author-link'
															),
					'property' => 'color',
				),
				array(
					'choice'   => 'sidebar',
					'element'  => array( '.site-sidebar h1',
										 '.site-sidebar h2',
						                 '.site-sidebar h3',
										 '.site-sidebar h4',
										 '.site-sidebar h5',
										 '.site-sidebar h6',
						'.site-sidebar h1 a',
						'.site-sidebar h2 a',
						'.site-sidebar h3 a',
						'.site-sidebar h4 a',
						'.site-sidebar h5 a',
						'.site-sidebar h6 a'
						),
					'property' => 'color',
				),
				array(
					'choice'   => 'footer',
					'element'  => array('.site-footer h1','.site-footer h2','.site-footer h3','.site-footer h4',
															'.site-footer h5','.site-footer h6'),
					'property' => 'color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_secondary_elements_colors',
		'label'       => esc_html__( 'Borders and Icons', 'chromium' ),
		'description' => esc_html__( 'Colors for all table borders, section borders, icons', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'border' => esc_html__( 'Borders Color', 'chromium' ),
				'icon' => esc_html__( 'Icons Color', 'chromium' ),
		),
		'default'     => array(
				'border' => '#ebebeb',
				'icon' => '#a9a9a9',
		),
		'output'      => array(
				array(
					'choice'   => 'border',
					'element'  => array('.primary-nav','.widget .widget-title','.elementor-widget h5','.widget_tz_shopping_cart .widget_shopping_cart_content',
															'.widget_tz_shopping_cart .mini-cart-heading','.widget_tz_shopping_cart ul.cart_list li a.remove',
															'.widget_tz_shopping_cart .widget_shopping_cart_content .total','.tz-login-form-wrapper','.tz-login-form-wrapper .heading',
															'.site-header .tm-woocompare-widget-products','.site-header .tm-woowishlist-widget-products','.widget_price_filter .from',
															'.widget_price_filter .to','.widget_layered_nav ul li a:before','.widget_layered_nav_filters ul li a:before',
															'form.ajax-auth','.ajax-auth .botom-links','.site-sidebar.style-1 .widget .widget-title + *',
															'ul.tabs.wc-tabs > li > a','#comments','table','table td','.site-sidebar.style-1 .widget .screen-reader-text + .select-wrapper',
															'table th','.cross-sells h2','.cart_totals h2','.tz-hoverable-tabs ul.nav li',
															'.woocommerce-checkout-review-order-table .img','article.type-post .post-cats','article.type-post .post-tags',
															'.author-info h3','.post-navigation .nav-links','.comment .child-comments',
															'#reviews ol.commentlist','.woocommerce-MyAccount-navigation','.woocommerce-MyAccount-navigation ul li',
															'.woocommerce-checkout h2','table.order_details','table.order_details th','table.order_details td',
															'.blog.blog-grid-posts .meta-counters','figure.gallery-item:hover img','.tz-product-tabs .tab-nav-wrapper',
															'.tz-from-blog.style-2 .title-wrapper','.tz-categories-grid.with-slider .title-wrapper',
															'.widget.widget_tz_categories.alt-style ul li','.product-classic-style div.product .product-shares-wrapper',
															'.post-date-wrapper .border'),
					'property' => 'border-color',
				),
				array(
					'choice'   => 'border',
					'element'  => array('.widget_tz_login_register + .widget:before',
															'.title-wrapper .slider-navi span + span::before','.owl-carousel .owl-nav div + div::before',
															'.tab-pane .slider-navi span + span::before','hr','article.type-post .post-date-wrapper::before',
															'article.type-post .post-date-wrapper::after'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'border',
					'element'  => array('.product .star-rating:before','.tz-testimonials .star-rating:before',
															'.product_list_widget .star-rating::before','.wc-layered-nav-rating .star-rating::before',
															'.tz-hoverable-tabs i.icon:before'),
					'property' => 'color',
				),
				array(
					'choice'   => 'icon',
					'element'  => array('.meta-counters','.quote-wrapper i::before','.widget_search .search-form::before',
															'.widget_tz_categories .count','.widget_categories .count','.widget_archive .count',
															'.tz-from-blog .post-views','.product-shares-wrapper .tz-social-links .wrapper a',
															'.product-shares-wrapper .tz-social-links .wrapper a i::before','.chromium-product-style-4 li.product .button::before',
															'.chromium-product-style-3 li.product .button::before','.chromium-product-style-2 li.product .button::before',
															'.tz-from-blog.style-2 .item-content a.post-cat-link','article.type-post .time-wrapper i',
															'.product-images-wrapper .woocommerce-product-gallery__trigger','.product .reviews-wrapper',
															'.related-posts .related-categorie'),
					'property' => 'color',
				),
				array(
					'choice'   => 'icon',
					'element'  => array('.product-images-wrapper .woocommerce-product-gallery__trigger'),
					'property' => 'border-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'separator_2',
		'section'     => 'chromium-colors',
		'default'     => '<div style="text-align: center; margin-top: 50px; padding: 10px; background-color: #333; color: #fff; border-radius: 6px;">' . esc_html__( 'Form Color Options', 'chromium' ) . '</div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'     		=> 'select',
		'settings'  	=> 'fields_font_family',
		'label'    		=> esc_html__( 'Fields Font-Family', 'chromium' ),
		'section'  		=> 'chromium-colors',
		'default'  		=> 'Rubik',
		'choices'  		=> $font_options,
		'output'   		=> array(
			array(
				'element' => array('input','button','.button','textarea'),
				'property'=> 'font-family'
			)
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
	  'settings'  => 'fields_border-radius',
	  'section'   => 'chromium-colors',
	  'label'     => esc_html__( 'Fields Border Radius', 'chromium' ),
	  'type'      => 'dimensions',
		'choices'   => array(
			'top' => esc_html__( 'Top Left ', 'chromium' ),
			'right' => esc_html__( 'Top Right', 'chromium' ),
			'bottom' => esc_html__( 'Bottom Right', 'chromium' ),
			'left' => esc_html__( 'Bottom Left', 'chromium' ),
		),
	  'default'   => array(
	    'top'    => '2px',
	    'right'  => '2px',
	    'bottom' => '2px',
	    'left'   => '2px',
	  ),
		'output'    => array(
	    array(
	      'choice'      => 'top',
	      'element'     => array('input','button','.button','textarea','.select2-container--default .select2-selection--single',
															 '.select2-dropdown'),
	      'property'    => 'border-top-left-radius',
	    ),
	    array(
	      'choice'      => 'right',
	      'element'     => array('input','button','.button','textarea','.select2-container--default .select2-selection--single',
															 '.select2-dropdown'),
	      'property'    => 'border-top-right-radius',
	    ),
	    array(
	      'choice'      => 'bottom',
	      'element'     => array('input','button','.button','textarea','.select2-container--default .select2-selection--single',
															 '.select2-dropdown'),
	      'property'    => 'border-bottom-right-radius',
	    ),
	    array(
	      'choice'      => 'left',
	      'element'     => array('input','button','.button','textarea','.select2-container--default .select2-selection--single',
															 '.select2-dropdown'),
	      'property'    => 'border-bottom-left-radius',
	    ),
	  ),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_text_fields_colors',
		'label'       => esc_html__( 'Text field, Textarea, etc.', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'color' => esc_html__( 'Color', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'border-color' => esc_html__( 'Border', 'chromium' ),
		),
		'default'     => array(
				'color'    => '#626262',
				'background-color'  => 'rgba(255,255,255,0)',
				'border-color' => '#dbdbdb',
		),
		'output'      => array(
				array(
					'choice'   => 'color',
					'element'  => array('input[type="text"]','input[type="email"]','input[type="url"]','input[type="password"]','input[type="search"]',
															'input[type="number"]','input[type="tel"]','input[type="range"]','input[type="date"]','input[type="month"]',
															'input[type="week"]','input[type="time"]','input[type="datetime"]','input[type="datetime-local"]','input[type="color"]',
															'textarea'),
					'property' => 'color',
				),
				array(
					'choice'   => 'background-color',
					'element'  => array('input[type="text"]','input[type="email"]','input[type="url"]','input[type="password"]','input[type="search"]',
															'input[type="number"]','input[type="tel"]','input[type="range"]','input[type="date"]','input[type="month"]',
															'input[type="week"]','input[type="time"]','input[type="datetime"]','input[type="datetime-local"]','input[type="color"]',
															'textarea'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'border-color',
					'element'  => array('input[type="text"]','input[type="email"]','input[type="url"]','input[type="password"]','input[type="search"]',
															'input[type="number"]','input[type="tel"]','input[type="range"]','input[type="date"]','input[type="month"]',
															'input[type="week"]','input[type="time"]','input[type="datetime"]','input[type="datetime-local"]','input[type="color"]',
															'textarea','select','.select2-container--default .select2-selection--single','.woocommerce-ordering::before',
															'.select2-dropdown','.select2-container--default .select2-search--dropdown .select2-search__field',
															'.product-pager::before','.select-wrapper::before'),
					'property' => 'border-color',
				),
				array(
					'choice'   => 'border-color',
					'element'  => array('.select2-container--default .select2-selection--single .select2-selection__arrow:before'),
					'property' => 'background-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'custom',
		'settings'    => 'separator_3',
		'section'     => 'chromium-colors',
		'default'     => '<div style="text-align: center; margin-top: 50px; padding: 10px; background-color: #333; color: #fff; border-radius: 6px;">' . esc_html__( 'Buttons Options', 'chromium' ) . '</div>',
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_primary_btn_colors',
		'label'       => esc_html__( 'Primary Button', 'chromium' ),
		'description' => esc_html__( 'Colors for all buttons & submits on this site', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'color' => esc_html__( 'Text Color', 'chromium' ),
				'color-hover' => esc_html__( ':hover', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'background-color-hover' => esc_html__( ':hover', 'chromium' ),
		),
		'default'     => array(
				'color' => '#212121',
				'color-hover' => '#fff',
				'background-color' => '#fdb819',
				'background-color-hover' => '#212121',
		),
		'output'      => array(
				array(
					'choice'   => 'color',
					'element'  => array('button','html input[type="button"]','input[type="reset"]','input[type="submit"]','.button',
															'.primary-nav .menu a','.logo-group-nav .menu a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'color-hover',
					'element'  => array('button:hover','html input[type="button"]:hover','input[type="reset"]:hover','input[type="submit"]:hover','.button:hover',
															'button:focus','html input[type="button"]:focus','input[type="reset"]:focus','input[type="submit"]:focus','.button:focus',
															'button:active','html input[type="button"]:active','input[type="reset"]:active','input[type="submit"]:active','.button:active',
															'.primary-nav .current-menu-item a','.logo-group-nav .current-menu-item a','.primary-nav .menu a:hover',
															'.logo-group-nav .menu a:hover','.primary-nav .menu a:focus','.logo-group-nav .menu a:focus',
															'.primary-nav .menu a:active','.logo-group-nav .menu a:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'background-color',
					'element'  => array('button','html input[type="button"]','input[type="reset"]','input[type="submit"]','.button',
															'.primary-nav .menu a','.logo-group-nav .menu a'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'background-color-hover',
					'element'  => array('button:hover','html input[type="button"]:hover','input[type="reset"]:hover','input[type="submit"]:hover','.button:hover',
															'button:focus','html input[type="button"]:focus','input[type="reset"]:focus','input[type="submit"]:focus','.button:focus',
															'button:active','html input[type="button"]:active','input[type="reset"]:active','input[type="submit"]:active','.button:active',
															'.primary-nav .current-menu-item a','.logo-group-nav .current-menu-item a','.primary-nav .menu a:hover',
															'.logo-group-nav .menu a:hover','.primary-nav .menu a:focus','.logo-group-nav .menu a:focus',
															'.primary-nav .menu a:active','.logo-group-nav .menu a:active'),
					'property' => 'background-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_primary_alt_btn_colors',
		'label'       => esc_html__( 'Primary Button Alt', 'chromium' ),
		'description' => esc_html__( 'Colors for all primary buttons & submits used with contrast backgrounds', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'color' => esc_html__( 'Text Color', 'chromium' ),
				'color-hover' => esc_html__( ':hover', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'background-color-hover' => esc_html__( ':hover', 'chromium' ),
		),
		'default'     => array(
				'color' => '#212121',
				'color-hover' => '#212121',
				'background-color' => '#fdb819',
				'background-color-hover' => '#ffa800',
		),
		'output'      => array(
				array(
					'choice'   => 'color',
					'element'  => array('.primary-alt-btn button','html .primary-alt-btn input[type="button"]',
															'.primary-alt-btn input[type="reset"]','.primary-alt-btn input[type="submit"]',
															'.primary-alt-btn .button','.widget_mailchimpsf_widget .mc_signup_submit',
															'.primary-alt-btn.button'),
					'property' => 'color',
				),
				array(
					'choice'   => 'color-hover',
					'element'  => array('.primary-alt-btn button:hover','html .primary-alt-btn input[type="button"]:hover',
															'.primary-alt-btn input[type="reset"]:hover','.primary-alt-btn input[type="submit"]:hover',
															'.primary-alt-btn .button:hover','.primary-alt-btn button:focus',
															'html .primary-alt-btn input[type="button"]:focus','.primary-alt-btn input[type="reset"]:focus',
															'.primary-alt-btn input[type="submit"]:focus','.primary-alt-btn .button:focus',
															'.primary-alt-btn button:active','html .primary-alt-btn input[type="button"]:active',
															'.primary-alt-btn input[type="reset"]:active','.primary-alt-btn input[type="submit"]:active',
															'.primary-alt-btn .button:active','.widget_mailchimpsf_widget .mc_signup_submit:hover',
															'.widget_mailchimpsf_widget .mc_signup_submit:focus','.widget_mailchimpsf_widget .mc_signup_submit:active',
															'.primary-alt-btn:hover .tz-banner .button','.primary-alt-btn.button:hover','.primary-alt-btn.button:focus',
															'.primary-alt-btn.button:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'background-color',
					'element'  => array('.primary-alt-btn button','html .primary-alt-btn input[type="button"]',
															'.primary-alt-btn input[type="reset"]','.primary-alt-btn input[type="submit"]',
															'.primary-alt-btn .button','.widget_mailchimpsf_widget .mc_signup_submit',
															'.primary-alt-btn.button'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'background-color-hover',
					'element'  => array('.primary-alt-btn button:hover','html .primary-alt-btn input[type="button"]:hover',
															'.primary-alt-btn input[type="reset"]:hover','.primary-alt-btn input[type="submit"]:hover',
															'.primary-alt-btn .button:hover','.primary-alt-btn button:focus',
															'html .primary-alt-btn input[type="button"]:focus','.primary-alt-btn input[type="reset"]:focus',
															'.primary-alt-btn input[type="submit"]:focus','.primary-alt-btn .button:focus',
															'.primary-alt-btn button:active','html .primary-alt-btn input[type="button"]:active',
															'.primary-alt-btn input[type="reset"]:active','.primary-alt-btn input[type="submit"]:active',
															'.primary-alt-btn .button:active','.widget_mailchimpsf_widget .mc_signup_submit:hover',
															'.widget_mailchimpsf_widget .mc_signup_submit:focus','.widget_mailchimpsf_widget .mc_signup_submit:active',
														  '.primary-alt-btn:hover .tz-banner .button','.primary-alt-btn.button:hover','.primary-alt-btn.button:focus',
															'.primary-alt-btn.button:active'),
					'property' => 'background-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_secondary_btn_colors',
		'label'       => esc_html__( 'Secondary Button', 'chromium' ),
		'description' => esc_html__( 'Colors for all secondary buttons & submits on this site', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'color' => esc_html__( 'Text Color', 'chromium' ),
				'color-hover' => esc_html__( ':hover', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'background-color-hover' => esc_html__( ':hover', 'chromium' ),
		),
		'default'     => array(
				'color' => '#fff',
				'color-hover' => '#212121',
				'background-color' => '#212121',
				'background-color-hover' => '#fdb819',
		),
		'output'      => array(
				array(
					'choice'   => 'color',
					'element'  => array('.button.empty-cart','.link-to-post.button','.checkout.button','.checkout-button.button',
															'.button.alt','li.product .buttons-wrapper .button','li.product .excerpt-wrapper .button',
															'.single article.type-post .post-tags a'),
					'property' => 'color',
				),
				array(
					'choice'   => 'color-hover',
					'element'  => array('.button.empty-cart:hover','.button.empty-cart:focus','.button.empty-cart:active',
															'.link-to-post.button:hover','.link-to-post.button:focus','.link-to-post.button:active',
															'.checkout.button:hover','.checkout.button:focus','.checkout.button:active',
															'.checkout-button.button:hover','.checkout-button.button:focus','.checkout-button.button:active',
															'.button.alt:hover','.button.alt:focus','.button.alt:active','li.product .buttons-wrapper .button:hover',
															'li.product .buttons-wrapper .button:focus','li.product .buttons-wrapper .button:active',
															'li.product .excerpt-wrapper .button:hover','li.product .excerpt-wrapper .button:focus',
															'li.product .excerpt-wrapper .button:active','.single article.type-post .post-tags a:hover',
															'.single article.type-post .post-tags a:focus','.single article.type-post .post-tags a:active'),
					'property' => 'color',
				),
				array(
					'choice'   => 'background-color',
					'element'  => array('.button.empty-cart','.link-to-post.button','.checkout.button','.checkout-button.button',
															'.button.alt','li.product .buttons-wrapper .button','li.product .excerpt-wrapper .button',
															'.single article.type-post .post-tags a'),
					'property' => 'background-color',
				),
				array(
					'choice'   => 'background-color-hover',
					'element'  => array('.button.empty-cart:hover','.button.empty-cart:focus','.button.empty-cart:active',
															'.link-to-post.button:hover','.link-to-post.button:focus','.link-to-post.button:active',
															'.checkout.button:hover','.checkout.button:focus','.checkout.button:active',
															'.checkout-button.button:hover','.checkout-button.button:focus','.checkout-button.button:active',
															'.button.alt:hover','.button.alt:focus','.button.alt:active','li.product .buttons-wrapper .button:hover',
															'li.product .buttons-wrapper .button:focus','li.product .buttons-wrapper .button:active',
															'li.product .excerpt-wrapper .button:hover','li.product .excerpt-wrapper .button:focus',
															'li.product .excerpt-wrapper .button:active','.single article.type-post .post-tags a:hover',
															'.single article.type-post .post-tags a:focus','.single article.type-post .post-tags a:active'),
					'property' => 'background-color',
				),
		),
	) );

	Chromium_Kirki::add_field( 'chromium', array(
		'type'        => 'multicolor',
		'settings'    => 'site_secondary_alt_btn_colors',
		'label'       => esc_html__( 'Secondary Button Alt', 'chromium' ),
		'description' => esc_html__( 'Colors for all secondary buttons & submits used with contrast backgrounds', 'chromium' ),
		'section'     => 'chromium-colors',
		'choices'     => array(
				'color' => esc_html__( 'Text Color', 'chromium' ),
				'color-hover' => esc_html__( ':hover', 'chromium' ),
				'background-color' 	=> esc_html__( 'Background', 'chromium' ),
				'background-color-hover' => esc_html__( ':hover', 'chromium' ),
		),
		'default'     => array(
				'color' => '#fff',
				'color-hover' => '#fff',
				'background-color' => '#212121',
				'background-color-hover' => '#3a3a3a',
		),
		'output'      => array(
			array(
				'choice'   => 'color',
				'element'  => array('.secondary-alt-btn button','html .secondary-alt-btn input[type="button"]',
														'.secondary-alt-btn input[type="reset"]','.secondary-alt-btn input[type="submit"]',
														'.secondary-alt-btn .button','.secondary-alt-btn.button',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit'),
				'property' => 'color',
			),
			array(
				'choice'   => 'color-hover',
				'element'  => array('.secondary-alt-btn button:hover','html .secondary-alt-btn input[type="button"]:hover',
														'.secondary-alt-btn input[type="reset"]:hover','.secondary-alt-btn input[type="submit"]:hover',
														'.secondary-alt-btn .button:hover','.secondary-alt-btn button:focus',
														'html .secondary-alt-btn input[type="button"]:focus','.secondary-alt-btn input[type="reset"]:focus',
														'.secondary-alt-btn input[type="submit"]:focus','.secondary-alt-btn .button:focus',
														'.secondary-alt-btn button:active','html .secondary-alt-btn input[type="button"]:active',
														'.secondary-alt-btn input[type="reset"]:active','.secondary-alt-btn input[type="submit"]:active',
														'.secondary-alt-btn .button:active','.secondary-alt-btn:hover .tz-banner .button',
														'.secondary-alt-btn.button:hover','.secondary-alt-btn.button:focus','.secondary-alt-btn.button:active',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:hover',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:focus',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:active'),
				'property' => 'color',
			),
			array(
				'choice'   => 'background-color',
				'element'  => array('.secondary-alt-btn button','html .secondary-alt-btn input[type="button"]',
														'.secondary-alt-btn input[type="reset"]','.secondary-alt-btn input[type="submit"]',
														'.secondary-alt-btn .button','.secondary-alt-btn.button',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit'),
				'property' => 'background-color',
			),
			array(
				'choice'   => 'background-color-hover',
				'element'  => array('.secondary-alt-btn button:hover','html .secondary-alt-btn input[type="button"]:hover',
														'.secondary-alt-btn input[type="reset"]:hover','.secondary-alt-btn input[type="submit"]:hover',
														'.secondary-alt-btn .button:hover','.secondary-alt-btn button:focus',
														'html .secondary-alt-btn input[type="button"]:focus','.secondary-alt-btn input[type="reset"]:focus',
														'.secondary-alt-btn input[type="submit"]:focus','.secondary-alt-btn .button:focus',
														'.secondary-alt-btn button:active','html .secondary-alt-btn input[type="button"]:active',
														'.secondary-alt-btn input[type="reset"]:active','.secondary-alt-btn input[type="submit"]:active',
														'.secondary-alt-btn .button:active','.secondary-alt-btn:hover .tz-banner .button',
														'.secondary-alt-btn.button:hover','.secondary-alt-btn.button:focus','.secondary-alt-btn.button:active',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:hover',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:focus',
														'.site .dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:active'),
				'property' => 'background-color',
			),		),
	) );

	add_action( 'registered_taxonomy', 'chromium_label_taxonomies_option');

	function chromium_get_custom_labels(){
		$terms = get_terms( array(
			'taxonomy' => 'product-custom-label',
			'hide_empty' => false,
		) );

		$terms_array = [];
		if ( ! ( $terms instanceof WP_Error ) && count( $terms ) )
			foreach ($terms as $term) {
				$terms_array[$term->slug] = $term->name;
			}

		return $terms_array;
	}

	function chromium_label_taxonomies_option(){

		Chromium_Kirki::add_field( 'chromium', array(
			'type'        => 'select',
			'settings'    => 'product_default_labels',
			'label'       => esc_html__( 'Default Custom Labels', 'chromium' ),
			'section'     => 'chromium-product',
			'default'     => '',
			'multiple'    => 10,
			'choices'     => chromium_get_custom_labels(),
		) );

	}

}
