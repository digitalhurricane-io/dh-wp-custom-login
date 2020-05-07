<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/admin
 * @author     Your Name <email@example.com>
 */
class Dh_Custom_Login_Admin {

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
	 * @param      string    $dh_custom_login       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dh_custom_login, $version ) {

		$this->dh_custom_login = $dh_custom_login;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'css/dh-custom-login-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'js/dh-custom-login-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_admin_page() {

		// add_option('dhcl_login_slug', 'login');
		// add_option('dhcl_signup_slug', 'signup');
		// add_option('dhcl_reset_password_slug', 'reset-password');
		// add_option('dhcl_pass_reset_email_slug', 'password-reset-email');
		//register_setting('dhcl_options_group', 'DH Custom Login', 'myplugin_callback');

		// Add the menu item and page
		$page_title = 'DH Custom Login';
		$menu_title = 'DH Custom Login';
		$capability = 'manage_options';
		$slug = 'dh_custom_login';
		$callback = 'dhcl_settings_page';
		$icon = 'dashicons-admin-plugins';
		$position = 100;

		// top level menu item
		// add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		// sub level menu item
		add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
	}

	public function setup_admin_page_sections() {
		add_settings_section('dhcl_slug_section', 'Page Slugs', array($this, 'section_callback'), 'dh_custom_login');
		add_settings_section('dhcl_other_section', 'Other', array($this, 'section_callback'), 'dh_custom_login');

		$this->setup_admin_page_fields();
	}

	public function setup_admin_page_fields() {
		// default options are set in plugin activator
		// the defaults set here will never actually be used if 
		// there is a default set in the activator function

		$fields = array(
			array(
				'uid' => 'dhcl_login_slug',
				'label' => 'Login',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Slug you will use for your login page.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_signup_slug',
				'label' => 'Sign up',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Slug you will use for your signup page.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_password_reset_email_slug',
				'label' => 'Password Reset Request',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Slug for page where the password reset email request form will be.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_reset_password_slug',
				'label' => 'Reset Password',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Slug for page where user will enter their new password after clicking on link in reset email.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_already_logged_in_redirect',
				'label' => 'Already Logged in Redirect',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Page where user will be redirected if they are already logged in and they try to 
					<br> visit one of the pages listed above. Admins will not be redirected.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_after_logged_in_redirect',
				'label' => 'After Logged in Redirect',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Page where user will be redirected after they login.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),
			array(
				'uid' => 'dhcl_after_signup_in_redirect',
				'label' => 'After Signup Redirect',
				'section' => 'dhcl_slug_section',
				'type' => 'text',
				'supplimental' => 'Page where user will be redirected after they signup.',
				'sanitizer' => 'dhcl_strip_leading_slash_sanitizer',
			),


			array(
				'uid' => 'dhcl_enqueue_bootstrap',
				'label' => 'Enqueue Bootstrap 4',
				'section' => 'dhcl_other_section',
				'type' => 'single_checkbox',
				'supplimental' => 'Check this if you want this plugin to load bootstrap.',
				'default' => 0,
			),
			array(
				'uid' => 'dhcl_enqueue_css',
				'label' => 'Enqueue plugin css',
				'section' => 'dhcl_other_section',
				'type' => 'single_checkbox',
				'supplimental' => 'Check this if you want to load this plugins default css. The default css uses bootstrap.',
				'default' => 1,
			),
			array(
				'uid' => 'dhcl_enabled',
				'label' => 'Custom Login Enabled',
				'section' => 'dhcl_other_section',
				'type' => 'single_checkbox',
				'supplimental' => 'Whether to enable this plugins functionality.',
				'default' => 0,
				'sanitizer' => 'dhcl_admin_single_checkbox_sanitizer'
			),
			array(
				'uid' => 'dhcl_create_pages',
				'label' => 'Create Pages',
				'section' => 'dhcl_slug_section',
				'type' => 'ajax_button',
				'supplimental' => 'This will create 4 pages using the slugs above and fill them with default content.
					<br> If the pages already exist, they will be OVERWRITTEN!!
					<br> You will still need to enable custom login below in order for 
					<br> the pages to be functional.'
			)
		);
		foreach ($fields as $field) {

			add_settings_field($field['uid'], $field['label'], 'dhcl_output_admin_field', 'dh_custom_login', $field['section'], $field);
			if (isset($field['sanitizer'])) {
				register_setting('dh_custom_login', $field['uid'], $field['sanitizer']);
			} else {
				register_setting('dh_custom_login', $field['uid']);
			}
			
		}
	}

	public function section_callback() {
		// this is the section callback. Not doing anything with it. I'll leave it for now.
	}
	
	// ajax function
	// will be called in admin when user want to create default pages
	public function create_default_pages() {
		$this->check_if_authorized();
		
		// https://stackoverflow.com/questions/32314278/how-to-create-a-new-wordpress-page-programmatically

		// The form hasn't been saved yet, so we're using the unsaved values in the POST variable, instead of using get_option
		// form will be submitted after this method returns a success reponse

		// method_name => slug
		$info = [
			'login_page_content' => $_POST['login_slug'],
			'signup_page_content' => $_POST['signup_slug'],
			'pass_reset_request_content' => $_POST['reset_request_slug'],
			'pass_reset_content' => $_POST['reset_password_slug']
		];

		foreach($info as $method_name => $slug) {
			$page = get_page_by_path($slug); // returns wp_post object https://developer.wordpress.org/reference/classes/wp_post/

			$dc = new DH_Default_Page_Content();
			$defaultContent = call_user_func_array([$dc, $method_name], []);
			
			if (isset($page)) { // update page
				$page->post_content = $defaultContent;
				wp_update_post($page);

			} else { // create page

				$args = [
					'comment_status' => 'close',
					'ping_status'    => 'close',
					'post_author'    => 1,
					'post_title'     => $slug,
					'post_name'      => $slug, // will be the actual slug of the page
					'post_status'    => 'publish',
					'post_content'   => $defaultContent,
					'post_type'      => 'page',
				];

				// page-no-title.php
				// this template exists in the theme I'm also making right now.
				// so I'm going to use it if it exists
				$template = get_template_directory() . '/page-no-title.php';
				if (file_exists($template)) {
					$args['page_template'] = 'page-no-title.php';
				}

				$result = wp_insert_post( // wp error or page id
					$args
				);

				if (is_wp_error($result)) {
					wp_send_json_error($result->get_error_message());
				}
			}
			
		}

		return wp_send_json_success();
	}

	/**
	 * Makes sure user has admin permissions. Also check whether nonce is valid.
	 */
	private function check_if_authorized()
	{
		// check if user has admin permissions
		if (!is_super_admin()) {
			wp_die(__('Unauthorized', 'dh-custom-login'));
		}

		// check nonce and kills script if is false
		// need to specify name here
		check_admin_referer();
	}
}
