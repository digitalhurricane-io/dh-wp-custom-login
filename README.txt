
This is a wordpress plugin that lets you create custom login and registration forms with shortcodes and html.

Style and markup as you like.

You can click a button in the plugin options to automatically setup 
login, signup, password-reset-request, and password reset pages.

Then you can customize the markup from there to suit your needs.


OTHER INFO:

All shortcode attributes will be passed through and set as html attributes in the underlying html elements.

For example, ids and classes.

[dh_registration_username_input id="username-input" class="class1 class2"]

Also, when the plugin is activated wp-login.php will redirect to the login page.

wp-admin will redirect to a 404 page if user is not administrator.

Wp admin top bar will be hidden for non administrators.

Also, auto insertion of <p> tags will be disabled if the page slug is 'login' or 'signup'.