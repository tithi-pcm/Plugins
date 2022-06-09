<?php
/**
 * Plugin Name:       PCM Ads
 * Description:       PCM Ads plugin is designed to display google ads, leaderboard and to integrate webskin on your site.
 * Version:           1.0
 * Requires PHP:      5.6
 * Author:            Prime Creative Media
 * Author URI:        https://www.primecreative.com.au/
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 **/


if (!defined ( 'ABSPATH' )) {
    exit;
}


// Admin Section
if ( is_admin() ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
}


require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';

function pcm_ads_settings_link( $links ) {
    // Build and escape the URL.
	$url = esc_url( add_query_arg(
        'page',
		'pcm-ads',
		get_admin_url() . 'admin.php'
    ) );

    // Create the link.
    $settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
    // Adds the link to the end of the array.
    array_push(
        $links,
        $settings_link
    );
    return $links;
}
add_filter( 'plugin_action_links_pcm-ads/pcm-ads.php', 'pcm_ads_settings_link' );