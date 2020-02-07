<?php

class DH_Registration_Shortcodes {

    public function form_opening($atts) {
        $vals = shortcode_atts([
            'id' => 'registerform',
            'class' => '',
            'action' => '/wp-admin/admin-ajax.php?action=dhcl_create_account',
        ], $atts);

        //$action_url = esc_url(site_url('wp-login.php?action=register', 'login_post'));
        $form_tag = '<form name="registerform" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '" action="' . esc_attr($vals['action']) . '" method="post" novalidate="novalidate">';
        // last arg prevents echoing
        $nonce = wp_nonce_field('dh_custom_registration', '_wpnonce', true, false);

        $final = $form_tag . $nonce;

        return $final;
    }

    public function username_input($atts) {
        $vals = shortcode_atts([
            'id' => 'username',
            'class' => '',
        ], $atts);

        return '<input type="text" name="username" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" autocapitalize="off" />';
    }

    public function email_input($atts)
    {
        $vals = shortcode_atts([
            'id' => 'email',
            'class' => '',
        ], $atts);

        return '<input type="text" name="email" id="' . esc_attr($vals['id']) . '" class="' . esc_attr($vals['class']) . '" autocapitalize="off" />';
    }

    public function password_input($atts) {
        $vals = shortcode_atts([
            'id' => 'username',
            'class' => '',
        ], $atts);

        return '<input type="password" name="password" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" />';
    }

    public function form_closing($atts) {
        $vals = shortcode_atts(array(
            'partial_redirect_url' => '/'
        ), $atts);

        $redirect_url = site_url();
        $redirect_option = get_option('dhcl_after_signup_in_redirect');

        if (!empty($redirect_option)) {
            $redirect_url = site_url('/' . $redirect_option);

        } else if (isset($atts['relative_redirect_url'])) {
            $redirect_url = site_url(esc_attr($atts['relative_redirect_url']));
        }

        return '<input type="hidden" name="redirect_to" value="'. $redirect_url . '" /></form>';
    }
}