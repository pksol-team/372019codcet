 <?php
/**
 * Template Name: Gallery Page Template
 */

// Custom Gallery shortcode output
function chromium_gallery( $blank = NULL, $attr ) {

    global $post;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] ) {
          unset( $attr['orderby'] );
        }
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

    /* Get filters array */
    $all_filters = array();
    $categories = get_terms( 'gallery-filter' );
    foreach ( $attachments as $attachment ) {
      $attachment_filters = get_the_terms($attachment, 'gallery-filter');
      if ( is_array($attachment_filters) && !empty($attachment_filters) ) {
        foreach ( $attachment_filters as $single_filter) {
          $all_filters[] = $single_filter->name;
        }
      }
    }
    $all_filters = array_unique($all_filters);
    array_unshift( $all_filters, "phoney", esc_html__("All", 'chromium') );
    unset($all_filters[0]);

    /* Output Filters nav */
    $output_filters_nav = '';
    if ( !empty($all_filters) && count($all_filters) > 1 && true==get_theme_mod( 'gallery_enable_filterizr', true ) ) {
      $output_filters_nav = '<div class="filters-wrapper">';
      $output_filters_nav .= '<ul>';
      foreach($all_filters as $key => $filter){
        if ($key == 1) {
          $output_filters_nav .= '<li class="gallery-filter filtr filtr-active" data-filter="'.esc_attr($key).'">'.esc_html($filter).'</li>';
        } else {
          $output_filters_nav .= '<li class="gallery-filter filtr" data-filter="'.esc_attr($key).'">'.esc_html($filter).'</li>';
        }
        unset($filter);
      }
      $output_filters_nav .= '</ul></div>';
    }

    $columns = intval( $atts['columns'] );

    /* Output Gallery */
    if ( count($all_filters) > 1 && true==get_theme_mod( 'gallery_enable_filterizr', true ) ) {
      $extra_class = "filtr-container galleryid-{$id} gallery-columns-{$columns}";
    } else {
      $extra_class = "galleryid-{$id} gallery-columns-{$columns}";
    }
    $output = "<div id='chromium-gallery' class='{$extra_class}'>";

  	foreach ( $attachments as $id => $attachment ) {

      /* Add responsive classes */
      $layout_class = '';
      switch ($columns) {
          case '2':
              $atts['size'] = 'chromium-gallery-l';
          break;
          case '3':
              $atts['size'] = 'chromium-gallery-m';
          break;
          case '4':
              $atts['size'] = 'chromium-gallery-s';
          break;
      }
      if ( count($all_filters) > 1 ) {
          $layout_class .= ' filtr-item';
      }

  		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "chromium-gallery-$id" ) : '';
  		$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );

      /* Adding special filter args */
      $special_filters = get_the_terms( $id, 'gallery-filter' );
      $filter_arg = '';
      if ( count($all_filters) > 1 ) {
        $filter_arg = ' data-category="1';
        $special_filters_string = '';

        if( is_array($special_filters) && !empty($special_filters) ) {
            $filter_arg .= ', ';
            $special_filter_cleared = array();
            $i = 1;

            foreach($special_filters as $special_filter){
                $special_filter_cleared[] = $special_filter->name;
                $filter_arg .= implode('', array_keys($all_filters, $special_filter->name));
                if ($i == count($special_filters)) {
                  $filter_arg .= '"';
                } else {
                  $filter_arg .= ', ';
                }
                $i++;
            }
        } else {
          $filter_arg .= '"';
        }
      }

  		$output .= "<{$itemtag} class='gallery-item{$layout_class}'{$filter_arg}>";
  		$output .= "
  			<{$icontag} class='gallery-icon'>
  				$image_output
  			</{$icontag}>";
        if ( $captiontag ) {
            $output .= "<{$captiontag} class='gallery-item-description'>";
            $output .= "<h3>" . esc_html( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) . "</h3>";
            $output .= "<p class='btns-wrapper'>
                        <a class='link-to-post' rel='bookmark' href='".esc_url(get_permalink($attachment->ID))."' title='".esc_attr__( 'Click to learn more', 'chromium')."'><i class='chromium-icon-link'></i></a>
                        <a class='quick-view' data-src='".esc_url(wp_get_attachment_url($attachment->ID))."' href='".esc_url(wp_get_attachment_url($attachment->ID))."' title='".esc_attr__('Quick View', 'chromium')."' rel='nofollow'><i class='chromium-icon-plus'></i></a>
                        </p>";
            $output .= "</{$captiontag}>";
        }
  		$output .= "</{$itemtag}>";
  	}

  	$output .= "
  		</div>\n";

  	return $output_filters_nav.$output;
}

add_filter( 'post_gallery', 'chromium_gallery', 10, 2);

get_header(); ?>

	<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

	<?php if ( function_exists('chromium_output_page_title') ) chromium_output_page_title(); ?>

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>

                <?php wp_link_pages( array(
                        'before'      => '<div class="page-links">',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'chromium' ) . ' </span>%',
                        'separator'   => '<span class="screen-reader-text">, </span>',
                ) ); ?>
            <?php endwhile; ?>
        <?php endif; ?>

    </main><!-- end of Main content -->

    <?php get_sidebar(); ?>

<?php get_footer(); ?>