<?php

function dhcl_settions_page() {
    wp_nonce_field('dhcl_nonce');
    ?>
    
    <div class="wrap">
        <h2>DH Custom Login Settings</h2>
        <form id="dhcl-settings-form" method="post" action="options.php">
            <?php
                settings_fields( 'dh_custom_login');
                do_settings_sections('dh_custom_login');
                submit_button();
            ?>
        </form>
    </div> 
    
    <?php
}