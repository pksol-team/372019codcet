<?php /* Social Networks Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_socials extends WP_Widget {

	function __construct() {
		parent::__construct(
			'tz_socials',
			esc_html__('TZ Social Icons', 'tz-feature-pack'),
			array(
				'description' => esc_html__('Themes Zone special widget. Displays a list of social media website icons and a link to your profile.', 'tz-feature-pack'),
			),
			array(
				'width' => 600,
			)
		);
	}

	// Get Social Networks
	protected function get_social_networks() {
		$social_networks = array(
			'facebook' => array(
				'icon' => 'facebook',
				'label' => '',
				'url' => ''
			),
			'linkedin' => array(
				'icon' => 'linkedin',
				'label' => '',
				'url' => ''
			),
			'twitter' => array(
				'icon' => 'twitter',
				'label' => '',
				'url' => ''
			),
			'google-plus' => array(
				'icon' => 'google-plus',
				'label' => '',
				'url' => ''
			),
			'youtube' => array(
				'icon' => 'youtube',
				'label' => '',
				'url' => ''
			),
			'instagram' => array(
				'icon' => 'instagram',
				'label' => '',
				'url' => ''
			),
			'github' => array(
				'icon' => 'github',
				'label' => '',
				'url' => ''
			),
			'rss' => array(
				'icon' => 'rss',
				'label' => '',
				'url' => ''
			),
			'pinterest' => array(
				'icon' => 'pinterest',
				'label' => '',
				'url' => ''
			),
			'flickr' => array(
				'icon' => 'flickr',
				'label' => '',
				'url' => ''
			),
			'bitbucket' => array(
				'icon' => 'bitbucket',
				'label' => '',
				'url' => ''
			),
			'tumblr' => array(
				'icon' => 'tumblr',
				'label' => '',
				'url' => ''
			),
			'dribbble' => array(
				'icon' => 'dribbble',
				'label' => '',
				'url' => ''
			),
			'vimeo' => array(
				'icon' => 'vimeo',
				'label' => '',
				'url' => ''
			),
			'wordpress' => array(
				'icon' => 'wordpress',
				'label' => '',
				'url' => ''
			),
			'delicious' => array(
				'icon' => 'delicious',
				'label' => '',
				'url' => ''
			),
			'digg' => array(
				'icon' => 'digg',
				'label' => '',
				'url' => ''
				),
			'behance' => array(
				'icon' => 'behance',
				'label' => '',
				'url' => ''
			),
		);
		return apply_filters('tz-feature-pack-social-networks', $social_networks);
	}

	public function form( $instance ) {

		$defaults = array(
			'title' => '',
			'icon_size' => 'small',
			'show_title' => '',
			'layout_type' => '',
			'rectangles' => false,
			'social_networks' => $this->get_social_networks(),
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		$social_networks = $instance['social_networks'];
	?>
		<div class="tz-widget-wrapper">

			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'tz-feature-pack'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

			<p>
	    	<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("rectangles")); ?>" name="<?php echo esc_attr($this->get_field_name("rectangles")); ?>" <?php checked( (bool) $instance["rectangles"] ); ?> />
	      <label for="<?php echo esc_attr($this->get_field_id("rectangles")); ?>"><?php esc_html_e( 'Add Colour Rectangles around icons?', 'tz-feature-pack' ); ?></label>
	    </p>

			<?php
			$icon_sizes = array(
				'Small (16px)' => 'small',
				'Medium (24px)' => 'medium',
				'Large (32px)' => 'large',
			);
			?>

			<p class="option_wrap"><label for="<?php echo esc_attr($this->get_field_id('icon_size')); ?>"><?php esc_html_e('Icon Size:', 'tz-feature-pack'); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id('icon_size')); ?>" name="<?php echo esc_attr($this->get_field_name('icon_size')); ?>">
				<?php
				foreach($icon_sizes as $option => $value) :

					if(esc_attr($instance['icon_size'] == $value)) { $selected = ' selected="selected"'; }
					else { $selected = ''; }
				?>

					<option value="<?php echo esc_attr($value); ?>"<?php echo $selected; ?>><?php echo esc_attr($option); ?></option>

				<?php endforeach; ?>
				</select>
			</p>

			<?php if(esc_attr($instance['layout_type'] == 'inline')) { $checked = ' checked="checked"'; } else { $checked = ''; } ?>
			<p class="option_wrap right"><input type="checkbox" id="<?php echo esc_attr($this->get_field_id('layout_type')); ?>" name="<?php echo esc_attr($this->get_field_name('layout_type')); ?>" value="inline"<?php echo $checked; ?> /> <label for="<?php echo esc_attr($this->get_field_id('layout_type')); ?>"><?php esc_html_e('Inline Mode', 'tz-feature-pack'); ?></label></p>

			<?php if ($social_networks) {
				echo '<ul class="list_wrap">';
          foreach ($social_networks as $key => $value) { ?>
						<li>
							<h4><?php echo esc_attr( $key ); ?></h4>

							<label for="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][label]"><?php esc_html_e('Label:', 'tz-feature-pack'); ?></label>
							<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][label]" name="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>" />

							<label for="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][url]"><?php esc_html_e('URL:', 'tz-feature-pack'); ?></label>
							<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][url]" name="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][url]" value="<?php echo esc_url( $value['url'] ); ?>" />

							<input class="widefat" type="hidden" id="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][icon]" name="<?php echo esc_attr($this->get_field_name('social_networks')); ?>[<?php echo esc_attr($key); ?>][icon]" value="<?php echo esc_attr( $value['icon'] ); ?>" />
						</li>
          <?php }
        echo "</ul>";
			} ?>

			</div>
		<?php
	}

	public function update($new_instance, $old_instance) {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['social_networks'] = $new_instance['social_networks'];
		$instance['icon_size'] = $new_instance['icon_size'];
		$instance['layout_type'] = esc_attr($new_instance['layout_type']);
		$instance['rectangles'] = strip_tags($new_instance['rectangles']);

		return $instance;
	}

	public function widget( $args, $instance ) {

		extract($args);

		$title = empty($instance['title']) ? 'Follow Us' : apply_filters('widget_title', $instance['title']);
		$icon_size = empty($instance['icon_size']) ? 'small' : $instance['icon_size'];
		$layout_type = $instance['layout_type'];
		$rectangles = ( isset($instance['rectangles']) ? $instance['rectangles'] : false );
		$social_networks = $instance['social_networks'];

		echo $before_widget;

		if ($title && $title!='') {
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		$ul_class = '';
		if($layout_type == 'inline') { $ul_class .= 'inline-mode '; }
		if($rectangles == true) { $ul_class .= 'rectangles '; }

		$ul_class .= 'icons-'.$icon_size;

		echo '<ul class="'.esc_attr($ul_class).'">';
		foreach($social_networks as $network) :
			if ( $network['url'] && $network['url']!='' ) {
				echo '<li class="social-network">';
				echo '<a href="'.esc_url($network['url']).'" target="_blank" title="'.esc_html__('Connect us', 'tz-feature-pack').'"><i class="fa fa-'.esc_attr($network['icon']).'"></i>';
				if ( $network['label'] && $network['label']!='' ) {
					echo '<span>'.esc_attr($network['label']).'</span>';
				}
				echo '</a>';
				echo '</li>';
			}
		endforeach;
		echo '</ul>';

		echo $after_widget;
	}
}
