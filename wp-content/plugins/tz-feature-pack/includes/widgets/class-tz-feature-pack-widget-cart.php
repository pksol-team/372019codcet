<?php /* Shopping Cart Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Woocommerce') ) return false;

class tz_woo_cart extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_woo_cart',
			esc_html__('TZ Cart for Woocommerce', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. Display the user's Cart in the sidebar.", 'tz-feature-pack' ),
				  'classname' => 'widget_tz_shopping_cart',
			)
		);

		// Add js to frontend
		add_action('wp_enqueue_scripts', array($this, 'tz_add_cart_js'));
		// Add product counter
		add_filter('woocommerce_add_to_cart_fragments', array($this, 'tz_header_add_to_cart_fragment'));
		// Add additional info to mini Cart
		add_action('woocommerce_before_mini_cart', array($this, 'tz_add_additional_heading'));
	}

	function tz_add_cart_js() {
		wp_enqueue_script( 'tz-cart-js-holder',  TZ_FEATURE_PACK_URL . '/public/js/cart-helper.js', array('jquery'), '1.0', true);
		wp_enqueue_script( 'tz-cart-custom-scrollbar',  TZ_FEATURE_PACK_URL . '/public/js/custom-scrollbar.js', array('jquery'), '3.1.5', true);
	}

	function tz_add_additional_heading() {
		echo '<h3 class="mini-cart-heading">';
		echo apply_filters('tz-woo-cart-widget-heading', esc_html__( 'My Shopping Cart', 'tz-feature-pack' ));
		echo '</h3>';
	}

	function tz_header_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
			<span class="cart-count-wrapper"><?php echo $cart_qty = WC()->cart->get_cart_contents_count(); ?></span>
	    <?php
		$fragments['span.cart-count-wrapper'] = ob_get_clean();
		ob_start();
		?>
			<span class="subtotal"><?php echo $cart_subtotal = WC()->cart->get_cart_subtotal(); ?></span>
			<?php
		$fragments['span.subtotal'] = ob_get_clean();
		return $fragments;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => 'Cart',
			'hide_if_empty' => '0',
			'cart_style' => 'style-2',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'tz-feature-pack' ) ?></label>
		<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
		<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('hide_if_empty') ); ?>" name="<?php echo esc_attr( $this->get_field_name('hide_if_empty') ); ?>"<?php checked( $hide_if_empty ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id('hide_if_empty') ); ?>"><?php esc_html_e( 'Hide if cart is empty', 'tz-feature-pack' ); ?></label></p>
		<?php /*<p>
				<label for="<?php echo esc_attr( $this->get_field_id('cart_style') ); ?>"><?php esc_html_e('Cart Widget frontend style:','tz-feature-pack'); ?>
						<select class='widefat' id="<?php echo esc_attr($this->get_field_id('cart_style')); ?>" name="<?php echo esc_attr( $this->get_field_name('cart_style') ); ?>">
							<option value='style-1'<?php echo (esc_attr($instance['cart_style']=='style-1'))?' selected="selected"':''; ?>><?php esc_html_e('Style 1', 'tz-feature-pack'); ?></option>
							<option value='style-2'<?php echo (esc_attr($instance['cart_style']=='style-2'))?' selected="selected"':''; ?>><?php esc_html_e('Style 2', 'tz-feature-pack'); ?></option>
						</select>
				</label>
		</p> */ ?>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
		$instance['hide_if_empty'] = empty( $new_instance['hide_if_empty'] ) ? 0 : 1;
		$instance['cart_style'] = strip_tags( stripslashes( $new_instance['cart_style'] ) );
		return $instance;
	}

	public function widget( $args, $instance ) {

		extract( $args );

		if ( apply_filters( 'woocommerce_widget_cart_is_hidden', is_cart() || is_checkout() ) ) {
			return;
		}

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;

		echo $before_widget;

		if ( $hide_if_empty ) {
			echo '<div class="hide_cart_widget_if_empty">';
		}

		echo '<div class="heading">';
		if ($title && $title!='') {
			echo '<div class="widget-heading">' . esc_attr($title);
		}
		echo '<span class="subtotal">' . WC()->cart->get_cart_subtotal() . '</span>';
		if ($title && $title!='') {
			echo '</div>';
		}
		echo '<span class="cart-count-wrapper">' . WC()->cart->get_cart_contents_count() . '</span>';
		echo '</div>';

		// Insert cart widget placeholder - code in woocommerce.js will update this on page load
		echo '<div class="widget_shopping_cart_content"></div>';

		if ( $hide_if_empty ) {
			echo '</div>';
		}

		echo $after_widget;
	}

}
