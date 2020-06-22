<?php

class DH_Registration_Shortcodes {

    public function form_opening($atts) {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge([
            'id' => 'registerform',
            'class' => '',
            'action' => '/wp-admin/admin-ajax.php?action=dhcl_create_account',
        ], $original);

        $startHtml = '<form name="dhclform" method="post" novalidate="novalidate"';
        $endHtml = '>';

        // last arg prevents echoing
        $nonce = wp_nonce_field('dh_custom_registration', '_wpnonce', true, false);

        $final = $this->set_attributes($startHtml, $endHtml, $mergedAtts) . $nonce;

        return $final;
    }

    public function username_input($atts) {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge([
            'id' => 'username',
            'class' => '',
        ], $original);

        $startHtml = '<input type="text" name="username"';
        $endHtml = 'autocapitalize="off" />';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function email_input($atts)
    {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge([
            'id' => 'email',
            'class' => '',
        ], $original);

        $startHtml = '<input type="text" name="email"';
        $endHtml = 'autocapitalize="off" />';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function password_input($atts) {
        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge([
            'id' => 'username',
            'class' => '',
        ], $original);

        $startHtml = '<input type="password" name="password"';
        $endHtml = '/>';

        return $this->set_attributes($startHtml, $endHtml, $mergedAtts);
    }

    public function form_closing($atts) {

        $redirect_url = site_url();
        $redirect_option = get_option('dhcl_after_signup_in_redirect');

        if (!empty($redirect_option)) {
            $redirect_url = site_url('/' . $redirect_option);

        } else if (isset($atts['relative_redirect_url'])) {
            $redirect_url = site_url(esc_attr($atts['relative_redirect_url']));
        }

        return '<input type="hidden" name="redirect_to" value="'. $redirect_url . '" /></form>';
    }

    /**
     * Takes any attributes passed in the shortcode, and sets them on the html element
     */
    public function set_attributes($startHtml, $endHtml, $atts)
    {
        foreach ($atts as $key => $val) {
            $startHtml = $startHtml . ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
        }
        return $startHtml . ' ' . $endHtml;
    }
}