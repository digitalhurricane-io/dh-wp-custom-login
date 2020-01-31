<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Dh_Custom_Login
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/dh-custom-login-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dh-custom-login
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PROXY_NETWORK_PRO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dh-custom-login-activator.php
 */
function activate_dh_custom_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dh-custom-login-activator.php';
	Dh_Custom_Login_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dh-custom-login-deactivator.php
 */
function deactivate_dh_custom_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dh-custom-login-deactivator.php';
	Dh_Custom_Login_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dh_custom_login' );
register_deactivation_hook( __FILE__, 'deactivate_dh_custom_login' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dh-custom-login.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dh_custom_login() {

	$plugin = new Dh_Custom_Login();
	$plugin->run();

}
run_dh_custom_login();
