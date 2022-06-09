<?php

if (!defined ( 'ABSPATH' )) {
    exit;
}


function pcm_register_settings() {
    register_setting (
        'pcm_ads_options',
        'pcm_ads_options',
        'pcm_ads_validate_callback_setting'
    );

    add_settings_section(
        'google_add_settings',
        'Google Ad Settings',
        'google_add_settings_callback_section',
        'pcm-ads'
    );

    add_settings_section(
        'google_add_shortcodes',
        'Google Ad Shortcodes',
        'google_add_shortcodes_callback_section',
        'pcm-ads'
    );

    add_settings_field(
        'google_publisher_tag',
        'Google Publisher Tag',
        'google_tag_callback_field',
        'pcm-ads',
        'google_add_settings',
        ['id' => 'google_publisher_tag', 'label' => '']
    );
}
add_action('admin_init', 'pcm_register_settings');
