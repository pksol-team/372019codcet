<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Testimonials extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-testimonials';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Testimonials', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-commenting';
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
				'testimonials_style',
				[
					 'label' => esc_html__( 'Testimonials Style', 'tz-feature-pack' ),
					 'type' => Controls_Manager::SELECT,
					 'default' => 'style-1',
					 'options' => [
						 'style-1' => esc_html__( 'Style 1', 'tz-feature-pack' ),
						 'style-2' => esc_html__( 'Style 2', 'tz-feature-pack' ),
					 ],
				]
			);
			$this->add_control(
				'per_row',
				[
					 'label' => esc_html__( 'Testimonials Per Row', 'tz-feature-pack' ),
					 'type' => Controls_Manager::SELECT,
					 'default' => '2',
					 'options' => [
						 '1' => esc_html__( 'One per Row', 'tz-feature-pack' ),
						 '2' => esc_html__( 'Two per Row', 'tz-feature-pack' ),
						 '3' => esc_html__( 'Three per Row', 'tz-feature-pack' ),
					 ],
				]
			);
			$this->add_control(
				'testimonials_items',
				[
					'label' => esc_html__( 'Testimonials Items', 'tz-feature-pack' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'name' => '',
							'occupation' => '',
							'content_text' => '',
						],
					],
					'fields' => [
						[
							'name' => 'image',
					    'label' => esc_html__( 'Testimonial Image', 'tz-feature-pack' ),
					    'type' => Controls_Manager::MEDIA,
					    'default' => [
					       'url' => Utils::get_placeholder_image_src(),
					    ],
					  ],
						[
							'name' => 'name',
							'label' => esc_html__( 'Name', 'tz-feature-pack' ),
							'type' => Controls_Manager::TEXT,
							'default' => 'John Doe',
						],
						[
							'name' => 'occupation',
							'label' => esc_html__( 'Occupation', 'tz-feature-pack' ),
							'type' => Controls_Manager::TEXT,
							'default' => 'Occupation',
						],
						[
							'name' => 'content_text',
					    'label'   => esc_html__( 'Testimonial Text', 'tz-feature-pack' ),
					    'type'    => Controls_Manager::TEXTAREA,
					    'default' => __( 'Default text', 'tz-feature-pack' ),
					  ],
						[
							'name' => 'rating_value',
							'label' => esc_html__( 'Add star rating to testimonial', 'tz-feature-pack' ),
							 'type' => Controls_Manager::SELECT,
							 'default' => '5',
								'options' => [
									'5' => esc_html__( '5 Stars', 'tz-feature-pack' ),
									'4' => esc_html__( '4 Stars', 'tz-feature-pack' ),
									'3' => esc_html__( '3 Stars', 'tz-feature-pack' ),
									'2' => esc_html__( '2 Stars', 'tz-feature-pack' ),
									'1' => esc_html__( '1 Star', 'tz-feature-pack' ),
								],
						],
					],
					'title_field' => '{{{ name }}}',
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
			$this->add_control(
				'slide_gap',
				[
					 'label'   => esc_html__( 'Specify gap between slides', 'tz-feature-pack' ),
					 'type'    => Controls_Manager::NUMBER,
					 'default' => 30,
					 'min'     => 0,
					 'max'     => 100,
					 'step'    => 1,
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
								'label' => esc_html__( 'Title Color', 'tz-feature-pack' ),
								'type' => Controls_Manager::COLOR,
								'default' => '#ffffff',
								'selectors' => [
										'{{WRAPPER}} .shortcode-title' => 'color: {{VALUE}}',
								],
						]
			);

			$this->add_control(
				'description_color',
						[
								'label' => esc_html__( 'Text Color', 'tz-feature-pack' ),
								'type' => Controls_Manager::COLOR,
								'default' => '#ffffff',
								'selectors' => [
										'{{WRAPPER}} .text-wrapper' => 'color: {{VALUE}}',
								],
						]
			);

			$this->add_control(
				'product_title_color',
						[
								'label' => esc_html__( 'Stars Color', 'tz-feature-pack' ),
								'type' => Controls_Manager::COLOR,
								'default' => '#ffa800',
								'selectors' => [
										'{{WRAPPER}} .star-rating span:before' => 'color: {{VALUE}}',
								],
						]
			);

			$this->add_control(
				'sticker_bg_color',
						[
								'label' => esc_html__( 'Testimonial Heading Color', 'tz-feature-pack' ),
								'type' => Controls_Manager::COLOR,
								'default' => '#fff',
								'selectors' => [
										'{{WRAPPER}} .sticker' => 'background-color: {{VALUE}}',
								],
						]
			);

			$this->add_control(
				'item_bg_color',
				[
						'label' => esc_html__( 'Background Color for each Testimonial', 'tz-feature-pack' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
								'{{WRAPPER}} .item-wrapper' => 'background-color: {{VALUE}}',
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
			$output = $carousel_content = '';

			if ( $settings['testimonials_items'] ) {
				foreach ( $settings['testimonials_items'] as $item ) {
					$carousel_content .= '<div class="item-wrapper">';
					/* Image */
					if(array_key_exists('image', $item )){
						$image_element = wp_get_attachment_image( $item['image']['id'], 'thumbnail');
						$carousel_content .= '<div class="img-wrapper">'.$image_element.'</div>';
					}
					/* Heading */
					$testimonial_header = '<div class="about-author">';
					if(array_key_exists('name', $item )){
						$testimonial_header .='<cite>'.$item['name'].'</cite>';
					}
					if(array_key_exists('occupation', $item )){
						$testimonial_header .= '<br /><span><small>'.$item['occupation'].'</small></span>';
					}
					$testimonial_header .= '</div>';
					if(array_key_exists('product_id', $item ) && $item['product_id']!='' && class_exists('Woocommerce')){
						$testimonial_header .= '<small>'.esc_html__(' on ', 'tz-feature-pack').'</small><a href="'.get_permalink($item['product_id']).'">'.get_the_title($item['product_id']).'</a>';
					}
					if ( 'style-2' == $settings['testimonials_style'] ) {
						$carousel_content .= $testimonial_header;
					}
					/* Stars */
					$width = absint($item['rating_value']*2);
					$carousel_content .= '<div class="star-rating"><span style="width:'.esc_attr($width).'0%"></span></div>';
					/* Content */
					$carousel_content .= '<div class="text-wrapper">';
					if(array_key_exists('content_text', $item )){
						$carousel_content .= '<p>'.$item['content_text'].'</p>';
					}
					if ( 'style-1' == $settings['testimonials_style'] ) {
						$carousel_content .= $testimonial_header;
					}
					$carousel_content .= '</div>';

					$carousel_content .= '</div>';
				}
			}

			$carousel_data = ' data-owl="container" data-owl-type="content-carousel" data-owl-slides="'.esc_attr($settings['per_row']).'" data-owl-custom-nav="' . esc_attr($settings['show_arrows']) . '" data-owl-arrows="no" data-owl-dots="' . esc_attr($settings['show_dots']) . '" data-owl-autoplay="' . esc_attr($settings['autoplay']) . '" data-owl-margin="' . esc_attr($settings['slide_gap']) . '"';

			$output .= '<div class="tz-testimonials '.esc_attr($settings['testimonials_style']).'">';
			if ( $settings['widget_title'] && $settings['widget_title']!='') {
				$output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3></div>';
			}
			$output .= '<span class="carousel-loader"></span>';
			$output .= '<div class="wrapper"'.$carousel_data.'>';
			if ( $carousel_content && $carousel_content!='') {
				if ( 'yes' == $settings['show_arrows'] ) { $output .= '<span class="slider-prev"></span><span class="slider-next"></span>'; }
				$output .= "<div class='carousel-container'>";
				$output .= $carousel_content;
				$output .= "</div>";
			} else {
	      $output .= esc_html__('Add some testimonials first', 'tz-feature-pack');
	    }
			$output .= "</div></div>";

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
