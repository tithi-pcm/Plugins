<?php

if (!defined ( 'ABSPATH' )) {
    exit;
}

function pcm_ads_plugin_menu() {
    add_menu_page( 
        'PCM Ad settings', 
        'PCM Ads', 
        'manage_options', 
        'pcm-ads', 
        'pcm_settings_page',
        'dashicons-admin-generic',
        null
    );
}
add_action( 'admin_menu', 'pcm_ads_plugin_menu' );
