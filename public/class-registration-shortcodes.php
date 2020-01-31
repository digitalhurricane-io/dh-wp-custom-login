<?php

class DH_Registration_Shortcodes {

    public function form_opening($atts) {
        $vals = shortcode_atts([
            'id' => 'registerform',
            'class' => '',
        ], $atts);

        $action_url = esc_url(site_url('wp-login.php?action=register', 'login_post'));

        return '<form name="registerform" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" action="'. $action_url .'" method="post" novalidate="novalidate">';
    }

    public function username_input($atts) {
        $vals = shortcode_atts([
            'id' => 'username',
            'class' => '',
        ], $atts);

        return '<input type="text" name="user_login" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" autocapitalize="off" />';
    }

    public function password_input($atts) {
        $vals = shortcode_atts([
            'id' => 'username',
            'class' => '',
        ], $atts);

        return '<input type="email" name="user_email" id="'. esc_attr($vals['id']) .'" class="'. esc_attr($vals['class']) .'" />';
    }

    public function form_closing($atts) {
        $vals = shortcode_atts(array(
            'partial_redirect_url' => '/'
        ), $atts);

        return '<input type="hidden" name="redirect_to" value="'. esc_attr($vals['partial_redirect_url']) . '" /></form>';
    }
}