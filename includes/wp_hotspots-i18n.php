<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/WsCandy/wp_hotspots
 * @since      1.0.0
 *
 * @package    Wordpress_Hotspots
 * @subpackage Wordpress_Hotspots/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Hotspots
 * @subpackage Wordpress_Hotspots/includes
 * @author     Samuel Woodbridge <s-bridge@live.co.uk>
 */
class Wordpress_Hotspots_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugin-name',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
