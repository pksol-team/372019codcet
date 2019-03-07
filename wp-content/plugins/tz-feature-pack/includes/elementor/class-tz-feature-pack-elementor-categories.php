<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_Categories_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-categories-grid';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Product Categories Grid/Carousel', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-th';
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
			'categories_output',
			[
				 'label' => esc_html__( 'Product Categories Output', 'tz-feature-pack' ),
				 'type' => Controls_Manager::SELECT,
				 'default' => 'grid',
				 'options' => [
					 'grid' => esc_html__( 'Grid', 'tz-feature-pack' ),
					 'carousel' => esc_html__( 'Carousel', 'tz-feature-pack' ),
				 ],
			]
		);
    $this->add_control(
      'columns_number',
      [
         'label' => esc_html__( 'Grid/Carousel Columns quantity', 'tz-feature-pack' ),
         'type' => Controls_Manager::SELECT,
         'default' => '3',
         'options' => [
            '2' => esc_html__( '2 Cols', 'tz-feature-pack' ),
            '3' => esc_html__( '3 Cols', 'tz-feature-pack' ),
            '4' => esc_html__( '4 Cols', 'tz-feature-pack' ),
            '5' => esc_html__( '5 Cols', 'tz-feature-pack' ),
         ],
      ]
    );

    /* Get categories with sub-cats */
    $categories_with_sub_categories = array();
    $args = array(
           'taxonomy'     => 'product_cat',
           'hide_empty'   => apply_filters('tz-show-categories-without-products', 1),
    );
    $all_product_categories = get_categories( $args );
    foreach ($all_product_categories as $cat) {
      if( count( get_term_children( $cat->term_id, 'product_cat' )) > 0 ) {
        $categories_with_sub_categories[$cat->term_id] = $cat->name;
      }
    }
		/* Get default categories for demos */
		$default_grid_categories = array();
		$default_grid_categorie_slugs = array('body-parts','audio-and-electronics','lighting','performance-parts','repair-parts','wheels-and-tires');
		foreach ($default_grid_categorie_slugs as $categorie_slug) {
			$categorie_object = get_category_by_slug($categorie_slug);
			if ( $categorie_object ) {
				$default_grid_categories[$categorie_object->term_id] = $categorie_object->term_name;
			}
		}

    $this->add_control(
      'chosen_cats',
      [
         'label' => __( 'Product Categories', 'tz-feature-pack' ),
         'type' => Controls_Manager::SELECT2,
         'options' => $categories_with_sub_categories,
	     'default' => $default_grid_categories,
         'multiple' => true,
         'label_block' => true,
         'description' => esc_html__( 'Note: make sure that desired categories have sub-categories', 'tz-feature-pack' ),
      ]
    );
    $this->add_control(
      'sub_cat_number',
      [
         'label'   => esc_html__( 'Number of Sub Categories to show', 'tz-feature-pack' ),
         'type'    => Controls_Manager::NUMBER,
         'default' => 4,
         'min'     => 1,
         'max'     => 100,
         'step'    => 1,
      ]
    );
    $this->add_control(
      'button_url',
      [
         'label' => __( 'Button URL', 'tz-feature-pack' ),
         'type' => Controls_Manager::URL,
         'default' => [
            'url' => '',
            'is_external' => '',
         ],
         'show_external' => true, // Show the 'open in new tab' button.
      ]
    );
    $this->add_control(
      'button_label',
      [
         'label'       => esc_html__( 'Button Label', 'tz-feature-pack' ),
         'type'        => Controls_Manager::TEXT,
         'default'     => esc_html__( 'Default label', 'tz-feature-pack' ),
         'placeholder' => esc_html__( 'Type your label here', 'tz-feature-pack' ),
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

		/* Check if carousel output selected */
		$carousel_data = '"';
		if ( 'carousel' == $settings['categories_output'] ) {
			$carousel_data = ' with-slider" data-owl="container" data-owl-type="content-carousel" data-owl-slides="' . esc_attr($settings['columns_number']) . '" data-owl-custom-nav="' . esc_attr($settings['show_arrows']) . '" data-owl-arrows="no" data-owl-dots="' . esc_attr($settings['show_dots']) . '" data-owl-autoplay="' . esc_attr($settings['autoplay']) . '"';
		}

		$output .= '<div class="tz-categories-grid columns-' . esc_attr($settings['columns_number']) . $carousel_data . '>';

		if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3>'; }
		/* Output button if needed */
		if ( is_array($settings['button_url']) && !empty($settings['button_url']) ) {
			$url = $settings['button_url']['url'];
			$target = $settings['button_url']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $settings['button_url']['nofollow'] ? ' rel="nofollow"' : '';
			$label = $settings['button_label'] ? $settings['button_label'] : '';
			if ($label && $label!='') {
				$output .= '<a class="button category-grid-button" href="' . esc_url($url) . '"' . $target . $nofollow .'>' . esc_attr($label) . '</a>';
			}
		}
		/* Carousel navigation */
		if ( 'carousel' == $settings['categories_output'] && 'yes' == $settings['show_arrows'] ) { $output .= '<div class="slider-navi"><span class="slider-prev"></span><span class="slider-next"></span></div>'; }
		if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '</div>'; }

		/* If we have chosen categories output them */
		if ( is_array($settings['chosen_cats']) && !empty($settings['chosen_cats']) ) {
			/* Add carousel wrapper if needed */
			if ( 'carousel' == $settings['categories_output'] ) {
				$output .= '<span class="carousel-loader"></span>';
				$output .= '<div class="carousel-container">';
			}

			foreach ( $settings['chosen_cats'] as $id) {

				$term = get_term_by( 'id', $id, 'product_cat' );

				if ( $term ) {

					$output .= '<div class="item">';
					/* Get image of parent category */
					$thumbnail_id = get_term_meta( $id, 'thumbnail_id', true );
					$image = wp_get_attachment_image( $thumbnail_id, 'thumbnail' );
					if ( $image ) {
						$output .= '<div class="img-wrapper">' . $image . '</div>';
					}
					/* Get name of parent categorie */
					$term = get_term_by( 'id', $id, 'product_cat' );
					$parent_cat_url = get_term_link( $term->slug, $term->taxonomy );
					$output .= '<div class="content-wrapper">';
					$output .= '<span class="cat-title-wrapper">' . esc_html($term->name) . '</span>';
					/* Get subcategories */
					$args = array(
						 'hierarchical' => 1,
						 'show_option_none' => '',
						 'hide_empty' => 0,
						 'parent' => $id,
						 'taxonomy' => 'product_cat'
					);
				  $subcats = get_categories($args);
				  $output .= '<ul class="sub-cats">';
				    foreach ($subcats as $index => $sc) {
				      $link = get_term_link( $sc->slug, $sc->taxonomy );
				      $output .= '<li><a href="' . esc_url($link) . '">' . esc_attr($sc->name) . '</a></li>';
							if( $index == ($settings['sub_cat_number'] - 1) ) {
								$output .= '<li class="show-all"><a href="' . esc_url($parent_cat_url) . '">' . esc_html__('Show All', 'tz-feature-pack') . '<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
								break;
							}
							unset($sc);
				    }

				  $output .= '</ul>';
				  $output .= '</div></div>';
				  unset($id);

				}
			}
			if ( 'carousel' == $settings['categories_output'] ) {
				$output .= '</div>';
			}
		} else {
			$output .= esc_html__('No categories specified', 'tz-feature-pack');
		}
		$output .= '</div>';

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
