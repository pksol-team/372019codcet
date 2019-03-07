<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Sale_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-sale-carousel';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Sale Carousel', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-tags';
	}
	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 */
	public function get_categories() {
		return [ 'themes-zone-elements' ];
	}
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */

	protected function _register_controls() {

		$products_array = array();

		if ( class_exists('WooCommerce') ) {
			/* Get array of available products */
	      $args = array(
	        'post_type' => 'product',
	        'posts_per_page' => -1,
	        'meta_key' => '_sale_price_dates_to',
	        'meta_value' => '"'.time().'"',
	        'meta_compare' => '>=',
	        'post_status' => 'publish',
	      );

			$products = get_posts( $args );
			if ($products) {
				foreach ( $products as $product ) {
					$products_array[$product->ID] = $product->post_title;
				}
			}

			wp_reset_postdata();
        }

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'tz-feature-pack' ),
			]
		);
    $this->add_control(
      'widget_title',
      [
         'label'       => esc_html__( 'Title', 'tz-feature-pack' ),
         'type'        => Controls_Manager::TEXT,
         'default'     => esc_html__( 'Default title text', 'tz-feature-pack' ),
         'placeholder' => esc_html__( 'Type your title text here', 'tz-feature-pack' ),
      ]
    );
		$this->add_control(
			'carousel_items',
			[
				'label' => esc_html__( 'Carousel Items', 'tz-feature-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'product_id' => '',
						'image' => '',
						'pre_countdown_text' => '',
					],
				],
				'fields' => [
          [
            'name' => 'product_id',
            'label' => __( 'Product ID', 'tz-feature-pack' ),
            'default' => '',
            'type' => Controls_Manager::SELECT2,
            'options' => $products_array,
          ],
					[
						'name' => 'image',
				    'label' => esc_html__( 'Product Image', 'tz-feature-pack' ),
            'description' => esc_html__( 'Add Custom Image for sale item instead of Product Image set in product options.', 'tz-feature-pack' ),
				    'type' => Controls_Manager::MEDIA,
				    'default' => [
				       'url' => Utils::get_placeholder_image_src(),
				    ],
				  ],
          [
            'name' => 'heading_text',
            'label'   => esc_html__( 'Heading text', 'tz-feature-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Heading text', 'tz-feature-pack' ),
          ],
          [
						'name' => 'pre_countdown_text',
				    'label'   => esc_html__( 'Pre-Countdown text', 'tz-feature-pack' ),
				    'type'    => Controls_Manager::TEXTAREA,
				    'default' => __( 'Default text', 'tz-feature-pack' ),
				  ],
					[
						'name' => 'alt_countdown_style',
						'label' => esc_html__( 'Enable alternative styles for countdown?', 'tz-feature-pack' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
						'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
						'return_value' => 'yes',
					],
					[
						'name' => 'swap_row',
						'label' => esc_html__( 'Swap Picture and Description?', 'tz-feature-pack' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
						'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
						'return_value' => 'yes',
					],
					[
						'name' => 'catalog_mode',
						'label' => esc_html__( 'Replace "Add to cart" with link to product?', 'tz-feature-pack' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
						'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
						'return_value' => 'yes',
					],
					[
						'name' => 'button_text',
						'label'       => esc_html__( 'Button Custom Text', 'your-plugin' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => esc_html__( 'Shop Now', 'your-plugin' ),
					],
					[
						'name' => 'add_sticker',
						'label' => esc_html__( 'Add price sticker to product image?', 'tz-feature-pack' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
						'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
						'return_value' => 'yes',
					],
				  [
						'name' => 'sticker_width',
				    'label'   => esc_html__( 'Sticker diameter (px)', 'your-plugin' ),
				    'type'    => Controls_Manager::NUMBER,
				    'default' => 110,
				    'min'     => 50,
				    'max'     => 500,
				    'step'    => 1,
				  ],
					[
						'name' => 'sticker_position',
						'label' => __( 'Specify top/left offset for sticker', 'tz-feature-pack' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'allowed_dimensions' => array('top','left'),

					],
				  [
						'name' => 'sticker_text',
				    'label'   => __( 'Description', 'your-plugin' ),
				    'type'    => Controls_Manager::WYSIWYG,
				    'default' => __( 'Default description', 'your-plugin' ),
				  ],
				],
				'title_field' => 'ID - {{{ product_id }}}',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
      'section_style',
      [
        'label' => esc_html__( 'Carousel Options', 'tz-feature-pack' ),
      ]
    );

    $this->add_control(
      'autoplay',
      [
        'label' => esc_html__( 'Autoplay?', 'tz-feature-pack' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => '',
        'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
        'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
        'return_value' => 'yes',
      ]
    );

    $this->add_control(
      'show_arrows',
      [
        'label' => esc_html__( 'Show Arrows?', 'tz-feature-pack' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => '',
        'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
        'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
        'return_value' => 'yes',
      ]
    );

    $this->add_control(
      'show_dots',
      [
        'label' => esc_html__( 'Show Dots?', 'tz-feature-pack' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => '',
        'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
        'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
        'return_value' => 'yes',
      ]
    );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_colors',
			[
				'label' => esc_html__( 'Color Options', 'tz-feature-pack' ),
			]
		);

		$this->add_control(
	    'title_color',
			    [
			        'label' => esc_attr__( 'Title Color', 'tz-feature-pack' ),
			        'type' => Controls_Manager::COLOR,
							'default' => '#ffffff',
			        'selectors' => [
			            '{{WRAPPER}} .sale-title-wrapper' => 'color: {{VALUE}}',
			        ],
			    ]
		);

		$this->add_control(
			'title_color_sec',
					[
							'label' => __( 'Secondary Title Color', 'tz-feature-pack' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#fdb819',
							'selectors' => [
									'{{WRAPPER}} .sale-title-wrapper span' => 'color: {{VALUE}}',
							],
					]
		);

		$this->add_control(
			'description_color',
					[
							'label' => __( 'Description Color', 'tz-feature-pack' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
									'{{WRAPPER}} .sale-description' => 'color: {{VALUE}}',
							],
					]
		);

		$this->add_control(
			'product_title_color',
					[
							'label' => __( 'Product Title Color', 'tz-feature-pack' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
									'{{WRAPPER}} .product-link' => 'color: {{VALUE}}',
							],
					]
		);

		$this->add_control(
			'sticker_bg_color',
					[
							'label' => __( 'Sticker Background', 'tz-feature-pack' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#2f548b',
							'selectors' => [
									'{{WRAPPER}} .sticker' => 'background-color: {{VALUE}}',
							],
					]
		);

		$this->add_control(
			'sticker_color',
					[
							'label' => __( 'Sticker Color', 'tz-feature-pack' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#fdb819',
							'selectors' => [
									'{{WRAPPER}} .sale-sticker' => 'color: {{VALUE}}',
							],
					]
		);

    $this->end_controls_section();

	}
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		/* Get all element Parameters */
		$settings = $this->get_settings();
		$output = $carousel_items = '';

    $carousel_data = ' data-owl="container" data-owl-type="content-carousel" data-owl-slides="1" data-owl-custom-nav="' . esc_attr($settings['show_arrows']) . '" data-owl-arrows="no" data-owl-dots="' . esc_attr($settings['show_dots']) . '" data-owl-autoplay="' . esc_attr($settings['autoplay']) . '"';

		if ( $settings['carousel_items'] ) {

			$_pf = new WC_Product_Factory();

			foreach ( $settings['carousel_items'] as $item ) {

				$product = $_pf->get_product( $item['product_id'] );

				if ( ! ( $product ) ) continue;

				$reverse_class = '';

				if ( $item['swap_row'] == 'yes' ) {
					$reverse_class = ' reverse';
				}
        $carousel_items .= '<div class="sale-product'.esc_attr($reverse_class).'"><div class="img-wrapper">';
				/* Sale Sticker */
				if( array_key_exists('add_sticker', $item ) && $item['add_sticker'] == 'yes') {
					$sticker_style = ' style="';
					if ( array_key_exists('sticker_width', $item ) && $item['sticker_width'] != '' ) {
						$sticker_style .= 'width:'.esc_attr($item['sticker_width']).'px;height:'.esc_attr($item['sticker_width']).'px;background-size:'.esc_attr($item['sticker_width']).'px '.esc_attr($item['sticker_width']).'px;';
					}
					if ( array_key_exists('sticker_position', $item ) && !empty($item['sticker_position']) ) {
						$sticker_style .= 'left:'.esc_attr($item["sticker_position"]["left"].$item["sticker_position"]["unit"]).';top:'.esc_attr($item["sticker_position"]["top"].$item["sticker_position"]["unit"]).';';
					}
					$sticker_style .= '"';
					$carousel_items .= '<div class="sale-sticker"'.$sticker_style.'><div class="stickercrop"><div class="sticker"></div><div class="fold"></div></div>';
					$carousel_items .= '<div class="text">'.$item['sticker_text'].'</div></div>';
				}
        $carousel_items .= '<a href="'.esc_url($product->get_permalink()).'" rel="nofollow">';
        if( array_key_exists('image', $item ) && $item['image']['id']!='') {
					$image_element = wp_get_attachment_image( $item['image']['id'], 'large');
				} else {
          $image_element = $product->get_image( 'large' );
        }
        $carousel_items .= $image_element;
        $carousel_items .= '</a></div>';
        $carousel_items .= '<div class="sale-product-wrapper">';
        if(array_key_exists('heading_text', $item )){
          $carousel_items .= '<h6 class="sale-title-wrapper">'.apply_filters('tz-feature-pack-shortcode-title', $item['heading_text']).'</h6>';
        }
        $carousel_items .= '<a class="product-link" href="'.esc_url($product->get_permalink()).'" rel="nofollow">'.get_the_title( $item['product_id'] ).'</a>';
        if(array_key_exists('pre_countdown_text', $item ) && $item['pre_countdown_text']!=''){
          $carousel_items .= '<p class="sale-description">'.$item['pre_countdown_text'].'</p>';
        }
        /* Countdown clock */
        $sales_price_to = get_post_meta( $item['product_id'], '_sale_price_dates_to', true );
        if( $sales_price_to != "") {
          $sales_price_date_to = date_i18n( 'Y-m-d', $sales_price_to);
					$countdown_style = '';
					if( array_key_exists('alt_countdown_style', $item ) && $item['alt_countdown_style'] == 'yes') {
						$countdown_style = ' style-2';
					}
          $carousel_items .= '<div class="countdown-wrapper'.esc_attr($countdown_style).'" data-countdown="container" data-countdown-target="' . esc_attr($sales_price_date_to) . '"></div>';
        }
				if( array_key_exists('catalog_mode', $item ) && $item['catalog_mode'] == 'yes') {
					$carousel_items .= '<a href="'.esc_url($product->get_permalink()).'" rel="nofollow" class="button">'.$item['button_text'].'</a>';
				} else {
					$carousel_items .= '<div class="price-wrapper">'.do_shortcode('[add_to_cart id="'.$item['product_id'].'"]').'</div>';
				}
        $carousel_items .= '</div></div>';
        unset($item);
      }
    }

    $output .= '<div class="tz-sales-carousel">';
    if ( $settings['widget_title'] && $settings['widget_title']!='') {
      $output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3></div>';
    }
		$output .= '<span class="carousel-loader"></span>';
    $output .= '<div class="wrapper"'.$carousel_data.'>';
    if ( $carousel_items && $carousel_items !='') {
			if ( 'yes' == $settings['show_arrows'] ) { $output .= '<span class="slider-prev"></span><span class="slider-next"></span>'; }
      $output .= '<div class="carousel-container">';
      $output .= $carousel_items;
      $output .= '</div>';
    } else {
      $output .= esc_html__('Add sale products first', 'tz-feature-pack');
    }
    $output .= '</div></div>';

		echo $output;
	}
	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 */
	protected function _content_template() {
	}
}
