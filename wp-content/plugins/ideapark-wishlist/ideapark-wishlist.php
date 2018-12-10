<?php
/*
 * Plugin Name: Kidz Theme Wishlist
 * Version: 1.2
 * Description: Woocommerce Wishlist plugin for the Kidz theme.
 * Author: ideapark.kz
 * Author URI: http://ideapark.kz
 * Text Domain: ideapark-wishlist
 * Domain Path: /lang/
 * WC requires at least: 3.0.0
 * WC tested up to: 3.3.1
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$theme_obj = wp_get_theme( );

if ( empty($theme_obj) || strtolower($theme_obj->get( 'Name' )) != 'kidz' && strtolower($theme_obj->get( 'Name' )) != 'kidz-child' ) {
	function ideapark_wishlist_wrong_theme( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$row_meta = array(
				'warning' =>  '<b>' . esc_html__( 'This plugin works only with Kidz theme', 'ideapark-wishlist' ) . '</b>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}
	add_filter( 'plugin_row_meta','ideapark_wishlist_wrong_theme', 10, 2 );
}

// Load plugin class files
require_once( dirname( __FILE__ ) . '/includes/class-ideapark-wishlist.php' );

/**
 * Returns the main instance of Ideapark_Wishlist to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ideapark_Wishlist
 */
function Ideapark_Wishlist () {
	return Ideapark_Wishlist::instance( __FILE__, '1.0.1' );
}

Ideapark_Wishlist();

function ideapark_is_wishlist_page(){
	global $post;
	return ( is_page() && ideapark_mod( 'wishlist_page' ) && ideapark_mod( 'wishlist_enabled' ) && class_exists( 'Ideapark_Wishlist' ) && ideapark_mod( 'wishlist_page' ) == $post->ID );
}
