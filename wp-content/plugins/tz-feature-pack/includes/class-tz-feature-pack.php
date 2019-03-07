<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Tz_Feature_Pack
 * @subpackage Tz_Feature_Pack/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tz_Feature_Pack
 * @subpackage Tz_Feature_Pack/includes
 * @author     Themes Zone <themes.zonehelp@gmail.com>
 */
class Tz_Feature_Pack {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tz_Feature_Pack_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'tz-feature-pack';
		$this->version = '1.0.3';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_widget_hooks();
		$this->define_shortcodes_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tz_Feature_Pack_Loader. Orchestrates the hooks of the plugin.
	 * - Tz_Feature_Pack_i18n. Defines internationalization functionality.
	 * - Tz_Feature_Pack_Admin. Defines all hooks for the admin area.
	 * - Tz_Feature_Pack_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tz-feature-pack-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tz-feature-pack-public.php';

		/* Adding widgets */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-cart.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-categories.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-contacts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-hot-offers.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-login.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-most-viewed-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-output-shortcode.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-recent-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-search.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-socials.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-tz-feature-pack-widget-pay-icons.php';



		$this->loader = new Tz_Feature_Pack_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tz_Feature_Pack_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Tz_Feature_Pack_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Tz_Feature_Pack_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Tz_Feature_Pack_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tz_Feature_Pack_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_widget_hooks() {
		$this->loader->add_action( 'widgets_init', $this, 'widgets_init' );
	}

	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function widgets_init() {
		register_widget( 'tz_woo_cart' );
		register_widget( 'tz_categories' );
		register_widget( 'tz_contacts' );
		register_widget( 'tz_hot_offers' );
		register_widget( 'tz_login_register' );
		register_widget( 'tz_most_viewed_posts' );
		register_widget( 'tz_shortcode' );
		register_widget( 'tz_pay_icons' );
		register_widget( 'tz_recent_posts' );
		register_widget( 'tz_search' );
		register_widget( 'tz_socials' );
	}

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shortcodes_hooks() {
		// Register custom widget category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_widget_category' ], 1 );
		$this->loader->add_action('elementor/init', $this, 'load_elementor_widgets');
		$this->loader->add_action( 'plugins_loaded', $this, 'additional_features' );
		$this->loader->add_action( 'elementor/widgets/widgets_registered', $this, 'elementor_widgets_init' );
		$this->loader->add_action( 'elementor/frontend/after_register_scripts', $this, 'elementor_add_js' );
		$this->loader->add_action( 'admin_action_elementor', $this, 'register_wc_hooks' );
	}

	/**
	 * Registers additional functions & features
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function additional_features() {

		/* Adding extra functions */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-login-register.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-share-buttons.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-post-like.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-post-views.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-elementor-shortcode.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-categories-walker.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-taxonomy-imgs.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tz-feature-pack-custom-taxonomies.php';
	}


	/**
	 * @param Tz_Feature_Pack_Loader $loader
	 */
	public function load_elementor_widgets()
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-banner.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-woo-codes.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-product-tabs.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-hoverable-tabs.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-testimonials.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-categories.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-sale-carousel.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-feature-pack-elementor-recent-post.php';
		if ( class_exists( 'WooCommerce' ) ) require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/class-tz-woo-categories-menu.php';
	}

	public function add_widget_category( $elements_manager ) {

		$elements_manager->add_category(
			'themes-zone-elements',
			[
				'title' => esc_html__( 'Themes Zone Widgets', 'dici-feature-pack' ),
				'icon' => 'tz-logo',
			]
		);

	}

	/**
	 * Registers Elementor custom widgets
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function elementor_widgets_init() {

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Banner() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Woo_Codes() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Product_Tabs() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Hoverable_Tabs() );

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Testimonials() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Categories_Grid() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Sale_Carousel() );

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_From_Blog() );

		if ( class_exists( 'WooCommerce' ) ) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TZ_Woo_Categories_Menu() );
	}

	/**
	 * Registers Elementor custom js
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function elementor_add_js() {
		wp_enqueue_script( 'tz-elementor-helper',  plugin_dir_url( __FILE__ ) . '../public/js/elementor-helper.js', [ 'jquery' ], $this->version, true );
	}

	/**
	 * Register Woocommerce hooks
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function register_wc_hooks() {
		if (function_exists( 'WC' )) {
			WC()->frontend_includes();
		}
	}

}
