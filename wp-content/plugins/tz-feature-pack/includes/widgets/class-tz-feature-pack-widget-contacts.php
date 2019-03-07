<?php /* Contacts Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_contacts extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_contacts',
			esc_html__('TZ Contacts', 'tz-feature-pack'),
			array( 'description' => esc_html__( 'Themes Zone special widget. Configurable Address Widget', 'tz-feature-pack' ), )
		);
		add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
	}

	/**
    * Upload the Javascripts for the media uploader
    */
  public function upload_scripts() {
		$mode = get_user_option( 'media_library_mode', get_current_user_id() ) ? get_user_option( 'media_library_mode', get_current_user_id() ) : 'grid';
    $modes = array( 'grid', 'list' );
    if ( isset( $_GET['mode'] ) && in_array( $_GET['mode'], $modes ) ) {
        $mode = $_GET['mode'];
        update_user_option( get_current_user_id(), 'media_library_mode', $mode );
    }
    if( ! empty ( $_SERVER['PHP_SELF'] ) && 'upload.php' === basename( $_SERVER['PHP_SELF'] ) && 'grid' !== $mode ) {
        wp_enqueue_script( 'media' );
    }
    if ( ! did_action( 'wp_enqueue_media' ) ) wp_enqueue_media();
    wp_enqueue_script( 'tz-upload-media-js', TZ_FEATURE_PACK_URL . '/admin/js/upload-media.js', array('jquery'), true);
  }

	public function form( $instance ) {

		$defaults = array(
			'title'	=> '',
			'precontent' => '',
			'postcontent' => '',
			'phone'	=> '',
			'fax'	=> '',
			'skype'	=> '',
			'email' => '',
			'address' => '',
			'company_name' => '',
			'image' => '',
			'working_hours' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'company_name' )); ?>"><?php esc_html_e( 'Company Name:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'company_name' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'company_name' )); ?>" type="text" value="<?php echo esc_attr($instance['company_name']); ?>" />
		</p>
		<p>
      <label for="<?php echo esc_attr($this->get_field_name( 'image' )); ?>"><?php esc_html_e( 'Company Logo:', 'tz-feature-pack' ); ?></label>
      <img class="custom_logo_image" src="<?php if ( !empty($instance['image']) ) { echo esc_url($instance['image']); } else { echo '#'; } ?>" style="margin:0 auto 10px;padding:0;width:200px;display:<?php if ( !empty($instance['image']) ) { echo 'block'; } else { echo 'none'; } ?>" />
      <input name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url($instance['image']); ?>" />
      <span class="button button-primary pt_upload_image_button" id="<?php echo esc_attr($this->get_field_id( 'image' )).'_button'; ?>" style="margin:10px 0 0 0;"><?php esc_html_e('Upload Image', 'tz-feature-pack'); ?></span>
    </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id ('precontent')); ?>"><?php esc_html_e('Pre-Content', 'tz-feature-pack'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('precontent')); ?>" name="<?php echo esc_attr($this->get_field_name('precontent')); ?>" rows="2" cols="25"><?php echo esc_attr($instance['precontent']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id ('postcontent')); ?>"><?php esc_html_e('Post-Content', 'tz-feature-pack'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('postcontent')); ?>" name="<?php echo esc_attr($this->get_field_name('postcontent')); ?>" rows="2" cols="25"><?php echo esc_attr($instance['postcontent']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>"><?php esc_html_e( 'Phone:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone' )); ?>" type="text" value="<?php echo esc_attr($instance['phone']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'fax' )); ?>"><?php esc_html_e( 'Fax:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'fax' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fax' )); ?>" type="text" value="<?php echo esc_attr($instance['fax']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>"><?php esc_html_e( 'Skype:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'skype' )); ?>" type="text" value="<?php echo esc_attr($instance['skype']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'email' )); ?>"><?php esc_html_e( 'Email:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" type="text" value="<?php echo esc_attr($instance['email']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'address' )); ?>"><?php esc_html_e( 'Address:', 'tz-feature-pack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>" type="text" value="<?php echo esc_attr($instance['address']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id ('working_hours')); ?>"><?php esc_html_e('Working Hours', 'tz-feature-pack'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('working_hours')); ?>" name="<?php echo esc_attr($this->get_field_name('working_hours')); ?>" rows="2" cols="25"><?php echo esc_attr($instance['working_hours']); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = ( $new_instance['title'] );
		$instance['precontent'] = stripslashes( $new_instance['precontent'] );
		$instance['postcontent'] = stripslashes( $new_instance['postcontent'] );
		$instance['working_hours'] = stripslashes( $new_instance['working_hours'] );
		$instance['phone'] = ( $new_instance['phone'] );
		$instance['fax'] = ( $new_instance['fax'] );
		$instance['skype'] = ( $new_instance['skype'] );
		$instance['email'] = ( $new_instance['email'] );
		$instance['address'] = ( $new_instance['address'] );
		$instance['image'] = ( $new_instance['image'] );
		$instance['company_name'] = ( $new_instance['company_name'] );

		return $instance;
	}

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$precontent = (isset($instance['precontent']) ? $instance['precontent'] : '' );
		$postcontent = (isset($instance['postcontent']) ? $instance['postcontent'] : '' );
		$working_hours = (isset($instance['working_hours']) ? $instance['working_hours'] : '' );
		$phone = (isset($instance['phone']) ? $instance['phone'] : '' );
		$fax = (isset($instance['fax']) ? $instance['fax'] : '' );
		$skype = (isset($instance['skype']) ? $instance['skype'] : '' );
		$email = (isset($instance['email']) ? $instance['email'] : '' );
		$address = (isset($instance['address']) ? $instance['address'] : '' );
		$image_url = (isset($instance['image']) ? $instance['image'] : '' );
		$company_name = (isset($instance['company_name']) ? $instance['company_name'] : '' );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . esc_attr($title) . $after_title;
		?>

		<?php if ( ! empty( $precontent ) ) {
			echo '<div class="precontent">'.esc_attr($precontent).'</div>';
		} ?>

			<ul itemprop="sourceOrganization" itemscope="itemscope" itemtype="http://schema.org/LocalBusiness">
				<?php if($company_name != '' ) : ?><meta itemprop="name" content="<?php echo esc_attr($company_name); ?>"><?php endif; ?>
				<?php if($image_url != '' ) : ?><li class="option-title a-logo"><div class="logo"><img alt="<?php echo esc_attr($company_name); ?>" src="<?php echo esc_url($image_url); ?>" itemprop="logo" /></div></li><?php endif; ?>
				<?php if($address != '' ) : ?><li class="option-title a-address"><div class="address" itemprop="address"><span class="label"><?php esc_html_e('Address: ', 'tz-feature-pack'); ?></span><?php echo strip_tags($address, '<br><span><span/>'); ?></div></li><?php endif; ?>
				<?php if($phone != '' ) : ?><li class="option-title a-phone"><div class="phone" itemprop="telephone"><span class="label"><?php esc_html_e('Phone: ', 'tz-feature-pack'); ?></span><?php echo strip_tags($phone, '<br><span><span/>'); ?></div></li><?php endif; ?>
				<?php if($fax != '' ) : ?><li class="option-title a-fx"><div class="fax"><span class="label"><?php esc_html_e('Fax: ', 'tz-feature-pack'); ?></span><?php echo esc_attr($fax); ?></div></li><?php endif; ?>
				<?php if($skype != '' ) : ?><li class="option-title a-skype"><div class="skype"><span class="label"><?php esc_html_e('Skype: ', 'tz-feature-pack'); ?></span><?php echo esc_attr($skype); ?></div></li><?php endif; ?>
				<?php if($email != '' ) : ?><li class="option-title a-email"><div class="email" itemprop="email"><span class="label"><?php esc_html_e('E-mail: ', 'tz-feature-pack'); ?></span><a title="Email us" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_attr($email); ?></a></div></li><?php endif; ?>
				<?php if($working_hours != '' ) : ?><li class="option-title a-hours"><div class="hours"><span class="label"><?php esc_html_e('Working Hours: ', 'tz-feature-pack'); ?></span><?php echo strip_tags($working_hours, '<br><span><span/>'); ?></div></li><?php endif; ?>
			</ul>

		<?php
		if ( ! empty( $postcontent ) ) {
			echo '<div class="postcontent">'.esc_attr($postcontent).'</div>';
		}

		echo $after_widget;
	}
}
