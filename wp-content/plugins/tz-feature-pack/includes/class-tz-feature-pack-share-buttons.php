<?php
/*
 * Themes Zone Share buttons System
 */

if ( !get_theme_mod( 'site_shares_system', true ) ) {
 return false;
}

class tz_share_buttons {

	public function get_all_buttons() {
		$included_socialnets = get_theme_mod( 'site_shares_socials', array( 'facebook', 'twitter', 'google', 'pinterest', 'linkedin', 'vk', 'tumblr', 'mail' ) );
		foreach ($included_socialnets as $soc_net) {
			$button_array[] = self::build_share_button($soc_net);
            $shares_array[] = self::get_share_count($soc_net);
		}

    $shares_total = array_sum($shares_array);
    if ( class_exists('WooCommerce') && is_product() ) {
      return '<div class="tz-social-links"><span class="heading">'.esc_html__('Share ', 'tz-feature-pack').'('.esc_html($shares_total).')</span><div class="wrapper">'.implode('', $button_array).'</div></div>';
    } else {
      return '<div class="tz-social-links"><span class="heading"><i class="share-icon"></i>'.esc_html__('Share ', 'tz-feature-pack').'('.esc_html($shares_total).')</span><div class="wrapper">'.implode('', $button_array).'</div></div>';
    }
	}

  public function get_total_shares_count() {
    $included_socialnets = get_theme_mod( 'site_shares_socials', array( 'facebook', 'twitter', 'google', 'pinterest', 'linkedin', 'vk', 'tumblr', 'mail' ) );
    foreach ($included_socialnets as $soc_net) {
      $shares_array[] = self::get_share_count($soc_net);
    }
    $shares_total = array_sum($shares_array);
    return '<div class="tz-shares_counter"><i class="share-icon"></i>'.esc_attr($shares_total).'</div>';
  }

	private function build_share_button($soc_net) {
		$charmap = array(
			'facebook' => 'facebook',
			'twitter' => 'twitter',
			'pinterest' => 'pinterest',
			'google' => 'google-plus',
			'mail' => 'envelope',
			'linkedin' => 'linkedin',
			'vk' => 'vk',
			'tumblr' => 'tumblr',
		);
		$titlemap = array(
			'facebook' => esc_html__('Share this article on Facebook', 'tz-feature-pack'),
			'twitter' => esc_html__('Share this article on Twitter', 'tz-feature-pack'),
			'pinterest' => esc_html__('Share an image on Pinterest', 'tz-feature-pack'),
			'google' => esc_html__('Share this article on Google+', 'tz-feature-pack'),
			'mail' => esc_html__('Email this article to a friend', 'tz-feature-pack'),
			'linkedin' => esc_html__('Share this article on LinkedIn', 'tz-feature-pack'),
			'vk' => esc_html__('Share this article on Vkontakte', 'tz-feature-pack'),
			'tumblr' => esc_html__('Share this article on Tumblr', 'tz-feature-pack'),
		);

    if ( class_exists('Woocommerce') && is_product() ) {
      return '<a class="post-share-button" data-service="'.esc_attr($soc_net).'" data-postID="'.get_the_ID().'" href="'.$this->get_social_url($soc_net).'" target="_blank" title="'.esc_attr($titlemap[$soc_net]).'">
                <i class="fa fa-'.esc_attr($charmap[$soc_net]).'"></i><small class="sharecount">'.esc_html__('Total: ', 'tz-feature-pack').esc_html($this->get_share_count($soc_net)).'</small>
              </a>';
    } else {
		  return '<a class="post-share-button '.esc_attr($soc_net).'" data-service="'.esc_attr($soc_net).'" data-postID="'.get_the_ID().'" href="'.$this->get_social_url($soc_net).'" target="_blank" title="'.esc_attr($titlemap[$soc_net]).'">
							'.esc_html__('Share with ', 'tz-feature-pack').'<i class="fa fa-'.esc_attr($charmap[$soc_net]).'"></i><span class="sharecount">'.esc_html($this->get_share_count($soc_net)).'</span>
						  </a>';
    }
	}

