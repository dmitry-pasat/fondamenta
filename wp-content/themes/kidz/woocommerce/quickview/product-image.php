<?php
/**
 *    Quickview Product Image
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$attachment_ids = method_exists($product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
$slider_disabled_class = ( count( $attachment_ids ) == 0 ) ? ' ip-carousel-disabled' : ' slick-product-qv';

add_filter( 'single_product_large_thumbnail_size', 'ideapark_quickview_large_thumbnail_size', 99, 1 );
function ideapark_quickview_large_thumbnail_size( $thumbnail_size ) {
	return 'ideapark-shop-quickview';
}

add_filter( 'woocommerce_available_variation', 'ideapark_quickview_woocommerce_available_variation', 99, 1 );
function ideapark_quickview_woocommerce_available_variation( $variation ) {
	$attachment_id = get_post_thumbnail_id( $variation['variation_id'] );
	$attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
	$image         = $attachment ? current( $attachment ) : '';
	$image_srcset  = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'ideapark-shop-quickview' ) : false;
	$image_sizes   = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $attachment_id, 'ideapark-shop-quickview' ) : false;

	$variation = array_merge( $variation,
		array(
			'image_src'     => $image,
			'image_srcset'  => $image_srcset ? $image_srcset : '',
			'image_sizes'   => $image_sizes ? $image_sizes : ''
		) );

	return $variation;
}



?>

<div class="product-images images <?php echo $slider_disabled_class; ?>">
	<?php
	if ( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		echo apply_filters( 'woocommerce_quickview_single_product_image_html', '<div class="slide woocommerce-product-gallery__image">' . $image . '</div>', $post->ID );
	} else {
		echo apply_filters( 'woocommerce_quickview_single_product_image_html', sprintf( '<div class="slide woocommerce-product-gallery__image"><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), esc_attr__( 'Placeholder', 'woocommerce' ) ), $post->ID );
	}

	if ( $attachment_ids ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$image_link = wp_get_attachment_url( $attachment_id );

			if ( !$image_link ) {
				continue;
			}

			$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );

			echo apply_filters( 'woocommerce_quickview_single_product_image_html', '<div class="slide woocommerce-product-gallery__image">' . $image . '</div>', $post->ID );
		}
	}
	?>
</div>
