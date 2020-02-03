<?php

// example field info
//
// array(
//     'uid' => 'awesome_text_field',
//     'label' => 'Sample Text Field',
//     'section' => 'our_first_section',
//     'type' => 'text',
//     'placeholder' => 'Some text',
//     'helper' => 'Does this help?',
//     'supplimental' => 'I am underneath!',
//     'default' => 'something'
// ),

function dhcl_output_admin_field( $arguments ) {

		
    $uid = $arguments['uid'];
    $default = isset($arguments['default']) ? $arguments['default'] : '';
    $placeholder = isset($arguments['placeholder']) ? $arguments['placeholder'] : '';

    //echo 'default: ' . $default;

    $value = get_option($uid, $default);
    //echo $value;

    switch( $arguments['type'] ){
        case 'text':
        case 'password':
        case 'number':
            printf( '/<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $placeholder, $value );
            break;
        case 'textarea':
            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $placeholder, $value );
            break;
        case 'select':
        case 'multiselect':
            if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                $attributes = '';
                $options_markup = '';
                foreach( $arguments['options'] as $key => $label ){

                    $options_markup .= sprintf( 
                        '<option value="%s" %s>%s</option>', 
                        $key, 
                        selected( 
                            $value, 
                            $key, 
                            false 
                        ), 
                        $label 
                    );
                }
                if( $arguments['type'] === 'multiselect' ){
                    $attributes = ' multiple="multiple" ';
                }
                printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
            }
            break;
        case 'radio':
        case 'multi_checkbox':
            $type = 'checkbox';
            if ($arguments['type'] == 'radio') {
                $type = 'radio';
            }

            if( ! empty ( $arguments['options'] ) && is_array( $arguments['options']  ) ){
                $options_markup = '';
                $iterator = 0;
                foreach( $arguments['options'] as $key => $label ){
                    $is_checked = false;

                    if (is_array($value) && in_array($key, $value)) {
                        //echo 'checked';
                        $is_checked = true;
                    }

                    $iterator++;
                    $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $type, $key, checked( true, $is_checked, false ), $label, $iterator );
                }
                printf( '<fieldset>%s</fieldset>', $options_markup );
            }
            break;
        case 'single_checkbox':
            $options_markup = sprintf('<label for="%1$s"><input id="%1$s" name="%1$s" type="%2$s" value="%3$s" %4$s /></label><br/>', $arguments['uid'], 'checkbox', '1', checked('1', $value, false));
            printf('<fieldset>%s</fieldset>', $options_markup);

            break;
        case 'ajax_button': // outputs a button that will be used with ajax
            printf('<button id="%s" class="button button-primary">%s</button>', $arguments['uid'], $arguments['label']);
            break;
    }

    if (isset($arguments['helper'])) {
        $helper = $arguments['helper'];
        printf('<span class="helper"> %s</span>', $helper);
    }

    if (isset($arguments['supplimental'])) {
        $supplimental = $arguments['supplimental'];
        printf('<p class="description">%s</p>', $supplimental);
    }
}

// if its a single textbox, it's representing a boolean, 
// we want it to always have a value of 0 / 1 
function dhcl_admin_single_checkbox_sanitizer($val) {
    return $val == '1' ? $val : '0';
}

function dhcl_strip_leading_slash_sanitizer($val) {
    $val = untrailingslashit($val); // remove ending slash
    return ltrim($val, '/'); // remove leading slash
}
