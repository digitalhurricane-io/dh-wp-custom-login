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

	// public function create_account() {
	// 	$nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	// 	if (!wp_verify_nonce( $nonce, 'dh_auth' )) {
	// 		wp_send_json_error();
	// 	}

	// 	if (!get_option('users_can_register')) { // a default wp setting in wp admin that determines whether user can register
	// 		wp_send_json_error(["error" => "Registration is closed"]);
	// 	};

	// 	if ( !isset($_POST['username'], $_POST['email'], $_POST['pass'], $_POST['confirm_pass'])) {
	// 		wp_send_json_error(["error" => "Form filled incorrectly"]);
	// 	}

	// 	$username = sanitize_text_field($_POST['username']);
	// 	$email = sanitize_email($_POST['email']);
	// 	$pass = sanitize_text_field($_POST['pass']);
	// 	$confirm_pass = sanitize_text_field($_POST['confirm_pass']);

	// 	if (username_exists($username) || email_exists($email)) {
	// 		wp_send_json_error(['error' => 'Username or email exists']);
	// 	}

	// 	if ($pass != $confirm_pass) {
	// 		wp_send_json_error(['error' => 'Passwords do not match']);
	// 	}

	// 	if (!is_email($email)) {
	// 		wp_send_json_error(['error' => 'Invalid email']);
	// 	}

	// 	$user_id = wp_insert_user([
	// 		'user_login' 	=> $username,
	// 		'user_pass' 	=> $pass,
	// 		'user_email' 	=> $email,
	// 		'user_nicename' => $username
	// 	]);

	// 	if (is_wp_error($user_id)) {
	// 		wp_send_json_error();
	// 	}

	// 	// send user an email with their new credentials
	// 	//wp_new_user_notification($user_id, null, 'user');

	// 	$user = get_user_by('ID', $user_id);

	// 	wp_set_current_user($user_id, $user->user_login);
	// 	wp_set_auth_cookie($user_id);

	// 	do_action('wp_login', $user->user_login, $user);
		
	// 	wp_send_json_success();
	// }

	// public function login() {
	// 	$nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	// 	if (!wp_verify_nonce($nonce, 'dh_auth')) {
	// 		wp_send_json_error();
	// 	}

	// 	if (!isset($_POST['usernameOrEmail'], $_POST['pass'])) {
	// 		wp_send_json_error();
	// 	}

	// 	$usernameOrEmail = $_POST['usernameOrEmail'];
	// 	$pass = sanitize_text_field($_POST['pass']);

	// 	if (is_email($usernameOrEmail)) {
	// 		// is email, so login with email
	// 		$email = sanitize_email($usernameOrEmail);
	// 		$this->login_with_email($email, $pass);

	// 	} else {
	// 		// is username, so login with username
	// 		$username = sanitize_text_field($usernameOrEmail);
	// 		$this->login_with_username($username, $pass);
	// 	}

	// }

	// public function login_with_email($email, $password) {
	// 	$user = get_user_by('email', $email);
		
	// 	if (!$user) {
	// 		// user with that email doesn't exist
	// 		wp_send_json_error();
	// 	}

	// 	$username = $user->user_login;

	// 	$this->do_login($username, $password);
	// }

	// public function login_with_username($username, $password) {
	// 	$this->do_login($username, $password);
	// }

	// public function do_login($username, $password) {
	// 	$result = wp_signon([ // returns user or wp error
	// 		'user_login' => $username,
	// 		'user_password' => $password,
	// 		'remember' => true
	// 	], false);

	// 	if (is_wp_error($result)) {
	// 		wp_send_json_error();
	// 	}

	// 	wp_send_json_success();
	// }

	// public function bootstrap_login_form() {
	// 	$formHTML = wp_login_form(['echo' => false]);
	// }

	// plan is to write shortcodes for each mandatory input field we need

	public function login_form_opening($atts) {
		$vals = shortcode_atts(array(
			'action' => esc_url( site_url( 'wp-login.php', 'login_post' )),
			'name' => 'loginform',
			'id' => 'login-form',
			'class' => '',
		), $atts);

		return '<form method="POST" action="'. esc_attr($vals['action']) .'" name="'. esc_attr($vals['name']) .'" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'">';
	}

	public function login_form_closing($atts) {
		$vals = shortcode_atts(array(
			'partial_redirect_url' => '/wp-admin/'
		), $atts);

		return $this->login_redirect_input(esc_attr($vals['partial_redirect_url'])) . $this->login_test_cookie_input() . '</form>';
	}

	// returns the input field for the username
	// takes shortcode atts of id and a space separated class list
	public function login_username_input($atts) {
		$vals = shortcode_atts(array(
			'id' => 'username',
			'class' => '',
		), $atts);

		return '<input type="text" name="log" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" />'; 
	}

	// returns the input field for the password
	// takes shortcode atts of id and a space separated class list
	public function login_password_input($atts) {
		$vals = shortcode_atts(array(
			'id' => 'password',
			'class' => '',
		), $atts);

		return '<input type="password" name="pwd" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" />';
	}

	public function login_redirect_input($partial_url) {

		$base_url = esc_url(site_url());
		$full_url = $base_url . $partial_url;

		return '<input type="hidden" name="redirect_to" value="'. $full_url .'" />';
	}

	public function login_test_cookie_input() {
		return '<input type="hidden" name="testcookie" value="1" />';
	}
}
