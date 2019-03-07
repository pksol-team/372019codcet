<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Tz_Feature_Pack
 * @subpackage Tz_Feature_Pack/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tz_Feature_Pack
 * @subpackage Tz_Feature_Pack/public
 * @author     Themes Zone <themes.zonehelp@gmail.com>
 */
class Tz_Feature_Pack_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'tz-public-styles', plugin_dir_url( __FILE__ ) . 'css/tz-feature-pack-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'tz-widget-styles', plugin_dir_url( __FILE__ ) . 'css/frontend-widget-styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'tz-elementor-styles', plugin_dir_url( __FILE__ ) . 'css/elementor-widgets-styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cdn-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tz-feature-pack-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'tz-bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.js', array('jquery'), '3.3.7', true );
		wp_enqueue_script( 'tz-owl-carousel-js', plugin_dir_url( __FILE__ ) . 'js/owl-carousel.js', array('jquery'), '2.2.1', true );
	}

}
