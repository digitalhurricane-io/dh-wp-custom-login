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
            'name' => 'loginform',
            'id' => 'login-form',
        ), $original);

        //$form_tag = '<form method="POST" action="' . esc_attr($vals['action']) . '" name="' . esc_attr($vals['name']) . '" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '">';
        $startHtml = '<form method="POST" ';
        $endHtml = '>';

        $nonce = wp_nonce_field('dh_custom_login', '_wpnonce', true, false);

        $final = $this->set_attributes($startHtml, $endHtml, $mergedAtts) . $nonce;

        return $final;
    }

    public function login_form_closing($atts)
    {

        $redirect_url = home_url();
        if (isset($atts['relative_redirect_url'])) {
            $redirect_url = home_url(esc_attr($atts['relative_redirect_url']));
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

    /**
     * Takes any attributes passed in the shortcode, and sets them on the html element
     */
    public function set_attributes($startHtml, $endHtml, $atts) {
        foreach($atts as $key => $val) {
            $startHtml = $startHtml . ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
        }
        return $startHtml . ' ' . $endHtml;
    }

}