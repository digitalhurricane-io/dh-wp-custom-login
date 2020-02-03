
This is a wordpress plugin that lets you create custom login and registration forms with shortcodes and html.

Create a page name 'login' (Must be named login, has to do with emails, could make a setting for this later).

The registration page can have any name.

Add the minimal code. 

Style and markup as you like.

All shortcode attributes will be passed through and set as html attributes in the underlying html elements.

For example, ids and classes.

[dh_registration_username_input id="username-input" class="class1 class2"]

The exception to this rule is for the redirect url.

You can set the url where the user will be redirected after a successful login 
by setting the shortcode attribute relative_redirect_url="/my-url" on the form_closing shortcode

Also, when the plugin is activated wp-login.php will redirect to a 404.

wp-admin will also redirect to a 404 page if user is not administrator.

Wp admin top bar will be hidden for non administrators.

Also, auto insertion of <p> tags will be disabled if the page slug is 'login' or 'signup'.

Not implemented yet, but form page for password reset email url will be /password-reset-email
Not implemented yet, but form page for entering new password will be /reset-password



minimal shortcodes / html needed to create custom login form
-----------------------------------

[dh_login_form_opening]  

[dh_login_username_input]   
[dh_login_password_input]   

<button type="submit">Login</button>  

[dh_login_form_closing relative_redirect_url="/"]  

-----------------------------------

minimal shortcodes / html needed to create custom registration form
-----------------------------------

[dh_registration_form_opening]

[dh_registration_username_input]
[dh_registration_email_input]
[dh_registration_password_input]

<button type="submit">Register</button>

[dh_registration_form_closing relative_redirect_url="/"]

-----------------------------------

Bootstrap sample login
-----------------------------------
<style>

.login-form-element {
    min-height: 47px;
}

.login-form-wrapper {
    padding: 0 30px 10px 30px;
    max-width: 460px;
    background: #222B45;
}

.login-title {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 15px;
}

.login-button {
    margin-top: 18px;
    margin-bottom: 20px;
    height: 60px;
    font-size: 24px;
}

.dh-login-links {
    padding-left: 20px;
    padding-right: 20px;
    margin-bottom: 15px;
}

.signup-button {
    margin-top: 50px;
    margin-bottom: 20px;
    height: 60px;
    font-size: 24px;
}

</style>

<div class="row justify-content-center">
    <div class="login-form-wrapper col-sm card">

        <h1 class="login-title">Login</h1>

        [dh_login_form_opening]

            <div class="form-group">
                <label>Username</label>
                [dh_login_username_input class="form-control login-form-element" placeholder="Username"]
            </div>

            <div class="form-group">
                <label>Password</label>
                [dh_login_password_input class="form-control login-form-element" placeholder="Password"]
            </div>

            <a href="" class="dh-forgot-pass-link">Forgot Password?</a>

            <button type="submit" class="login-form-element btn btn-success btn-block login-button">Login</button>

        [dh_login_form_closing relative_redirect_url="/"]

        <div class="row justify-content-center dh-login-links">
	        <a href="" class="dh-sign-up-link">Sign Up</a>
        </div>
</div>

    </div>
</div>

-----------------------------

Bootstrap sample registration
-----------------------------------

<style>

.login-form-element {
    min-height: 47px;
}

.login-form-wrapper {
    padding: 0 30px 10px 30px;
    max-width: 460px;
    background: #222B45;
}

.login-title {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 15px;
}

.login-button {
    margin-top: 18px;
    margin-bottom: 20px;
    height: 60px;
    font-size: 24px;
}

.dh-login-links {
    padding-left: 20px;
    padding-right: 20px;
    margin-bottom: 15px;
}

.signup-button {
    margin-top: 50px;
    margin-bottom: 20px;
    height: 60px;
    font-size: 24px;
}

</style>

<div class="row justify-content-center">
    <div class="login-form-wrapper col-sm card">
        <h1 class="login-title">Sign Up</h1>

        [dh_registration_form_opening]

            <div class="form-group">
                <label>Email</label>
                [dh_registration_email_input class="form-control login-form-element" placeholder="Email"]
            </div>

            <div class="form-group">
                <label>Username</label>
                [dh_registration_username_input class="form-control login-form-element" placeholder="Username"]
            </div>

            <div class="form-group">
                <label>Password</label>
                [dh_registration_password_input class="form-control login-form-element" placeholder="Password"]
            </div>

            <button type="submit" class="login-form-element btn btn-success btn-block signup-button">Sign Up</button>

        [dh_registration_form_closing relative_redirect_url="/"]

    </div>
</div>