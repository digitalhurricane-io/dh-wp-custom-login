<?php

class DH_Password_Reset
{

    /**
     * Handles sending password retrieval email to user.
     *
     * @since 2.5.0
     *
     * @return bool|WP_Error True: when finish. WP_Error on error
     */
    function send_password_reset_email()
    {

        $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

        if (!wp_verify_nonce($nonce, 'dh_custom_login')) {
            wp_send_json_error("Nonce validation failed");
        }

        $errors = new WP_Error();

        if (empty($_POST['user_login']) || !is_string($_POST['user_login'])) {
            $errors->add('empty_username', __('Enter a username or email address.'));
        } elseif (strpos($_POST['user_login'], '@')) {
            $user_data = get_user_by('email', trim(wp_unslash($_POST['user_login'])));
            if (empty($user_data)) {
                $errors->add('invalid_email', __('There is no account with that username or email address.'));
            }
        } else {
            $login     = trim($_POST['user_login']);
            $user_data = get_user_by('login', $login);
        }

        /**
         * Fires before errors are returned from a password reset request.
         *
         * @since 2.1.0
         * @since 4.4.0 Added the `$errors` parameter.
         *
         * @param WP_Error $errors A WP_Error object containing any errors generated
         *                         by using invalid credentials.
         */
        do_action('lostpassword_post', $errors);

        if ($errors->has_errors()) {
            wp_send_json_error($errors->get_error_message());
        }

        if (!$user_data) {
            $errors->add('invalidcombo', __('There is no account with that username or email address.'));
            wp_send_json_error($errors->get_error_message());
        }

        // Redefining user_login ensures we return the right case in the email.
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;
        $key        = get_password_reset_key($user_data);

        if (is_wp_error($key)) {
            return wp_send_json_error($key->get_error_message());
        }

        if (is_multisite()) {
            $site_name = get_network()->site_name;
        } else {
            /*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
            $site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        }

        $message = __('Someone has requested a password reset for the following account:<br><br>') . "\r\n\r\n";
        /* translators: %s: Site name. */
        $message .= sprintf(__('Site Name: %s<br>'), $site_name) . "\r\n\r\n";
        /* translators: %s: User login. */
        $message .= sprintf(__('Username: %s<br><br>'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email.<br><br>') . "\r\n\r\n";
        $message .= __('To reset your password, click the link below:<br><br>') . "\r\n\r\n";
        
        $message .= '<a href="' . network_site_url( get_option('dhcl_reset_password_slug') . "/?key=$key&login=" . rawurlencode($user_login), 'login') . "\">Reset Password</a>\r\n";

        /* translators: Password reset notification email subject. %s: Site title. */
        $title = sprintf(__('[%s] Password Reset'), $site_name);

        /**
         * Filters the subject of the password reset email.
         *
         * @since 2.8.0
         * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
         *
         * @param string  $title      Default email title.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $title = apply_filters('retrieve_password_title', $title, $user_login, $user_data);

        /**
         * Filters the message body of the password reset mail.
         *
         * If the filtered message is empty, the password reset email will not be sent.
         *
         * @since 2.8.0
         * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
         *
         * @param string  $message    Default mail message.
         * @param string  $key        The activation key.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $message = apply_filters('retrieve_password_message', $message, $key, $user_login, $user_data);
        $headers = array('Content-Type: text/html; charset=UTF-8');

        if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message, $headers)) {
            $errors->add(
                'retrieve_password_email_failure',
                __('The email could not be sent. Site may not be correctly configured to send emails. Get support for resetting your password.')
            );

            wp_send_json_error($errors->get_error_message());
        }

        wp_send_json_success('Check you email!');
    }

    // this will be called on reset pass form submission
    function reset_password()
    {
        $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

        if (!wp_verify_nonce($nonce, 'dh_custom_login')) {
            wp_send_json_error("Nonce validation failed");
        }

        $user = check_password_reset_key($_POST['rp_key'], $_POST['login']);

        if (!$user || is_wp_error($user)) {
            wp_send_json_error('Invalid password reset key');
            exit;
        }

        $errors = new WP_Error();

        /**
         * Fires before the password reset procedure is validated.
         *
         * @since 3.5.0
         *
         * @param object           $errors WP Error object.
         * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
         */
        do_action('validate_password_reset', $errors, $user);

        if ((!$errors->has_errors()) && isset($_POST['password']) && !empty($_POST['password'])) {
            reset_password($user, $_POST['password']);
            // setcookie($rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
            // ** password successfully reset **
            wp_send_json_success("Success!");
            exit;
        }
    }
}

