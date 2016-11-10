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
		public $shopify;
		public $new_meta;
		public $products;
		public $ws_class;
		public $collections;

		public function __construct( $type = null ) {

			$this->type     = $type;

			add_action( 'add_meta_boxes', [ $this, 'add_meta' ] );
			add_action( 'save_post', [ $this, 'validate_meta' ] );

			add_action( 'plugins_loaded', [ $this, 'call_wordpress_shopify' ] );

		}

		public function call_wordpress_shopify () {

			if( class_exists( 'Wordpress_Shopify_Api' ) ) {

				$this->ws_class = true;
				$this->shopify = Wordpress_Shopify_Api::forge( ENDPOINT_COLLECTIONS );

				$this->collections = $this->shopify->get_collections();

			} else {

				$this->ws_class = false;

			}

		}

		public function add_meta() {

			add_meta_box( 'hotpsots', 'Hotspots', [ $this, 'render_meta' ], $this->type, 'advanced', 'high' );

		}

		public function render_meta() {

			global $post;

			$this->meta = get_post_meta( $post->ID, '_hotspots', true );

			if ( $this->meta === '' ) {
				$this->meta = [ ];
			}

			if( !$this->ws_class ) {

				print (

					'<div class="notice notice-error is-dismissible"><p>Wordpress Shopify plugin is required.</p></div>'

				);

			}

			?>

			<div class="hotspot__background">

				<script>
					window.shop_url = '<?= get_home_url().'/wp-json/shopify/v1/products/' ?>';
					window.collections = <?= json_encode($this->collections) ?>;
				</script>

				<?php wp_nonce_field( basename( __FILE__ ), 'hotspot_nonce' ); ?>

				<input type="hidden" name="hotspot_bg" id="hotspot_bg" value="<?= $this->meta['background'] ? $this->meta['background'] : null; ?>">

				<div class="hotspot__label">
					<label>Image</label>
					<p class="description">
						Select or upload an image you would like to place hot spots on.
					</p>
				</div>
				<p>
					<? if ( $this->meta['background'] ) : ?>
						<a class="button  button-primary hotspot__image__add" href="javascript:void(0);">Replace Image</a>
					<? else : ?>
						<a class="button  hotspot__image__add" href="javascript:void(0);">Add Image</a>
					<? endif; ?>
					<a href="javascript:void(0);" class="button hotspot__image__delete<?= $this->meta['background'] ? '' : '  hidden' ?>">Remove Image</a>
				</p>
				<div class="hotspot__image">
					<a href="javascript: void(0);" class="hotspot__add">&plus;</a>
					<? if ( $this->meta['background'] ) : ?>
						<img src="<?= wp_get_attachment_image_src( $this->meta['background'], 'original' )[0]; ?>" class="hotspot__bg">
					<? endif; ?>
					<? if ( $this->meta['hotspots'] ) : ?>
						<? foreach ( $this->meta['hotspots'] as $id => $spot ) : ?>
							<a class="hotspot__point" data-id="<?= $id ?>" style="top: <?= $spot['y'] ?>%; left: <?= $spot['x'] ?>%;">
								<?= $id ?>
								<input type="hidden" name="hotspots[<?= $id ?>][x]" value="<?= $spot['x'] ?>" class="hotspot__x">
								<input type="hidden" name="hotspots[<?= $id ?>][y]" value="<?= $spot['y'] ?>" class="hotspot__y">
							</a>
						<? endforeach; ?>
					<? endif ?>
				</div>
			</div>

			<div class="hotspot__details">
				<? if ( $this->meta['hotspots'] ) : ?>
					<? foreach ( $this->meta['hotspots'] as $id => $spot ) : ?>
						<div id="hotspot_detail_<?= $id; ?>" class="hotspot__detail" data-id="<?= $id; ?>">
							<div class="hotspot__detail__header">
								<span class="hotspot__id"><?= $id ?></span>Hot spot<span class="hotspot__delete" data-id="<?= $id; ?>">&minus;</span>
							</div>
							<div class="hotspot__detail__left">
								<input type="hidden" name="hotspots[<?= $id ?>][image]" id="hotspot_detail_image_<?= $id ?>" value="<?= $spot['image'] ? $spot['image'] : null; ?>">
								<div class="hotspot__label">
									<label>Image</label>
									<p class="description">
										Select an image to display for this hot spot.
									</p>
								</div>
								<p>
									<? if ( $spot['image'] ) : ?>
										<a class="button  button-primary hotspot__image__add" href="javascript:void(0);">Replace Image</a>
									<? else : ?>
										<a class="button  hotspot__image__add" href="javascript:void(0);">Add Image</a>
									<? endif; ?>
									<a href="javascript:void(0);" class="button hotspot__image__delete<?= $spot['image'] ? '' : '  hidden' ?>">Remove Image</a>
								</p>
								<div class="hotspot__image">
									<a href="javascript: void(0);" class="hotspot__add">&plus;</a>
									<? if ( $spot['image'] ) : ?>
										<img src="<?= wp_get_attachment_image_src( $spot['image'], 'original' )[0]; ?>" class="hotspot__bg">
									<? endif; ?>
									<? if ( $spot['hotspots'] ) : ?>
										<? foreach ( $spot['hotspots'] as $sub_id => $sub_spot ) : ?>
											<a class="hotspot__point" data-id="<?= $sub_id ?>" style="top: <?= $sub_spot['y'] ?>%; left: <?= $sub_spot['x'] ?>%;">
												<?= $sub_id ?>
												<input type="hidden" name="hotspots[<?= $id ?>][hotspots][<?= $sub_id ?>][x]" value="<?= $sub_spot['x'] ?>" class="hotspot__x">
												<input type="hidden" name="hotspots[<?= $id ?>][hotspots][<?= $sub_id ?>][y]" value="<?= $sub_spot['y'] ?>" class="hotspot__y">
											</a>
										<? endforeach; ?>
									<? endif ?>
								</div>
							</div>
							<div class="hotspot__detail__right">
								<? if ( $spot['hotspots'] ) : ?>
									<? foreach ( $spot['hotspots'] as $sub_id => $sub_spot ) : ?>
										<div class="hotspot__detail" data-id="<?= $sub_id; ?>">
											<div class="hotspot__detail__header">
												<span class="hotspot__id"><?= $sub_id ?></span>Hot spot<span class="hotspot__delete" data-id="<?= $sub_id; ?>">&minus;</span>
											</div>
											<div class="hotspot__detail__full">

												<? /* COLLECTIONS */ ?>
												<div class="hotspot__label">
													<label>Collection</label>
												</div>

												<select name="hotspots[<?= $id ?>][hotspots][<?= $sub_id ?>][collection]" class="hotspot__collection">
													<option value="">Select a Collection</option>
													<? foreach ( $this->collections as $collection ) : ?>

														<option value="<?= $collection->id; ?>"<?= $collection->id === (int) $sub_spot['collection'] ? '  selected' : null ?>><?= $collection->title; ?></option>

													<? endforeach; ?>
												</select>

												<? /* PRODUCTS */ ?>
												<div class="hotspot__label">
													<label>Product</label>
													<span class="hotspot__spinner"></span>
												</div>

												<?
													$this->shopify = Wordpress_Shopify_Api::forge( ENDPOINT_PRODUCTS, [ 'collection_id' => $sub_spot['collection'] ] );
													$this->products = $this->shopify->get_products();
												?>

												<select name="hotspots[<?= $id ?>][hotspots][<?= $sub_id ?>][product]" class="hotspot__product">
													<option value="">Select a Product</option>
													<? if($this->products): ?>

														<? foreach ( $this->products as $product ) : ?>

															<option value="<?= $product->id; ?>"<?= $product->id === (int) $sub_spot['product'] ? '  selected' : null ?>><?= $product->title; ?></option>

														<? endforeach; ?>

													<? endif; ?>
												</select>

												<div class="hotspot__label">
													<label>Alignment</label>
													<p class="description">Which side of the hotspot would you like the label to appear on?</p>
												</div>

												<select name="hotspots[<?= $id ?>][hotspots][<?= $sub_id ?>][alignment]">
													<option value="left"<?= $sub_spot['alignment'] === 'left' ? '  selected' : null ?>>Left</option>
													<option value="right"<?= $sub_spot['alignment'] === 'right' ? '  selected' : null ?>>Right</option>
												</select>

											</div>
										</div>
									<? endforeach; ?>
								<? endif; ?>
							</div>
						</div>
					<? endforeach; ?>
				<? endif; ?>
			</div>

		<? }

		public function validate_meta( $post_id ) {

			$post           = get_post( $post_id );
			$this->meta     = get_post_meta( $post_id, '_hotspots', true );
			$this->new_meta = $this->meta;

			$post_type = get_post_type_object( $post->post_type );

			if ( ! isset( $_POST['hotspot_nonce'] ) || ! wp_verify_nonce( $_POST['hotspot_nonce'], basename( __FILE__ ) ) ) {

				return false;

			}

			if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {

				return false;

			}

			$this->save_meta( $post_id );

		}

		public function save_meta( $post_id ) {

			$this->new_meta['background'] = $_POST['hotspot_bg'];
			$this->new_meta['hotspots']   = $_POST['hotspots'];

			if ( isset( $this->new_meta['hotspots'] ) ) {

				ksort( $this->new_meta['hotspots'] );

				foreach ( $this->new_meta['hotspots'] as $key => $hotspot ) {

					if ( isset( $this->new_meta['hotspots'][ $key ]['hotspots'] ) ) {

						ksort( $this->new_meta['hotspots'][ $key ]['hotspots'] );

					}

				}

			}

			if ( empty( $this->meta ) ) {

				add_post_meta( $post_id, '_hotspots', $this->new_meta, true );

			} else {

				update_post_meta( $post_id, '_hotspots', $this->new_meta, $this->meta );

			}

		}

	}
