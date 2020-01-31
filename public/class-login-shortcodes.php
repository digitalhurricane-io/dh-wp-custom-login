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
        $vals = shortcode_atts(array(
            'action' => '/wp-admin/admin-ajax.php?action=dhcl_login',
            'name' => 'loginform',
            'id' => 'login-form',
            'class' => '',
        ), $atts);

        $form_tag = '<form method="POST" action="' . esc_attr($vals['action']) . '" name="' . esc_attr($vals['name']) . '" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '">';
        $nonce = wp_nonce_field('dh_custom_login', '_wpnonce', true, false);

        $final = $form_tag . $nonce;

        return $final;
    }

    public function login_form_closing($atts)
    {
        $vals = shortcode_atts(array(
            'partial_redirect_url' => '/wp-admin/'
        ), $atts);

        return $this->login_redirect_input(esc_attr($vals['partial_redirect_url'])) . $this->login_test_cookie_input() . '</form>';
    }

    // returns the input field for the username
    // takes shortcode atts of id and a space separated class list
    public function login_username_input($atts)
    {
        $vals = shortcode_atts(array(
            'id' => 'username',
            'class' => '',
        ), $atts);

        return '<input type="text" name="usernameOrEmail" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '" />';
    }

    // returns the input field for the password
    // takes shortcode atts of id and a space separated class list
    public function login_password_input($atts)
    {
        $vals = shortcode_atts(array(
            'id' => 'password',
            'class' => '',
        ), $atts);

        return '<input type="password" name="pass" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '" />';
    }

    public function login_redirect_input($partial_url)
    {

        $base_url = esc_url(site_url());
        $full_url = $base_url . $partial_url;

        return '<input type="hidden" name="redirect_to" value="' . $full_url . '" />';
    }

    public function login_test_cookie_input()
    {
        return '<input type="hidden" name="testcookie" value="1" />';
    }

}