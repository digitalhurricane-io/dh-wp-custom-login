<form name="registerform" id="registerform" action="<?php echo esc_url(site_url('wp-login.php?action=register', 'login_post')); ?>" method="post" novalidate="novalidate">
    <p>
        <label for="user_login"><?php _e('Username'); ?></label>
        <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(wp_unslash($user_login)); ?>" size="20" autocapitalize="off" />
    </p>
    <p>
        <label for="user_email"><?php _e('Email'); ?></label>
        <input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr(wp_unslash($user_email)); ?>" size="25" />
    </p>
    <?php

    /**
     * Fires following the 'Email' field in the user registration form.
     *
     * @since 2.1.0
     */
    do_action('register_form');

    ?>
    <p id="reg_passmail">
        <?php _e('Registration confirmation will be emailed to you.'); ?>
    </p>
    <br class="clear" />
    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
    <p class="submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Register'); ?>" />
    </p>
</form>

<p id="nav">
    <a href="<?php echo esc_url(wp_login_url()); ?>"><?php _e('Log in'); ?></a>
    <?php echo esc_html($login_link_separator); ?>
    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Lost your password?'); ?></a>
</p>