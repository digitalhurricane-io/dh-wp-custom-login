<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/digitalhurricane-io/dh-wp-custom-login
 * @since             1.0.0
 * @package           Dh_Custom_Login
 *
 * @wordpress-plugin
 * Plugin Name:       DH Custom Login
 * Plugin URI:        https://github.com/digitalhurricane-io/dh-wp-custom-login
 * Description:       Allows you to create custom login pages with html. Also redirects wp-login, etc.
 * Version:           1.1.22
 * Author:            Digital Hurricane
 * Author URI:        https://github.com/digitalhurricane-io/dh-wp-custom-login
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
define( 'DH_CUSTOM_LOGIN_VERSION', '1.1.22' );

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


// UPDATE CHECK
// check gitlab tags vs version at top of this file
require_once 'plugin-update-checker/plugin-update-checker.php';
$doLoginUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/digitalhurricane-io/dh-wp-custom-login',
	__FILE__,
	'dh-wp-custom-login'
);

// add some global functions

// To be used with redirects with the 'template_redirect' hook.
//
// Creates a new url using the given path, with a query parameter named next.
// The 'next' query param value is the path and query params of the url we are 
// navigating to currently, $_SERVER['REQUEST_URI']
// After login or registration is finished, the 'next' query param will be used in the redirect.
function dhcl_create_next_url($newPath) {
	// add slashes if don't exist, format will be /path/
	$newPath = dhcl_pre_slash_it(trailingslashit($newPath));

	$requestUri = $_SERVER['REQUEST_URI'];
	$parsedRequest = parse_url($requestUri);
	$next = '?next=' . $parsedRequest['path'] . '?' . $parsedRequest['query'];

	$pathWithNext = $newPath . $next;
	$finalUrl = site_url($pathWithNext);
	return $finalUrl;
}

// same as above but query params are not passed on
function dhcl_next_url_strip_params($newPath)
{
	// add slashes if don't exist, format will be /path/
	$newPath = dhcl_pre_slash_it(trailingslashit($newPath));

	$requestUri = $_SERVER['REQUEST_URI'];
	$parsedRequest = parse_url($requestUri);
	$next = '?next=' . $parsedRequest['path'];

	$pathWithNext = $newPath . $next;
	$finalUrl = site_url($pathWithNext);
	return $finalUrl;
}

// if url already has a 'next' query param, return it,
// else return null
function dhcl_get_existing_next($parsedUrl) {
	$queryParams = [];
	isset($parsedUrl['query']) ? parse_str($parsedUrl['query'], $queryParams) : '';
	return isset($queryParams['next']) ? $queryParams['next'] : null;
}

// add slash to beginning of string if doesn't exist
function dhcl_pre_slash_it($str) {
	if (mb_substr($str, 0, 1) === '/') {
		return $str;
	}
	return '/' . $str;
}