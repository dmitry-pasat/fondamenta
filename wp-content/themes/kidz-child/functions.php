<?php
/**
 * Kidz-Child functions and definitions
 *
 * @package kidz-child
 */

/** Loading language **/
add_action( 'after_setup_theme', 'kidz_child_theme_setup' );
function kidz_child_theme_setup() {
	load_child_theme_textdomain( 'kidz', get_stylesheet_directory() . '/languages' );
	load_textdomain( 'ideapark-wishlist', get_stylesheet_directory() . '/languages/' . 'ideapark-wishlist' . '-' . apply_filters( 'plugin_locale', get_locale(), 'ideapark-wishlist' ) . '.mo' );
	load_textdomain( 'ideapark-theme-functionality', get_stylesheet_directory() . '/languages/' . 'ideapark-theme-functionality' . '-' . apply_filters( 'plugin_locale', get_locale(), 'ideapark-theme-functionality' ) . '.mo' );
}

/** Enqueue the child theme stylesheet **/
add_action( 'wp_enqueue_scripts', 'kidz_child_enqueue_scripts', 100 );
function kidz_child_enqueue_scripts() {
	wp_enqueue_style( 'kidz-child-style', get_stylesheet_directory_uri() . '/style.css' );
}
