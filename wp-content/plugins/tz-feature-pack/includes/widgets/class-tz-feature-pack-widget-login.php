<?php /* AJAX Login/Register Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_login_register extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_login_register',
			esc_html__('TZ Login/Register', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. An AJAX Login/Register form for your site.", 'tz-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Log In',
			'inline' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("inline")); ?>" name="<?php echo esc_attr($this->get_field_name("inline")); ?>" <?php checked( (bool) $instance["inline"] ); ?> />
			<label for="<?php echo esc_attr($this->get_field_id("inline")); ?>"><?php esc_html_e( 'Check if use widget in header top panels', 'tz-feature-pack' ); ?></label>
		</p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['inline'] = $new_instance['inline'];
		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
		$inline = ( isset($instance['inline']) ? $instance['inline'] : false );
		$inline_class = '';

		echo $before_widget;

		if ($title) { echo $before_title . esc_attr($title) . $after_title; }
		if ($inline) { $inline_class = ' inline'; }

 		if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user(); ?>

			<div class="tz-login-heading<?php echo esc_attr($inline_class); ?>">
				<?php if ( class_exists('WooCommerce') ) { ?>
					<a class="my-account" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_html_e('My Account','tz-feature-pack'); ?>"><?php esc_html_e('My Account','tz-feature-pack'); ?></a>
				<?php }; ?>
				<span class="logged-in-as">
					<?php printf( esc_html__( "Hello ", 'tz-feature-pack' ) . '<strong>%1$s</strong>.', esc_attr($current_user->display_name)); ?>
				</span>
				<a class="log-out" href="<?php echo wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ); ?>" title="<?php esc_html_e('Log out of this account', 'tz-feature-pack');?>"><?php esc_html_e('Log out', 'tz-feature-pack');?></a>
			</div>

		<?php } else { ?>

			<div class="tz-login-heading clickable<?php echo esc_attr($inline_class); ?>">
				<?php if ($inline) { ?>
					<p class="logged-in-as">
						<?php echo '<i class="user-icon"></i>'; esc_html_e( 'Hello.', 'tz-feature-pack' ); ?>
					</p>
					<a class="login-button" id="show_login_form" href="#"><?php esc_html_e('Sign In', 'tz-feature-pack'); ?></a><span class="delimiter">|</span>
					<a class="login-button" id="show_register_form" href="#"><?php esc_html_e('Register', 'tz-feature-pack'); ?></a>
				<?php } else { ?>
					<p class="my-account"><?php esc_html_e('My Account','tz-feature-pack'); ?></p>
					<p class="logged-in-as">
						<?php esc_html_e( 'Hello. Sign In', 'tz-feature-pack' ); ?>
					</p>
				<?php }; ?>
			</div>

		<?php } ?>

		<?php if (!$inline) { echo '<div class="tz-login-form-wrapper">'; } ?>

			<form id="tz-login" class="ajax-auth" method="post">
				<h3 class="heading"><?php esc_html_e('Login', 'tz-feature-pack');?></h3>
				<p class="status"></p>
				<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
				<p class="username">
					<label for="username"><?php esc_html_e('Username', 'tz-feature-pack');?><span class="required">*</span></label>
					<input type="text" class="tz-login-username" placeholder="<?php esc_html_e('Username', 'tz-feature-pack');?>" name="username" required aria-required="true" pattern="<?php echo apply_filters('feedback_form_sender_pattern', '[a-zA-Z0-9 ]+'); ?>" title="<?php esc_html_e('Digits and Letters only.', 'tz-feature-pack'); ?>">
				</p>
				<p class="password">
					<label for="password"><?php esc_html_e('Password', 'tz-feature-pack');?><span class="required">*</span></label>
					<input type="password" class="tz-login-password" placeholder="<?php esc_html_e('Password', 'tz-feature-pack');?>" name="password" required aria-required="true">
				</p>
				<p class="submit-wrapper">
					<a class="text-link" href="<?php echo wp_lostpassword_url(); ?>"><?php esc_html_e('Lost password?', 'tz-feature-pack');?></a>
					<input class="login button" type="submit" value="<?php esc_html_e('Login', 'tz-feature-pack'); ?>">
				</p>
				<h3 class="botom-links"><?php esc_html_e('New to site? ', 'tz-feature-pack');?><a id="tz-pop-register" href="#"><?php esc_html_e('Create an Account', 'tz-feature-pack');?></a></h3>
				<?php if ( function_exists('oa_social_login_render_login_form') ) {
					$settings = get_option ('oa_social_login_settings');
					if (is_array ($settings ['providers'])) {
						echo '<h3>' . esc_html__('Or login to site using social networks', 'tz-feature-pack') . '</h3>';
						echo '<div class="social-networks-login">';
						do_action('oa_social_login');
						echo '</div>';
					}
				} ?>
				<a class="tz-form-close" href="#"><?php esc_html_e('(close)', 'tz-feature-pack');?></a>
			</form>

			<form id="tz-register" class="ajax-auth" method="post">
				<h3 class="heading"><?php esc_html_e('Register', 'tz-feature-pack');?></h3>
				<p class="status"></p>
				<?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
				<p class="username">
					<label for="signonname"><?php esc_html_e('Username', 'tz-feature-pack');?><span class="required">*</span></label>
					<input class="tz-register-username" placeholder="<?php esc_html_e('Username', 'tz-feature-pack');?>" type="text" name="signonname" required aria-required="true" pattern="<?php echo apply_filters('register_form_username_pattern', '[a-zA-Z0-9 ]+'); ?>" title="<?php esc_html_e('Digits and Letters only.', 'tz-feature-pack'); ?>">
					<input type="text" name="register-firstname" class="tz-register-firstname" maxlength="50" value="<?php echo ( isset( $_POST["firstname"] ) ? esc_attr( $_POST["firstname"] ) : '' ); ?>" />
					<input type="text" name="register-lastname" class="tz-register-lastname" maxlength="50" value="<?php echo ( isset( $_POST["lastname"] ) ? esc_attr( $_POST["lastname"] ) : '' ); ?>" />
				</p>
				<p class="email">
					<label for="email"><?php esc_html_e('Email', 'tz-feature-pack');?><span class="required">*</span></label>
					<input class="tz-register-email" placeholder="<?php esc_html_e('E-Mail', 'tz-feature-pack');?>" type="email" name="email" required aria-required="true">
				</p>
				<p class="password">
					<label for="signonpassword"><?php esc_html_e('Password', 'tz-feature-pack');?><span class="required">*</span></label>
					<input class="tz-register-password" placeholder="<?php esc_html_e('Password', 'tz-feature-pack');?>" type="password" name="signonpassword" required aria-required="true">
				</p>
				<p class="submit-wrapper">
					<input class="register button" type="submit" value="<?php esc_html_e('Register', 'tz-feature-pack'); ?>">
				</p>
				<h3 class="botom-links"><?php esc_html_e('Already have an account? ', 'tz-feature-pack');?><a id="tz-pop-login" href="#"><?php esc_html_e('Login', 'tz-feature-pack');?></a></h3>
				<a class="tz-form-close" href="#"><?php esc_html_e('(close)', 'tz-feature-pack');?></a>
		</form>

		<?php if (!$inline) { echo '</div>'; } ?>

	<?php
		echo $after_widget;
	}

}
