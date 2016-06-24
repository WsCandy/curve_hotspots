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
	class Wordpress_Hotspots_Meta {

		public $type;

		public function __construct( $type = null ) {

			$this->type = $type;

			add_action( 'add_meta_boxes', [ $this, 'add_meta' ] );

		}

		public function add_meta() {

			add_meta_box( 'hotpsots', 'Hotspots', [ $this, 'test' ], $this->type, 'advanced', 'high' );

		}

		public function test() { ?>

			<div class="hotspot__background">

				<input type="hidden">

				<div class="hotspot__label">
					<label for="">Image</label>
					<p class="description">
						Select or upload an image you would like to place hotspots on.
					</p>
				</div>
				<p>
					No image selected <a class="button  hotspot__add" href="javascript:void(0);">Add Image</a>
				</p>
				<div class="hotspot__image"></div>
			</div>

		<? }

	}