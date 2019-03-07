<?php /* Recent Posts Widget */

if ( ! defined( 'ABSPATH' ) ) exit;

class tz_collapsing_archive_list extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'tz_collapsing_archive_list',
			esc_html__('TZ Collapsing Archive List', 'tz-feature-pack'),
			array('description' => esc_html__( "Themes Zone special widget. Displaying terms of chosen taxonomy on your site.", 'tz-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => '',
			'post-quantity' => 5,
			'sort-by' => 'date',
			'sort-order' => false,  // DESC
			'date' => false,
			'comments' => false,
			'category' => '',
			'thumb' => false,
			'excerpt' => false,
			'cats' => false,
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
      <label for="<?php echo esc_attr($this->get_field_id("sort-by")); ?>"><?php esc_html_e('Sort by:', 'tz-feature-pack'); ?></label>
        <select class="widefat" id="<?php echo esc_attr($this->get_field_id("sort-by")); ?>" name="<?php echo esc_attr($this->get_field_name("sort-by")); ?>">
          <option value="date" <?php selected( $instance["sort-by"], "date" ); ?>><?php esc_html_e('Date', 'tz-feature-pack'); ?></option>
          <option value="title" <?php selected( $instance["sort-by"], "title" ); ?>><?php esc_html_e('Title', 'tz-feature-pack'); ?></option>
          <option value="comment_count" <?php selected( $instance["sort-by"], "comment_count" ); ?>><?php esc_html_e('Number of comments', 'tz-feature-pack'); ?></option>
					<option value="author" <?php selected( $instance["sort-by"], "author" ); ?>><?php esc_html_e('Author', 'tz-feature-pack'); ?></option>
					<option value="menu_order" <?php selected( $instance["sort-by"], "menu_order" ); ?>><?php esc_html_e('Menu Order (if specified only for pages)', 'tz-feature-pack'); ?></option>
          <option value="rand" <?php selected( $instance["sort-by"], "rand" ); ?>><?php esc_html_e('Random', 'tz-feature-pack'); ?></option>
        </select>
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
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("cats")); ?>" name="<?php echo esc_attr($this->get_field_name("cats")); ?>"<?php checked( (bool) $instance["cats"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("cats")); ?>"><?php esc_html_e( 'Show list of post Categories?', 'tz-feature-pack' ); ?></label>
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
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id("excerpt")); ?>" name="<?php echo esc_attr($this->get_field_name("excerpt")); ?>"<?php checked( (bool) $instance["excerpt"] ); ?> />
      <label for="<?php echo esc_attr($this->get_field_id("excerpt")); ?>"><?php esc_html_e( 'Show post excerpt?', 'tz-feature-pack' ); ?></label>
    </p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post-quantity'] = intval( $new_instance['post-quantity'] );
		$instance['sort-by'] = strip_tags( $new_instance['sort-by'] );
		$instance['sort-order'] = $new_instance['sort-order'];
		$instance['date'] = $new_instance['date'];
		$instance['comments'] = $new_instance['comments'];
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['thumb'] = $new_instance['thumb'];
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['cats'] = $new_instance['cats'];

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);
		global $wpdb, $post;

		$title = apply_filters('widget_title', $instance['title'] );
		$post_num = ( isset($instance['post-quantity']) ? $instance['post-quantity'] : 5 );
		$post_type = 'post';
		$sort_by = ( isset($instance['sort-by']) ? $instance['sort-by'] : 'date' );
		$sort_order = ( isset($instance['sort-order']) ? $instance['sort-order'] : false );
		if ($sort_order) { $order = 'ASC'; } else { $order = 'DESC'; }
		$show_date = ( isset($instance['date']) ? $instance['date'] : false );
		$show_comments = ( isset($instance['comments']) ? $instance['comments'] : false );
		$categories = ( isset($instance['category']) ? $instance['category'] : '' );
		$show_excerpt = ( isset($instance['excerpt']) ? $instance['excerpt'] : false );

		// Excerpt filters
		$new_excerpt_more = create_function('$more', 'return " ";');
		add_filter('excerpt_more', $new_excerpt_more);
		$new_excerpt_length = create_function('$length', 'return 10;');
		add_filter('excerpt_length', $new_excerpt_length);

		$show_thumb = ( isset($instance['thumb']) ? $instance['thumb'] : false );
		$show_cats = ( isset($instance['cats']) ? $instance['cats'] : false );
		$cur_postID = $post->ID;

    // The Query
    $query_args = array (
      'ignore_sticky_posts' => 1,
			'posts_per_page' => $post_num,
			'orderby' => $sort_by,
			'order' => $order,
			'post_type' => $post_type,
			'post_status' => 'publish',
			'cat' => $categories
		);

		$the_query = new WP_Query( $query_args );

		echo $before_widget;

		if ($title) { echo $before_title . esc_attr($title) . $after_title; }

		if ( $the_query->have_posts() ) {

			echo '<ul class="posts-list">';

			while ( $the_query->have_posts() ) :
				$the_query->the_post(); ?>

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
								<div class="post-date"><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?php the_time('M j, Y'); ?></div>
							<?php endif; // Post Date & Author ?>

							<?php if ($show_comments) :?>
								<div class="comments-qty"><i class="fa fa-comments" aria-hidden="true"></i><?php comments_popup_link( esc_html__('No comments', 'tz-feature-pack'), esc_html__('1 comment', 'tz-feature-pack'), esc_html__('% comments', 'tz-feature-pack'), 'comments-link', esc_html__('Closed', 'tz-feature-pack') ); ?></div>
							<?php endif; // Post Comments ?>

						</div>
						<?php endif; ?>

						<?php if ($show_excerpt) : ?>
						<div class="recent-posts-entry-content">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; // Post Content ?>

					</div>
				</li>
			<?php
			endwhile;
			echo '</ul>';

		} else {
			esc_html_e('There are no posts to display', 'tz-feature-pack');
		}

		wp_reset_postdata();
		echo $after_widget;
	}
}
