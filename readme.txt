=== Plugin Name ===
Contributors: proodos
Donate link: http://prood-os.com/donate?plg=pdsWeather
Tags: weather, current conditions
Requires at least: 3.0.1
Tested up to: 4.7
Stable tag: 4.7
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin to show the current weather conditions in your city. Currently it renews the conditions every hour.
The drop and drag widget now available.


== Description ==

The weather plugin shows current conditions in your area. The plugin for weather data connects with Weather underground API and collects the data:
conditions string, icon, current temperature, feels like temperature, all in Fahrenheit and Celsius degrees.

To show the plugin datam first you have to setup the plugin on settings page. The settings are:

* API Key - your api key from weather underground
* Country - select your country, or the country for which you want to show the conditions.
* City - write the name of the city for which you want to show the conditions. As you start writing the list of locations woll be shown beside the "Select your location" option.
* Location - this is the measuring station that you/ll get the data from. You'll see the list of the stations for the entered City, and may choose one of them.
* Use icon set - Do you want to sho graphical presentation of the conditions, or not. Also if you want to use icon set provided by the weather underground api or weather font.
* Show feels like - show feels like temperatures (Fahrenheit or Celsius)
* Show weather label - show the weather conditions (i.e. Partly sunny, Clear, Snow ... )
* Preview - not an options, but shows how will your sweather snippet look like.

After setting up, you have 2 options:
1. simply echo pdsWeather() where you want the conditions to show. Make sure the plugin is activated before echoing pdsWeather() otherwise it will throw an error.
or
2. go to Appearance -> Widgets and drop and drag the widget to your desired widget area.


From 3.0 Weather Underground API key is required. Please go to Weather underground for your key.

== Installation ==

To manually install the extension:

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Setup the plugin on the settings page
4. Place `<?php echo pdsWeather(); ?>` in your templates
or
4. Go to Appearance -> Widgets in wp-admin area and add Weather plugin widget to your plugin area

== Frequently Asked Questions ==

== Screenshots ==


== Changelog ==

= 3.3 =
* bugix when weather string is blank set clear for weather

= 3.2 =
* solved bug for conditions after new year has started
* tested on 4.7

= 3.1 =
* removed print of the results after save
* tested on 4.5
* implement selective refresh for widget

= 3.0 =
* solved more bugs
* add input field for API key to the settings area
* made sure that api key is required in order for widget to be shown
* added drag & drop widget in widgets secions

= 2.0 =
* solved some bugs
* added input field for API key
* added uninstall functions

= 1.1.1 =
* another little bug solved

= 1.1 =
* solved bug with showing of the countries
* added F and °C for temperature strings

= 1.0 =
* First version of the plugin.
* Weather conditions change once per hour.
* Shows conditions and feels like string.
* Uses WU icons and weather font.