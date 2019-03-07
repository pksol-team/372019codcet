<?php /* Payment Icons Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_pay_icons extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_pay_icons',
			esc_html__('TZ Payment Icons', 'tz-feature-pack'),
			array( 'description' => esc_html__( 'Themes Zone special widget. Add payment methods icons', 'tz-feature-pack' ), ),
			array( 'width' => 600, )
		);
	}

	// Get Payment Icons
	protected function get_payment_icons() {
		return array(
			'american_express' => array(
				'active' => '',
				'image' => 'americanexpress-icon.png',
				'label' => '',
				'title' => 'American Express'
			),
			'bank_transfer' => array(
				'active' => '',
				'image' => 'banktransfer-icon.png',
				'label' => '',
				'title' => 'Bank Transfer'
			),
			'bitcoin' => array(
				'active' => '',
				'image' => 'bitcoin-icon.png',
				'label' => '',
				'title' => 'Bitcoin'
			),
			'cirrus' => array(
				'active' => '',
				'image' => 'cirrus-icon.png',
				'label' => '',
				'title' => 'Cirrus'
			),
			'ebay' => array(
				'active' => '',
				'image' => 'ebay-icon.png',
				'label' => '',
				'title' => 'Ebay'
			),
			'maestro' => array(
				'active' => '',
				'image' => 'maestro-icon.png',
				'label' => '',
				'title' => 'Maestro'
			),
			'master_card' => array(
				'active' => '',
				'image' => 'mastercard-icon.png',
				'label' => '',
				'title' => 'MasterCard'
			),
			'paypal' => array(
				'active' => '',
				'image' => 'paypal-icon.png',
				'label' => '',
				'title' => 'PayPal'
			),
			'scrill' => array(
				'active' => '',
				'image' => 'scrill-icon.png',
				'label' => '',
				'title' => 'Scrill'
			),
			'visa' => array(
				'active' => '',
				'image' => 'visa-icon.png',
				'label' => '',
				'title' => 'Visa'
			),
		);
	}

	public function form( $instance ) {

		$defaults = array(
			'title' => 'We Accept',
			'precontent' => '',
			'postcontent' => '',
			'icon_size' => 'normal',
			'layout_type' => '',
			'payment_icons' => $this->get_payment_icons(),
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$payment_icons = $instance['payment_icons'];
		$icon_sizes = array(
			'Normal' => 'normal',
			'Small' => 'small',
			'Extra-Small' => 'x-small',
		);
		if(esc_attr($instance['layout_type'] == 'inline')) { $checked = ' checked="checked"'; } else { $checked = ''; }
	?>
	<div class="tz-widget-wrapper">

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'tz-feature-pack'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p class="option_wrap">
			<label for="<?php echo esc_attr($this->get_field_id('icon_size')); ?>"><?php esc_html_e('Icon Size:', 'tz-feature-pack'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('icon_size')); ?>" name="<?php echo esc_attr($this->get_field_name('icon_size')); ?>">
			<?php foreach($icon_sizes as $option => $value) :
				if(esc_attr($instance['icon_size'] == $value)) { $selected = ' selected="selected"'; }
				else { $selected = ''; } ?>
				<option value="<?php echo esc_attr($value); ?>"<?php echo $selected; ?>><?php echo esc_attr($option); ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p class="option_wrap right">
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('layout_type')); ?>" name="<?php echo esc_attr($this->get_field_name('layout_type')); ?>" value="inline"<?php echo $checked; ?> />
			<label for="<?php echo esc_attr($this->get_field_id('layout_type')); ?>"><?php esc_html_e('Inline Mode', 'tz-feature-pack'); ?></label>
		</p>

		<p class="clear-float">
			<label for="<?php echo esc_attr( $this->get_field_id ('precontent') ); ?>"><?php esc_html_e('Pre-Content', 'tz-feature-pack'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('precontent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('precontent') ); ?>" rows="2" cols="25"><?php echo esc_attr( $instance['precontent'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id ('postcontent') ); ?>"><?php esc_html_e('Post-Content', 'tz-feature-pack'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('postcontent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('postcontent') ); ?>" rows="2" cols="25"><?php echo esc_attr( $instance['postcontent'] ); ?></textarea>
		</p>

		<?php if ($payment_icons) {
				echo '<ul class="list_wrap">';
							foreach ($payment_icons as $key => $value) {
								if( array_key_exists('active', $value) && $value['active']=='yes' ) { $_checked = ' checked="checked"'; } else { $_checked = ''; }	?>
								<li>
									<h4><?php echo esc_attr( $value['title'] ); ?></h4>

									<p class="option_wrap">
										<input type="checkbox" id="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][active]" name="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][active]" value="yes"<?php echo $_checked; ?> />
										<label for="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][active]"><?php esc_html_e('Show on frontend', 'tz-feature-pack'); ?></label>
									</p>

									<p>
										<label for="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][label]"><?php esc_html_e('Label:', 'tz-feature-pack'); ?></label>
										<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][label]" name="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>" />
									</p>

									<input class="widefat" type="hidden" id="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][image]" name="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][image]" value="<?php echo esc_attr( $value['image'] ); ?>" />
									<input class="widefat" type="hidden" id="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][title]" name="<?php echo esc_attr($this->get_field_name('payment_icons')); ?>[<?php echo esc_attr($key); ?>][title]" value="<?php echo esc_attr( $value['title'] ); ?>" />

								</li>
							<?php }
				 echo "</ul>";
		} ?>

	</div>

	<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['precontent'] = stripslashes( $new_instance['precontent'] );
		$instance['postcontent'] = stripslashes( $new_instance['postcontent'] );
		$instance['payment_icons'] = $new_instance['payment_icons'];
		$instance['icon_size'] = $new_instance['icon_size'];
		$instance['layout_type'] = esc_attr($new_instance['layout_type']);

		return $instance;
	}

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$icon_size = empty($instance['icon_size']) ? 'normal' : $instance['icon_size'];
		$layout_type = $instance['layout_type'];
		$payment_icons = $instance['payment_icons'];
		$precontent = (isset($instance['precontent']) ? $instance['precontent'] : '' );
		$postcontent = (isset($instance['postcontent']) ? $instance['postcontent'] : '' );

		echo $before_widget;

		if ($title && $title!='') {
			echo $before_title;
			echo $title;
			echo $after_title;
		}

		if($layout_type == 'inline') { $ul_class = 'inline-mode '; }
		else { $ul_class = ''; }

		$ul_class .= 'icons-'.$icon_size;

		echo '<ul class="'.esc_attr($ul_class).'">';
		foreach($payment_icons as $payment) :
			if ( array_key_exists('active', $payment) && $payment['active']=='yes' ) {
				/* Get payment icon img dased on current icon size */
				$img = $payment['image'];
				if ( $icon_size == 'small') {
					$img = str_replace( 'icon.png', 'icon-sm.png', $img );
				}
				if ( $icon_size == 'x-small') {
					$img = str_replace( 'icon.png', 'icon-xs.png', $img );
				}
				$img_src =  TZ_FEATURE_PACK_URL . '/public/img/payment_icons/'.$img;

				echo '<li class="payment-icon">';
				echo '<img src="'.esc_url($img_src).'" alt="'.$payment['title'].'" />';
				if ( $payment['label'] && $payment['label']!='' ) {
					echo '<span>'.esc_attr($payment['label']).'</span>';
				}
				echo '</li>';
			}
		endforeach;
		echo '</ul>';

		echo $after_widget;

	}
}
