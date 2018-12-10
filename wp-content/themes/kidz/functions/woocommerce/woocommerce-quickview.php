<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function ip_ajax_load_product() {
	global $woocommerce, $product, $post;

	$product = wc_get_product( $_POST['product_id'] );
	$post    = get_post( $_POST['product_id'] );

	setup_postdata( $post );

	ob_start();
	wc_get_template_part( 'quickview/content', 'quickview' );

	wp_reset_postdata();

	echo ob_get_clean();

	exit;
}

function ideapark_qv_product_summary_actions() {
	global $product;
	echo '<div class="ip-product-share-wrap">';
	if ( ideapark_mod( 'wishlist_enabled' ) && class_exists( 'Ideapark_Wishlist' ) ) {
		echo '<div class="ip-product-wishlist-button">';
		Ideapark_Wishlist()->button( true );
		echo '</div>';
	}
	echo '<div class="ip-product-share"><a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="ip-qv-details-button button">' . esc_html__( 'Show Full Details', 'kidz' ) . '</a></div>';
	echo '</div>';
}

function ideapark_qv_product_summary_availability() {
	echo '<div class="ip-product-stock-status">';
	ideapark_single_product_summary_availability();
	echo '</div>';
}

add_action( 'wp_ajax_ip_ajax_load_product', 'ip_ajax_load_product' );
add_action( 'wp_ajax_nopriv_ip_ajax_load_product', 'ip_ajax_load_product' );
add_action( 'wc_ajax_ip_ajax_load_product', 'ip_ajax_load_product' );