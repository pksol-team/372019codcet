<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Hoverable_Tabs extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-hoverable-tabs';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Hoverable Tabs', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-h-square';
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
		  'price',
		  [
		     'label'   => esc_html__( 'Tab Content Width (px)', 'tz-feature-pack' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 900,
		     'min'     => 300,
		     'max'     => 1800,
		     'step'    => 1,
				 'label_block' => true,
				 'selectors' => [
						 '{{WRAPPER}} .inner-content' => 'width: {{VALUE}}px',
				 ],
		  ]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Tab Content', 'tz-feature-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title' => esc_html__( 'Tab Title', 'tz-feature-pack' ),
						'tab_content' => '',
					],
				],
				'fields' => [
					[
						'name' => 'tab_title',
						'label' => esc_html__( 'Tab Title', 'tz-feature-pack' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
					],
					[
						'name' => 'tab_content',
					  'label'   => esc_html__( 'Shortcode', 'tz-feature-pack' ),
					  'type'    => Controls_Manager::TEXTAREA,
					],
				],
				'title_field' => '{{{ tab_title }}}',
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
		$output = $tabs_nav_output = $tabs_content_output = '';

    $css_class = 'tz-hoverable-tabs';

		if ( $settings['tabs'] ) {

      foreach ( $settings['tabs'] as $tab ) {

				/* Get nav arg for proper tabs opening */
				$nav_arg = strtolower($tab['tab_title']);
				$nav_arg = preg_replace('/\s+/', ' ', $nav_arg);
				$nav_arg = str_replace(' ', '-', $nav_arg);

				/* Tabs nav links */
				$tabs_nav_output .= '<li>';
				$tabs_nav_output .= esc_attr($tab['tab_title']);
				/* Tabs content */
				$tabs_nav_output .= '<div class="inner-content">';
				$tabs_nav_output .= do_shortcode( $tab['tab_content'] );
				$tabs_nav_output .= '</div>';
				$tabs_nav_output .= '<i class="icon"></i></li>';

        unset($tab);
      }

			$output .= '<div class="'. esc_attr($css_class) .'">';
			if ( $settings['widget_title'] && $settings['widget_title']!='') {
			$output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3></div>';
			}
			$output .= '<ul class="nav">';
			$output .= $tabs_nav_output;
      $output .= '</ul>';
			$output .= '</div>';

		} else {
			$output .= esc_html__('Nothing to output. Add some tabs first.', 'tz-feature-pack');
		}

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
