<?php


if (!defined ( 'ABSPATH' )) {
    exit;
}


function pcm_ads_validate_callback_setting($input) {
    if ( isset ( $input['google_publisher_tag'] ) ) {
        $input['google_publisher_tag'] = sanitize_text_field( $input['google_publisher_tag'] );
    }

    return $input;
}

function google_add_settings_callback_section() {
    echo "<p>In the Google Publisher Tag field, enter the network-code and the parent-ad-unit-code. For Prime Creative Media the network-code you would enter a Google Publisher Tag like: /36655067/<parent-ad-unit-code> where the <parent-ad-unit-code> might be the site's name.</p>";
}

function google_add_shortcodes_callback_section() {
    echo "<p>These shortcodes allow you to display Google Ads on your website.</p>";
    $table = "<table class='wp-list-table widefat fixed striped table-view-list posts pcm_ads_shortcode' cellspacing='0'>
                <tr>
                    <th> Section </th>
                    <th> Shortcode </th>
                </tr>
                <tr>
                    <td> Webskin</td>
                    <td> [pcm_webskin] </td>
                </tr>
                <tr>
                    <td> First Leaderboard</td>
                    <td> [pcm_leaderboard_one] </td>
                </tr>
                <tr>
                    <td> Second Leaderboard</td>
                    <td> [pcm_leaderboard_two] </td>
                </tr>
                <tr>
                    <td> Third Leaderboard</td>
                    <td> [pcm_leaderboard_three] </td>
                </tr>
                <tr>
                    <td> Fourth Leaderboard</td>
                    <td> [pcm_leaderboard_four] </td>
                </tr>
                <tr>
                    <td> Mrecs</td>
                    <td> [pcm_mrecs] </td>
                </tr>
                <tr>
                    <td> Half Page</td>
                    <td> [pcm_halfpage] </td>
                </tr>
            </table>";
        
    echo $table;
}

function google_tag_callback_field( $args ) {
    $options = get_option('pcm_ads_options');

    $id = isset( $args['id'] ) ? $args['id'] : '';
    $label = isset( $args['label'] ) ? $args['label'] : '';

    $value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

    echo "<input id='pcm_ads_options_". $id ."' name='pcm_ads_options[". $id ."]' type='text' value='". $value ."'> &nbsp; 
        <label for='pcm_ads_options_". $id ."'>". $label ."</label>";
}