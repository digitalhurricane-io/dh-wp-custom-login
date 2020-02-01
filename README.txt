
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

Also, auto insertion of <p> tags will be disabled if 'login' or 'signup' is in the url.


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
