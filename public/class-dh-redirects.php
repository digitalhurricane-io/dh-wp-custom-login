<?php

class DH_Redirects {

    // the url for the login / register page
    private $login_slug;

    public function __construct()
    {
        // IMPORTANT: this is the slug for the login page that you will create in the wordpress admin
        $this->login_slug = get_option('dhcl_login_slug');
    }

    public function plugins_loaded()
    {
        $this->hide_wp_login();
        $this->already_logged_in_redirect();
    }

    // if the user is logged in, and they try to visit login page or signup page,
    // they will be redirected to a page specified in admin settings
    public function already_logged_in_redirect() {

        $requestUri = $_SERVER['REQUEST_URI'];
        $request = parse_url($requestUri);

        $path = untrailingslashit($request['path']);

        $login_slug = '/' . get_option('dhcl_login_slug');
        $signup_slug = '/' . get_option('dhcl_signup_slug');
        $pass_reset_request_slug = '/' . get_option('dhcl_password_reset_email_slug');
        $pass_reset_slug = '/' . get_option('dhcl_reset_password_slug');

        $target_paths = [
            $login_slug,
            $signup_slug,
            $pass_reset_request_slug,
            $pass_reset_slug
        ];

        if(in_array($path, $target_paths) && is_user_logged_in()) {
            wp_safe_redirect(site_url('/'.get_option('dhcl_already_logged_in_redirect')));
            die();
        };  

    }

    // hides login page
    public function hide_wp_login()
    {
        // if we are logging out, return
        $request = parse_url($_SERVER['REQUEST_URI']);
        if (array_key_exists('query', $request) && strpos($request["query"], 'action=logout') !== false) {
            // if you are looking at this because you're being redirected to 404 page after logging out,
            // remember to set you logout link redirect link to something else when you output it.
            // for example, the home url.
            // echo wp_logout_url(home_url())
            return;
        }

        if ($this->target_page_match()) {
            // user is trying to go to disallowed page
            // we should 404 them
            wp_safe_redirect(home_url('/404'));
        }
    }

    // returns true if we're heading to one of the target pages
    public function target_page_match()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $request = parse_url($requestUri);

        $match = false;

        $path = untrailingslashit($request['path']);

        $target_paths = [
            '/wp-signup',
            '/wp-activate',
            '/wp-login',
            '/wp-login.php',
            '/wp-register',
        ];

        $match = in_array($path, $target_paths);

        $isWpAdminUri = strpos($requestUri, 'wp-admin') !== false;
        $isAjaxRequest = strpos($requestUri, 'wp-admin/admin-ajax.php') !== false;
        if ($isWpAdminUri && !$isAjaxRequest && !is_super_admin()) {
            $match = true;
        }

        return $match;
    }

    public function welcome_email($value)
    {
        return str_replace('wp-login.php', trailingslashit($this->login_slug), $value);
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
        $email_text = str_replace('###CONFIRM_URL###', esc_url_raw(str_replace($this->login_slug . '/', 'wp-login.php', $email_data['confirm_url'])), $email_text);

        return $email_text;
    }

    public function get_login_url($scheme = null)
    {

        if (get_option('permalink_structure')) {

            return $this->user_trailingslashit(home_url('/', $scheme) . $this->login_slug);
        } else {

            return home_url('/', $scheme) . '?' . $this->login_slug;
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