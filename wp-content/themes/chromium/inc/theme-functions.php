<?php /*------- Theme Extra Functions ----------*/

/* Contents:
 * - Layout Extra Classes for body
 * - Post meta functions
 * - Custom Fields for Blog Posts
 * - Page title function
 * - Wrap first word of widget title into a span tag
 * - MailChimp widget update placeholder
 * - Custom background colorpicker metabox for Pages
 * - Yoast Breadcrumbs integration
 * - Convert Comment Time to Time ago
 * - Special walker class for comments
 * - Output search results counter on Search Results
 * - Add filter taxonomy for Attachments
 * - Wrap default widget counts into <span>
 * - Scroll to top button
 * - Custom Post Galleries Output
 */

 /* Layout Extra Classes for body */
 if ( !function_exists('chromium_layout_extra_classes_for_body') ) {
  function chromium_layout_extra_classes_for_body( $classes ) {
    /* Get Site Layout */
    $site_layout = get_theme_mod( 'site_layout', 'boxed' );
    switch ( $site_layout ) {
      case 'boxed':
        $classes[] = 'site-boxed';
      break;
      case 'full':
        $classes[] = 'site-fullwidth';
      break;
    }
    /* Get logo position */
  	$logo_position = get_theme_mod( 'site_logo_position', 'left' );
    switch ( $logo_position ) {
      case 'left':
        $classes[] = 'logo-pos-left';
      break;
      case 'right':
        $classes[] = 'logo-pos-right';
      break;
      case 'center-inside':
        $classes[] = 'logo-pos-center-inside';
      break;
      case 'center-above':
        $classes[] = 'logo-pos-center-above';
      break;
    }
    /* Get Blog layout */
    if ( 'style-2' == get_theme_mod( 'blog_style', 'style-1' ) ) {
      $classes[] = 'blog-style-2';
    } else {
        $classes[] = 'blog-style-default';
    }
    /* Get Blog layout */
    if ( get_theme_mod( 'grid_blog', false ) ) {
      $classes[] = 'blog-grid-posts';
      $classes[] = get_theme_mod( 'blog_grid_cols', 'col-3' );
    }
    /* Gallery Template classes */
    if ( get_theme_mod( 'gallery_fullwidth', true ) && is_page_template( 'page-templates/gallery-page.php' ) ) {
      $classes[] = 'gallery-fullwidth';
    }

    return $classes;
  }
  add_filter( 'body_class', 'chromium_layout_extra_classes_for_body' );
 }


if ( ! function_exists( 'chromium_chromify_title' ) ) :

    function chromium_chromify_title( $title ){
        if ( ! $title ) return;
        return preg_replace('/(?<=\>)\b\w*\b|^\w*\b/', '<span>$0</span>', $title);
    }

