<?php


/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/public
 * @author     Your Name <email@example.com>
 */
class Dh_Custom_Login_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $dh_custom_login    The ID of this plugin.
	 */
	private $dh_custom_login;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	// my class
	public $login_shortcodes;

	// my class
	public $registration_shortcodes;

	// my class, has ajax function for creating user
	public $dh_custom_registration_endpoint;

	// my class, has ajax function for loging in
	public $dh_custom_login_endpoint;

	// my class with redirection code for wp-login
	public $dh_redirects;

	// my class with password reset code
	public $password_reset;

	// my class, pass email form shortcodes
	public $pass_email_shortcodes;

	// my class, reset password shortcodes
	public $reset_password_shortcodes;

	// my class, login / logout / signup button shortcodes
	public $login_logout_button_shortcodes;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $dh_custom_login       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dh_custom_login, $version ) {

		$this->dh_custom_login = $dh_custom_login;
		$this->version = $version;
		$this->login_shortcodes = new DH_Login_Shortcodes();
		$this->registration_shortcodes = new DH_Registration_Shortcodes();
		$this->dh_custom_registration_endpoint = new DH_Custom_Registration();
		$this->dh_custom_login_endpoint = new DH_Custom_Login_Endpoint();
		$this->dh_redirects = new DH_Redirects();
		$this->password_reset = new DH_Password_Reset();
		$this->pass_email_shortcodes = new DH_Pass_Email_Shortcodes();
		$this->reset_password_shortcodes = new DH_Reset_Password_Shortcodes();
		$this->login_logout_button_shortcodes = new DH_Login_Logout_Button_Shortcodes();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dh_Custom_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dh_Custom_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if (get_option('dhcl_enqueue_css')) {
			wp_enqueue_style($this->dh_custom_login, plugin_dir_url(__FILE__) . 'css/dh-custom-login-public.css', array("bootstrap"), '1.0.0', 'all');
		}
		

		if (get_option('dhcl_enqueue_bootstrap')) {
			wp_register_style('bootstrap', plugin_dir_url(__FILE__). '/css/bootstrap.min.css', array(), null, 'all');
			wp_enqueue_style('bootstrap');
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dh_Custom_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dh_Custom_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'js/dh-custom-login-public-vanilla.js', array(), $this->version, true );

		if (get_option('dhcl_enqueue_bootstrap')) {
			wp_register_script('bootstrap', plugin_dir_url(__FILE__) . '/js/bootstrap.bundle.min.js', array('jquery'), '4.4.1', true);
			wp_enqueue_script('bootstrap');
		}

	}

	// disable auto insertion of <p> tags by wordpress
	// if we are on any of our custom pages
	public function conditionally_disable_wpautop($content) {

		// check if it's the login or signup page
		$request = parse_url($_SERVER['REQUEST_URI']);
		if (array_key_exists('path', $request) && $this->page_match($request) ) {
			remove_filter('the_content', 'wpautop');
			remove_filter('the_excerpt', 'wpautop');
		 }

		return $content;
	}
	
	// returns true if we're on one of the target pages
	public function page_match($request) {
		$path = untrailingslashit($request['path']);

		$target_paths = [
			'/'.get_option('dhcl_login_slug'),
			'/'.get_option('dhcl_signup_slug'),
			'/'.get_option('dhcl_password_reset_email_slug'),
			'/'.get_option('dhcl_reset_password_slug')
		];

		return in_array($path, $target_paths);
	}

	public function remove_admin_bar()
	{
		if (!current_user_can('administrator')) {
			show_admin_bar(false);
		}
	}
}
