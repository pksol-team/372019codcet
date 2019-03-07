<?php /* Output Shortcode Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('WPBakeryShortCode') ) return false;

class tz_shortcode extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'description' => esc_html__( "Themes Zone special widget. Outputs shortcodes in widget areas.", 'tz-feature-pack' ),
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'tz_shortcode', esc_html__( 'TZ Output Shortcode', 'tz-feature-pack' ), $widget_ops, $control_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'text' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'tz-feature-pack'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Shortcode:', 'tz-feature-pack' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$shortcode = ! empty( $instance['text'] ) ? $instance['text'] : '';

		echo $before_widget;
		if ($title) echo $before_title . esc_attr($title) . $after_title; ?>
			<div class="output-shortcode"><?php echo do_shortcode($shortcode); ?></div>
		<?php
		echo $after_widget;
	}

}