endif;
 /* Post meta functions */
 // Entry publication time
 if (!function_exists('chromium_entry_publication_time')) {
   function chromium_entry_publication_time() {
     echo '<div class="time-wrapper"><span class="label">'.esc_html__('on ', 'chromium').'</span>';
     echo '<time class="entry-date" datetime="'.esc_attr( get_the_date('c') ).'" itemprop="datePublished">'.esc_html( get_the_date() ).'</time>';
     echo '</div>';
     $last_modified_time = get_the_modified_date();
     if ($last_modified_time && $last_modified_time!='') {
        echo '<meta itemprop="dateModified" content="'. esc_attr($last_modified_time) .'">';
     }
   }
 }

 // Entry post author
 if ( ! function_exists( 'chromium_entry_author' ) ) {
   function chromium_entry_author() {
       printf( '<div class="post-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">'.esc_html__(' by ', 'chromium').'<a href="%1$s" title="%2$s" rel="author" itemprop="url"><span itemprop="name">%3$s</span></a></div>',
         esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
         esc_attr( sprintf( __( 'View all posts by %s', 'chromium' ), get_the_author() ) ),
         get_the_author()

       );
       echo '<span itemprop="publisher" itemscope="itemscope" itemtype="https://schema.org/Organization">
             <meta itemprop="name" content="'.esc_attr(get_bloginfo('name')).'">
             <meta itemprop="url" content="'.esc_url(home_url()).'">';
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = '';
      if ($custom_logo_id && $custom_logo_id!='') {
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      }
      if ( is_array($logo) ) {
        echo '<span itemprop="logo" itemscope="itemscope" itemtype="http://schema.org/ImageObject"><meta itemprop="url" content="'.esc_url($logo[0]).'"></span>';
      }
       echo '</span>';
   }
 }

 // Entry post categories
 if ( ! function_exists( 'chromium_entry_post_cats' ) ) {
   function chromium_entry_post_cats() {
       $categories_list = get_the_category_list( ', ' );
       if ( $categories_list ) {
         echo '<div class="post-cats" itemprop="articleSection"><span class="label">'.esc_html__('Categories: ', 'chromium').'</span>'.$categories_list.'</div>'; }
   }
 }

 // Entry post tags
 if ( ! function_exists( 'chromium_entry_post_tags' ) ) {
   function chromium_entry_post_tags() {
       $tag_list = get_the_tag_list( '',', ' );
       if ( is_single() ) {
         $tag_list = get_the_tag_list( '',' ' );
       }
       if ( $tag_list ) { echo '<div class="post-tags"><span class="label">'.esc_html__('Tags: ', 'chromium').'</span>'.$tag_list.'</div>'; }
   }
 }

 // Comments counter
 if ( ! function_exists( 'chromium_entry_comments_counter' ) ) {
   function chromium_entry_comments_counter( $post_id ) {
    $html_output = '<div class="post-comments" itemprop="interactionCount"><i class="chromium-icon-comments"></i>';
    $html_output .=  number_format_i18n( get_comments_number($post_id) );
    $html_output .=  '</div>';
    return $html_output;
   }
 }


 /* Custom Fields for Blog Posts */
 // Custom field "Label" for blog posts
 if ( ! function_exists( 'chromium_entry_custom_label' ) ) {
   function chromium_entry_custom_label($post_id) {
     $saved_label = get_post_meta( $post_id, 'chromium_post_custom_label', true);
     if ( !$saved_label ) {
       add_post_meta($post_id, 'chromium_post_custom_label', '', true);
     } else {
       echo '<span class="custom-post-label">'.esc_html($saved_label).'</span>';
     }
   }
 }

 // Custom field "Featured Video" for video post format
 if ( ! function_exists( 'chromium_add_iframe_tags' ) ) {
  function chromium_add_iframe_tags( $allowedposttags ) {
    $allowedposttags['iframe']=array(
      'align' => true,
      'width' => true,
      'height' => true,
      'frameborder' => true,
      'name' => true,
      'src' => true,
      'id' => true,
      'class' => true,
      'style' => true,
      'scrolling' => true,
      'marginwidth' => true,
      'marginheight' => true,
      'allowfullscreen' => true,
      'mozallowfullscreen' => true,
      'webkitallowfullscreen' => true,
    );
    return $allowedposttags;
  }
  add_filter( 'wp_kses_allowed_html', 'chromium_add_iframe_tags',1,1 );
 }
 if ( ! function_exists( 'chromium_entry_featured_video' ) ) {
   function chromium_entry_featured_video($post_id) {
     global $wp_embed;
     $saved_video = get_post_meta( $post_id, 'chromium_featured_video', true);
     if ( ! $saved_video ) {
       add_post_meta($post_id, 'chromium_featured_video', '', true);
     } else {
      $shortcode = '[embed width="870" height="490"]'.esc_url($saved_video).'[/embed]';
      $iframe = $wp_embed->run_shortcode( $shortcode );
      echo wp_kses_post($iframe);
     }
   }
 }

 // Custom field "Featured Quote" for quote post format
 if ( ! function_exists( 'chromium_entry_featured_quote' ) ) {
   function chromium_entry_featured_quote($post_id) {
     $saved_quote = get_post_meta( $post_id, 'chromium_featured_quote', true);
     if ( !$saved_quote ) {
       add_post_meta($post_id, 'chromium_featured_quote', '', true);
     } else {
       echo '<div class="quote-wrapper"><i class="chromium-icon-left-quote">'.strip_tags($saved_quote, '<br>').'</i></div>';
     }
   }
 }


 /* Page title function */
 if (!function_exists('chromium_output_page_title')) {
 	function chromium_output_page_title() {
 			// Archives
 			if ( is_archive() ) {
        echo '<div class="page-title">';
        echo chromium_chromify_title(get_the_archive_title());
        echo '</div>';
 			}
 			// 404
 			elseif ( is_404() ) {
        echo '<div class="page-title">';
 				esc_html_e( '404', 'chromium' );
        echo '</div>';
 			}
 			// Search
 			elseif ( is_search() ) {
        echo '<div class="page-title">';
 				printf( esc_html__( 'Search Results for: %s', 'chromium' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
        echo '</div>';
 			}
 			// Blog
 			elseif ( is_home() ) {
        echo '<div class="page-title">';
 				esc_html_e( 'BLOG', 'chromium' );
        echo '</div>';
 			}
 			elseif ( is_home() && get_option( 'page_for_posts' ) ) {
        echo '<div class="page-title">';
 				echo chromium_chromify_title( get_the_title( get_option( 'page_for_posts' ) ) );
        echo '</div>';
 			}
      // Front Page
      elseif ( is_page() && is_front_page() ) {
        return;
      }
      // Page
 			else {
        echo '<h2 class="page-title">';
        echo chromium_chromify_title( get_the_title() );
        echo '</h2>';
 			}
 	 }
 }


 /* Wrap first word of widget title into a span tag */
 if (!function_exists('chromium_add_span_to_title')) {
   function chromium_add_span_to_title( $old_title ) {
     $title = explode( " ", $old_title, 2 );
     if ( isset( $title[0] ) && isset( $title[1] ) ) {
       $titleNew = "<span>$title[0]</span> $title[1]";
     } else {
       return false;
     }
     return $titleNew;
   }
   /* Add filter to tz shortcodes title */
   add_filter ( 'tz-feature-pack-shortcode-title', 'chromium_add_span_to_title' );
   /* Add Filter to single post titles */
   add_filter ( 'chromium-single-post-titles', 'chromium_add_span_to_title' );
 }


 /* MailChimp widget update placeholder */
 if ( class_exists('mailchimpSF_Widget') ) {
 	$new_options = get_option('mc_merge_vars');
 	if ( $new_options ) {
 		$new_options[0]['default_value'] = esc_html__('Enter Your E-Mail Here', 'chromium');
 		update_option('mc_merge_vars', $new_options);
 	}
 }


  /* Yoast Breadcrumbs integration */
  if (!function_exists('chromium_yoast_breadcrumbs')) {
    function chromium_yoast_breadcrumbs() {
      if ( class_exists('WooCommerce') ) {
        if ( !is_front_page() && !is_woocommerce() ) {
          echo '<div class="site-breadcrumbs"><!-- Site Breadcrumbs -->';
          yoast_breadcrumb('<p id="breadcrumbs">','</p>');
          echo '</div><!-- end of Site Breadcrumbs -->';
        }
      } else {
        if ( !is_front_page() ) {
          echo '<div class="site-breadcrumbs"><!-- Site Breadcrumbs -->';
          yoast_breadcrumb('<p id="breadcrumbs">','</p>');
          echo '</div><!-- end of Site Breadcrumbs -->';
        }
      }
    }
  }


  /* Convert Comment Time to Time ago */
  if (!function_exists('chromium_time_ago')) {
    function chromium_time_ago($time_ago) {
      $time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
      $time  = time() - $time_ago;

      switch($time):
        // seconds
        case $time <= 60;
        return esc_html__('less than a minute ago', 'chromium');
        // minutes
        case $time >= 60 && $time < 3600;
        return (round($time/60) == 1) ? esc_html__('a minute ago', 'chromium') : round($time/60).esc_html__(' minutes ago', 'chromium');
        // hours
        case $time >= 3600 && $time < 86400;
        return (round($time/3600) == 1) ? esc_html__('a hour ago', 'chromium') : round($time/3600).esc_html__(' hours ago', 'chromium');
        // days
        case $time >= 86400 && $time < 604800;
        return (round($time/86400) == 1) ? esc_html__('a day ago', 'chromium') : round($time/86400).esc_html__(' days ago', 'chromium');
        // weeks
        case $time >= 604800 && $time < 2600640;
        return (round($time/604800) == 1) ? esc_html__('a week ago', 'chromium') : round($time/604800).esc_html__(' weeks ago', 'chromium');
        // months
        case $time >= 2600640 && $time < 31207680;
        return (round($time/2600640) == 1) ? esc_html__('a month ago', 'chromium') : round($time/2600640).esc_html__(' months ago', 'chromium');
        // years
        case $time >= 31207680;
        return (round($time/31207680) == 1) ? esc_html__('a year ago', 'chromium') : round($time/31207680).esc_html__(' years ago', 'chromium') ;
      endswitch;
    }
  }


  /* Special walker class for comments */
  if ( ! class_exists('chromium_comments_walker')) {
  	class chromium_comments_walker extends Walker_Comment {
  	    var $tree_type = 'comment';
  	    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

  	    // wrapper for child comments list
  	    function start_lvl( &$output, $depth = 0, $args = array() ) {
  	        $GLOBALS['comment_depth'] = $depth + 1; ?>
  	        <div class="child-comments comments-list">
  	    <?php }

  	    // closing wrapper for child comments list
  	    function end_lvl( &$output, $depth = 0, $args = array() ) {
  	        $GLOBALS['comment_depth'] = $depth + 1; ?>
  	        </div>
  	    <?php }

  	    // HTML for comment template
  	    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
  	      $depth++;
  	      $GLOBALS['comment_depth'] = $depth;
  	      $GLOBALS['comment'] = $comment;
  	      $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
  	      $add_below = 'comment';

  				if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type )	{ ?>
  					<article <?php comment_class( '', $comment ); ?> id="comment-<?php comment_ID() ?>">
  						<header class="comment-meta">
  							<?php esc_html_e( 'Pingback:', 'chromium' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link('Edit','',''); ?>
  						</header>
  				<?php } else { ?>
      	    <article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
      	      <figure class="gravatar"><?php echo get_avatar( $comment, 60, '', esc_html__("Author's gravatar", 'chromium') ); ?></figure>

      	      <header class="comment-meta">
      	        <h2 class="comment-author" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">
      	          <?php if (get_comment_author_url() != '') { ?>
      	            <a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="name"><?php comment_author(); ?></span></a>
      	          <?php } else { ?>
      	            <span class="author" itemprop="name"><?php comment_author(); ?></span>
      	          <?php } ?>
      	        </h2>
      	        <time class="comment-meta-time" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="commentTime"><?php echo ' - ' . chromium_time_ago( get_comment_date() ); ?></time>
                <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                <?php edit_comment_link('Edit','',''); ?>
              </header>

      	      <?php if ($comment->comment_approved == '0') : ?>
      	        <p class="comment-meta-item"><?php esc_html_e('Your comment is awaiting moderation.', 'chromium'); ?></p>
      	      <?php endif; ?>

      	      <div class="comment-content entry-content" itemprop="commentText">
      	        <?php comment_text() ?>
      	      </div>
  				<?php } // end for else ?>

  	    <?php }
  	    // end_el – closing HTML for comment template
  	    function end_el( &$output, $comment, $depth = 0, $args = array() ) { ?>
  	        </article>
  	    <?php }

  	}
  }


  /* Output search results counter on Search Results */
  if ( ! function_exists( 'chromium_output_search_results_counter' ) ) {
    function chromium_output_search_results_counter() {
      global $wp_query;
      echo '<div class="search-counter-wrapper">';
      echo '<p class="msg">';
      printf( esc_html__( "%s result(s) found upon your request. Please attempt another search if you haven't found what you are looking for", 'chromium' ), '<strong>' . esc_html( $wp_query->found_posts ) . '</strong>' );
      echo "</p>";
      // Output search form
      get_search_form();
      echo '</div>';
    }
  }


  /* Wrap default widget counts into <span> */
  if ( ! function_exists( 'chromium_add_count_span' ) ) {
    function chromium_add_count_span($links) {
        $links = str_replace('</a>&nbsp;(', '</a><span class="count">', $links);
        $links = str_replace(')', '</span>', $links);
        return $links;
    }
    add_filter('get_archives_link', 'chromium_add_count_span');

  }



  /* Scroll to top button */
  if ( ! function_exists( 'chromium_add_totop_button' ) ) {
  	function chromium_add_totop_button() {
  		echo '<a href="#" class="to-top" title="'.esc_attr__('Back To Top', 'chromium').'"><i class="chromium-icon-arrow-down mirror"></i></a>';
  	}
  }
  if ( get_theme_mod( 'totop_button', false ) ) {
  	add_action('wp_footer', 'chromium_add_totop_button');
  }


/* Custom Post Galleries Output */
if ( ! function_exists( 'chromium_post_gallery' ) ) {
  function chromium_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    $atts = shortcode_atts( array(
  		'order'      => 'ASC',
  		'orderby'    => 'menu_order ID',
  		'id'         => $post ? $post->ID : 0,
  		'itemtag'    => 'figure',
  		'icontag'    => 'div',
  		'captiontag' => 'figcaption',
  		'columns'    => 3,
  		'size'       => 'thumbnail',
  		'include'    => '',
  		'exclude'    => '',
  		'link'       => ''
  	), $attr, 'gallery' );

    $id = intval( $atts['id'] );

  	if ( ! empty( $atts['include'] ) ) {
  		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

  		$attachments = array();
  		foreach ( $_attachments as $key => $val ) {
  			$attachments[$val->ID] = $_attachments[$key];
  		}
  	} elseif ( ! empty( $atts['exclude'] ) ) {
  		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  	} else {
  		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  	}

  	if ( empty( $attachments ) ) {
  		return '';
  	}

  	$itemtag = tag_escape( $atts['itemtag'] );
  	$captiontag = tag_escape( $atts['captiontag'] );
  	$icontag = tag_escape( $atts['icontag'] );
  	$valid_tags = wp_kses_allowed_html( 'post' );
  	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
  		$itemtag = 'figure';
  	}
  	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
  		$captiontag = 'figcaption';
  	}
  	if ( ! isset( $valid_tags[ $icontag ] ) ) {
  		$icontag = 'div';
  	}

    $columns = intval( $atts['columns'] );

    $popup_class = '';
    if ( $atts['link'] === 'file' ) {
      $popup_class = ' with-popup';
    }

    $output = "<div class='gallery galleryid-{$id} gallery-columns-{$columns}{$popup_class}'>";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {

      $image_output = wp_get_attachment_image( $id, $atts['size'] );

      $output .= "<{$itemtag} class='gallery-item'>";
      if ( $atts['link'] === 'file' ) {
        $output .= "<a class='quick-view' data-src='".esc_url(wp_get_attachment_url($attachment->ID))."' href='".esc_url(wp_get_attachment_url($attachment->ID))."' title='".esc_attr__('Quick View', 'chromium')."' rel='nofollow'>";
      } else {
        $output .= "<a class='link-to-post' rel='bookmark' href='".esc_url(get_permalink($attachment->ID))."' title='".esc_attr__( 'Click to learn more', 'chromium')."'>";
      }
  		$output .= "
  			<{$icontag} class='gallery-icon'>
  				$image_output
  			</{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
           $output .= "
               <{$captiontag} class='wp-caption-text gallery-caption'>
               " . wptexturize($attachment->post_excerpt) . "
               </{$captiontag}>";
        }
  		$output .= "</a></{$itemtag}>";
    }
    $output .= "</div>\n";

    return $output;
  }
  add_filter('post_gallery', 'chromium_post_gallery', 10, 2);
}

if ( ! function_exists( 'chromium_excerpt_more' ) ) :

function chromium_excerpt_more( $more ){
		return '<br/><a class="more-link" href="'. get_permalink() . '">
        '.sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Read More<span class="screen-reader-text"> "%s"</span>', 'chromium' ),
					array(
						'span' => array(
							'class' => array(''),
						),
					)
				),
				get_the_title()
			).'</a>';

    }

	add_filter('excerpt_more', 'chromium_excerpt_more' );

endif;

if ( ! function_exists( 'chromium_continue_reading_text' ) ) :

    function chromium_continue_reading_text(){
        return  esc_html__( 'Read More', 'chromium' );
    }

endif;

if ( ! function_exists( 'chromium_read_more_link' ) ) :

    function chromium_read_more_link() {
        return '';
    }
    add_filter( 'the_content_more_link', 'chromium_read_more_link' );

endif;