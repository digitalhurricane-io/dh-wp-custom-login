<?php

// a lot of this code was pulled and slightly modified from the plugin WPS Hide Login
// https://github.com/tabrisrp/wps-hide-login

class DH_Custom_Registration {

    public function create_account() {
		$nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

		if (!wp_verify_nonce( $nonce, 'dh_custom_registration' )) {
			wp_send_json_error();
		}

		if (!get_option('users_can_register')) { // a default wp setting in wp admin that determines whether user can register
			wp_send_json_error(["error" => "Registration is closed"]);
		};

		if ( !isset($_POST['username'], $_POST['email'], $_POST['pass'], $_POST['confirm_pass'])) {
			wp_send_json_error(["error" => "Form filled incorrectly"]);
		}

		$username = sanitize_text_field($_POST['username']);
		$email = sanitize_email($_POST['email']);
		$pass = sanitize_text_field($_POST['pass']);
		$confirm_pass = sanitize_text_field($_POST['confirm_pass']);

		if (username_exists($username) || email_exists($email)) {
			wp_send_json_error(['error' => 'Username or email exists']);
		}

		if ($pass != $confirm_pass) {
			wp_send_json_error(['error' => 'Passwords do not match']);
		}

		if (!is_email($email)) {
			wp_send_json_error(['error' => 'Invalid email']);
		}

		$user_id = wp_insert_user([
			'user_login' 	=> $username,
			'user_pass' 	=> $pass,
			'user_email' 	=> $email,
			'user_nicename' => $username
		]);

		if (is_wp_error($user_id)) {
			wp_send_json_error();
		}

		// send user an email with their new credentials
		//wp_new_user_notification($user_id, null, 'user');

		$user = get_user_by('ID', $user_id);

		wp_set_current_user($user_id, $user->user_login);
		wp_set_auth_cookie($user_id);

		do_action('wp_login', $user->user_login, $user);
		
		wp_send_json_success();
	}
}