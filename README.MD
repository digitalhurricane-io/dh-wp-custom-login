# DH Custom Login
Wordpress login and registrations forms are not easy to customize. This plugin helps.

This plugin lets you create custom login and registration forms with shortcodes and html.

Style and markup as you like.

You can click a button in the plugin options to automatically create 
login, signup, password-reset-request, and password reset pages.

Then you can customize the markup from there to suit your needs.

## Login / Logout button shortcode

To create a button link that switches between logging in and logging out based on login status, use the following shortcode.
### [dh_login_logout_btn] 

#### Attributes with defaults and explanations:
###### logged_in_text="Logout"
Text to display when user is logged in
###### logged_out_text="Login"
Text to display when user is logged out
###### logged_in_classes=""  
Classes to add to button when logged in
###### logged_out_classes=""  
Classes to add to button when logged out
###### logged_in_anchor_classes=""   
Classes to add to anchor tag when logged in
###### logged_out_anchor_classes=""  
Classes to add to anchor tag when logged out
###### link_only_logged_in="false"  
Whether to ommit button tag and only use anchor tag when logged in
###### link_only_logged_out="false"  
Whether to ommit button tag and only use anchor tag when logged out

## Signup button shortcode

To create a signup button, which will only be displayed if the user is logged out, use the following shortcode:
### [dh_signup_btn]

#### Attributes with defaults and explanations:
###### text="Sign Up"
Text to display
###### button_classes=""
Classes to add to button tag
###### anchor_classes=""
Classes to add to anchor tag
###### link_only=""
Whether to ommit button tag and only output anchor tag

## Other Info:

* All shortcode attributes will be passed through and set as html attributes in the underlying html elements.
(Exceptions include login / logout / signup button shortcodes)

For example, ids and classes.

[dh_registration_username_input id="username-input" class="class1 class2"]  
Would result in attributes being passed through like so:
<input id="username-input" class="class1 class2">

* When the plugin is activated wp-login.php will redirect to the login page.

* wp-admin will redirect to a 404 page if user is not administrator.

* Wp admin top bar will be hidden for non administrators.

* Auto insertion of <p> tags will be disabled if the page slug is 'login' or 'signup'.
