<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.3.2
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $post, $product, $woocommerce;

$attachment_ids = method_exists($product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop = 0;
	?>
	<div class="thumbnails slick-product flex-control-nav"><?php

	if ( has_post_thumbnail() ) {
		$loop  = 1;
		$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="current slide"><li>%s</li></div>', $image ), $post->ID );
	} else {
		$loop = 0;
	}

	foreach ( $attachment_ids as $attachment_id ) {

		$loop ++;

		$image_link = wp_get_attachment_url( $attachment_id );

		if ( !$image_link ) {
			continue;
		}

		$active_class = ( $loop == 1 ) ? ' class="slide current"' : ' class="slide"';
		$image        = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div%s><li>%s</li></div>', $active_class, $image ), $attachment_id, $post->ID );

	}

	?></div>
	<?php
}
