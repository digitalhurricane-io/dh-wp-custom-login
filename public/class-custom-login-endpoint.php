<?php 


class DH_Custom_Login_Endpoint {

    private $redirect_to;

    function __construct()
    {
        $this->redirect_to = home_url();
    }

    public function login()
    {
        $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

        if (!wp_verify_nonce($nonce, 'dh_custom_login')) {
            wp_send_json_error("Nonce validation failed");
        }

        if (!isset($_POST['usernameOrEmail'], $_POST['pass'])) {
            wp_send_json_error("Username or email not provided");
        }

        $this->redirect_to = $_POST['redirect_to'];
        $usernameOrEmail = $_POST['usernameOrEmail'];
        $pass = sanitize_text_field($_POST['pass']);

        if (is_email($usernameOrEmail)) {
            // is email, so login with email
            $email = sanitize_email($usernameOrEmail);
            $this->login_with_email($email, $pass);
        } else {
            // is username, so login with username
            $username = sanitize_text_field($usernameOrEmail);
            $this->login_with_username($username, $pass);
        }
    }

    public function login_with_email($email, $password)
    {
        $user = get_user_by('email', $email);

        if (!$user) {
            // user with that email doesn't exist
            wp_send_json_error("User with that email doesn't exist");
        }

        $username = $user->user_login;

        $this->do_login($username, $password);
    }

    public function login_with_username($username, $password)
    {
        $this->do_login($username, $password);
    }

    public function do_login($username, $password)
    {
        $result = wp_signon([ // returns user or wp error
            'user_login' => $username,
            'user_password' => $password,
            'remember' => true
        ], is_ssl());

        if (is_wp_error($result)) {
            wp_send_json_error(wp_strip_all_tags($result->get_error_message()));
        }

        wp_send_json_success();
        //wp_safe_redirect($this->redirect_to);
        die();
    }

}