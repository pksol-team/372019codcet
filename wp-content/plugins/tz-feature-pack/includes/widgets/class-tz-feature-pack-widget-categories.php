<?php /* Collapsing Categories Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_categories extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_categories',
			esc_html__('TZ Categories', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. Display configurable list of categories on your site.", 'tz-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Categories',
			'alt_style' => false,
			'cats_count' => false,
			'show_img' => false,
			'hierarchical' => false,
			'collapsing' => false,
			'cats_type' => 'category',
			'sortby' => 'name',
			'order' => 'DESC',
			'exclude_cats' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
		    <label for ="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title: ','tz-feature-pack'); ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
				<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('alt_style') ); ?>" <?php if (esc_attr( $instance['alt_style'] )) {
												echo 'checked="checked"';
										} ?> class=""  size="4"  id="<?php echo esc_attr($this->get_field_id('alt_style')); ?>" />
				<label for ="<?php echo esc_attr( $this->get_field_id('alt_style') ); ?>"><?php esc_html_e('Check for alternative widget styling','tz-feature-pack'); ?></label>
		</p>
		<p>
		    <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('cats_count') ); ?>" <?php if (esc_attr( $instance['cats_count'] )) {
		                    echo 'checked="checked"';
		                } ?> class=""  size="4"  id="<?php echo esc_attr($this->get_field_id('cats_count')); ?>" />
		    <label for ="<?php echo esc_attr( $this->get_field_id('cats_count') ); ?>"><?php esc_html_e('Show count for categories','tz-feature-pack'); ?></label>
		</p>
		<p>
		    <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('show_img') ); ?>" <?php if (esc_attr( $instance['show_img'] )) {
		                    echo 'checked="checked"';
		                } ?> class=""  size="4"  id="<?php echo esc_attr($this->get_field_id('show_img')); ?>" />
		    <label for ="<?php echo esc_attr( $this->get_field_id('show_img') ); ?>"><?php esc_html_e('Show images for categories','tz-feature-pack'); ?></label>
		</p>
		<p>
		    <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('hierarchical') ); ?>" <?php if (esc_attr( $instance['hierarchical'] )) {
		                    echo 'checked="checked"';
		                } ?> class=""  size="4"  id="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>" />
		    <label for ="<?php echo esc_attr( $this->get_field_id('hierarchical') ); ?>"><?php esc_html_e('Show hierarchy','tz-feature-pack'); ?></label>
		</p>
		<p>
		    <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('collapsing') ); ?>" <?php if (esc_attr( $instance['collapsing'] )) {
		                    echo 'checked="checked"';
		                } ?> class=""  size="4"  id="<?php echo esc_attr($this->get_field_id('collapsing')); ?>" />
		    <label for ="<?php echo esc_attr( $this->get_field_id('collapsing') ); ?>"><?php esc_html_e('Collapsing categories','tz-feature-pack'); ?></label>
		    <br /><small><?php esc_html_e('works only when "Show hierarchy" checked.', 'tz-feature-pack'); ?></small>
		</p>
		<p>
		    <label for="<?php echo esc_attr( $this->get_field_id('cats_type') ); ?>"><?php esc_html_e('Categories type:','tz-feature-pack'); ?>
		        <select class='widefat' id="<?php echo esc_attr($this->get_field_id('cats_type')); ?>" name="<?php echo esc_attr( $this->get_field_name('cats_type') ); ?>">
		          <option value='category'<?php echo (esc_attr($instance['cats_type']=='category'))?' selected="selected"':''; ?>><?php esc_html_e('Post Categories', 'tz-feature-pack'); ?></option>
							<?php if ( class_exists('Woocommerce') ) : ?>
							<option value='product_cat'<?php echo (esc_attr($instance['cats_type']=='product_cat'))?' selected="selected"':''; ?>><?php esc_html_e('Product Categories', 'tz-feature-pack'); ?></option>
							<?php endif; ?>
						</select>
		    </label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('sortby') ); ?>"><?php esc_html_e('Sort by:','tz-feature-pack'); ?>
		        <select class='widefat' id="<?php echo esc_attr($this->get_field_id('sortby')); ?>" name="<?php echo $this->get_field_name('sortby'); ?>">
		          <option value='ID'<?php echo (esc_attr($instance['sortby']=='ID'))?' selected':''; ?>><?php esc_html_e('ID', 'tz-feature-pack'); ?></option>
		          <option value='name'<?php echo (esc_attr($instance['sortby']=='name'))?' selected="selected"':''; ?>><?php esc_html_e('Name', 'tz-feature-pack'); ?></option>
		          <option value='slug'<?php echo (esc_attr($instance['sortby']=='slug'))?' selected="selected"':''; ?>><?php esc_html_e('Slug', 'tz-feature-pack'); ?></option>
		        </select>
		    </label>
		</p>
		<p>
		    <label for="<?php echo esc_attr( $this->get_field_id('order') ); ?>"><?php esc_html_e('Order:','tz-feature-pack'); ?>
		        <select class='widefat' id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr( $this->get_field_name('order') ); ?>">
		          <option value='ASC'<?php echo (esc_attr($instance['order']=='ASC'))?' selected="selected"':''; ?>><?php esc_html_e('Ascending', 'tz-feature-pack'); ?></option>
		          <option value='DESC'<?php echo (esc_attr($instance['order']=='DESC'))?' selected="selected"':''; ?>><?php esc_html_e('Descending', 'tz-feature-pack'); ?></option>
		        </select>
		    </label>
		</p>
		<p>
		    <label for ="<?php echo esc_attr( $this->get_field_id('exclude_cats') ); ?>"><?php esc_html_e('Exclude Category (ID): ','tz-feature-pack'); ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('exclude_cats')); ?>" name="<?php echo esc_attr( $this->get_field_name('exclude_cats') ); ?>" value="<?php echo esc_attr($instance['exclude_cats']); ?>"/>
		    <small><?php esc_html_e('category IDs, separated by commas.', 'tz-feature-pack'); ?></small>
		</p>

	<?php }

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['alt_style'] = $new_instance['alt_style'];
		$instance['cats_count'] = $new_instance['cats_count'];
		$instance['show_img'] = $new_instance['show_img'];
		$instance['hierarchical'] = $new_instance['hierarchical'];
		$instance['collapsing'] = $new_instance['collapsing'];
		$instance['cats_type'] = strip_tags( $new_instance['cats_type'] );
		$instance['sortby'] = strip_tags( $new_instance['sortby'] );
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['exclude_cats'] = strip_tags( $new_instance['exclude_cats'] );

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$alt_style = ( isset($instance['alt_style']) ? $instance['alt_style'] : false );
		$show_count = ( isset($instance['cats_count']) ? $instance['cats_count'] : false );
		$show_img = ( isset($instance['show_img']) ? $instance['show_img'] : false );
		$hierarchical = ( isset($instance['hierarchical']) ? $instance['hierarchical'] : false );
		$collapsing = ( isset($instance['collapsing']) ? $instance['collapsing'] : false );
		$cats_type = ( isset($instance['cats_type']) ? $instance['cats_type'] : 'category' );
		$sortby = ( isset($instance['sortby']) ? $instance['sortby'] : 'name' );
		$order = ( isset($instance['order']) ? $instance['order'] : 'DESC' );
		$exclude_cats = ( isset($instance['exclude_cats']) ? $instance['exclude_cats'] : '' );

		global $wp_query, $post, $product;

		// Setup Current Category
		$current_cat   = false;
		$cat_ancestors = array();

		if ( is_tax('product_cat') || is_category() ) {
			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, $cats_type );
		}

		/* Add extra class if alt styling checked */
		if ( $alt_style )  {
			$before_widget = str_replace('class="', 'class="alt-style ', $before_widget);
		}

		echo $before_widget;
		if ($title) echo $before_title . esc_attr($title) . $after_title;

	  $args = array(
			'orderby'            => $sortby,
			'order'              => $order,
			'style'              => 'list',
			'show_count'         => $show_count,
			'hide_empty'         => true,
			'exclude'            => $exclude_cats,
			'hierarchical'       => $hierarchical,
			'title_li'           => '',
			'show_option_none'   => esc_html__( 'No categories', 'tz-feature-pack' ),
			'taxonomy'           => $cats_type,
	  );

		if (class_exists('tz_cats_list_walker')) {
			$catsWalker = new tz_cats_list_walker();
			$catsWalker->show_img = $show_img;
			$catsWalker->collapsing = $collapsing;
			$args['walker'] = $catsWalker;
		}

	  $args['current_category'] = ( $current_cat ) ? $current_cat->term_id : '';
		$args['current_category_ancestors'] = $cat_ancestors;

		echo '<ul class="pt-categories">';

		wp_list_categories( $args );

		echo '</ul>';

    echo $after_widget;

    }

}
