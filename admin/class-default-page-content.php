<?php

class DH_Default_Page_Content {

    public function login_page_content() {
        return '<div class="row justify-content-center">
<div class="login-form-wrapper col-sm card">
<h1 class="login-title">Login</h1>
[dh_login_form_opening]
<div class="form-group">
<label>Username</label>
[dh_login_username_input class="form-control login-form-element" placeholder="Username"]</div>
<div class="form-group">
<label>Password</label>
[dh_login_password_input class="form-control login-form-element" placeholder="Password"]</div>
[dh_forgot_password_link_open]Forgot Password?[dh_forgot_password_link_close]

[dh_form_messages]

<button type="submit" class="login-form-element btn btn-success btn-block login-button">Login</button>
[dh_login_form_closing relative_redirect_url="/"]
<div class="row justify-content-center dh-login-links">
	[dh_signup_link_open]Sign Up[dh_signup_link_close]</div>
</div>
</div>';

    }

    public function signup_page_content() {
        return '<div class="row justify-content-center">
<div class="login-form-wrapper col-sm card">
<h1 class="login-title">Sign Up</h1>
[dh_registration_form_opening]
<div class="form-group">
<label>Email</label>
[dh_registration_email_input class="form-control login-form-element" placeholder="Email"]</div>
<div class="form-group">
<label>Username</label>
[dh_registration_username_input class="form-control login-form-element" placeholder="Username"]</div>
<div class="form-group">
<label>Password</label>
[dh_registration_password_input class="form-control login-form-element" placeholder="Password"]</div>
[dh_form_messages]

<button type="submit" class="login-form-element btn btn-success btn-block signup-button">Sign Up</button>
[dh_registration_form_closing relative_redirect_url="/"]

</div>
</div>';
    }

    public function pass_reset_request_content() {
        return '<div class="row justify-content-center">
<div class="login-form-wrapper col-sm card">
<h1 class="login-title">Reset Password</h1>
[dh_pass_reset_email_form_opening]
<div class="form-group">
<label>Email or Username</label>
[dh_pass_reset_email_input class="form-control login-form-element"]</div>
[dh_form_messages]

<button type="submit" class="login-form-element btn btn-success btn-block dh-send-reset-btn">Send Email</button>
[dh_pass_reset_email_form_closing]

</div>
</div>';
    }

    public function pass_reset_content() {
        return '<div class="row justify-content-center">
<div class="login-form-wrapper col-sm card">
<h1 class="login-title">Reset Password</h1>
[dh_rest_password_form_opening]
<div class="form-group">
<label>New Password</label>
[dh_rest_password_password_input class="form-control login-form-element"]</div>
[dh_form_messages]

<button type="submit" class="login-form-element btn btn-success btn-block dh-send-reset-btn">Reset Password</button>
[dh_rest_password_form_closing]

</div>
</div>';
    }
}