<?php

	/**
	 * The options page for the plugin.
	 *
	 * @link       https://github.com/WsCandy/wp_hotspots
	 * @since      1.0.0
	 *
	 * @package    Wordpress_Hotspots
	 * @subpackage Wordpress_Hotspots/admin
	 */

	/**
	 * @package    Wordpress_Hotspots
	 * @subpackage Wordpress_Hotspots/admin
	 * @author     Samuel Woodbridge <s-bridge@live.co.uk>
	 */
	class Wordpress_Hotspots_Options {

		/**
		 * Wordpress_Hotspots_Options constructor.
		 *
		 * @since   1.0.0
		 */

		public function __construct() {

			add_action( 'admin_menu', [ $this, 'create_menu' ] );
			add_action( 'admin_init', [ $this, 'register_settings' ] );
			add_action( 'admin_init', [ $this, 'define_settings' ] );

		}

		/**
		 * Create the admin menu.
		 *
		 * @since   1.0.0
		 */

		public function create_menu() {

			add_menu_page(
				'Hotspots',
				'Hotspots',
				'administrator',
				'wp-hotspots',
				[ $this, 'create_option_page' ],
				'dashicons-sticky',
				2

			);

		}

		/**
		 * Create the options page.
		 *
		 * @since   1.0.0
		 */

		public function create_option_page() { ?>

			<div class="wrap">
				<h1>WP Hotspots Settings</h1>
				<form method="post" action="options.php">
					<?
						settings_fields( 'wp_hotspots_main' );
						do_settings_sections( 'wp-hotspots' );
						submit_button();
					?>
				</form>
			</div>


		<? }

		/**
		 * Register the plugin settings
		 *
		 * @since   1.0.0
		 */

		public function register_settings() {

			register_setting(

				'wp_hotspots_main',
				'hotspots_main'

			);

		}

		/**
		 * Define the settings for the page
		 *
		 * @since   1.0.0
		 */

		public function define_settings() {

			add_settings_section(

				'sections_main',
				'Main Settings',
				[ $this, 'print_section_info' ],
				'wp-hotspots'

			);

			add_settings_field(

				'post_type',
				'Post Type',
				[ $this, 'add_post_type' ],
				'wp-hotspots',
				'sections_main'

			);

		}

		/**
		 * Add the field to the option page
		 *
		 * @since   1.0.0
		 */

		public function add_post_type() { ?>

			<? $post_types = get_post_types(); ?>

			<select id="post_type" name="hotspots_main[post_type]">
				<? foreach($post_types as $type) :?>
					<? $data = get_post_type_object( $type ) ;?>
					<option value="<?= $type ;?>"<?= get_option('hotspots_main')['post_type'] === $type ? ' selected' : null ?>><?= $data->labels->name ;?></option>
				<? endforeach;?>
			</select>
			<p class="description">Which post type would you like the fields to appear on?</p>

		<? }

		/**
		 * Print some information about the options page
		 *
		 * @since   1.0.0
		 */

		public function print_section_info() {

			printf( 'Please configure your settings below.' );

		}

	}