<?php /* Add Shortcode to output elementor templates */
namespace Elementor;

function tz_output_elementor_template($atts){
    if(!class_exists('Elementor\Plugin')){
        return false;
    }
    if(!isset($atts['id']) || empty($atts['id'])){
        return false;
    }

    $post_id = $atts['id'];
    $response = Plugin::instance()->frontend->get_builder_content_for_display($post_id);
    return $response;
}
add_shortcode('tz-elementor-template','Elementor\tz_output_elementor_template');
