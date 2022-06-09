<?php

if (!defined ( 'ABSPATH' )) {
    exit;
}

function pcm_get_unique_ids($uniqueNumbers = 4) {
    $picked = [];
    $uniqueRandomNumbers = array_map(function () use(&$picked, $uniqueNumbers) {
        do {
            $rand = rand(1000000000000, $uniqueNumbers);
        } while(in_array($rand, $picked));

        $picked[] = "div-gpt-ad-". $rand ."-0";

        return $rand;
    }, array_fill(1000000000000, $uniqueNumbers, null));
    
    return $picked;
}


function enqueue_googletag_scripts () {

    $activePlugins = get_option( 'active_plugins', array() );
    if (in_array('pcm-ads/pcm-ads.php', $activePlugins)) {
        wp_enqueue_script('google-tag-manager', "https://www.googletagmanager.com/gtag/js?id=UA-7620499-7");
        wp_enqueue_script('secure-pub-ads', "https://securepubads.g.doubleclick.net/tag/js/gpt.js");
        wp_enqueue_style('pcm-ads-style', plugin_dir_url(__FILE__) . "../assets/css/style.css");
    }
}
add_action('wp_enqueue_scripts', 'enqueue_googletag_scripts');


add_filter( 'script_loader_tag', function ( $tag, $handle ) {

	if ( 'google-tag-manager' == $handle ||  'secure-pub-ads' == $handle ) {
        return str_replace( ' src', ' async src', $tag ); // OR async the script
	}
    return $tag;

}, 10, 2 );


function define_googletag_slot () {

    echo "<script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-7620499-7');
        </script>";
}
add_action('wp_head', 'define_googletag_slot');


function pcm_webskin() {
    $div_id = "div-gpt-ad-". rand(1000000000000, 1) ."-0";
    $options = get_option('pcm_ads_options');

    if ( empty( $options['google_publisher_tag'] ) )
        return;

    $google_publisher_tag = $options['google_publisher_tag'];

    $result = "<script>
                    window.googletag = window.googletag || {cmd: []};
                    googletag.cmd.push(function() {
                        googletag.pubads().collapseEmptyDivs();
                        googletag.defineSlot('". $google_publisher_tag ."', [1, 1], '". $div_id ."').addService(googletag.pubads());
                        googletag.pubads().enableSingleRequest();
                        googletag.enableServices();
                    });
                </script>
                <div id='page' class='hfeed site'>
                    <div id='wrap'>
                        <div id='". $div_id ."' style='height:1px; width:1px;'>
                            <script>
                                googletag.cmd.push(function() { googletag.display('". $div_id ."'); });
                            </script>
                        </div>
                    </div>
                </div>";

    return $result;
}
add_shortcode('pcm_webskin', 'pcm_webskin');


//custom ad leaderboard shortcode
function pcm_main_leaderboard () { 
	return pcm_leaderboards('nbanner1');
}

function pcm_secondary_leaderboard () { 
	return pcm_leaderboards('nbanner2');
}

function pcm_leaderboards ( $args ) {
    $div_id = "div-gpt-ad-". rand(1000000000000, 1) ."-0";
    $options = get_option('pcm_ads_options');

    if ( empty( $options['google_publisher_tag'] ) )
        return;

    $google_publisher_tag = $options['google_publisher_tag'];

    $result = "<center>
                <script>
                    window.googletag = window.googletag || {cmd: []};
                    googletag.cmd.push(function() {
                        var mapping = googletag.sizeMapping()
                            .addSize([1000, 400], [[970, 90], [970, 250], [728, 90]])
                            .addSize([750, 400], [[728, 90]])
                            .addSize([470, 400], [[320, 50]])
                            .addSize([0, 0], [[320, 50]])
                            .build();

                        googletag.pubads().collapseEmptyDivs();
                        googletag.defineSlot('". $google_publisher_tag ."', [[728, 90], [320, 50]], '". $div_id ."')
                            .setTargeting('pos', ['". $args ."'])
                            .defineSizeMapping(mapping)
                            .addService(googletag.pubads());
                        googletag.pubads().enableSingleRequest();
                        googletag.enableServices();
                    });
                </script>

                <div id='". $div_id ."' class='pcm_leaderboard'>
                    <script>
                        googletag.cmd.push(function() { googletag.display('". $div_id ."'); });
                    </script>
                </div>
            </center>";

    return $result;
}
add_shortcode('pcm_main_leaderboard', 'pcm_main_leaderboard');
add_shortcode('pcm_secondary_leaderboard', 'pcm_secondary_leaderboard');


//custom ad mrecs shortcode
function pcm_ads_mrecs () {
    $div_ids = pcm_get_unique_ids(4);
    $options = get_option('pcm_ads_options');
    
    if ( empty( $options['google_publisher_tag'] ) )
        return;

    $google_publisher_tag = $options['google_publisher_tag'];
    $mrec_size = "[300, 250]";

    $result = "<script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function() {
                    googletag.pubads().collapseEmptyDivs();
                    googletag.defineSlot('". $google_publisher_tag ."', ". $mrec_size .", '". $div_ids[0] ."').setTargeting('pos', ['mrec1']).addService(googletag.pubads());
                    googletag.defineSlot('". $google_publisher_tag ."', ". $mrec_size .", '". $div_ids[1] ."').setTargeting('pos', ['mrec2']).addService(googletag.pubads());
                    googletag.defineSlot('". $google_publisher_tag ."', ". $mrec_size .", '". $div_ids[2] ."').setTargeting('pos', ['mrec3']).addService(googletag.pubads());
                    googletag.defineSlot('". $google_publisher_tag ."', ". $mrec_size .", '". $div_ids[3] ."').setTargeting('pos', ['mrec4']).addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>";

        foreach($div_ids as $id) {
            $result .= "<div id='". $id ."' class='pcm_mrec'>
                            <script>
                                googletag.cmd.push(function() { googletag.display('". $id ."'); });
                            </script>
                        </div>";
        }

    return $result;
}
add_shortcode('pcm_ads_mrecs', 'pcm_ads_mrecs');