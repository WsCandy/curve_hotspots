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
		public $meta;
		public $new_meta;

		public function __construct( $type = null ) {

			$this->type = $type;

			add_action( 'add_meta_boxes', [ $this, 'add_meta' ] );
			add_action( 'save_post', [ $this, 'validate_meta' ] );

		}

		public function add_meta() {

			add_meta_box( 'hotpsots', 'Hotspots', [ $this, 'render_meta' ], $this->type, 'advanced', 'high' );

		}

		public function render_meta() {

			global $post;

			$this->meta = get_post_meta($post->ID, '_hotspots', true);

			if($this->meta === '') {
				$this->meta = [];
			}

			?>

			<div class="hotspot__background">

				<?php wp_nonce_field( basename( __FILE__ ), 'hotspot_nonce' ); ?>

				<input type="hidden" name="hotspot_bg" id="hotspot_bg">

				<div class="hotspot__label">
					<label for="">Image</label>
					<p class="description">
						Select or upload an image you would like to place hotspots on.
					</p>
				</div>
				<p>
				<? if($this->meta['background']) :?>
					<a class="button  button-primary hotspot__add" href="javascript:void(0);">Replace Image</a>
				<? else :?>
					<a class="button  hotspot__add" href="javascript:void(0);">Add Image</a>
				<? endif;?>
				</p>
				<div class="hotspot__image">
					<? if($this->meta['background']) :?>
						<img src="<?= wp_get_attachment_image_src($this->meta['background'], 'original')[0];?>" class="hotspot__bg">
					<? endif;?>
				</div>
			</div>

		<? }

		public function validate_meta( $post_id ) {

			$post = get_post($post_id);
			$this->meta = get_post_meta($post_id, '_hotspots', true);
			$this->new_meta = $this->meta;

			$post_type = get_post_type_object( $post->post_type );

			if ( ! isset( $_POST['hotspot_nonce'] ) || ! wp_verify_nonce( $_POST['hotspot_nonce'], basename( __FILE__ ) ) ) {

				return false;

			}

			if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {

				return false;

			}

			$this->save_meta($post_id);

		}

		public function save_meta( $post_id ) {

			$this->new_meta['background'] = $_POST['hotspot_bg'];

			if(empty($this->meta)) {

				add_post_meta($post_id, '_hotspots', $this->new_meta, true);

			} else {

				update_post_meta($post_id, '_hotspots', $this->new_meta, $this->meta);

			}

		}

	}