<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/includes
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
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/includes
 * @author     Your Name <email@example.com>
 */
class Dh_Custom_Login {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dh_Custom_Login_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $dh_custom_login    The string used to uniquely identify this plugin.
	 */
	protected $dh_custom_login;

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
		if ( defined( 'DH_CUSTOM_LOGIN_VERSION' ) ) {
			$this->version = DH_CUSTOM_LOGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->dh_custom_login = 'dh-custom-login';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

		// remember that if you didn't have this option,
		// the users login page would be disabled as soon as 
		// they activate the plugin, even though new login page
		// has not yet been created
		if (get_option('dhcl_enabled')) {
			$this->define_public_hooks();
		}
		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dh_Custom_Login_Loader. Orchestrates the hooks of the plugin.
	 * - Dh_Custom_Login_i18n. Defines internationalization functionality.
	 * - Dh_Custom_Login_Admin. Defines all hooks for the admin area.
	 * - Dh_Custom_Login_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dh-custom-login-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dh-custom-login-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dh-custom-login-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dh-custom-login-public.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/plugin-settings-template-callback.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin-field-outputter.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-default-page-content.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-login-shortcodes.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-registration-shortcodes.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-custom-registration-endpoint.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-custom-login-endpoint.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-dh-redirects.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-password-reset-endpoints.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-pass-email-shortcodes.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-password-reset-shortcodes.php';

		$this->loader = new Dh_Custom_Login_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dh_Custom_Login_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dh_Custom_Login_i18n();

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

		$plugin_admin = new Dh_Custom_Login_Admin( $this->get_dh_custom_login(), $this->get_version() );

		// only enqueue admin styles and scripts if we're on our settings page
		if (isset($_GET['page']) && $_GET['page'] === 'dh_custom_login') { 
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		}
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_admin_page');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'setup_admin_page_sections');

		$this->loader->add_action( 'wp_ajax_dhcl_create_default_pages', $plugin_admin, 'create_default_pages');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dh_Custom_Login_Public( $this->get_dh_custom_login(), $this->get_version() );

		// only enqueue scripts and styles if we're on a page where they're needed
		$request = parse_url($_SERVER['REQUEST_URI']);
		if (array_key_exists('path', $request) && $plugin_public->page_match($request)) {
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		}

		// hide admin bar for non admin users
		$this->loader->add_action('after_setup_theme', $plugin_public, 'remove_admin_bar');

		// custom registration / login / logout
		$this->loader->add_action('wp_ajax_nopriv_dhcl_create_account', $plugin_public->dh_custom_registration_endpoint, 'create_account');
		$this->loader->add_action('wp_ajax_nopriv_dhcl_login', $plugin_public->dh_custom_login_endpoint, 'login');
		$this->loader->add_action('wp_ajax_dhcl_login', $plugin_public->dh_custom_login_endpoint, 'login');

		// custom password reset
		$this->loader->add_action('wp_ajax_nopriv_dhcl_send_password_reset_email', $plugin_public->password_reset, 'send_password_reset_email');
		$this->loader->add_action('wp_ajax_nopriv_dhcl_reset_password', $plugin_public->password_reset, 'reset_password');

		// disable auto insertion of <p> tags by wordpress
		$this->loader->add_filter('the_content', $plugin_public, 'conditionally_disable_wpautop', 9);

		// redirects for wp-login.php etc
		$this->loader->add_action('plugins_loaded', $plugin_public->dh_redirects, 'plugins_loaded');
		$this->loader->add_filter('site_option_welcome_email', $plugin_public->dh_redirects, 'welcome_email');
		$this->loader->add_action('template_redirect', $plugin_public->dh_redirects, 'wps_hide_login_redirect_page_email_notif_woocommerce');
		$this->loader->add_filter('user_request_action_email_content', $plugin_public->dh_redirects, 'user_request_action_email_content', 999, 2);

		// login shortcodes
		add_shortcode('dh_login_form_opening', [$plugin_public->login_shortcodes, 'login_form_opening']);
		add_shortcode('dh_login_form_closing', [$plugin_public->login_shortcodes, 'login_form_closing']);
		add_shortcode('dh_login_username_input', [$plugin_public->login_shortcodes, 'login_username_input']);
		add_shortcode('dh_login_password_input', [$plugin_public->login_shortcodes, 'login_password_input']);
		add_shortcode('dh_form_messages', [$plugin_public->login_shortcodes, 'form_messages']);
		add_shortcode('dh_forgot_password_link_open', [$plugin_public->login_shortcodes, 'forgot_password_link_open']);
		add_shortcode('dh_forgot_password_link_close', [$plugin_public->login_shortcodes, 'forgot_password_link_close']);
		add_shortcode('dh_signup_link_open', [$plugin_public->login_shortcodes, 'signup_link_open']);
		add_shortcode('dh_signup_link_close', [$plugin_public->login_shortcodes, 'signup_link_close']);

		// register shortcodes
		add_shortcode('dh_registration_form_opening', [$plugin_public->registration_shortcodes, 'form_opening']);
		add_shortcode('dh_registration_username_input', [$plugin_public->registration_shortcodes, 'username_input']);
		add_shortcode('dh_registration_email_input', [$plugin_public->registration_shortcodes, 'email_input']);
		add_shortcode('dh_registration_password_input', [$plugin_public->registration_shortcodes, 'password_input']);
		add_shortcode('dh_registration_form_closing', [$plugin_public->registration_shortcodes, 'form_closing']);

		// pass reset email shortcodes
		add_shortcode('dh_pass_reset_email_form_opening', [$plugin_public->pass_email_shortcodes, 'form_opening']);
		add_shortcode('dh_pass_reset_email_input', [$plugin_public->pass_email_shortcodes, 'email_input']);
		add_shortcode('dh_pass_reset_email_form_closing', [$plugin_public->pass_email_shortcodes, 'form_closing']);

		// pass reset shortcodes
		add_shortcode('dh_rest_password_form_opening', [$plugin_public->reset_password_shortcodes, 'form_opening']);
		add_shortcode('dh_rest_password_password_input', [$plugin_public->reset_password_shortcodes, 'password_input']);
		add_shortcode('dh_rest_password_form_closing', [$plugin_public->reset_password_shortcodes, 'form_closing']);

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
	public function get_dh_custom_login() {
		return $this->dh_custom_login;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dh_Custom_Login_Loader    Orchestrates the hooks of the plugin.
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

}
