<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

$product_link = ' href="' . esc_url( get_permalink() ) . '"';

if ( ideapark_mod( 'quickview_enabled' ) ) {
	$quickview_link = $product_link . ' data-title="' . __( 'Quick View', 'kidz' ) . '" data-product_id="' . esc_attr( $product->get_id() ) . '" class="ip-quickview-btn product_type_' . esc_attr( $product->get_type() ) . '"';
	if ( ideapark_mod( 'product_quickview_links' ) == 'all' ) {
		$product_link = $quickview_link;
	}
} else {
	$quickview_link = '';
}

ideapark_mod_set_temp( 'products_in_page', true );

?>
<li <?php post_class(); ?>>

	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>

	<div class="ip-shop-loop-wrap">

		<div class="ip-shop-loop-thumb">
			<a<?php echo $product_link; ?>>
				<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				?>

				<?php
				$placeholder_image = apply_filters( 'ideapark_shop_placeholder_img_src', IDEAPARK_THEME_URI . '/img/placeholder.gif' );

				if ( has_post_thumbnail() ) {
					add_filter( 'max_srcset_image_width', 'ideapark_woocommerce_max_srcset_image_width_768', 10, 2 );
					add_filter( 'wp_calculate_image_srcset', 'ideapark_woocommerce_srcset', 10, 5 );
					$product_thumbnail_id     = get_post_thumbnail_id();
					$product_thumbnail        = wp_get_attachment_image_src( $product_thumbnail_id, 'shop_catalog' );
					$product_thumbnail_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $product_thumbnail_id, 'shop_catalog' ) : false;
					$product_thumbnail_alt    = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
					remove_filter( 'max_srcset_image_width', 'ideapark_woocommerce_max_srcset_image_width_768', 10 );
					remove_filter( 'wp_calculate_image_srcset', 'ideapark_woocommerce_srcset', 10 );

					if ( empty( $product_thumbnail_alt ) ) {
						$product_thumbnail_alt = get_the_title();
					}

					if ( is_front_page() ) {
						$product_thumbnail_sizes = "(min-width: 1200px) 210px, (min-width: 992px) 241px, 360px";
					}

					echo '<img src="' . esc_url( $product_thumbnail[0] ) . '" ' . ( empty( $product_thumbnail_sizes ) ? 'width="' . esc_attr( $product_thumbnail[1] ) . '" height="' . esc_attr( $product_thumbnail[2] ) . '"' : '' ) . ' alt="' . esc_attr( $product_thumbnail_alt ) . '" class="thumb-shop-catalog ' . ( is_front_page() ? 'front' : '' ) . '" ' . ( $product_thumbnail_srcset ? ' srcset="' . esc_attr( $product_thumbnail_srcset ) . '"' : '' ) . ( ! empty( $product_thumbnail_sizes ) ? ' sizes="' . esc_attr( $product_thumbnail_sizes ) . '"' : '' ) . '/>';
				} else {
					if ( wc_placeholder_img_src() ) {
						echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" class="thumb-shop-catalog" alt=""/>';
					}
				}
				?>
			</a>
		</div>

		<div class="ip-shop-loop-details">
			<h3><a<?php echo $product_link; ?>><?php the_title(); ?></a></h3>

			<div class="ip-shop-loop-after-title">
				<div class="ip-shop-loop-price">
					<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook.
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
				</div>
				<div class="ip-shop-loop-actions">
					<?php
					if ( ideapark_mod( 'wishlist_enabled' ) && class_exists( 'Ideapark_Wishlist' ) ) {
						echo Ideapark_Wishlist()->button();
					}
					if ( $quickview_link ) {
						echo '<a' . $quickview_link . '><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-quick-view" /></svg></a>';
					}

					/**
					 * woocommerce_after_shop_loop_item hook.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</div>
			</div>
		</div>
	</div>
</li>