<?php

require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-login-shortcodes.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-registration-shortcodes.php';

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

	// the url for the login / register page
	private $new_login_slug;

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

	// class
	public $login_shortcodes;

	// class
	public $registration_shortcodes;

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
		$this->new_login_slug = 'login';
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

		wp_enqueue_style( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'css/dh-custom-login-public.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'js/dh-custom-login-public.js', array( 'jquery' ), $this->version, false );

	}

	public function plugins_loaded() {
		$this->hide_wp_login();
	}

	// hides login page
	public function hide_wp_login() {

		// check whether going to signup page and whether it's enabled
		if (strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-signup') !== false // check if wp-signup is in request uri
			|| strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-activate') !== false
			|| strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-login') !== false
			|| strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-register') !== false  // check if wp-activate is in request uri
		) { 

			// user is trying to go to disallowed page
			// we should 404 them
			wp_safe_redirect(home_url('/404'));
			die();
		}
	}

	public function welcome_email($value)
	{
		$login_slug = 'login';
		return $value = str_replace('wp-login.php', trailingslashit($login_slug, $value));
	}

	/**
	 * Update redirect for Woocommerce email notification
	 */
	public function wps_hide_login_redirect_page_email_notif_woocommerce()
	{

		if (!class_exists('WC_Form_Handler')) {
			return false;
		}

		if (!empty($_GET) && isset($_GET['action']) && 'rp' === $_GET['action'] && isset($_GET['key']) && isset($_GET['login'])) {
			wp_redirect($this->get_login_url());
			exit();
		}
	}

	public function user_request_action_email_content($email_text, $email_data)
	{
		$email_text = str_replace('###CONFIRM_URL###', esc_url_raw(str_replace($this->new_login_slug . '/', 'wp-login.php', $email_data['confirm_url'])), $email_text);

		return $email_text;
	}

	public function get_login_url($scheme = null)
	{

		if (get_option('permalink_structure')) {

			return $this->user_trailingslashit(home_url('/', $scheme) . $this->new_login_slug);
		} else {

			return home_url('/', $scheme) . '?' . $this->new_login_slug;
		}
	}

	private function use_trailing_slashes()
	{

		return ('/' === substr(get_option('permalink_structure'), -1, 1));
	}

	private function user_trailingslashit($string)
	{

		return $this->use_trailing_slashes() ? trailingslashit($string) : untrailingslashit($string);
	}
	
}
