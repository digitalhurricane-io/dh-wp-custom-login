<?php


class DH_Reset_Password_Shortcodes {

    public function form_opening($atts) {

        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            'action' => '/wp-admin/admin-ajax.php?action=dhcl_reset_password',
            'name' => 'dh-pass-form',
            'id' => 'dh-pass-form',
        ), $original);

        $startHtml = '<form method="POST" ';
        $endHtml = '>';

        $nonce = wp_nonce_field('dh_custom_login', '_wpnonce', true, false);

        $final = $this->set_attributes($startHtml, $endHtml, $mergedAtts) . $nonce;

        return $final;
    }

    public function password_input($atts) {
        $atts = is_array($atts) ? $atts : []; // is a string if no shortcode args passed
        
        $startHtml = '<input name="password" type="password"';
        $endHtml = '/>';
        return $this->set_attributes($startHtml, $endHtml, $atts);
    }

    public function form_closing() {
        return '</form>';
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