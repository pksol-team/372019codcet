<?php /* Most Viewed Posts Widget */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class tz_most_viewed_posts extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_most_viewed_posts', // Base ID
			esc_html__('TZ Most Viewed Posts', 'tz-feature-pack'), // Name
			array('description' => esc_html__( "Themes Zone special widget. Displaying number of most viewed posts on your site.", 'tz-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Most Viewed Posts',
			'post-quantity' => 5,
			'sort-order' => false,  // DESC
			'date' => false,
			'comments' => false,
			'category' => '',
			'thumb' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post-quantity')); ?>"><?php esc_html_e( 'How many posts to display: ', 'tz-feature-pack' ) ?></label>
			<input size="3" id="<?php echo esc_attr( $this->get_field_id('post-quantity') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post-quantity') ); ?>" type="number" value="<?php echo esc_attr( $instance['post-quantity'] ); ?>" />
		</p>
    <p>
    	<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("sort-order")); ?>" name="<?php echo esc_attr($this->get_field_name("sort-order")); ?>" <?php checked( (bool) $instance["sort-order"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("sort-order")); ?>"><?php esc_html_e( 'Reverse sort order (ascending)?', 'tz-feature-pack' ); ?></label>
    </p>
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("date")); ?>" name="<?php echo esc_attr($this->get_field_name("date")); ?>"<?php checked( (bool) $instance["date"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("date")); ?>"><?php esc_html_e( 'Show publish date?', 'tz-feature-pack' ); ?></label>
    </p>
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("comments")); ?>" name="<?php echo esc_attr($this->get_field_name("comments")); ?>"<?php checked( (bool) $instance["comments"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("comments")); ?>"><?php esc_html_e( 'Show number of comments?', 'tz-feature-pack' ); ?></label>
    </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e( 'Specify ID of category (categories) to show: ', 'tz-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('category') ); ?>" name="<?php echo esc_attr( $this->get_field_name('category') ); ?>" type="text" value="<?php echo esc_attr( $instance['category'] ); ?>" />
		</p>
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("thumb")); ?>" name="<?php echo esc_attr($this->get_field_name("thumb")); ?>"<?php checked( (bool) $instance["thumb"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("thumb")); ?>"><?php esc_html_e( 'Show post thumbnail?', 'tz-feature-pack' ); ?></label>
    </p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post-quantity'] = intval( $new_instance['post-quantity'] );
		$instance['sort-order'] = $new_instance['sort-order'];
		$instance['date'] = $new_instance['date'];
		$instance['comments'] = $new_instance['comments'];
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['thumb'] = $new_instance['thumb'];

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);
		global $post;

		$title = apply_filters('widget_title', $instance['title'] );
		$post_num = ( isset($instance['post-quantity']) ? $instance['post-quantity'] : 5 );
		$sort_order = ( isset($instance['sort-order']) ? $instance['sort-order'] : false );
		if ($sort_order) { $order = 'ASC'; } else { $order = 'DESC'; }
		$show_date = ( isset($instance['date']) ? $instance['date'] : false );
		$show_comments = ( isset($instance['comments']) ? $instance['comments'] : false );
		$categories = ( isset($instance['category']) ? $instance['category'] : '' );
		$show_thumb = ( isset($instance['thumb']) ? $instance['thumb'] : false );
		$show_price = ( isset($instance['price']) ? $instance['price'] : false );

    // The Query
    $query_args = array (
			'posts_per_page' => $post_num,
			'ignore_sticky_posts' => 1,
			'orderby' => 'meta_value_num',
			'meta_key' => '_tz_views',
			'order' => $order,
			'post_type' => 'post',
			'post_status' => 'publish',
			'cat' => $categories
		);

		$the_query = new WP_Query( $query_args );

		echo $before_widget;
		if ($title) { echo $before_title . esc_attr($title) . $after_title; }

		if ( $the_query->have_posts() ) {
			echo '<ul class="posts-list">';
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				// Frontend Output ?>
				<li>

					<?php if ( $show_thumb && has_post_thumbnail() ) : ?>
					<div class="thumb-wrapper">
						<a rel="bookmark" href="<?php esc_url(the_permalink()); ?>" title="<?php esc_html_e('Click to learn more about ', 'tz-feature-pack') . esc_attr(the_title()); ?>">
							<?php the_post_thumbnail('thumbnail'); ?>
						</a>
					</div>
					<?php endif; // Post Thumbnail ?>

					<div class="content-wrapper">
						<h4>
							<a href="<?php esc_url(the_permalink()); ?>" rel="bookmark" title="<?php esc_html_e('Click to learn more about ', 'tz-feature-pack') . esc_attr(the_title()); ?>"><?php esc_attr(the_title()); ?></a>
						</h4>

						<?php if ($show_date || $show_comments) : ?>
						<div class="entry-meta">

							<?php if ($show_date) :?>
								<div class="post-date"><?php the_date(); ?></div>
							<?php endif; // Post Date ?>

							<?php if ($show_comments) :?>
								<div class="comments-qty"><i class="icon-comments"></i><?php comments_popup_link( esc_html__('No comments', 'tz-feature-pack'), esc_html__('1 comment', 'tz-feature-pack'), esc_html__('% comments', 'tz-feature-pack'), 'comments-link', esc_html__('Closed', 'tz-feature-pack') ); ?></div>
							<?php endif; // Post Comments ?>

							<div class="views-qty"><i class="icon-eye"></i><?php printf( esc_html( _n( '%1$s View', '%1$s Views', get_post_meta($post->ID,'views',true), 'tz-feature-pack' ) ), number_format_i18n( get_post_meta($post->ID,'_tz_views',true) ) ); ?></div>

						</div>
						<?php endif; ?>
					</div>

				</li>
			<?php
			endwhile;
			echo '</ul>';
		} else {
			esc_html_e('No posts found', 'tz-feature-pack');
		}

		echo $after_widget;
		wp_reset_postdata();
	}
}
