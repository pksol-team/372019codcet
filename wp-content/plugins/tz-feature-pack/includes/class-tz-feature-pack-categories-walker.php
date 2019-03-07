<?php // ----- New Walker for categories

  /* Special Walker Class for Category Lists */
  if (!class_exists('tz_cats_list_walker')) {

     class tz_cats_list_walker extends Walker {

    	private $curItem;

    	var $db_fields = array ( 'parent' => 'parent', 'id' => 'term_id', 'slug' => 'slug' );

    	public function start_lvl( &$output, $depth = 0, $args = array() ) {
    		if ( 'list' != $args['style'] )
    			return;

    		$indent = str_repeat("\t", $depth);
    		$data = get_object_vars($this->curItem);
    		$parent_id = $data['term_id'];
    		$col_class = '';

    		if ($this->collapsing = true) {
    		 $col_class = ' collapse';
         $expanded_arg = 'false';
    			if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $parent_id, $args['current_category_ancestors'] ) ) {
    			  $col_class .= ' in';
            $expanded_arg = 'true';
         }
    		}

    		$output .= $indent . '<ul id="children-of-' . esc_attr($parent_id) . '" class="children' . esc_attr($col_class) . '" aria-expanded="' . esc_attr($expanded_arg) . '">';
    	}

    	public function end_lvl( &$output, $depth = 0, $args = array() ) {
    		if ( 'list' != $args['style'] )
    			return;

    		$indent = str_repeat("\t", $depth);
    		$output .= $indent . '</ul>';
    	}

    	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
    		$this->curItem = $cat;

    		/* Adding extra classes if needed */
    		$output .= '<li class="cat-item cat-item-' . esc_attr($cat->term_id);
    		if ( $args['current_category'] == $cat->term_id ) {
    			$output .= ' current-cat';
    		}
    		if ( $args['has_children'] && $args['hierarchical'] ) {
    			$output .= ' cat-parent';
    		}
    		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
    			$output .= ' current-cat-parent';
    		}
    		$output .=  '">';

    		/* Output categorie img */
       $image = '';
    		if ($this->show_img == true) {
    			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
    			$image = wp_get_attachment_image( $thumbnail_id, 'thumbnail', false );
    		}

    		if ($image && $image!='') {
    			$output .= '<span class="cat-img-wrap">'.$image.'</span>';
    		}

    		/* Get link to category & Adding extra data to cat anchor */
    		$term_link = get_term_link( (int) $cat->term_id, $cat->taxonomy );
    		if ( is_wp_error( $term_link ) ) {
           return;
       }
    		$output .=  '<a href="' . esc_url($term_link) . '">' . esc_attr($cat->name) . '</a>';

    		/* Adding show subcategories button */
    		if ($this->collapsing = true) {
    			$anchor = '';
    	    if ( $args['has_children'] && $args['hierarchical'] ) {
    				$anchor = '<a href="#children-of-' . esc_attr($cat->term_id) . '" class="show-children collapsed" data-toggle="collapse" aria-controls="children-of-' . esc_attr($cat->term_id) . '" aria-expanded="false"></a>';
    			}
         if ( $args['current_category_ancestors'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
           $anchor = '<a href="#children-of-' . esc_attr($cat->term_id) . '" class="show-children" data-toggle="collapse" aria-controls="children-of-' . esc_attr($cat->term_id) . '" aria-expanded="true"></a>';
         }
    			$output .= $anchor;
    		}

    		/* Adding counter if needed */
    		if ( $args['show_count'] ) {
    			$output .= ' <span class="count">' . esc_attr($cat->count) . '</span>';
    		}
    	}

    	public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
    		$output .= "</li>\n";
    	}

    	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
    		if ( ! $element || 0 === $element->count ) {
    			return;
    		}
    		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    	}
    }
  }
