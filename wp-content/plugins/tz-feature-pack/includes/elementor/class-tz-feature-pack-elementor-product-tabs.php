<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Product_Tabs extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-product-tabs';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Product Tabs', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-window-restore';
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
			'tabs_style',
			[
				'label' => esc_html__( 'Tabs Style', 'tz-feature-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-2',
				'options' => [
						'style-1' => esc_html__( 'Style 1', 'tz-feature-pack' ),
						'style-2' => esc_html__( 'Style 2', 'tz-feature-pack' ),
				 ],
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
			'product_shortcodes',
			[
				'label' => esc_html__( 'Product Shortcodes', 'tz-feature-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title' => __( 'Tab Title', 'tz-feature-pack' ),
						'codeswoo' => 'recent_products',
						'cat_slug' => '',
					],
				],
				'fields' => [
					[
						'name' => 'tab_title',
						'label' => __( 'Tab Title', 'tz-feature-pack' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( 'Tab Title' , 'tz-feature-pack' ),
						'label_block' => true,
					],
					[
						'name' => 'shortcode',
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
					],
					[
						'name' => 'cat_slug',
						'label'       => esc_html__( 'Categorie SLUG', 'tz-feature-pack' ),
	          'type'        => Controls_Manager::TEXT,
	          'default'     => '',
	          'placeholder' => 'slug',
	          'description' => esc_html__( 'Comma separated list of category slugs which products you want to output. For shortcode "Products by category".', 'tz-feature-pack' ),
					],
					[
						'name' => 'items_number',
						'label'   => esc_html__( 'Number of Products to show', 'tz-feature-pack' ),
	          'type'    => Controls_Manager::NUMBER,
	          'default' => 4,
	          'min'     => 1,
	          'max'     => 100,
	          'step'    => 1,
					],
					[
						'name' => '2rows',
						'label' => esc_html__( 'Number of rows', 'tz-feature-pack' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'TWO', 'your-plugin' ),
						'label_off' => esc_html__( 'ONE', 'your-plugin' ),
						'return_value' => 'yes',
						'default' => 'yes',
					],
					[
						'name' => 'order_param',
						'label' => esc_html__( 'Order Parameter', 'tz-feature-pack' ),
		 		     'type' => Controls_Manager::SELECT,
		 		     'default' => 'ASC',
		 		     'options' => [
		            'ASC' => esc_html__( 'Ascending', 'tz-feature-pack' ),
		            'DESC' => esc_html__( 'Descending', 'tz-feature-pack' ),
		 		     ],
					],
					[
						'name' => 'order_by_param',
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

    $css_class = 'tz-product-tabs';

		if ( 'style-2' === $settings['tabs_style'] ) {
			$css_class .= ' style-2';
		}

		if ( $settings['product_shortcodes'] ) {

      foreach ( $settings['product_shortcodes'] as $product_shortcode ) {

				/* Get nav arg for proper tabs opening */
				$nav_arg = strtolower($product_shortcode['tab_title']);
				$nav_arg = preg_replace('/\s+/', ' ', $nav_arg);
				$nav_arg = str_replace(' ', '-', $nav_arg);
				/* Check if two row output */
				$owl_row_data = '';
				if ( 'yes' === $product_shortcode['2rows'] ) {
					$owl_row_data = ' data-owl-2rows=yes';
				}
				/* Get and parse woo shortcode */
				$on_sale_var = 'false';
		    $best_selling_var = 'false';
		    $top_rated_var = 'false';
		    $visibility_var = 'visible';
				$order_param_by = $product_shortcode['order_by_param'];
		    switch ($product_shortcode['shortcode']) {
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
		    $shortcode = '[products limit="'.esc_attr($product_shortcode['items_number']).'" columns="'.esc_attr($settings['columns_number']).'" orderby="'.esc_attr($product_shortcode['order_by_param']).'" order="'.esc_attr($product_shortcode['order_param']).'"';
		    $shortcode .= ' visibility="'.esc_attr($visibility_var).'" on_sale="'.esc_attr($on_sale_var).'" best_selling="'.esc_attr($best_selling_var).'" top_rated="'.esc_attr($top_rated_var).'"';
				if ($product_shortcode['shortcode']=='product_category') {
					$shortcode .= ' category="'.esc_attr($product_shortcode['cat_slug']).'"';
				}
				$shortcode .= ']';

				$shortcode = do_shortcode($shortcode);

        if ( $product_shortcode === reset($settings['product_shortcodes']) ) {
					/* Tabs nav links */
          $tabs_nav_output .= '<li role="presentation" class="active"><a href="#section-'.esc_attr($nav_arg).'" data-toggle="tab" rel="tab" title="'.esc_attr($product_shortcode['tab_title']).'">';
					$tabs_nav_output .= esc_attr($product_shortcode['tab_title']);
					$tabs_nav_output .= '</a></li>';
					/* Tabs content */
					$tabs_content_output .= '<div role="tabpanel" class="tab-pane fade in active row" id="section-'.esc_attr($nav_arg).'" data-owl="container" data-owl-margin="' . esc_attr($settings['slide_gap']) . '" data-owl-slides="' . esc_attr($settings['columns_number']) . '"'.esc_html($owl_row_data).'>';
					$tabs_content_output .= '<span class="carousel-loader"></span>';
					$tabs_content_output .= '<div class="slider-navi"><span class="prev"></span><span class="next"></span></div>';
					$tabs_content_output .= $shortcode;
					$tabs_content_output .= '</div>';
				} else {
					/* Tabs nav links */
          $tabs_nav_output .= '<li role="presentation"><a href="#section-'.esc_attr($nav_arg).'" data-toggle="tab" rel="tab" title="'.esc_attr($product_shortcode['tab_title']).'">';
					$tabs_nav_output .= esc_attr($product_shortcode['tab_title']);
					$tabs_nav_output .= '</a></li>';
					/* Tabs content */
					$tabs_content_output .= '<div role="tabpanel" class="tab-pane fade row" id="section-'.esc_attr($nav_arg).'" data-owl="container" data-owl-margin="' . esc_attr($settings['slide_gap']) . '" data-owl-slides="' . esc_attr($settings['columns_number']) . '"'.esc_html($owl_row_data).'>';
					$tabs_content_output .= '<span class="carousel-loader"></span>';
					$tabs_content_output .= '<div class="slider-navi"><span class="prev"></span><span class="next"></span></div>';
					$tabs_content_output .= $shortcode;
					$tabs_content_output .= '</div>';
        }
        unset($product_shortcode);
      }


			$output .= '<div class="'. esc_attr($css_class) .'">';
			if ( $settings['tabs_style'] == 'style-2') { $output .= '<div class="tab-nav-wrapper">'; }
			if ( $settings['widget_title'] && $settings['widget_title']!='') {
			$output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3></div>';
			}
			$output .= '<ul class="nav nav-tabs" role="tablist">';
			$output .= $tabs_nav_output;
      $output .= '</ul>';
			if ( $settings['tabs_style'] == 'style-2') { $output .= '</div>'; }
			$output .= '<div class="tab-content">';
			$output .= $tabs_content_output;
			$output .= '</div></div>';

		} else {
			$output .= esc_html__('Nothing to output. Specify woo shortcodes first.', 'tz-feature-pack');
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
