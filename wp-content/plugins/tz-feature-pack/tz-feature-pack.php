<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Themes Zone Feature Pack
 * Plugin URI:        https://themes.zone/feature-pack
 * Description:       Special collection of widgets & shortcodes for Chromium Theme.
 * Version:           1.0.9
 * Author:            Themes Zone
 * Author URI:        https://themes.zone/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tz-feature-pack
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Used for referring to the plugin file or basename
if ( ! defined( 'TZ_FEATURE_PACK_URL' ) ) {
	define( 'TZ_FEATURE_PACK_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tz-feature-pack-activator.php
 */
function activate_tz_feature_pack() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tz-feature-pack-activator.php';
	Tz_Feature_Pack_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tz-feature-pack-deactivator.php
 */
function deactivate_tz_feature_pack() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tz-feature-pack-deactivator.php';
	Tz_Feature_Pack_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tz_feature_pack' );
register_deactivation_hook( __FILE__, 'deactivate_tz_feature_pack' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tz-feature-pack.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tz_feature_pack() {

	$plugin = new Tz_Feature_Pack();
	$plugin->run();

}
run_tz_feature_pack();
