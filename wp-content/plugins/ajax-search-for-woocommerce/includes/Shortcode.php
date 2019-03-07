<?php

namespace DgoraWcas;

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

class Shortcode
{

    public static function register()
    {

        add_shortcode('wcas-search-form', array(__CLASS__, 'addBody'));

    }

    /**
     * Register Woo Ajax Search shortcode
     *
     * @param array $atts bool show_details_box
     */
    public static function addBody($atts)
    {

        $search_args = shortcode_atts(array(
            'class'       => '',
            'bar'         => 'something else',
            'details_box' => 'show'
        ), $atts);

        $search_args['class'] .= empty($search_args['class']) ? 'woocommerce' : ' woocommerce';

        $args = apply_filters('dgwt/wcas/shortcode/args', $search_args);

        return self::getForm($args);
    }

    /**
     * Display search form
     *
     * @param array args
     *
     * @return string
     */

    public static function getForm($args)
    {

        // Enqueue required scripts
        wp_enqueue_script('woocommerce-general');
        wp_enqueue_script('jquery-dgwt-wcas');

        ob_start();
        $filename = apply_filters('dgwt/wcas/form/partial_path', DGWT_WCAS_DIR . 'partials/search-form.php');
        if (file_exists($filename)) {
            include $filename;
        }
        $html = ob_get_clean();

        return apply_filters('dgwt/wcas/form/html', $html, $args);
    }

}
