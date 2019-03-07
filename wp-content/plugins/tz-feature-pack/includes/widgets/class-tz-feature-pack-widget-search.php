<?php /* Search Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_search extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_search',
			esc_html__('TZ Search', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. A mobile-friendly search form for your site.", 'tz-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => '',
			'search-input' => 'Search by title, brand, category...',
			'search-button' => 'Find',
			'category-search' => false,
			'search-in' => 'category',
			'exclude' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Input Text: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('search-input') ); ?>" name="<?php echo esc_attr( $this->get_field_name('search-input') ); ?>" type="text" value="<?php echo esc_attr( $instance['search-input'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Button Title Text: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('search-button') ); ?>" name="<?php echo esc_attr( $this->get_field_name('search-button') ); ?>" type="text" value="<?php echo esc_attr( $instance['search-button'] ); ?>" />
		</p>
		<p>
    	<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("category-search"); ?>" name="<?php echo $this->get_field_name("category-search"); ?>" <?php checked( (bool) $instance["category-search"] ); ?> />
      <label for="<?php echo $this->get_field_id("category-search"); ?>"><?php esc_html_e( 'Add "search in category" dropdown?', 'tz-feature-pack' ); ?></label>
    </p>
		<p><?php esc_html_e('Select which post type you want to output in Search results page','tz-feature-pack'); ?></p>
		<p>
			<?php
			$typeoptions = array (
				"post" => esc_html__("Posts",'tz-feature-pack'),
				"product" => esc_html__("Products",'tz-feature-pack'),
			);
			foreach ($typeoptions as $val => $html) {
				$checked = '';
				$output = '<input type="radio" value="'.esc_attr($val).'" id="'.esc_attr($this->get_field_id('search-in').'-'.$val).'" name="'.esc_attr($this->get_field_name('search-in')).'" ';
				if($instance['search-in']==$val) { $checked = 'checked="checked"'; }
				$output .= $checked.' class="radio" /><label for="'.esc_attr($this->get_field_id('search-in').'-'.$val).'">'.esc_attr($html).'</label><br />';
				echo $output;
			};
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php esc_html_e( 'Exclude next categories(a comma-separated list of categories by unique ID, in ascending order): ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('exclude') ); ?>" name="<?php echo esc_attr( $this->get_field_name('exclude') ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude'] ); ?>" />
		</p>

		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['search-input'] = strip_tags( $new_instance['search-input'] );
		$instance['search-button'] = strip_tags( $new_instance['search-button'] );
		$instance['category-search'] = $new_instance['category-search'];
		$instance['search-in'] = $new_instance['search-in'];
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$text = ( isset($instance['search-input']) ? $instance['search-input'] : 'Search by title, brand, category...' );
		$button = ( isset($instance['search-button']) ? $instance['search-button'] : 'Find' );
		$category_search = ( isset($instance['category-search']) ? $instance['category-search'] : false );
		$search_in = ( isset($instance['search-in']) ? $instance['search-in'] : 'post' );
		$exclude = ( isset($instance['exclude']) ? $instance['exclude'] : '' );

		echo $before_widget;
		if ($title) { echo $before_title . esc_attr($title) . $after_title; }
	?>

	<form class="tz-searchform" method="get" action="<?php echo esc_url( home_url() ); ?>">
		<?php if ($category_search) {
			$select_output = '';
			$taxonomy = 'category';
			if ( $search_in == 'product' ) {
				$taxonomy = 'product_cat';
			}
			$args = array(
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hierarchical'             => 0,
				'exclude'                  => $exclude,
				'taxonomy'                 => $taxonomy,
			);
			$categories = get_categories( $args );
			if ($categories) {
				$select_output .= '<div class="select-wrapper">';
				if ($search_in == 'product') { $select_name = 'product_cat'; } else { $select_name = 'category_name'; }
				$select_output .= '<select class="search-select" name="'.esc_attr($select_name).'">';
				$select_output .= '<option value="">'.esc_html__('All', 'tz-feature-pack').'</option>';
				foreach ($categories as $category) {
					$select_output .= '<option value="'.esc_attr($category->slug).'">'.esc_attr($category->name).'</option>';
				}
				$select_output .= '</select>';
				$select_output .= '</div>';
			}
			echo $select_output;
		}?>

		<input id="s" name="s" type="text" class="search-text" value="" placeholder="<?php echo esc_attr( $text ); ?>" tabindex="1">

		<button id="searchsubmit" class="search-button" title="<?php echo esc_attr( $button ); ?>" tabindex="2"><i class="chromium-icon-search-bold" aria-hidden="true"></i></button>

		<?php if ($search_in == 'product') {
			echo '<input type="hidden" name="post_type" value="product" />';
		}?>
	</form>

	<?php
		echo $after_widget;
	}

}
