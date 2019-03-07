<?php /* Hot Offers Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Woocommerce') ) return false;

class tz_hot_offers extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_hot_offers',
			esc_html__('TZ Hot Offers', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. Displaying sale products carousel with countdowns.", 'tz-feature-pack' ), )
		);
		// Add js to frontend
		add_action('wp_enqueue_scripts', array($this, 'tz_hot_offers_js'));
	}

	function tz_hot_offers_js() {
		wp_enqueue_script( 'tz-hot-offers-countdown', TZ_FEATURE_PACK_URL . '/public/js/countdown.js', array('jquery'), '2.0.2', true);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Hot Offers',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;

		/* Get array of available products */
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => apply_filters('tz_feature_pack_hot_offers_products_qty', '-1'),
			'meta_key' => '_sale_price_dates_to',
			'meta_value' => '"'.time().'"',
			'meta_compare' => '>=',
			'post_status' => 'publish',
		);

    $products = new WP_Query( $args );
    if ( $products->have_posts() ) {

			if ($title) { echo $before_title . esc_attr($title) . $after_title; } ?>

			<div class="hot-offers-wrapper" data-owl="container" data-owl-type="product-carousel" data-owl-slides="1" data-owl-autoplay="<?php echo apply_filters( 'tz-feature-pack-hot-offers-autoplay', 'no'); ?>">
				<div class="slider-navi"><span class="prev"></span><span class="next"></span></div>
				<span class="carousel-loader"></span>
        <ul class="products">

          <?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<li <?php post_class(); ?>>
								<?php
								do_action( 'woocommerce_before_shop_loop_item' );
								do_action( 'woocommerce_before_shop_loop_item_title' );
								/* Countdown clock */
								$sales_price_to = get_post_meta( get_the_ID(), '_sale_price_dates_to', true);
								if( $sales_price_to != "") {
									$sales_price_date_to = date_i18n( 'Y-m-d', $sales_price_to);
									echo '<div class="countdown-wrapper" data-countdown="container" data-countdown-target="' . esc_attr($sales_price_date_to) . '"></div>';
								}
								do_action( 'woocommerce_shop_loop_item_title' );
								do_action( 'woocommerce_after_shop_loop_item_title' );
								do_action( 'woocommerce_after_shop_loop_item' );
								?>
							</li>
          <?php endwhile; // end of the loop. ?>

        </ul>
			</div>

    <?php } else {
			if ($title) { echo $before_title . esc_attr($title) . $after_title; }
			esc_html_e('No sale products with sheduled dates', 'tz-feature-pack');
		};

    wp_reset_postdata();

		echo $after_widget;

	}
}
