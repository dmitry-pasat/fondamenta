<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class ASPWC_Admin_Settings.
 *
 * Admin settings class handles everything related to settings.
 *
 * @class		ASPWC_Admin_Settings
 * @version		1.0.0
 * @author		Jeroen Sormani
 */
class ASPWC_Admin_Settings {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Initialize class
		add_action( 'admin_init', array( $this, 'init' ), 11 );

	}


	/**
	 * Initialize class.
	 *
	 * Initialize the class components/hooks on admin_init so its called once.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Save settings
		add_action( 'woocommerce_settings_save_shipping', array( $this, 'update_options' ) );

		// Keep WC menu open while in WAS edit screen
		add_action( 'admin_head', array( $this, 'menu_highlight' ) );

		// Add 'extra shipping options' shipping section
		add_action( 'woocommerce_get_sections_shipping', array( $this, 'add_section' ) );

		// Add settings to 'Packages' section
		add_action( 'woocommerce_settings_shipping', array( $this, 'section_settings' ) );

		// Table field type
		add_action( 'woocommerce_admin_field_advanced_shipping_packages_settings_table', array( $this, 'generate_table_field' ) );

	}


	/**
	 * Settings page array.
	 *
	 * Get settings page fields array.
	 *
	 * @since 1.0.0
	 */
	public function get_settings() {

		$settings = apply_filters( 'advanced_shipping_packages_for_woocommerce_settings', array(

			array(
				'title' => __( 'Advanced Shipping Packages', 'advanced-shipping-packages-for-woocommerce' ),
				'type'  => 'title',
			),

			array(
				'title'    => __( 'Enable/Disable', 'advanced-shipping-packages-for-woocommerce' ),
				'desc'     => __( 'Enable Advanced Shipping Packages', 'advanced-shipping-packages-for-woocommerce' ),
				'id'       => 'enable_woocommerce_advanced_shipping_packages',
				'default'  => 'yes',
				'type'     => 'checkbox',
				'autoload' => false
			),

			array(
				'title'    => __( 'Default package name', 'advanced-shipping-packages-for-woocommerce' ),
				'placeholder' => __( 'Leave empty to use default package name', 'advanced-shipping-packages-for-woocommerce' ),
				'id'       => 'advanced_shipping_packages_default_package_name',
				'default'  => '',
				'class'    => 'regular-input',
				'type'     => 'text',
				'autoload' => false
			),

			array(
				'title' => __( 'Advanced Shipping Packages', 'advanced-shipping-packages-for-woocommerce' ),
				'type'  => 'advanced_shipping_packages_settings_table',
			),

			array(
				'type' => 'sectionend',
			),

		) );

		return $settings;

	}


	/**
	 * Save settings.
	 *
	 * Save settings based on WooCommerce save_fields() method.
	 *
	 * @since 1.0.0
	 */
	public function update_options() {

		global $current_section;

		if ( $current_section == 'advanced_shipping_packages' ) {
			WC_Admin_Settings::save_fields( $this->get_settings() );
		}

	}


	/**
	 * Keep menu open.
	 *
	 * Highlights the correct top level admin menu item for post type add screens.
	 *
	 * @since 1.0.0
	 */
	public function menu_highlight() {

		global $parent_file, $submenu_file, $post_type;

		if ( 'shipping_package' == $post_type ) :
			$parent_file  = 'woocommerce';
			$submenu_file = 'wc-settings';
		endif;

	}


	/**
	 * Add shipping section.
	 *
	 * Add a new 'extra shipping options' section under the shipping tab.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $sections List of existing shipping sections.
	 * @return array           List of modified shipping sections.
	 */
	public function add_section( $sections ) {

		$sections['advanced_shipping_packages'] = __( 'Packages', 'advanced-shipping-packages-for-woocommerce' );

		return $sections;

	}


	/**
	 * ASPWC settings.
	 *
	 * Add the settings to the Extra Shipping Options shipping section.
	 *
	 * @since 1.0.0
	 *
	 * @param string $current_section Slug of the current section
	 */
	public function section_settings( $current_section ) {

		global $current_section;

		if ( 'advanced_shipping_packages' !== $current_section ) :
			return;
		endif;

		$settings = $this->get_settings();
		WC_Admin_Settings::output_fields( $settings );

	}


	/**
	 * Table field type.
	 *
	 * Load and render table as a field type.
	 *
	 * @return string
	 */
	public function generate_table_field() {

		// Shipping Packages table
		require_once plugin_dir_path( __FILE__ ) . 'views/html-advanced-shipping-packages-table.php';

	}


}
