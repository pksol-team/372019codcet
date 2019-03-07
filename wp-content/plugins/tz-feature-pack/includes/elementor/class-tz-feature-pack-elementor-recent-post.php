<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TZ_From_Blog extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 */
	public function get_name() {
		return 'tz-from-blog';
	}
	/**
	 * Retrieve the widget title.
	 */
	public function get_title() {
		return esc_html__( 'TZ Posts from Blog', 'tz-feature-pack' );
	}
	/**
	 * Retrieve the widget icon.
	 */
	public function get_icon() {
		return 'fa fa-archive';
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
			'widget_style',
			[
				 'label' => esc_html__( 'Choose style for widget', 'tz-feature-pack' ),
				 'type' => Controls_Manager::SELECT,
				 'default' => 'style-2',
				 'options' => [
					 'style-1' => esc_html__( 'Style 1', 'tz-feature-pack' ),
					 'style-2' => esc_html__( 'Style 2', 'tz-feature-pack' ),
					],
			]
		);
		$this->add_control(
			'img_position',
			[
				 'label' => esc_html__( 'Choose thumbnail Position', 'tz-feature-pack' ),
				 'type' => Controls_Manager::SELECT,
				 'default' => 'left',
				 'options' => [
					 'left' => esc_html__( 'Left', 'tz-feature-pack' ),
					 'right' => esc_html__( 'Right', 'tz-feature-pack' ),
					 'top' => esc_html__( 'Top', 'tz-feature-pack' ),
					],
			]
		);
		$this->add_control(
			'additional_meta',
			[
				'label' => esc_html__( 'Show additional post meta (number of comments, likes, shares) on hover?', 'tz-feature-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Yes', 'tz-feature-pack' ),
				'label_off' => esc_html__( 'No', 'tz-feature-pack' ),
				'return_value' => 'yes',
			]
		);
    $this->add_control(
		  'per_row',
		  [
		     'label' => esc_html__( 'Posts per row', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => '2',
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
      'post_qty',
      [
         'label'   => esc_html__( 'Total number of Posts to show', 'tz-feature-pack' ),
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
		  'orderby_param',
		  [
		     'label' => esc_html__( 'Order By Parameter', 'tz-feature-pack' ),
		     'type' => Controls_Manager::SELECT,
		     'default' => 'date',
		     'options' => [
           'date' => esc_html__( 'Date', 'tz-feature-pack'),
           'rand' => esc_html__( 'Random', 'tz-feature-pack'),
           'author' => esc_html__( 'Author', 'tz-feature-pack'),
           'comment_count' => esc_html__( 'Comments Quantity', 'tz-feature-pack'),
		     ],
		  ]
		);
    $this->add_control(
      'cat_slug',
      [
         'label'       => esc_html__( 'Posts by Categorie SLUG', 'tz-feature-pack' ),
         'type'        => Controls_Manager::TEXT,
         'default'     => '',
         'placeholder' => 'slug',
         'description' => esc_html__( 'Comma separated list of category slugs which posts you want to output.', 'tz-feature-pack' ),
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
	}
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		// Get all element Parameters
		$settings = $this->get_settings();
		$output = $carousel_items = '';
    // Carousel Data
    if ( 'yes' == $settings['use_slider'] ) {
      $carousel_data = ' data-owl="container" data-owl-type="content-carousel" data-owl-custom-nav="' . esc_attr($settings['show_arrows']) . '" data-owl-arrows="no" data-owl-dots="' . esc_attr($settings['show_dots']) . '" data-owl-autoplay="' . esc_attr($settings['autoplay']) . '" data-owl-slides="' . esc_attr($settings['per_row']) . '" data-owl-margin="' . esc_attr($settings['slide_gap']) . '"';
    }
		// Extra Class for Styles
		$extra_style_class = '';
		if ( 'style-2' == $settings['widget_style'] ) {
			$extra_style_class .= ' style-2';
		}
		if ( 'top' == $settings['img_position'] ) {
			$extra_style_class .= ' img-top';
		}
		if ( 'right' == $settings['img_position'] ) {
			$extra_style_class .= ' img-right';
		}
    // Excerpt filters
    if (!function_exists('tz_post_excerpt')) {
      function tz_post_excerpt($limit, $source = null){
          if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
          $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
          $excerpt = strip_shortcodes($excerpt);
          $excerpt = strip_tags($excerpt);
          $excerpt = substr($excerpt, 0, $limit);
          $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
          $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
          $excerpt = $excerpt.' [...]';
          return $excerpt;
      }
    }
    // Args for new Post Query
    $args = array(
      'orderby' => $settings['orderby_param'],
      'order' => $settings['order_param'],
      'post_type' => 'post',
      'post_status' => 'publish',
      'ignore_sticky_posts' => 1,
      'posts_per_page' => $settings['post_qty'],
    );
    if ( $settings['cat_slug'] && $settings['cat_slug']!='' ) {
      $args['category_name'] = $settings['cat_slug'];
    }
    // The Query
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) {
      $carousel_items .= '<div class="carousel-container columns-'.esc_attr($settings['per_row']).'">';
      while( $the_query->have_posts() ) : $the_query->the_post();

        $carousel_items .= '<div class="item">';
        if ( has_post_thumbnail() ) {
          $carousel_items .= '<div class="thumb-wrapper">';
					/* Get image size according to img position */
					$thumb_size = 'chromium-recent-posts-thumb-m';
					if ( 'top' == $settings['img_position'] ) {
						$thumb_size = 'chromium-recent-posts-thumb-top';
					}
          $carousel_items .= get_the_post_thumbnail(get_the_ID(), apply_filters('tz-feature-pack-fromblog-thumbnail-size', $thumb_size));
					/* Additional Post Data */
					if ( 'yes' == $settings['additional_meta'] ) {
						$carousel_items .= '<div class="addtional-meta-counters">';
						if ( function_exists('chromium_entry_comments_counter') ) { $carousel_items .= chromium_entry_comments_counter( get_the_ID() ); }
						if ( function_exists('tz_entry_likes_counter') ) { $carousel_items .= tz_entry_likes_counter( get_the_ID() ); }
						if ( function_exists('tz_shares_counter') ) { $carousel_items .=  tz_shares_counter(); }
						$carousel_items .= '</div>';
					}
					$carousel_items .= '</div>';
        }
				/* Get post categories */
				$post_categories = '';
				$i = 0;
				foreach((get_the_category()) as $cat) {
					$post_categories .= '<a class="post-cat-link" href="'.esc_url(get_category_link($cat->cat_ID)).'" rel="nofollow">' . esc_attr($cat->cat_name) . '</a>';
					if ( ++$i == apply_filters('tz-feature-pack-limit-cat-qty', 1) ) break;
				}

        $carousel_items .= '<div class="item-content">';
				if ( 'style-2' == $settings['widget_style'] ) {
					$carousel_items .= '<div class="time-wrapper">' . get_the_date() . '</div>';
					if ( $post_categories !== '') { $carousel_items .= $post_categories; }
				} else {
					if ( $post_categories !== '') { $carousel_items .= $post_categories; }
				}
        $title = get_the_title(get_the_ID());
        if ( empty($title) || $title == '' ) {
          $carousel_items .= '<h6><a href="' . esc_url( get_permalink(get_the_ID()) ) . '" rel="bookmark">' . esc_html__( 'Click here to read more', 'tz-feature-pack' ) . '</a></h6>';
        } else {
          $carousel_items .= '<h6><a href="' . esc_url( get_permalink(get_the_ID()) ) . '" rel="bookmark">' . esc_attr($title) . '</a></h6>';
        }
				if ( 'style-2' != $settings['widget_style'] ) {
        	$carousel_items .= '<div class="time-wrapper">' . get_the_date() . '</div>';
				}
        $carousel_items .= '<p class="entry-excerpt">' . tz_post_excerpt( apply_filters('tz-feature-pack-excerpt-limit', 70) ) . '</p>';
        $carousel_items .= '<div class="entry-meta">';
				$carousel_items .= '<a class="link-to-post button" rel="bookmark" href="'.esc_url(get_permalink(get_the_ID())).'">' . esc_html__( 'Read more', 'tz-feature-pack') . '</a>';
				if ( function_exists( 'tz_feature_pack_entry_post_views' ) ) {
					$carousel_items .= tz_feature_pack_entry_post_views(get_the_ID());
				}
        $carousel_items .= '</div>';
        $carousel_items .= '</div>';
        $carousel_items .= '</div>';

      endwhile;

      wp_reset_postdata();
      $carousel_items .= '</div>';
    }

    $output .= '<div class="tz-from-blog'.esc_attr($extra_style_class).'"' . $carousel_data . '>';
    if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.apply_filters('tz-feature-pack-shortcode-title', $settings['widget_title']).'</h3>'; }
    if ( 'yes' == $settings['use_slider'] && 'yes' == $settings['show_arrows'] ) { $output .= '<div class="slider-navi"><span class="slider-prev"></span><span class="slider-next"></span></div>'; }
    if ( $settings['widget_title'] && $settings['widget_title']!='' ) { $output .= '</div>'; }
    if ( 'yes' == $settings['use_slider'] ) { $output .= '<span class="carousel-loader"></span>'; }
    $output .= $carousel_items;
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
