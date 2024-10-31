<?php
/**
 * Created by PhpStorm.
 * User: Iva
 * Date: 3.4.2015.
 * Time: 23:06
 */

if(isset($_POST) && !empty($_POST)){
    foreach($_POST as $key=>$opt){
        update_option($key,$opt);
    }
}


function pds_weather_menu(){
    add_menu_page('Weather plugin by Proodos','Weather plugin','manage_options','pds-weather-parent','pds_weather_options',plugin_dir_url( __FILE__ ) . 'images/sun.png');
    add_submenu_page('pds-weather-parent','Weather settings','Settings','manage_options','pds-weather-settings','pds_weather_set');
}

add_action('admin_menu','pds_weather_menu');

function pds_weather_options(){
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    echo '<div class="wrap">';
    echo "<h2>What's the weather like?</h2>";
    echo '<p>Simple weather plugin for Wordpress developed by <a href="http://prood-os.com">Proodos.</a></p>';
    echo '<p>This plugin shows the current weather data for the selected area. In the settings area you can set all the needed info.</p>';
    echo '<p>Weather data received by api from <a href="http://www.wunderground.com/?apiref=e53cbb9516ee4519">Weather underground</a>.</p>';
    echo '<p>Weather font provided by <a href="http://erikflowers.github.io/weather-icons/">Weather Icons</a>.</p>';

}

function pds_weather_set(){
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    include('admin/weather-set.php');
}

// register widget
add_action('widgets_init', 'create_weather_plugin');

function create_weather_plugin(){
    register_widget("pds_weather_plugin");
}

class pds_weather_plugin extends WP_Widget
{
    // constructor
    public function __construct() {
        parent::__construct(
            'weather_plugin', // Base ID
            __( 'Weather Plugin', 'proodos' ), // Name
            array( 'description' => __( 'A Weather Widget', 'proodos' ),
                'customize_selective_refresh' => true,
                )
        );
    }

// widget form creation

    function form($instance)
    {
    }

    function update($new_instance, $old_instance)
    {
    }

// display widget
    function widget($args, $instance)
    {
        extract($args);
        echo $args['before_widget'];
        echo pdsWeather();
        echo $args['after_widget'];
    }
}