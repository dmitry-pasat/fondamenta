<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ideapark_Admin_Taxonomies {
	private $icon_ids = array();

	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'init' ), 100 );
	}

	public function init(  ) {

		$filename = get_template_directory() . '/img/sprite.svg';
		ideapark_init_theme_mods();

		if (!ideapark_mod('mega_menu') && is_file( $filename )) {

			add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 100 );
			add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 11 );
			add_action( 'created_term', array( $this, 'save_category_fields' ), 11, 3 );
			add_action( 'edit_term', array( $this, 'save_category_fields' ), 11, 3 );
			add_filter( 'manage_product_cat_custom_column', array( $this, 'product_cat_column' ), 11, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

			$t_xml = new DOMDocument();
			$t_xml->load( $filename );
			$symbols = $t_xml->getElementsByTagName( 'symbol' );
			foreach ( $symbols as $symbol ) {
				if ( preg_match( '~^svg-icon-\d+$~', $symbol->getAttribute( 'id' ) ) ) {
					$this->icon_ids[] = $symbol->getAttribute( 'id' );
				}
			}
		}
	}

	public function scripts( $hook ) {
		if ( 'edit-tags.php' != $hook && 'term.php' != $hook ) {
			return;
		}
		wp_enqueue_style( 'woocommerce-tax-extra-fields', get_template_directory_uri() . '/functions/woocommerce/woocommerce-tax-extra-fields.css', array() );
		wp_enqueue_script( 'woocommerce-tax-extra-fields', get_template_directory_uri() . '/functions/woocommerce/woocommerce-tax-extra-fields.js', array( 'jquery' ), '', true );
		wp_localize_script( 'woocommerce-tax-extra-fields', 'ideapark_wp_vars_wtef', array(
			'themeUri' => get_template_directory_uri(),
		) );
	}

	public function add_category_fields() {
		?>
		<div class="form-field term-display-type-wrap wtef-svg-icons">
			<label for="product_cat_svg_id"><?php esc_html_e( 'SVG Icon', 'kidz' ); ?></label>
			<ul>
				<?php foreach ( $this->icon_ids as $icon_id ) { ?>
					<li>
						<label>
							<input type="radio" name="product_cat_svg_id" value="<?php echo esc_attr( $icon_id ); ?>">
							<svg>
								<use xlink:href="#<?php echo esc_attr( $icon_id ); ?>" />
							</svg>
							<i></i>
						</label>
					</li>
				<?php } ?>
			</ul>
			<a class="clear" href="javascript: jQuery('input[name=product_cat_svg_id]').removeAttr('checked');jQuery('.wtef-svg-icons .clear').removeClass('show');">
				<svg>
					<use xlink:href="#svg-close" />
				</svg>
				<?php esc_html_e('clear icon', 'kidz'); ?>
			</a>
		</div>
		<?php
	}

	public function edit_category_fields( $term ) {
		$product_cat_svg_id = function_exists( 'get_term_meta' ) ? get_term_meta( $term->term_id, 'product_cat_svg_id', true ) : get_metadata( 'woocommerce_term', $term->term_id, 'product_cat_svg_id', true );
		?>
		<tr class="form-field wtef-svg-icons">
			<th scope="row" valign="top">
				<label><?php esc_html_e( 'SVG Icon', 'kidz' ); ?></label>
			</th>
			<td>
				<ul>
					<?php foreach ( $this->icon_ids as $icon_id ) { ?>
						<li>
							<label>
								<input type="radio" name="product_cat_svg_id" value="<?php echo esc_attr( $icon_id ); ?>"<?php checked( $icon_id, $product_cat_svg_id ); ?>>
								<svg>
									<use xlink:href="#<?php echo esc_attr( $icon_id ); ?>" />
								</svg>
								<i></i>
							</label>
						</li>
					<?php } ?>
				</ul>
				<a class="clear<?php if ($product_cat_svg_id) { ?> show<?php } ?>" href="javascript: jQuery('input[name=product_cat_svg_id]').removeAttr('checked');jQuery('.wtef-svg-icons .clear').removeClass('show');">
					<svg>
						<use xlink:href="#svg-close" />
					</svg>
					<?php esc_html_e( 'clear icon', 'kidz' ); ?>
				</a>
			</td>
		</tr>

		<?php
	}

	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ('product_cat' === $taxonomy) {
			if ( isset( $_POST['product_cat_svg_id'] ) ) {
				if ( function_exists( 'update_term_meta' ) ) {
					update_term_meta( $term_id, 'product_cat_svg_id', esc_attr( $_POST['product_cat_svg_id'] ) );
				} else {
					update_metadata( 'woocommerce_term', $term_id, 'product_cat_svg_id', esc_attr( $_POST['product_cat_svg_id'] ) );
				}
			} else {
				if ( function_exists( 'delete_term_meta' ) ) {
					delete_term_meta( $term_id, 'product_cat_svg_id' );
				} else {
					delete_metadata( 'woocommerce_term', $term_id, 'product_cat_svg_id' );
				}
			}
		}
	}

	public function product_cat_column( $columns, $column, $id ) {

		if ( 'thumb' == $column ) {

			if ( $product_cat_svg_id = function_exists( 'get_term_meta' ) ? get_term_meta( $id, 'product_cat_svg_id', true ) : get_metadata( 'woocommerce_term', $id, 'product_cat_svg_id', true ) ) {
				$columns = '<svg alt="' . esc_attr__( 'Thumbnail', 'kidz' ) . '" class="wp-post-image wtef-svg-icon" height="48" width="48" ><use xlink:href="#' . esc_attr( $product_cat_svg_id ) . '"/></svg>';
			}
		}

		return $columns;
	}

}

new Ideapark_Admin_Taxonomies();
