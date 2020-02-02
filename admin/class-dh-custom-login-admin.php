<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dh_Custom_Login
 * @subpackage Dh_Custom_Login/admin
 * @author     Your Name <email@example.com>
 */
class Dh_Custom_Login_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $dh_custom_login    The ID of this plugin.
	 */
	private $dh_custom_login;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $dh_custom_login       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dh_custom_login, $version ) {

		$this->dh_custom_login = $dh_custom_login;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dh_Custom_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dh_Custom_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'css/dh-custom-login-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dh_Custom_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dh_Custom_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->dh_custom_login, plugin_dir_url( __FILE__ ) . 'js/dh-custom-login-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_admin_page() {

		// add_option('dhcl_login_slug', 'login');
		// add_option('dhcl_signup_slug', 'signup');
		// add_option('dhcl_reset_password_slug', 'reset-password');
		// add_option('dhcl_pass_reset_email_slug', 'password-reset-email');
		//register_setting('dhcl_options_group', 'DH Custom Login', 'myplugin_callback');

		// Add the menu item and page
		$page_title = 'DH Custom Login';
		$menu_title = 'DH Custom Login';
		$capability = 'manage_options';
		$slug = 'dh_custom_login';
		$callback = 'dhcl_settions_page';
		$icon = 'dashicons-admin-plugins';
		$position = 100;

		// top level menu item
		// add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		// sub level menu item
		add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
	}

	public function setup_admin_page_sections() {
		add_settings_section('our_first_section', 'My First Section Title', array($this, 'section_callback'), 'dh_custom_login');
		add_settings_section('our_second_section', 'My Second Section Title', array($this, 'section_callback'), 'dh_custom_login');
		add_settings_section('our_third_section', 'My Third Section Title', array($this, 'section_callback'), 'dh_custom_login');

		$this->setup_admin_page_fields();
	}

	public function setup_admin_page_fields() {
		$fields = array(
			array(
				'uid' => 'awesome_text_field',
				'label' => 'Sample Text Field',
				'section' => 'our_first_section',
				'type' => 'text',
				'placeholder' => 'Some text',
				'helper' => 'Does this help?',
				'supplimental' => 'I am underneath!',
			),
			array(
				'uid' => 'awesome_password_field',
				'label' => 'Sample Password Field',
				'section' => 'our_first_section',
				'type' => 'password',
			),
			array(
				'uid' => 'awesome_number_field',
				'label' => 'Sample Number Field',
				'section' => 'our_first_section',
				'type' => 'number',
			),
			array(
				'uid' => 'awesome_textarea',
				'label' => 'Sample Text Area',
				'section' => 'our_first_section',
				'type' => 'textarea',
			),
			array(
				'uid' => 'awesome_select',
				'label' => 'Sample Select Dropdown',
				'section' => 'our_first_section',
				'type' => 'select',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'awesome_multiselect',
				'label' => 'Sample Multi Select',
				'section' => 'our_first_section',
				'type' => 'multiselect',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'awesome_radio',
				'label' => 'Sample Radio Buttons',
				'section' => 'our_first_section',
				'type' => 'radio',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'awesome_checkboxes',
				'label' => 'Sample Checkboxes',
				'section' => 'our_first_section',
				'type' => 'checkbox',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			)
		);
		foreach ($fields as $field) {

			add_settings_field($field['uid'], $field['label'], array($this, 'field_callback'), 'dh_custom_login', $field['section'], $field);
			register_setting('dh_custom_login', $field['uid']);
		}
	}

	// output fields
	public function field_callback( $arguments ) {
		//echo var_dump($arguments);
		
		$uid = $arguments['uid'];
		$default = isset($arguments['default']) ? $arguments['default'] : '';
		$placeholder = isset($arguments['placeholder']) ? $arguments['placeholder'] : '';

		$value = get_option($uid, $default);

        switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $placeholder, $value );
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
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value, $key, false ), $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
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

	public function section_callback() {
		echo 'hello world';
	}
	
}
