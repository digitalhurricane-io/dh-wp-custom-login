<?php

class DH_Default_Page_Content {

    public function login_page_content() {
        return [
            'title' => 'login',
            'content' => '<div class="row justify-content-center">
<div class="login-form-wrapper col-sm card">
<h1 class="login-title">Login</h1>
[dh_login_form_opening]
<div class="form-group">
<label>Username</label>
[dh_login_username_input class="form-control login-form-element" placeholder="Username"]</div>
<div class="form-group">
<label>Password</label>
[dh_login_password_input class="form-control login-form-element" placeholder="Password"]</div>
<a href="" class="dh-forgot-pass-link">Forgot Password?</a>

[dh_form_messages]

<button type="submit" class="login-form-element btn btn-success btn-block login-button">Login</button>
[dh_login_form_closing relative_redirect_url="/"]
<div class="row justify-content-center dh-login-links">
	<a href="" class="dh-sign-up-link">Sign Up</a></div>
</div>
</div>'
        ]
    }

    public function signup_page_content() {

    }

    public function pass_reset_request_content() {
 
    }

    public function pass_reset_content() {

    }
}