<?php

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       https://github.com/WsCandy/wp_hotspots
	 * @since      1.0.0
	 *
	 * @package    Wordpress_Hotspots
	 * @subpackage Wordpress_Hotspots/admin
	 */

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @package    Wordpress_Hotspots
	 * @subpackage Wordpress_Hotspots/admin
	 * @author     Samuel Woodbridge <s-bridge@live.co.uk>
	 */
	class Wordpress_Hotspots_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $Wordpress_Hotspots The ID of this plugin.
		 */
		private $Wordpress_Hotspots;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;


		/**
		 * @var     Options, store the Wordpress_Hotspots_Options object.
		 * @since   1.0.0
		 */
		private $options;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 *
		 * @param      string $Wordpress_Hotspots The name of this plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct( $Wordpress_Hotspots, $version ) {

			$this->load_dependencies();

			$this->Wordpress_Hotspots = $Wordpress_Hotspots;
			$this->version            = $version;
			$this->options = new Wordpress_Hotspots_Options();

		}

		public function load_dependencies() {

			/**
			 * The class responsible for defining option pages in the admin area.
			 */

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wp_hotspots-options.php';

		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			wp_enqueue_style( $this->Wordpress_Hotspots, plugin_dir_url( __FILE__ ) . 'css/wp_hotspots-admin.css', [ ], $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_script( $this->Wordpress_Hotspots, plugin_dir_url( __FILE__ ) . 'js/wp_hotspots-admin.js', [ 'jquery' ], $this->version, false );

		}

	}