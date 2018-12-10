<?php

function ideapark_customize_css() {

	$custom_css = '';
	if ( ideapark_mod( 'custom_css_ip' ) ) {
		$custom_css .= html_entity_decode( ideapark_mod( 'custom_css_ip' ) );
	}

	if (ideapark_mod( 'accent_color_custom' ) && strtoupper( ideapark_mod( 'accent_color_custom' ) ) != '#56B0F2' ) {
		$custom_css .= ' 
	
		/* custom-accent */
		
		input[type=submit],
		button,
		.widget a.button,
		.collaterals a.button,
		.shop-content a.button,
		.ip-product-container .summary a.alt.button,
		.page-links span,
		.navigation .current,
		#home-review,
		.woocommerce-pagination .current,
		.widget.widget_price_filter .ui-widget-header,
		.widget.widget_price_filter .ui-slider-handle,
		.ip-shop-loop-wrap .onsale,
		.ip-product-container .onsale{
			background: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.ip-shop-loop-loading i {
			background-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.error-page h2,
		#ajax-search-result .actions a,
		.entry-content a,
		.search-container .results-list .actions a,
		.ip-shop-loop-price .price,
		.home-tabs li.current a,
		.woocommerce-tabs .tabs li.active a,
		#home-post .more,
		.widget.widget_product_categories li,
		.widget.widget_layered_nav li.chosen,
		.widget.widget_layered_nav li.chosen a,
		.widget.widget_layered_nav_filters li.chosen,
		.widget.widget_layered_nav_filters li.chosen a,
		.widget.widget_product_categories li a,
		.widget.widget_shopping_cart a.button.checkout,
		#footer .widget.widget_shopping_cart a.button.checkout,
		a.ip-wishlist-btn,
		.ip-shop-loop-actions a,
		.shop-content .ip-shop-loop-actions a.button,
		.woocommerce-MyAccount-content p a:not(.button),
		.home-tabs li a:hover,
		.woocommerce-tabs .tabs li a:hover{
			color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.ip-quickview-btn svg,
		.ip-wishlist-btn svg,
		.mobile-sidebar svg,
		#ip-wishlist-empty .note svg {
			fill: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		#home-post h2,
		#home-text h1,
		.ip-product-container .products h2,
		.cross-sells h2,
		.home-tabs li.current a,
		.woocommerce-tabs .tabs li.active a,
		.widget.widget_shopping_cart a.button,
		#footer .widget.widget_shopping_cart a.button,
		 #home-review .thumb{
			border-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.main-menu .product-categories > ul > li:after,
		.home-tabs.expand:before,
		.woocommerce-tabs .tabs.expand:before{
			border-bottom-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.main-menu .product-categories > ul > li.ltr > ul > li ul:after {
			border-right-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.main-menu .product-categories > ul > li.rtl > ul > li ul:after {
			border-left-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.home-tabs:before,
		.woocommerce-tabs .tabs:before {
			border-top-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}
		
		.widget select:focus,
		.footer-widget select:focus {
			outline-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
		}

		.star-rating:before,
		.star-rating span:before,
		.comment-form-rating .stars a {
			background-image:  url(\'data:image/svg+xml;base64,' . base64_encode( '<svg fill="' . ideapark_mod( 'accent_color_custom' ) . '" width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5T1385 1619q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5T365 1569q0-6 2-20l86-500L89 695q-25-27-25-48 0-37 56-46l502-73L847 73q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"/></svg>') . '\');
		}
		
		@media (min-width: 992px) {
			#header .top-menu .menu ul li a:hover,
			.main-menu .product-categories > ul > li:hover span,
			#footer a:hover,
			.ip-shop-loop-details h3 a:hover,
			#home-post .post:hover h3,
			#home-post a:hover h2,
			.woocommerce-breadcrumb li a:hover,
			.ip-product-container .watch-video a:hover,
			.ip-product-container .product_meta a:hover,
			.mini_cart_item a:hover,
			.widget.widget_layered_nav li a:hover,
			.widget a:hover,
			.entry-content .post-tags a:hover,
			.post-related h3 a:hover,
			.post-navigation .nav-links a:hover,
			.comments-navigation a:hover,
			.post-comments .comment-metadata .comment-reply-link:hover,
			.post-comments .comment-metadata .comment-edit-link:hover,
			.main-header .post-categories a:hover,
			.blog-container h2 a:hover,
			.shop_table.cart .product-name > a:hover,
			.post-comments a:hover,
			#header .top-menu .auth a:hover,
			#header .top-menu .menu > li > a:hover{
				color: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
		
			.header-type-2 #header .soc a:hover,
			#footer .soc a:hover,
			.post-author .soc a:hover,
			.main-menu .product-categories ul > li ul{
				background-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
		
			.main-menu .wishlist:hover svg,
			.main-menu .search:hover svg,
			.main-menu .cart-info:hover svg,
			.ip-product-container .watch-video a:hover svg,
			.entry-content .bottom .meta-share a:hover svg,
			.post-navigation .nav-links a:hover svg,
			.comments-navigation a:hover svg,
			#header .top-menu .auth a:hover svg,
			#ajax-search button:hover svg,
			#search-close:hover svg{
				fill: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
		
			.home-tabs li a:hover,
			.woocommerce-tabs .tabs li a:hover,
			.post-tags a:hover,
			.widget .tagcloud a:hover,
			#home-post .post:hover .post-content {
				border-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
		}
		
		@media (max-width: 991px) {
			.product-categories .auth {
				background: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
			
			#header .mobile-menu-back,
			.main-menu .product-categories > ul > li.menu-item > a,
			.main-menu .product-categories > ul > li.menu-item > ul li a{
				color: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
			
			#header .mobile-menu-back svg {
				fill: ' . ideapark_mod( 'accent_color_custom' ) . ';	
			}
			
			.home-tabs,
			.woocommerce-tabs .tabs {
				border-color: ' . ideapark_mod( 'accent_color_custom' ) . ';
			}
			
			.main-menu .product-categories > ul li.menu-item.has-children:after,
			.main-menu .product-categories > ul li.menu-item.menu-item-has-children:after {
				background: url(\'data:image/svg+xml;base64,' . base64_encode( '<svg width="9" height="13" viewBox="0 0 9 13" xmlns="http://www.w3.org/2000/svg"><path d="M7.377 5.838a.916.916 0 0 1 0 1.295l-4.609 4.608a.916.916 0 0 1-1.295-1.295l4.608-4.608v1.295l-4.57-4.57a.916.916 0 0 1 1.296-1.295l4.57 4.57z" stroke="' . esc_attr( ideapark_mod( 'accent_color_custom' ) ) . '" fill="' .  esc_attr( ideapark_mod( 'accent_color_custom' ) ) . '" fill-rule="evenodd"/></svg>' ) . '\') no-repeat;
				background-size: 7px 11px;
			}
		}
		
		';
	}


	if (ideapark_mod( 'accent_color_2_custom' ) && strtoupper( ideapark_mod( 'accent_color_2_custom' ) ) != '#FF5B4B' ) {
		$custom_css .= ' 
	
		/* custom-accent 2 */
		
		.main-menu .cart-info .ip-cart-count,
		.ip-product-container .cart button[type=submit],
		.ip-product-container .summary a.button.alt,
		.shop-content .woocommerce-MyAccount-content .button:not(input):not(.wc-backward),
		.woocommerce-MyAccount-content .shop_table .button,
		.shop-content .woocommerce-MyAccount-content *[type=submit],
		#ip-wishlist-table .actions .button,
		div.woocommerce-error a,
		div.woocommerce-error a.button,
		.woocommerce-account #customer_login *[type=submit],
		.collaterals a.button.checkout-button,
		#place_order,
		.woocommerce-error li a{
			background-color: ' . ideapark_mod( 'accent_color_2_custom' ) . ';
		}
		
		.main-header .search-results strong,
		.woocommerce-MyAccount-login-info a,
		.woocommerce-MyAccount-navigation ul li.is-active a,
		.ip-product-stock-status .ip-out-of-stock,
		.ip-product-container .summary .price,
		.ip-product-container .single_variation,
		#ip-wishlist-table td.product-price,
		.shop_table.cart td.product-subtotal,
		.shop_table.cart .update-cart input[type=submit],
		.collaterals .woocommerce-remove-coupon,
		div.woocommerce-error,
		.woocommerce-error li,
		.woocommerce-account .required,
		#customer_details .required,
		.woocommerce-Pagination a.button,
		#customer_login .lost_password a,
		.collaterals .order-total .amount,
		.blog-container .sticky h2 a{
			color: ' . ideapark_mod( 'accent_color_2_custom' ) . ';
		}
		
		.woocommerce-MyAccount-login-info svg,
		.woocommerce-MyAccount-navigation ul li.is-active svg,
		.ip-product-stock-status .ip-out-of-stock svg,
		.shop_table.cart .update-cart svg,
		.woocommerce-thankyou-order-failed svg{
			fill: ' . ideapark_mod( 'accent_color_2_custom' ) . ';
		}
		
		.woocommerce-account .woocommerce-invalid input[type=text],
		.woocommerce-account .woocommerce-invalid input[type=email],
		.woocommerce-account .woocommerce-invalid input[type=tel],
		.woocommerce-account .woocommerce-invalid input[type=password],
		.woocommerce-account .woocommerce-invalid textarea,
		#customer_details .woocommerce-invalid input[type=text],
		#customer_details .woocommerce-invalid input[type=email],
		#customer_details .woocommerce-invalid input[type=tel],
		#customer_details .woocommerce-invalid input[type=password],
		#customer_details .woocommerce-invalid textarea {
			border-color: ' . ideapark_mod( 'accent_color_2_custom' ) . ';
		}
		
		@media (min-width: 992px) {
			.entry-content a:hover,
			.mini_cart_item a.remove:hover,
			.widget.widget_product_categories li a:hover,
			.widget.widget_layered_nav li.chosen a:hover:after,
			.widget.widget_layered_nav_filters li.chosen a:hover:after,
			#ip-wishlist-table .product-thumbnail .remove:hover,
			.shop_table.cart .product-thumbnail .remove:hover,
			.woocommerce-MyAccount-content p a:not(.button):hover {
				color: ' . ideapark_mod( 'accent_color_2_custom' ) . ';
			}
		}

		.shop_table.cart .update-cart input[type=submit] {
			background-image: url(\'data:image/svg+xml;base64,' . base64_encode( '<svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M13.929 7.5c-.653 0-.963.46-1.072.946-.391 1.749-2.053 4.411-5.357 4.411a5.357 5.357 0 0 1 0-10.714c1.2 0 2.3.403 3.193 1.071h-1.05a1.072 1.072 0 0 0 0 2.143h3.214c.592 0 1.072-.48 1.072-1.071V1.07a1.072 1.072 0 0 0-2.143 0v.278A7.449 7.449 0 0 0 7.5 0a7.5 7.5 0 1 0 0 15c5.346 0 7.5-5.09 7.5-6.362 0-.778-.569-1.138-1.071-1.138z" fill="' . ideapark_mod( 'accent_color_2_custom' ) . '" fill-rule="evenodd"/></svg>' ) . '\');
		}
		
		.woocommerce-account input[type=radio]:checked + i,
		.collaterals input[type=radio]:checked + i,
		.woocommerce-account input[type=radio]:checked + label:after,
		.collaterals input[type=radio]:checked + label:after{
			background-image: url(\'data:image/svg+xml;base64,' . base64_encode( '<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><circle id="a" cx="300" cy="17" r="8"/><mask id="b" x="-1" y="-1" width="18" height="18"><path fill="#fff" d="M291 8h18v18h-18z"/><use xlink:href="#a"/></mask><mask id="c" x="0" y="0" width="16" height="16" fill="#fff"><use xlink:href="#a"/></mask></defs><g transform="translate(-291 -8)" fill="none" fill-rule="evenodd"><use fill="' . ideapark_mod( 'accent_color_2_custom' ) . '" xlink:href="#a"/><use stroke="' . ideapark_mod( 'accent_color_2_custom' ) . '" mask="url(#b)" stroke-width="2" xlink:href="#a"/><use stroke="#FFF" mask="url(#c)" stroke-width="8" xlink:href="#a"/></g></svg>' ) . '\');
		}
		
		.woocommerce-account input[type=checkbox]:checked + i,
		.collaterals input[type=checkbox]:checked + i,
		#customer_details input[type=checkbox]:checked + i,
		 .woocommerce-account input[type=checkbox]:checked + label:after,
		.collaterals input[type=checkbox]:checked + label:after,
		#customer_details input[type=checkbox]:checked + label:after{
			background-image: url(\'data:image/svg+xml;base64,' . base64_encode( '<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><rect id="a" x="1" y="1" width="16" height="16" rx="2"/><mask id="b" x="-1" y="-1" width="18" height="18"><path fill="#fff" d="M0 0h18v18H0z"/><use xlink:href="#a"/></mask><mask id="c" x="0" y="0" width="16" height="16" fill="#fff"><use xlink:href="#a"/></mask></defs><g fill="none" fill-rule="evenodd"><use fill="' . ideapark_mod( 'accent_color_2_custom' ) . '" xlink:href="#a"/><use stroke="' . ideapark_mod( 'accent_color_2_custom' ) . '" mask="url(#b)" stroke-width="2" xlink:href="#a"/><use stroke="#FFF" mask="url(#c)" stroke-width="8" xlink:href="#a"/></g></svg>' ) . '\');
		}
	';
	}

	if ( ideapark_mod( 'theme_font_1' ) && ideapark_mod( 'theme_font_1_weight' ) && ( ideapark_mod( 'theme_font_1' ) != 'Fredoka One' || ideapark_mod( 'theme_font_1_weight' ) != 400 ) ) {
		$custom_css .= '
		#home-slider h3,
		#home-banners .banner h4,
		.main-header h1,
		.ip-shop-loop-price .price,
		.ip-product-container .product_title,
		.ip-product-container .summary .price,
		#ip-wishlist-table td.product-price,
		.shop_table.cart td.product-subtotal,
		.collaterals .order-total .amount,
		#customer_login h1 {
			font-family: "' . esc_attr( ideapark_mod( 'theme_font_1' ) ) . '", sans-serif !important;
			font-weight: ' . esc_attr( ideapark_mod( 'theme_font_1_weight' ) ) . ' !important;
		}';
	}

	if ( ideapark_mod( 'theme_font_2' ) != 'Montserrat' ) {
		$custom_css .= '
		.entry-content dt,
		.error-page,
		.error-page h2,
		#ajax-search-result h4,
		#home-slider h4,
		#home-banners .banner h3,
		#home-banners .banner .more,
		.home-tabs li a,
		.woocommerce-tabs .tabs li a,
		#home-post h2,
		#home-text h1,
		.ip-product-container .products h2,
		.cross-sells h2,
		#home-post .post,
		#home-review .author,
		.entry-content blockquote,
		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content h5,
		.entry-content h6,
		.entry-content .bottom span,
		.post-related h4,
		.post-related h3,
		.comment-reply-title,
		.post-comments h2,
		.comment-reply-title,
		.post-comments .comment-metadata a,
		.post-comments .author-name,
		.comments-navigation,
		.post-navigation,
		.blog-container h2,
		.search-container .results-list h2,
		.main-header .search-results,
		.navigation,
		.woocommerce-pagination,
		.page-links,
		.widget .widget-title,
		.widget label,
		.custom-latest-posts-widget h4,
		.widget:not(.custom-latest-posts-widget) li,
		.widget_calendar th,
		.widget_calendar td,
		.widget.widget_shopping_cart ul li,
		.widget .product_list_widget .product-title,
		.woocommerce-MyAccount-navigation ul li,
		.ip-shop-loop-wrap .onsale,
		.ip-product-container .onsale,
		.ip-shop-loop-new-badge,
		.ip-shop-loop-details h3,
		.ip-quickview-btn:before,
		.ip-wishlist-btn:before,
		.ip-product-container .group_table td.label,
		#tab-reviews #comments > h2,
		.cart-empty,
		#ip-wishlist-empty,
		.woocommerce-MyAccount-content legend,
		#ip-wishlist-table .product-name > a,
		.shop_table.cart .product-name > a,
		.collaterals h3,
		#customer_details h3,
		.woocommerce-thankyou-order-failed,
		.woocommerce-thankyou-order-received,
		.woocommerce-MyAccount-content h2,
		.woocommerce-MyAccount-content h3,
		.woocommerce-thankyou-order-wrap h2,
		.ip-customer-details h2,
		.ip-customer-details h3,
		.main-menu .product-categories > ul > li
		{
			font-family: "' . esc_attr( ideapark_mod( 'theme_font_2' ) ) . '", sans-serif !important;
		}
		';
	}

	if ( ideapark_mod('logo_extra_size') ) {
		$custom_css .= '
		
			@media (min-width: 1200px) {
				.header-type-2 .main-menu .logo {
					max-width: 254px;
					max-height: 155px;
				}
				.header-type-2 .main-menu .logo img {
					max-width: 254px;
					max-height: 155px;
				}
			}
			
			@media (max-width: 1199px) and (min-width: 992px) {
				.header-type-2 #header .logo {
					max-width: 185px;
					max-height: 155px;
				}
				.header-type-2 #header .logo img {
					max-width: 185px;
					max-height: 155px;
				}
			}

		';
	}

	if ( $custom_css ) {
		wp_add_inline_style( 'ideapark-core', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'ideapark_customize_css', 1000 );