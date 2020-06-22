<?php

/**
 * Minimal html / shortcodes to create login form on wordpress frontend
 * [dh_login_form_opening]    
 * [dh_login_username_input]   
 * [dh_login_password_input]   
 * <button type="submit">Log In</button>  
 * [dh_login_form_closing]  
 */

class DH_Login_Shortcodes {

    public function login_form_opening($atts)
    {

        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'action' => '/wp-admin/admin-ajax.php?action=dhcl_login',
            'id' => 'login-form',
        ), $original);

        //$form_tag = '<form method="POST" action="' . esc_attr($vals['action']) . '" name="' . esc_attr($vals['name']) . '" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '">';
        $startHtml = '<form method="POST" name="dhclform" ';
        $endHtml = '>';

        $nonce = wp_nonce_field('dh_custom_login', '_wpnonce', true, false);

        $final = $this->set_attributes($startHtml, $endHtml, $mergedAtts) . $nonce;

        return $final;
    }

    public function login_form_closing($atts)
    {

        $redirect_url = site_url();
        $redirect_option = get_option('dhcl_after_logged_in_redirect');

        if (!empty($redirect_option)) {
            $redirect_url = site_url('/'.$redirect_option);

        } else if (isset($atts['relative_redirect_url'])) {
            $redirect_url = site_url(esc_attr($atts['relative_redirect_url']));
        }

        return $this->login_redirect_input($redirect_url) . $this->login_test_cookie_input() . '</form>';
    }

    // returns the input field for the username
    // takes shortcode atts of id and a space separated class list
    public function login_username_input($atts)
    {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'id' => 'username',
        ), $original);

        $startHtml = '<input type="text" name="usernameOrEmail"';
        $endHtml = '/>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    // returns the input field for the password
    // takes shortcode atts of id and a space separated class list
    public function login_password_input($atts)
    {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'id' => 'password',
        ), $original);

        $startHtml = '<input type="password" name="pass"';
        $endHtml = '/>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function login_redirect_input($url)
    {

        // $base_url = esc_url(site_url());
        // $full_url = $base_url . $partial_url;

        return '<input type="hidden" name="redirect_to" value="' . $url . '" />';
    }

    public function login_test_cookie_input()
    {
        return '<input type="hidden" name="testcookie" value="1" />';
    }

    public function forgot_password_link_open($atts) {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'class' => 'dh-forgot-pass-link',
            'href' => site_url(get_option('dhcl_password_reset_email_slug'))
        ), $original);

        $startHtml = '<a';
        $endHtml = '>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function forgot_password_link_close() {
        return '</a>';
    }

    public function signup_link_open($atts) {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'class' => 'dh-sign-up-link',
            'href' => $this->use_next_if_exists(get_option('dhcl_signup_slug'))
        ), $original);

        $startHtml = '<a';
        $endHtml = '>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function signup_link_close() {
        return '</a>';
    }

    public function login_link_open($atts)
    {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'class' => 'dh-login-link',
            'href' => $this->use_next_if_exists(get_option('dhcl_login_slug'))
        ), $original);

        $startHtml = '<a';
        $endHtml = '>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function login_link_close()
    {
        return '</a>';
    }

    /**
     * Takes any attributes passed in the shortcode, and sets them on the html element
     */
    public function set_attributes($startHtml, $endHtml, $atts) {
        foreach($atts as $key => $val) {
            $startHtml = $startHtml . ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
        }
        return $startHtml . ' ' . $endHtml;
    }

    public function form_messages() {
        return '<div id="dh_form_messages"></div>';
    }

    // If the current request uri has a 'next' query param,
    // we want to return a link for the passed in path 
    // that uses the same 'next' query param.
    // So either a link with previous 'next' will be returned,
    // or a link without a 'next' will be returned.
    // This function will for sure be used in the shortcodes 
    // for creating login and signup links that are put on the login
    // and signup pages.
    public function use_next_if_exists($newPath)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $parsedRequest = parse_url($requestUri);

        // if there was already a 'next' param in the url, we want to use is value again
        $existingNextValue = dhcl_get_existing_next($parsedRequest);
        if (isset($existingNextValue)) {
            // there was an existing next value, tack it on and return it
            $next = '?next=' . $existingNextValue;

            $pathWithNext = $newPath . $next;

            return site_url($pathWithNext);
        }

        return site_url($newPath);
    }
}