<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function ideapark_woocommerce_functions() {
	if ( ! function_exists( 'wc_query_string_form_fields' ) ) {
		function wc_query_string_form_fields( $values = null, $exclude = array(), $current_key = '', $return = false ) {
			if ( is_null( $values ) ) {
				$values = $_GET; // WPCS: input var ok, CSRF ok.
			}
			$html = '';

			foreach ( $values as $key => $value ) {
				if ( in_array( $key, $exclude, true ) ) {
					continue;
				}
				if ( $current_key ) {
					$key = $current_key . '[' . $key . ']';
				}
				if ( is_array( $value ) ) {
					$html .= wc_query_string_form_fields( $value, $exclude, $key, true );
				} else {
					$html .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( wp_unslash( $value ) ) . '" />';
				}
			}

			if ( $return ) {
				return $html;
			} else {
				echo $html; // WPCS: XSS ok.
			}
		}
	}


	if ( ! function_exists( 'wc_get_cart_remove_url' ) ) {
		function wc_get_cart_remove_url( $cart_item_key ) {
			$cart_page_url = wc_get_page_permalink( 'cart' );

			return apply_filters( 'woocommerce_get_remove_url', $cart_page_url ? wp_nonce_url( add_query_arg( 'remove_item', $cart_item_key, $cart_page_url ), 'woocommerce-cart' ) : '' );
		}
	}
}

add_action( 'init', 'ideapark_woocommerce_functions' );