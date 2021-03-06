(function ($, root, undefined) {
	"use strict";

	$('.variations_form').on('show_variation', function () {
		var $this = $(this);
		var $availability_text = $this.find('.woocommerce-variation-availability p');
		var $ip_stock = $('.ip-stock');

		if ($availability_text.length) {
			var in_stock = $this.find('.woocommerce-variation-availability .in-stock').length;
			var stock_html = $availability_text.html();
			if (in_stock) {
				$ip_stock.removeClass('out-of-stock')
					.removeClass('ip-out-of-stock')
					.addClass('in-stock')
					.addClass('ip-in-stock')
					.html(ideapark_wc_add_to_cart_variation_vars.in_stock_svg + stock_html);
			} else {
				$ip_stock.removeClass('in-stock')
					.removeClass('ip-in-stock')
					.addClass('out-of-stock')
					.addClass('ip-out-of-stock')
					.html(ideapark_wc_add_to_cart_variation_vars.out_of_stock_svg + stock_html);
			}
		} else {
			$ip_stock.removeClass('out-of-stock')
				.removeClass('ip-out-of-stock')
				.removeClass('in-stock')
				.removeClass('ip-in-stock')
				.html('');
		}
	});

	/**
	 * Sets product images for the chosen variation
	 */
	$.fn.wc_variations_image_update = function (variation) {
		var $form = this,
			$product = $form.closest('.product'),
			$product_gallery = $product.find('.images'),
			$gallery_img = $product.find('.flex-control-nav li:eq(0) img'),
			$product_img_wrap = $product_gallery.find('.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder').eq(0),
			$product_img = $product_img_wrap.find('.wp-post-image'),
			$product_link = $product_img_wrap.find('a').eq(0);

		if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
			$product_img.wc_set_variation_attr('src', variation.image.src);
			$product_img.wc_set_variation_attr('height', variation.image.src_h);
			$product_img.wc_set_variation_attr('width', variation.image.src_w);
			$product_img.wc_set_variation_attr('srcset', variation.image.srcset);
			$product_img.wc_set_variation_attr('sizes', variation.image.sizes);
			$product_img.wc_set_variation_attr('title', variation.image.title);
			$product_img.wc_set_variation_attr('alt', variation.image.alt);
			$product_img.wc_set_variation_attr('data-src', variation.image.full_src);
			$product_img.wc_set_variation_attr('data-large_image', variation.image.full_src);
			$product_img.wc_set_variation_attr('data-large_image_width', variation.image.full_src_w);
			$product_img.wc_set_variation_attr('data-large_image_height', variation.image.full_src_h);
			$product_img_wrap.wc_set_variation_attr('data-thumb', variation.image.src);
			$gallery_img.wc_set_variation_attr('srcset', false);
			$gallery_img.wc_set_variation_attr('src', variation.image.src);
			$product_link.wc_set_variation_attr('href', variation.image.full_src);
		} else {
			$product_img.wc_reset_variation_attr('src');
			$product_img.wc_reset_variation_attr('width');
			$product_img.wc_reset_variation_attr('height');
			$product_img.wc_reset_variation_attr('srcset');
			$product_img.wc_reset_variation_attr('sizes');
			$product_img.wc_reset_variation_attr('title');
			$product_img.wc_reset_variation_attr('alt');
			$product_img.wc_reset_variation_attr('data-src');
			$product_img.wc_reset_variation_attr('data-large_image');
			$product_img.wc_reset_variation_attr('data-large_image_width');
			$product_img.wc_reset_variation_attr('data-large_image_height');
			$product_img_wrap.wc_reset_variation_attr('data-thumb');
			$gallery_img.wc_reset_variation_attr('src');
			$gallery_img.wc_reset_variation_attr('srcset');
			$product_link.wc_reset_variation_attr('href');
		}

		window.setTimeout(function () {
			$product_gallery.trigger('woocommerce_gallery_init_zoom');
			$form.wc_maybe_trigger_slide_position_reset(variation);
			$(window).trigger('resize');
		}, 10);
	};

})(jQuery, this);