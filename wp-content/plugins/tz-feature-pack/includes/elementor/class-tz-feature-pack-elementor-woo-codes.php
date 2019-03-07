<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Woo_Codes extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-woo-codes';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Woocommerce Shortcode', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-shopping-cart';
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
		  'codeswoo',
		  [
		     'label' => esc_html__( 'Choose Woocommerce Shortcode', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'recent_products',
		     'options' => [
           'recent_products' => esc_html__( 'Recent Products', 'tz-feature-pack' ),
           'featured_products' => esc_html__( 'Featured Products', 'tz-feature-pack' ),
           'product_category' => esc_html__( 'Products by category', 'tz-feature-pack' ),
           'sale_products' => esc_html__( 'Sale Products', 'tz-feature-pack' ),
           'best_selling_products' => esc_html__( 'Best Selling Products', 'tz-feature-pack' ),
           'top_rated_products' => esc_html__( 'Top Rated Products', 'tz-feature-pack' ),
		     ],
		  ]
		);
    $this->add_control(
      'cat_slug',
      [
         'label'       => esc_html__( 'Categorie SLUG', 'tz-feature-pack' ),
         'type'        => Controls_Manager::TEXT,
         'default'     => '',
         'placeholder' => 'slug',
         'description' => esc_html__( 'Comma separated list of category slugs which products you want to output. For shortcode "Products by category".', 'tz-feature-pack' ),
      ]
    );
    $this->add_control(
      'items_number',
      [
         'label'   => esc_html__( 'Number of Products to show', 'tz-feature-pack' ),
         'type'    => Controls_Manager::NUMBER,
         'default' => 4,
         'min'     => 1,
         'max'     => 100,
         'step'    => 1,
      ]
    );
    $this->add_control(
		  'order_param',
		  [
		     'label' => esc_html__( 'Order Parameter', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'ASC',
		     'options' => [
           'ASC' => esc_html__( 'Ascending', 'tz-feature-pack' ),
           'DESC' => esc_html__( 'Descending', 'tz-feature-pack' ),
		     ],
		  ]
		);
    $this->add_control(
		  'order_by_param',
		  [
		     'label' => esc_html__( 'Order By Parameter', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'date',
		     'options' => [
           'date' => esc_html__( 'Date', 'tz-feature-pack'),
           'id' => esc_html__( 'ID', 'tz-feature-pack'),
           'menu_order' => esc_html__( 'The Menu Order, if set (lower numbers display first).', 'tz-feature-pack'),
           'title' => esc_html__( 'Title', 'tz-feature-pack'),
           'popularity' => esc_html__( 'The number of purchases', 'tz-feature-pack'),
           'rating' => esc_html__( 'The average product rating.', 'tz-feature-pack'),
           'rand' => esc_html__( 'Random', 'tz-feature-pack'),
		     ],
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
    	'use_slider',
    	[
    		'label' => esc_html__( 'Use Owl Carousel?', 'tz-feature-pack' ),
    		'type' => Controls_Manager::SWITCHER,
    		'default' => '',
    		'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
    		'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
    		'return_value' => 'yes',
    	]
    );
		$this->add_control(
		  'columns_number',
		  [
		     'label' => esc_html__( 'Columns quantity', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => '3',
		     'options' => [
					  '2' => esc_html__( '2 Cols', 'tz-feature-pack' ),
		 				'3' => esc_html__( '3 Cols', 'tz-feature-pack' ),
		 				'4' => esc_html__( '4 Cols', 'tz-feature-pack' ),
		 				'5' => esc_html__( '5 Cols', 'tz-feature-pack' ),
		 				'6' => esc_html__( '6 Cols', 'tz-feature-pack' ),
		     ],
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

    $carousel_data = '"';
		if ( 'yes' == $settings['use_slider'] ) {
      $carousel_data = ' with-slider" data-owl="container" data-owl-type="product-carousel" data-owl-slides="' . esc_attr($settings['columns_number']) . '" data-owl-autoplay="' . esc_attr($settings['autoplay']) . '" data-owl-margin="' . esc_attr($settings['slide_gap']) . '"';
		}

		$output .= '<div class="tz-woo-shortcode' . $carousel_data . '>';
    if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3>'; }
    if ( 'yes' == $settings['use_slider'] ) { $output .= '<div class="slider-navi"><span class="prev"></span><span class="next"></span></div>'; }
    if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '</div>'; }
    if ( 'yes' == $settings['use_slider'] ) { $output .= '<span class="carousel-loader"></span>'; }

    $on_sale_var = 'false';
    $best_selling_var = 'false';
    $top_rated_var = 'false';
    $visibility_var = 'visible';
    switch ($settings['codeswoo']) {
      case 'recent_products':
        $order_param_by = 'id';
      break;
      case 'featured_products':
        $visibility_var = 'featured';
      break;
      case 'sale_products':
        $on_sale_var = 'true';
      break;
      case 'best_selling_products':
        $best_selling_var = 'true';
      break;
      case 'top_rated_products':
        $top_rated_var = 'true';
      break;
    }
    $shortcode = '[products limit="'.esc_attr($settings['items_number']).'" columns="'.esc_attr($settings['columns_number']).'" orderby="'.esc_attr($settings['order_by_param']).'" order="'.esc_attr($settings['order_param']).'"';
    $shortcode .= ' visibility="'.esc_attr($visibility_var).'" on_sale="'.esc_attr($on_sale_var).'" best_selling="'.esc_attr($best_selling_var).'" top_rated="'.esc_attr($top_rated_var).'"';
		if ($settings['codeswoo']=='product_category') {
			$shortcode .= ' category="'.esc_attr($settings['cat_slug']).'"';
		}
		$shortcode .= ']';

		$output .= do_shortcode($shortcode);

		$output .= "</div>";

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
