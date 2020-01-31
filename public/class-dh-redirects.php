<?php

class DH_Redirects {

    // the url for the login / register page
    private $new_login_slug;

    public function __construct()
    {
        // IMPORTANT: this is the slug for the login page that you will create in the wordpress admin
        $this->new_login_slug = 'login';
    }

    public function plugins_loaded()
    {
        $this->hide_wp_login();
    }

    // hides login page
    public function hide_wp_login()
    {

        // check whether going to signup page and whether it's enabled
        if (
            strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-signup') !== false // check if wp-signup is in request uri
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