<?php
/**
 * ASPWC meta box settings.
 *
 * Display the shipping settings in the meta box.
 *
 * @author		Jeroen Sormani
 * @package		Advanced Shipping Packages for WooCommerce
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_nonce_field( 'aspwc_meta_box', 'aspwc_meta_box_nonce' );

global $post;
$post_id = $post->ID;

$name               = get_post_meta( $post_id, '_name', true );
$condition_groups   = get_post_meta( $post_id, '_product_conditions', true );
$excluded_shipping  = (array) get_post_meta( $post_id, '_exclude_shipping', true );
$shipping_methods   = array();

// Get shipping methods from the 'shipping method' condition
$shipping_method_condition = wpc_get_condition( 'shipping_method' );
$field_args = $shipping_method_condition->get_value_field_args();
$shipping_methods = $field_args['options'];

?><div class='aspwc-meta-box aspwc-meta-box-settings'>

	<div class='aspwc-shipping-package'>

		<p class="aspwc-option">
			<label>
				<span class="aspwc-option-name"><?php _e( 'Package name', 'advanced-shipping-packages-for-woocommerce' ); ?></span>
				<input type="text" class="aspwc-input" name="_name" value="<?php echo wp_kses_post( $name ); ?>">
			</label><?php
			echo wc_help_tip( __( 'This is the name that will be displayed at the cart/checkout', 'advanced-shipping-packages-for-woocommerce' ) );
		?></p>

		<p class="aspwc-option">
			<label>
				<span class="aspwc-option-name"><?php _e( 'Exclude shipping methods', 'advanced-shipping-packages-for-woocommerce' ); ?></span>
				<select class="aspwc-input wc-enhanced-select" name="_exclude_shipping[]" multiple="multiple" placeholder="<?php _e( 'Exclude shipping options', 'advanced-shipping-packages-for-woocommerce' ); ?>"><?php
					foreach ( $shipping_methods as $optgroup => $methods ) :
						?><optgroup label='<?php echo esc_attr( $optgroup ); ?>'><?php
						foreach ( $methods as $k => $v ) :
							?><option value="<?php echo esc_attr( $k ); ?>" <?php selected( in_array( $k, $excluded_shipping ) ); ?>><?php echo esc_html( $v ); ?></option><?php
						endforeach;
					endforeach;
				?></select>
			</label><?php
			echo wc_help_tip( __( 'Exclude shipping methods from this package. Leave empty to allow all available methods.', 'advanced-shipping-packages-for-woocommerce' ) );
		?></p>

	</div>

	<br/>
	<hr/>

	<div class='wpc-conditions wpc-conditions-meta-box'>
		<div class='wpc-condition-groups'>

			<p>
				<strong><?php _e( 'Add the products that match one of the following rule groups to the package', 'advanced-shipping-packages-for-woocommerce' ); ?></strong><?php
			?></p><?php

			if ( ! empty( $condition_groups ) ) :

				foreach ( $condition_groups as $condition_group => $conditions ) :
					include 'html-product-condition-group.php';
				endforeach;

			else :

				$condition_group = '0';
				include 'html-product-condition-group.php';

			endif;

		?></div>

		<div class='wpc-condition-group-template hidden' style='display: none'><?php
			$condition_group = '9999';
			$conditions      = array();
			include 'html-product-condition-group.php';
		?></div>
		<a class='button wpc-condition-group-add' href='javascript:void(0);'><?php _e( 'Add \'Or\' group', 'woocommerce-advanced-messages' ); ?></a>

	</div>
</div>