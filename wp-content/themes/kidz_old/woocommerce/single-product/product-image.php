<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version 3.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
?>

<div class="ip-product-thumbnails-col col-md-1 hidden-sm hidden-xs">
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	<?php if ( $video_url = get_post_meta( $post->ID, '_ip_product_video_url', true ) ) { ?>
		<div class="watch-video">
			<a href="<?php echo esc_url( $video_url ); ?>" target="_blank" class="ip-watch-video-btn">
				<svg>
					<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-play" />
				</svg>
				<span><?php _e( 'Video', 'kidz' ); ?></span>
			</a>
		</div>
	<?php } ?>
</div>

<div class="images ip-product-images-col <?php if ( ideapark_mod( 'product_hide_sidebar' ) ) { ?>col-lg-6 col-md-6<?php } elseif ( ideapark_mod( 'product_short_sidebar' ) ) { ?>col-lg-4 col-md-4<?php } else { ?>col-lg-5 col-md-5<?php } ?> col-sm-12">

	<div class="wrap">
		<div class="slick-product-single<?php if (ideapark_mod( 'shop_product_modal' )) { ?> product-modal-gallery<?php } ?>">
			<?php
			if ( has_post_thumbnail() ) {

				$image_title = esc_attr( get_the_title( $post->ID ) );
				$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'alt' => $image_title
				) );
				$zoom_class  = '';

				if ( ideapark_mod( 'shop_product_modal' ) ) {
					$full_image       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$image_wrap_open  = sprintf( '<a href="%s" class="ip-product-image-link zoom" data-size="%sx%s" itemprop="image">', esc_url( $full_image[0] ), intval( $full_image[1] ), intval( $full_image[2] ) );
					$image_wrap_close = '</a>';
				} else {
					$image_wrap_open  = '';
					$image_wrap_close = '';
				}

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="slide woocommerce-product-gallery__image">%s%s%s</div>', $image_wrap_open, $image, $image_wrap_close ), $post->ID );

			} else {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="slide woocommerce-product-gallery__image"><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), esc_attr__( 'Placeholder', 'woocommerce' ) ), $post->ID );

			}

			$attachment_ids = method_exists($product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

			if ( $attachment_ids ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );

					if ( !$image_link ) {
						continue;
					}

					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
						'alt' => $image_title
					) );

					if ( ideapark_mod( 'shop_product_modal' ) ) {
						$full_image       = wp_get_attachment_image_src( $attachment_id, 'full' );
						$image_wrap_open  = sprintf( '<a href="%s" class="ip-product-image-link" data-size="%sx%s" itemprop="image">', esc_url( $full_image[0] ), intval( $full_image[1] ), intval( $full_image[2] ) );
						$image_wrap_close = '</a>';
					} else {
						$image_wrap_open  = '';
						$image_wrap_close = '';
					}

					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="slide woocommerce-product-gallery__image">%s%s%s</div>', $image_wrap_open, $image, $image_wrap_close ), $post->ID );
				}

			}
			?>
		</div>
		<?php woocommerce_show_product_sale_flash(); ?>
	</div>
</div>
