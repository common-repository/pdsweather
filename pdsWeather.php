<?php
/*
Plugin Name: Weather
Plugin URI: http://prood-os.com/weather-plugin
Description: Weather plugin by Proodos. Shows current conditions anywhere on your web page. After activation adjust plugin's settings and then echo pdsWeather() where you want it to show
Author: Iva Korlevic, Proodos j.d.o.o.
Version: 3.3
Author URI: http://prood-os.com
License: GPL2
*/

/**
 * @package pdsWeather
 * @version 3.3
 */

include_once('pdsAdmin.php');


function pdsWeather(){

    $api_key = get_option('weather-key');

    if($api_key) {
        $current = get_option('pds_weather_current');
        $hour = date('H');


        if (!$current or count($current) <= 1) {
            if (get_option('locid')) {
                $fp = file_get_contents('http://api.wunderground.com/api/' . $api_key . '/conditions' . get_option('locid') . '.json', 'r');
                $resp = json_decode($fp, true);

                $current = $resp['current_observation'];
                $current['time'] = date('Y-m-d H:i:s');
                update_option('pds_weather_current', $current);

            }

        } elseif ($hour > date('H', strtotime($current['time'])) || date('Ymd') > date('Ymd', strtotime($current['time']))) {
            if (get_option('locid')) {
                $fp = file_get_contents('http://api.wunderground.com/api/' . $api_key . '/conditions' . get_option('locid') . '.json', 'r');
                $resp = json_decode($fp, true);
                $current = $resp['current_observation'];
                $current['time'] = date('Y-m-d H:i:s');
                update_option('pds_weather_current', $current);
            }
        }
        
        if ($current or count($current) > 1) {
            $sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $current['display_location']['latitude'], $current['display_location']['longitude'], $current['display_location']['elevation'], 1);
            $sunrise = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $current['display_location']['latitude'], $current['display_location']['longitude'], $current['display_location']['elevation'], 1);

            if (time() > $sunrise && time() < $sunset) {
                $current['tod'] = "day";
            } else {
                $current['tod'] = "night";
            }


            $html = '<div class="weather">';
            if (get_option('iconset') == 1) {
                $html .= '<div class="img"><img src="http://icons.wxug.com/i/c/' . get_option('icset') . '/' . $current['icon'] . '.gif" alt="' . $current['weather'] . '"/></div>';
            }

            if (get_option('iconset') == 2) {

                $curr = ($current['icon']) ? $current['icon'] : 'clear';
                $html .= '<i class="wi wi-' . $current['tod'] . '-' . $curr . '"></i>';
            }

            $html .= '<div class="conditions">';
            if (get_option('weather')) {
                $curw = ($current['weather']) ? $current['weather'] : 'clear';
                $html .= '<span class="wthr">' . $curw . '</span>';
            }

            if (get_option('feelslike')) {
                $html .= '<small><label>feels like: </label>';

                if (get_option('degrees')) {
                    $degrees = get_option('degrees');
                    if (isset($degrees['f'])) {
                        $html .= '<span class="deg">' . $current['feelslike_f'] . ' F</span>';
                    }
                    if (isset($degrees['c'])) {
                        $html .= '<span class="deg">' . $current['feelslike_c'] . ' °C</span>';
                    }
                } else {
                    $html .= '<span class="deg">' . $current['feelslike_f'] . ' F</span>' . '<span class="deg">' . $current['feelslike_c'] . ' °C</span>';
                }
                $html .= '</small>';
            }

            $html .= '<div class="current">';


            if (get_option('degrees')) {
                $degrees = get_option('degrees');
                if (isset($degrees['f'])) {
                    $html .= '<span class="deg">' . $current['temp_f'] . ' F</span>';
                }
                if (isset($degrees['c'])) {
                    $html .= '<span class="deg">' . $current['temp_c'] . ' °C</span>';
                }
            } else {
                $html .= '<span class="deg">' . $current['temp_f'] . ' F</span>' . '<span class="deg">' . $current['temp_c'] . ' °C</span>';
            }
            $html .= '</div>';

            $html .= '   </div>
	</div>';

            return $html;
        }
    }
    else{
        return "";
    }
	
}


function pds_weather_register_script() {
	wp_register_style( 'pds_style', plugins_url('/css/style.min.css', __FILE__), false, '1.0.0', 'all');
	wp_register_style( 'pds_weather_icons', plugins_url('/css/weather-icons.min.css', __FILE__), false, '1.0.0', 'all');
}



function pds_weather_enqueue_style(){
	wp_enqueue_style( 'pds_style' );
	wp_enqueue_style( 'pds_weather_icons' );
}

function pds_weather_admin_font(){
    wp_register_style( 'pds_admin_weather', plugins_url('/css/weather-icons.min.css', __FILE__), false, '1.0.0');
}

function pds_weather_admin_enque(){
    wp_enqueue_style('pds_admin_weather');
}

add_action('init','pds_weather_admin_font');
add_action('admin_enqueue_scripts','pds_weather_admin_enque');
add_action('init', 'pdsWeather');
add_action('init', 'pds_weather_register_script');
add_action('wp_enqueue_scripts', 'pds_weather_enqueue_style');
