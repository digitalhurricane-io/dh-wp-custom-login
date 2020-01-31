

<form name="loginform" id="loginform" action="http://127.0.0.1/login/" method="post">
    <p>
        <label for="user_login">Username or Email Address</label>
        <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="off" />
    </p>

    <div class="user-pass-wrap">
        <label for="user_pass">Password</label>
        <div class="wp-pwd">
            <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20" />
            <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Show password">
                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
            </button>
        </div>
    </div>
                <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever"  /> <label for="rememberme">Remember Me</label></p>
    <p class="submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
                            <input type="hidden" name="redirect_to" value="http://127.0.0.1/wp-admin/" />
                            <input type="hidden" name="testcookie" value="1" />
    </p>
</form>