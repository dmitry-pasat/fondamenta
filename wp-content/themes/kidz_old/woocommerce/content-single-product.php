<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
add_action( 'woocommerce_single_product_summary', 'ideapark_single_product_summary_break', 23 );

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

global $post;

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row ip-single-product-nav">
		<div class="col-lg-12">
		<?php
		next_post_link( '%link', '<i class="next"><svg><use xlink:href="'. esc_url( ideapark_svg_url() ) .'#svg-angle-left" /></svg></i>', ideapark_mod('shop_product_navigation_same_term'), array(), 'product_cat' );
		previous_post_link( '%link', '<i class="prev"><svg><use xlink:href="'. esc_url( ideapark_svg_url() ) .'#svg-angle-right" /></svg></i>', ideapark_mod('shop_product_navigation_same_term'), array(), 'product_cat' );
		?>
		</div>
	</div>

	<div class="row">
		<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary <?php if ( ideapark_mod( 'product_hide_sidebar' ) ) { ?>col-lg-5 col-md-5<?php } elseif ( ideapark_mod( 'product_short_sidebar' ) ) { ?>>col-lg-4 col-md-4<?php } else { ?>col-lg-6 col-md-6<?php } ?> col-sm-12 col-xs-12">

			<div class="row">
				<div class="col-md-8 hidden-xs hidden-sm ip-product-images-col">
					<?php woocommerce_breadcrumb(); ?>
				</div>
				<?php if ( $ideapark_video = get_post_meta( $post->ID, '_ip_product_video_url', true ) ) { ?>
					<div class="col-xs-6 visible-sm visible-xs ip-product-video-col">
						<div class="watch-video">
							<a href="<?php echo esc_url( $ideapark_video ); ?>" target="_blank" class="ip-watch-video-btn">
								<svg>
									<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-play" />
								</svg>
								<span><?php _e( 'Video', 'kidz' ); ?></span>
							</a>
						</div>
					</div>
				<?php } ?>
				<div class="col-md-4 col-xs-<?php if ( !empty( $ideapark_video ) ) { ?>6<?php } else { ?>12<?php } ?> ip-product-stock-status">
					<?php ideapark_single_product_summary_availability(); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-6 break">
					<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
					?>
				</div>
			</div>

		</div><!-- .summary -->

		<?php if ( !ideapark_mod( 'product_hide_sidebar' ) && ideapark_mod( 'product_short_sidebar' ) ) { ?>
			<div class="col-md-3">
				<?php
				/**
				 * woocommerce_sidebar hook.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
				?>
			</div>
		<?php } ?>
	</div>

	<?php
	/**
	 * woocommerce_after_single_product_summary hook.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_
	 * related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php if ( !empty( $ideapark_video ) ) { ?>
	<?php if ( $embded_video = wp_oembed_get( $ideapark_video ) ) { ?>
		<input type="hidden" id="ip_hidden_product_video" value="<?php echo esc_js(wp_oembed_get( $ideapark_video )); ?>">
	<?php } ?>
<?php } ?>
