<?php
/**
 * List tables: coupons.
 *
 * @author   WooCommerce
 * @category Admin
 * @package  WooCommerce/Admin
 * @version  3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Admin_List_Table_Coupons', false ) ) {
	return;
}

if ( ! class_exists( 'WC_Admin_List_Table', false ) ) {
	include_once( 'abstract-class-wc-admin-list-table.php' );
}

/**
 * WC_Admin_List_Table_Coupons Class.
 */
class WC_Admin_List_Table_Coupons extends WC_Admin_List_Table {

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $list_table_type = 'shop_coupon';

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_filter( 'disable_months_dropdown', '__return_true' );
	}

	/**
	 * Render blank state.
	 */
	protected function render_blank_state() {
		echo '<div class="woocommerce-BlankState">';
		echo '<h2 class="woocommerce-BlankState-message">' . esc_html__( 'Coupons are a great way to offer discounts and rewards to your customers. They will appear here once created.', 'woocommerce' ) . '</h2>';
		echo '<a class="woocommerce-BlankState-cta button-primary button" target="_blank" href="https://docs.woocommerce.com/document/coupon-management/?utm_source=blankslate&utm_medium=product&utm_content=couponsdoc&utm_campaign=woocommerceplugin">' . esc_html__( 'Learn more about coupons', 'woocommerce' ) . '</a>';
		echo '<a class="woocommerce-BlankState-cta button-primary button" href="' . esc_url ( admin_url( 'post-new.php?post_type=shop_coupon' ) ) . '">' . esc_html__( 'Create your first coupon', 'woocommerce' ) . '</a>';
		echo '</div>';
	}

	/**
	 * Define primary column.
	 *
	 * @return array
	 */
	protected function get_primary_column() {
		return 'coupon_code';
	}

	/**
	 * Get row actions to show in the list table.
	 *
	 * @param array   $actions Array of actions.
	 * @param WP_Post $post Current post object.
	 * @return array
	 */
	protected function get_row_actions( $actions, $post ) {
		unset( $actions['inline hide-if-no-js'] );
		return $actions;
	}

	/**
	 * Define which columns to show on this screen.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public function define_columns( $columns ) {
		$show_columns                = array();
		$show_columns['cb']          = $columns['cb'];
		$show_columns['coupon_code'] = __( 'Code', 'woocommerce' );
		$show_columns['type']        = __( 'Coupon type', 'woocommerce' );
		$show_columns['amount']      = __( 'Coupon amount', 'woocommerce' );
		$show_columns['description'] = __( 'Description', 'woocommerce' );
		$show_columns['products']    = __( 'Product IDs', 'woocommerce' );
		$show_columns['usage']       = __( 'Usage / Limit', 'woocommerce' );
		$show_columns['expiry_date'] = __( 'Expiry date', 'woocommerce' );

		return $show_columns;
	}

	/**
	 * Pre-fetch any data for the row each column has access to it. the_coupon global is there for bw compat.
	 *
	 * @param int $post_id Post ID being shown.
	 */
	protected function prepare_row_data( $post_id ) {
		global $the_coupon;

		if ( empty( $this->object ) || $this->object->get_id() !== $post_id ) {
			$this->object = $the_coupon = new WC_Coupon( $post_id );
		}
	}

	/**
	 * Render columm: coupon_code.
	 */
	protected function render_coupon_code_column() {
		global $post;

		$edit_link = get_edit_post_link( $this->object->get_id() );
		$title     = $this->object->get_code();

		echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) . '">' . esc_html( $title ) . '</a>';
		_post_states( $post );
		echo '</strong>';
	}

	/**
	 * Render columm: type.
	 */
	protected function render_type_column() {
		echo esc_html( wc_get_coupon_type( $this->object->get_discount_type() ) );
	}

	/**
	 * Render columm: amount.
	 */
	protected function render_amount_column() {
		echo esc_html( wc_format_localized_price( $this->object->get_amount() ) );
	}
	/**
	 * Render columm: products.
	 */
	protected function render_products_column() {
		$product_ids = $this->object->get_product_ids();

		if ( count( $product_ids ) > 0 ) {
			echo esc_html( implode( ', ', $product_ids ) );
		} else {
			echo '&ndash;';
		}
	}

	/**
	 * Render columm: usage_limit.
	 */
	protected function render_usage_limit_column() {
		$usage_limit = $this->object->get_usage_limit();

		if ( $usage_limit ) {
			echo esc_html( $usage_limit );
		} else {
			echo '&ndash;';
		}
	}

	/**
	 * Render columm: usage.
	 */
	protected function render_usage_column() {
		$usage_count = $this->object->get_usage_count();
		$usage_limit = $this->object->get_usage_limit();

		/* translators: 1: count 2: limit */
		printf(
			__( '%1$s / %2$s', 'woocommerce' ),
			esc_html( $usage_count ),
			$usage_limit ? esc_html( $usage_limit ) : '&infin;'
		);
	}

	/**
	 * Render columm: expiry_date.
	 */
	protected function render_expiry_date_column() {
		$expiry_date = $this->object->get_date_expires();

		if ( $expiry_date ) {
			echo esc_html( $expiry_date->date_i18n( 'F j, Y' ) );
		} else {
			echo '&ndash;';
		}
	}

	/**
	 * Render columm: description.
	 */
	protected function render_description_column() {
		echo wp_kses_post( $this->object->get_description() ? $this->object->get_description() : '&ndash;' );
	}

	/**
	 * Render any custom filters and search inputs for the list table.
	 */
	protected function render_filters() {
		?>
		<select name="coupon_type" id="dropdown_shop_coupon_type">
			<option value=""><?php esc_html_e( 'Show all types', 'woocommerce' ); ?></option>
			<?php
			$types = wc_get_coupon_types();

			foreach ( $types as $name => $type ) {
				echo '<option value="' . esc_attr( $name ) . '"';

				if ( isset( $_GET['coupon_type'] ) ) { // WPCS: input var ok.
					selected( $name, wc_clean( wp_unslash( $_GET['coupon_type'] ) ) ); // WPCS: input var ok, sanitization ok.
				}

				echo '>' . esc_html( $type ) . '</option>';
			}
			?>
		</select>
		<?php
	}

	/**
	 * Handle any custom filters.
	 *
	 * @param array $query_vars Query vars.
	 * @return array
	 */
	protected function query_filters( $query_vars ) {
		if ( ! empty( $_GET['coupon_type'] ) ) { // WPCS: input var ok, sanitization ok.
			// @codingStandardsIgnoreStart
			$query_vars['meta_key']   = 'discount_type';
			$query_vars['meta_value'] = wc_clean( wp_unslash( $_GET['coupon_type'] ) ); // WPCS: input var ok, sanitization ok.
			// @codingStandardsIgnoreEnd
		}
		return $query_vars;
	}
}
