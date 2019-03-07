<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-banner';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Promo Banner', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-file-image-o';
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
		  'banner_img',
		  [
		     'label' => esc_html__( 'Banner Image', 'tz-feature-pack' ),
				 'description' => esc_html__( 'Select image for banner background.', 'tz-feature-pack' ),
		     'type' => Controls_Manager::MEDIA,
		     'default' => [
		        'url' => Utils::get_placeholder_image_src(),
		     ],
		  ]
		);
		$this->add_control(
		  'banner_img_size',
		  [
		     'label' => esc_html__( 'Image size', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'full',
		     'options' => [
					 'thumbnail' => 'Thumbnail',
					 'medium' => 'Medium',
					 'large' => 'Large',
					 'full' => 'Full',
		     ],
		  ]
		);
		$this->add_control(
			'main_caption',
			[
					'label' => esc_html__( 'Banner main caption', 'tz-feature-pack' ),
					'type' => Controls_Manager::WYSIWYG,
					'default' => '',
			]
		);
		$this->add_control(
		  'main_caption_pos',
		  [
			    'label' => __( 'Specify top/left offset for banner main caption', 'tz-feature-pack' ),
			    'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => array('top','left'),
					'selectors' => [
					 		'{{WRAPPER}} .main-caption' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
					],
		  ]
		);
		$this->add_control(
			'secondary_caption',
			[
					'label' => esc_html__( 'Banner secondary caption', 'tz-feature-pack' ),
					'type' => Controls_Manager::WYSIWYG,
					'default' => '',
			]
		);
		$this->add_control(
		  'secondary_caption_pos',
		  [
			    'label' => __( 'Specify top/left offset for banner secondary caption', 'tz-feature-pack' ),
			    'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => array('top','left'),
					'selectors' => [
					 		'{{WRAPPER}} .secondary-caption' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
					],
		  ]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'tz-feature-pack' ),
			]
		);
		$this->add_control(
		  'hover_effect',
		  [
		     'label' => esc_html__( 'Choose animation effect for Banner', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'lily',
		     'options' => [
					  'lily' => 'lily',
		 				'sadie' => 'sadie',
		 				'roxy' => 'roxy',
		 				'bubba' => 'bubba',
		 				'romeo' => 'romeo',
		 				'honey' => 'honey',
		 				'oscar' => 'oscar',
		 				'marley' => 'marley',
		 				'ruby' => 'ruby',
		 				'milo' => 'milo',
		 				'dexter' => 'dexter',
		 				'sarah' => 'sarah',
		 				'chico' => 'chico',
		 				'julia' => 'julia',
		 				'goliath' => 'goliath',
		 				'selena' => 'selena',
		 				'kira' => 'kira',
		 				'ming' => 'ming',
		 				'without-hover' => 'without animation',
		     ],
		  ]
		);

		$this->add_control(
		  'banner_link',
		  [
		     'label' => esc_html__( 'Add link to banner', 'tz-feature-pack' ),
		     'type' => Controls_Manager::URL,
		     'default' => [
		        'url' => 'http://',
		        'is_external' => '',
		     ],
		     'show_external' => true,
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
		$output = '';

		$output .= '<figure class="tz-banner effect-'. esc_attr( $settings['hover_effect'] ) .'">';
		if ( $settings['banner_img'] && $settings['banner_img']['id']!='' ) {
			$output .= wp_get_attachment_image( $settings['banner_img']['id'], $settings['banner_img_size'] );
		}
		$output .= '<figcaption>';
		if ( $settings['main_caption'] && $settings['main_caption']!='' ) {
			$output .= '<div class="main-caption">' . $settings['main_caption'] . '</div>';
		}
		if ( $settings['secondary_caption'] && $settings['secondary_caption']!='' ) {
			$output .= '<div class="secondary-caption">' . $settings['secondary_caption'] . '</div>';
		}
		$output .= '</figcaption>';
		if ( $settings['banner_link'] && $settings['banner_link']!='' ) {
			$url = $settings['banner_link']['url'];
			$target = $settings['banner_link']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $settings['banner_link']['nofollow'] ? ' rel="nofollow"' : '';
			$output .=  '<a href="' . esc_url($url) . '"' . $target . $nofollow .'></a>';
		}
		$output .= '</figure>';

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
