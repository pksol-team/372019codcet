<?php /* Post views counter function */

if ( !get_theme_mod( 'site_view_counters', true ) ) {
	return false;
}

if ( ! function_exists( 'tz_feature_pack_postviews' ) ) {
  function tz_feature_pack_postviews() {

    /* ------------ Settings -------------- */
    $meta_key       = '_tz_views';  // The meta key field, which will record the number of views.
    $who_count      = 0;            // Whose visit to count? 0 - All of them. 1 - Only the guests. 2 - Only registred users.
    $exclude_bots   = 1;            // Exclude bots, robots, spiders, and other mischief? 0 - no. 1 - yes.

    global $user_ID, $post;
        if(is_singular()) {
            $id = (int)$post->ID;
            static $post_views = false;
            if($post_views) return true;
            $post_views = (int)get_post_meta($id,$meta_key, true);
            $should_count = false;
            switch( (int)$who_count ) {
                case 0: $should_count = true;
                    break;
                case 1:
                    if( (int)$user_ID == 0 )
                        $should_count = true;
                    break;
                case 2:
                    if( (int)$user_ID > 0 )
                        $should_count = true;
                    break;
            }
            if( (int)$exclude_bots==1 && $should_count ){
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                $notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - all equals Mozilla
                $bot = "Bot/|robot|Slurp/|yahoo";
                if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
                    $should_count = false;
            }
            if($should_count)
                if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
        }
        return true;
    }
  add_action('wp_head', 'tz_feature_pack_postviews');
}

/* Post/Products views */
if ( ! function_exists( 'tz_feature_pack_entry_post_views' ) ) {
 function tz_feature_pack_entry_post_views($id) {
   $views = get_post_meta ($id,'_tz_views',true);
   if ($views) {
     return '<div class="post-views"><i class="chromium-icon-view"></i>'.esc_attr($views).'</div>';
   } else {
     return '<div class="post-views"><i class="chromium-icon-view"></i>0</div>';
   }
 }
}
