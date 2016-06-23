<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/WsCandy/wp_hotspots
 * @since      1.0.0
 *
 * @package    Wordpress_Hotspots
 * @subpackage Wordpress_Hotspots/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Hotspots
 * @subpackage Wordpress_Hotspots/public
 * @author     Samuel Woodbridge <s-bridge@live.co.uk>
 */
class Wordpress_Hotspots_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Wordpress_Hotspots    The ID of this plugin.
	 */
	private $Wordpress_Hotspots;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Wordpress_Hotspots       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Wordpress_Hotspots, $version ) {

		$this->Wordpress_Hotspots = $Wordpress_Hotspots;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Hotspots_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Hotspots_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Wordpress_Hotspots, plugin_dir_url( __FILE__ ) . 'css/wp_hotspots-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Hotspots_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Hotspots_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Wordpress_Hotspots, plugin_dir_url( __FILE__ ) . 'js/wp_hotspots-public.js', array( 'jquery' ), $this->version, false );

	}

}
