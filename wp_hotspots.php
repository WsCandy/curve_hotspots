<?php

	/**
	 *
	 * @link              https://github.com/WsCandy/wp_hotspots
	 * @since             1.0.0
	 * @package           Wordpress Hotspots
	 *
	 * @wordpress-plugin
	 * Plugin Name:      Wordpress Hotspots
	 * Plugin URI:       https://github.com/WsCandy/wp_hotspots
	 * Description:      Allow the inclusion of images with hotspots in your posts/pages.
	 * Version:          1.0.0
	 * Author:           Samuel Woodbridge
	 * Author URI:       https://github.com/WsCandy/
	 * License:          GPL-2.0+
	 * License URI:      http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:      plugin-name
	 * Domain Path:      /languages
	 */

	if ( ! defined( 'WPINC' ) ) {

		die;

	}

	function activate_Wordpress_Hotspots() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/wp_hotspots-activator.php';
		Wordpress_Hotspots_Activator::activate();

	}

	function deactivate_Wordpress_Hotspots() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/wp_hotspots-deactivator.php';
		Wordpress_Hotspots_Deactivator::deactivate();

	}

	register_activation_hook( __FILE__, 'activate_Wordpress_Hotspots' );
	register_deactivation_hook( __FILE__, 'deactivate_Wordpress_Hotspots' );

	require plugin_dir_path( __FILE__ ) . 'includes/wp_hotspots.php';

	function run_Wordpress_Hotspots() {

		$plugin = new Wordpress_Hotspots();
		$plugin->run();

	}

	run_Wordpress_Hotspots();
