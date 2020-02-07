<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/includes
 * @author     Your Name <email@example.com>
 */
class Dh_Custom_Login_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$activator = new self;
		$activator->add_default_settings();
	}

	public function add_default_settings() {
		// slugs
		add_option('dhcl_login_slug', 'login');
		add_option('dhcl_signup_slug', 'signup');
		add_option('dhcl_password_reset_email_slug', 'password-reset-request');
		add_option('dhcl_reset_password_slug', 'reset-password');
		add_option('dhcl_already_logged_in_redirect', '');
		add_option('dhcl_after_logged_in_redirect', '');
		add_option('dhcl_after_signup_in_redirect', '');

		// other
		add_option('dhcl_enqueue_bootstrap', '0');
		add_option('dhcl_enqueue_css', '1');
		add_option('dhcl_enabled', '0');
	}
}
