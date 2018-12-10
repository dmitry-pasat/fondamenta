<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta name="format-detection" content="telephone=no" />
	<?php if ( ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) && ideapark_mod( 'favicon' ) ) { ?>
		<link rel="shortcut icon" href="<?php echo esc_url( ideapark_mod( 'favicon' ) ); ?>" />
	<?php } ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="ajax-search">
	<?php
	add_filter( 'get_search_form', 'ideapark_search_form_ajax', 100 );
	get_search_form();
	remove_filter( 'get_search_form', 'ideapark_search_form_ajax', 100 );
	?>
</div>
<div id="ajax-search-result"></div>
<div id="wrap">
	<header id="header">
		<?php if ( ideapark_mod( 'top_menu' ) ) { ?>
			<div class="top-menu">
				<!--Navigation-->
				<div class="container">
					<?php if ( ideapark_woocommerce_on() ) { ?>
						<div class="auth"><?php echo ideapark_get_account_link(); ?></div>
					<?php } ?>
					<nav>
						<?php
						echo function_exists( 'wp_nav_menu' ) ?
							wp_nav_menu( array(
								'container'      => '',
								'echo'           => false,
								'theme_location' => 'primary',
								'fallback_cb'    => 'ideapark_default_menu'
							) ) : ideapark_default_menu();
						?>
					</nav>
				</div>
			</div>
		<?php } ?>

		<div class="main-menu">
			<div class="container">
				<a class="mobile-menu" href="#">
					<svg>
						<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-bars" />
					</svg>
				</a>
				<div class="container-2">
					<?php if ( ideapark_woocommerce_on() && ideapark_mod( 'wishlist_enabled' ) && ideapark_mod( 'wishlist_page' ) ) { ?>
						<a rel="nofollow" class="wishlist<?php if ( class_exists( 'Ideapark_Wishlist' ) && Ideapark_Wishlist()->ids() ) { ?> added<?php } ?>" href="<?php echo esc_url( get_permalink( apply_filters( 'wpml_object_id', ideapark_mod( 'wishlist_page' ), 'page' ) ) ); ?>">
							<svg class="on">
								<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-wishlist-on" />
							</svg>
							<svg class="off">
								<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-wishlist-off" />
							</svg>
						</a>
					<?php } ?>
					<a class="search" href="#">
						<svg>
							<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-search" />
						</svg>
					</a>
					<?php if ( ideapark_woocommerce_on() ) { ?>
						<a class="cart-info" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
							<?php echo ideapark_cart_info(); ?>
						</a>
					<?php } ?>

					<?php if ( ideapark_mod( 'header_type' ) != 'header-type-1' ) { ?>
						<div class="soc">
							<?php
							$soc_count = 0;
							$soc_list  = array(
								'facebook',
								'instagram',
								'twitter',
								'google-plus',
								'youtube',
								'vimeo',
								'linkedin',
								'flickr',
								'pinterest',
								'tumblr',
								'dribbble',
								'github'
							);
							foreach ( $soc_list AS $soc_name ) {
								if ( ideapark_mod( $soc_name ) ): $soc_count ++; ?>
									<a href="<?php echo esc_url( ideapark_mod( $soc_name ) ); ?>" target="_blank">
										<svg>
											<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-<?php echo esc_attr( $soc_name ); ?>" />
										</svg>
									</a>
								<?php endif;
							} ?>
						</div>
					<?php } ?>
					<div class="logo">
						<?php if ( ! is_front_page() ): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php endif ?>
							<?php if ( ideapark_mod( 'logo' ) ) { ?>
								<img src="<?php echo stripslashes( ideapark_mod( 'logo' ) ); ?>" alt="" />
							<?php } else { ?>
								<img src="<?php echo esc_url( get_template_directory_uri() ) ?>/img/logo.svg" class="svg" alt="" />
							<?php } ?>
							<?php if ( ! is_front_page() ): ?></a><?php endif ?>
					</div>

				</div>

				<div class="menu-shadow"></div>

				<nav class="product-categories">
					<?php if ( ideapark_mod( 'mega_menu' ) && class_exists( 'Ideapark_Megamenu_Walker' ) && function_exists( 'wp_nav_menu' ) ) {
						wp_nav_menu( array(
							'container'      => '',
							'theme_location' => 'megamenu',
							'fallback_cb'    => 'ideapark_empty_menu',
							'walker'         => new Ideapark_Megamenu_Walker()
						) );
					} else { ?>
						<?php ideapark_category_menu(); ?>
					<?php } ?>
					<a class="mobile-menu-close" href="#">
						<svg>
							<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-close" />
						</svg>
					</a>
					<?php if ( ideapark_woocommerce_on() ) { ?>
						<div class="auth"><?php echo ideapark_get_account_link(); ?></div>
					<?php } ?>
					<a href="#" class="mobile-menu-back">
						<svg>
							<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-angle-left" />
						</svg>
						<?php esc_html_e( 'Back', 'kidz' ); ?>
					</a>
					<?php if ( ideapark_woocommerce_on() && ideapark_mod( 'wishlist_enabled' ) && ideapark_mod( 'wishlist_page' ) ) { ?>
						<a rel="nofollow" class="mobile-wishlist<?php if ( class_exists( 'Ideapark_Wishlist' ) && Ideapark_Wishlist()->ids() ) { ?> added<?php } ?>" href="<?php echo esc_url( get_permalink( apply_filters( 'wpml_object_id', ideapark_mod( 'wishlist_page' ), 'page' ) ) ); ?>">
							<svg class="on">
								<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-wishlist-on" />
							</svg>
							<svg class="off">
								<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-wishlist-off" />
							</svg>
						</a>
					<?php } ?>
					<a class="mobile-search" href="#">
						<svg>
							<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-search" />
						</svg>
					</a>
				</nav>
			</div>
		</div>
	</header>