	private function get_social_url($soc_net) {
		global $post;
		$text = urlencode(esc_html__('A great post: ', 'tz-feature-pack').$post->post_title);
		$escaped_url = urlencode(get_permalink());
		$image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) : '';

		switch ($soc_net) {
			case "twitter" :
				$api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer='.$escaped_url.'&amp;text='.esc_attr($text).'&amp;url='.$escaped_url;
				break;

			case "facebook" :
				$api_link = 'https://www.facebook.com/sharer/sharer.php?u='.$escaped_url;
				break;

			case "google" :
				$api_link = 'https://plus.google.com/share?url='.$escaped_url;
				break;

			case "pinterest" :
				if (isset($image) && $image != '') {
					$api_link = 'http://pinterest.com/pin/create/bookmarklet/?media='.esc_url($image[0]).'&amp;url='.$escaped_url.'&amp;title='.esc_attr(get_the_title()).'&amp;description='.esc_html( $post->post_excerpt );
				}
				else {
					$api_link = "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
				}
				break;

			case "mail" :
				$subject = esc_html__('Check this!', 'tz-feature-pack');
				$body = esc_html__('See more at: ', 'tz-feature-pack');
				$api_link = 'mailto:?subject='.str_replace('&amp;','%26',rawurlencode($subject)).'&body='.str_replace('&amp;','%26',rawurlencode($body).$escaped_url);
				break;

			case "linkedin" :
				$api_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$escaped_url.'&title='.$text;
				break;

			case "vk" :
				$api_link = 'http://vk.com/share.php?url='.$escaped_url.'&title='.$text.'&noparse=true';
				break;

			case "tumblr" :
				$api_link = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$escaped_url.'&title='.$text;
				break;
		}

		return $api_link;
	}

	private function get_share_count($soc_net) {
		$count = get_post_meta( get_the_ID(), "_post_".$soc_net."_shares", true ); // get post shares
		if( empty( $count ) ) {
			add_post_meta( get_the_ID(), "_post_".$soc_net."_shares", 0, true ); // create post shares meta if not exist
			$count = 0;
		}
		return $count;
	}
}

/* Frontend output */
function tz_share_buttons_output() {
	if (!is_feed() && !is_home()) {
		$my_buttons = new tz_share_buttons;
		$out = $my_buttons->get_all_buttons();
	}
	echo $out;
}

/* Shares counter output */
function tz_shares_counter() {
	if (!is_feed() && !is_home()) {
		$my_buttons = new tz_share_buttons;
		$out = $my_buttons->get_total_shares_count();
	}
	return $out;
}

/* Enqueue scripts */
function tz_share_scripts() {
	wp_enqueue_script( 'tz-share-buttons', TZ_FEATURE_PACK_URL . '/public/js/post-share.js', array('jquery'), '1.0', true );
	wp_localize_script( 'tz-share-buttons', 'ajax_var', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' )
		)
	);
}
add_action( 'init', 'tz_share_scripts' );

/* Share post counters */
add_action( 'wp_ajax_nopriv_tz_post_share_count', 'tz_post_share_count' );
add_action( 'wp_ajax_tz_post_share_count', 'tz_post_share_count' );

function tz_post_share_count() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ();

	$post_id = $_POST['post_id']; // post id
	$service = $_POST['service'];
	$count = get_post_meta( $post_id, "_post_".$service."_shares", true ); // post like count

	if ( function_exists ( 'wp_cache_post_change' ) ) { // invalidate WP Super Cache if exists
		$GLOBALS["super_cache_enabled"]=1;
		wp_cache_post_change( $post_id );
	}
	update_post_meta( $post_id, "_post_".$service."_shares", ++$count ); // +1 count post meta
	echo esc_attr($count); // update count on front end

	die();
}
