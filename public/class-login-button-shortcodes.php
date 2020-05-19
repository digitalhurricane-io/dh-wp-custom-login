<?php


class DH_Login_Logout_Button_Shortcodes {

    // example:
    // [dhcl_login_logout_button logged_in_text="Login" logged_out_text="Logout" logged_in_classes="" logged_out_classes="" logged_in_anchor_classes="" logged_out_anchor_classes="" link_only_logged_in="true" link_only_logged_out="true"]
    public function login_logout_button($atts) {

        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            "logged_in_text" => "Login", // text to display when logged in
            "logged_out_text" => "Logout", // text to display when logged out
            "logged_in_classes" => "", // classes to add to button when logged in
            "logged_out_classes" => "", // classes to add to button when logged out
            "logged_in_anchor_classes" => "", // classes to add to anchor tag when logged in
            "logged_out_anchor_classes" => "", // classes to add to anchor tag when logged out
            "link_only_logged_in" => "false", // whether to ommit button tag and only use anchor tag when logged in
            "link_only_logged_out" => "false", // whether to ommit button tag and only use anchor tag when logged out
        ), $original);
    
        $linkHref = "";
        $linkClasses = "";
        $buttonClasses = "";
        $buttonText = "";
        $linkOnly = false;

        if (is_user_logged_in()) { // is logged in
            $linkHref = wp_logout_url(home_url());
            $linkClasses = $mergedAtts['logged_in_anchor_classes'];
            $buttonClasses = $mergedAtts['logged_in_classes'];
            $buttonText = $mergedAtts['logged_in_text'];
            $linkOnly = strtolower($mergedAtts['link_only_logged_in']) == 'false' ? false : true; 
        
        } else { // is logged out
            $linkHref = site_url('/' . get_option('dhcl_login_slug'));
            $linkClasses = $mergedAtts['logged_out_anchor_classes'];
            $buttonClasses = $mergedAtts['logged_out_classes'];
            $buttonText = $mergedAtts['logged_out_text'];
            $linkOnly = strtolower($mergedAtts['link_only_logged_out']) == 'false' ? false : true; 

        }

        if ($linkOnly) {
            return "<a href=\"$linkHref\" class=\"$linkClasses\">$buttonText</a>";

        } else {
            return "<a href=\"$linkHref\" class=\"$linkClasses\"><button class=\"$buttonClasses\">$buttonText</button></a>";
            
        }
        
    }

    public function signup_button($atts) {

        if (is_user_logged_in()) {
            // user is logged in, thus, no need to output signup button
            return '';
        }

        $original = is_array($atts) ? $atts : []; // is a string if no shortcode args passed

        $mergedAtts = array_merge(array(
            "text" => "Sign Up", // text to display when logged in
            "button_classes" => "", // classes to add to button when logged in
            "anchor_classes" => "", // classes to add to anchor button
            "link_only" => "false", // whether to ommit button tag and only output anchor
        ), $original);


        $linkHref = site_url(get_option('dhcl_signup_slug'));
        $linkClasses = $mergedAtts['anchor_classes'];
        $buttonClasses = $mergedAtts['button_classes'];
        $text = $mergedAtts['text'];
        $linkOnly = strtolower($mergedAtts['link_only']) == 'false' ? false : true;

        if ($linkOnly) {
            return "<a href=\"$linkHref\" class=\"$linkClasses\">$text</a>";
        } else {
            return "<a href=\"$linkHref\" class=\"$linkClasses\"><button class=\"$buttonClasses\">$text</button></a>";
        }
        
    }

}