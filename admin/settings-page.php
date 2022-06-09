<?php

if (!defined ( 'ABSPATH' )) {
    exit;
}

function enqueue_shortcode_admin_style () {
    wp_enqueue_style('pcm-ads-admin-style', plugin_dir_url(__FILE__) . "assets/css/style.css");
}
add_action('admin_enqueue_scripts', 'enqueue_shortcode_admin_style');


function pcm_settings_page() {
    if ( !current_user_can ( 'manage_options' ) )  return; ?>

    <div class="wrap">
        <h1><?php echo esc_html ( get_admin_page_title() ); ?></h1>
        <?php settings_errors(); ?>
        <form action="options.php" method="POST">
            <?php
                settings_fields ( 'pcm_ads_options' );

                do_settings_sections ( 'pcm-ads' );

                submit_button ();
            ?>
        </form>
    </div>

<?php
}