<?php

/*------------------------------------*\
	Constants & Globals
\*------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$theme_obj = wp_get_theme( 'kidz' );

define( 'IDEAPARK_THEME_DEMO', false );
define( 'IDEAPARK_THEME_NAME', $theme_obj['Name'] );
define( 'IDEAPARK_THEME_DIR', get_template_directory() );
define( 'IDEAPARK_THEME_URI', get_template_directory_uri() );
define( 'IDEAPARK_THEME_VERSION', '1.4.8' );

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if ( ! function_exists( 'ideapark_setup' ) ) {

	function ideapark_setup() {

		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		add_image_size( 'ideapark-shop-quickview', 425, 425, true );
		add_image_size( 'ideapark-related-thumb', 263, 190, true );
		add_image_size( 'ideapark-related-thumb-2x', 526, 380, true );
		add_image_size( 'ideapark-home-posts', 241, 241, true );
		add_image_size( 'ideapark-home-brands', 142, 160 );
		add_image_size( 'ideapark-home-banners', '', 250 );
		add_image_size( 'ideapark-category-thumb', '', 53 );

		load_theme_textdomain( 'kidz', IDEAPARK_THEME_DIR . '/languages' );

		$a = ideapark_mod( 'mega_menu' );

		register_nav_menus( array(
			'primary'  => esc_html__( 'Top Menu', 'kidz' ),
			'megamenu' => esc_html__( 'Mega Menu (Primary)', 'kidz' ),
		) );

	}
}

if ( ! function_exists( 'ideapark_woocommerce_set_image_dimensions' ) ) {
	function ideapark_woocommerce_set_image_dimensions() {
		if ( ! get_option( 'ideapark_shop_image_sizes_set' ) ) {
			$catalog = array(
				'width'  => '210',
				'height' => '210',
				'crop'   => true
			);

			$single = array(
				'width'  => '555',
				'height' => '',
				'crop'   => false
			);

			$thumbnail = array(
				'width'  => '70',
				'height' => '70',
				'crop'   => true
			);

			update_option( 'shop_catalog_image_size', $catalog );
			update_option( 'shop_single_image_size', $single );
			update_option( 'shop_thumbnail_image_size', $thumbnail );

			update_option( 'thumbnail_size_w', 70 );
			update_option( 'thumbnail_size_h', 70 );

			update_option( 'medium_size_w', 360 );
			update_option( 'medium_size_h', '' );

			update_option( 'large_size_w', '' );
			update_option( 'large_size_h', 590 );

			add_option( 'ideapark_shop_image_sizes_set', '1' );
		}
	}
}

// Maximum width for media
if ( ! isset( $content_width ) ) {
	$content_width = 1220; // Pixels
}

/*------------------------------------*\
	Include files
\*------------------------------------*/
include( IDEAPARK_THEME_DIR . '/functions/customize/ip_customize_settings.php' );
include( IDEAPARK_THEME_DIR . '/functions/customize/ip_customize_style.php' );

if ( ideapark_woocommerce_on() ) {
	include( IDEAPARK_THEME_DIR . '/functions/woocommerce/woocommerce-func.php' );

	if ( is_admin() ) {
		include( IDEAPARK_THEME_DIR . '/functions/woocommerce/woocommerce-tax-extra-fields.php' );
	}

	include( IDEAPARK_THEME_DIR . '/functions/woocommerce/woocommerce-quickview.php' );
}


/*------------------------------------*\
	TGM-Plugin-Activation
\*------------------------------------*/

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see        http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme kidz for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once IDEAPARK_THEME_DIR . '/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'ideapark_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

function ideapark_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'         => esc_html__( 'Kidz Theme Functionality', 'kidz' ),
			'slug'         => 'ideapark-theme-functionality',
			'source'       => IDEAPARK_THEME_DIR . '/plugins/ideapark-theme-functionality.zip',
			'required'     => true,
			'version'      => '1.4.2',
			'external_url' => '',
			'is_callable'  => '',
		),

		array(
			'name'         => esc_html__( 'Kidz Theme Wishlist', 'kidz' ),
			'slug'         => 'ideapark-wishlist',
			'source'       => IDEAPARK_THEME_DIR . '/plugins/ideapark-wishlist.zip',
			'required'     => true,
			'version'      => '1.2',
			'external_url' => '',
			'is_callable'  => '',
		),

		array(
			'name'               => esc_html__( 'Envato Market', 'kidz' ),
			'slug'               => 'envato-market',
			'source'             => IDEAPARK_THEME_DIR . '/plugins/envato-market.zip',
			'required'           => false,
			'version'            => '1.0.0-RC2',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),

		array(
			'name'     => esc_html__( 'Contact Form 7', 'kidz' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'WooCommerce', 'kidz' ),
			'slug'     => 'woocommerce',
			'required' => false
		),

		array(
			'name'     => esc_html__( 'Regenerate Thumbnails', 'kidz' ),
			'slug'     => 'regenerate-thumbnails',
			'required' => false
		)

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'kidz',
		// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',
		// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',
		// Menu slug.
		'parent_slug'  => 'themes.php',
		// Parent menu slug.
		'capability'   => 'edit_theme_options',
		// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,
		// Show admin notices or not.
		'dismissable'  => true,
		// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',
		// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,
		// Automatically activate plugins after installation or not.
		'message'      => '',
		// Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}


function ideapark_scripts_disable_cf7() {
	if ( ! is_singular() || is_front_page() ) {
		add_filter( 'wpcf7_load_js', '__return_false' );
		add_filter( 'wpcf7_load_css', '__return_false' );
	}
}

function ideapark_scripts() {

	if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {

		$fonts = array(
			ideapark_mod( 'theme_font_1' ),
			ideapark_mod( 'theme_font_2' ),
		);

		if ( ! array_key_exists( 'Open Sans', $fonts ) ) {
			$fonts[] = 'Open Sans';
		}

		$font_uri = ideapark_get_google_font_uri( $fonts );
		wp_enqueue_style( 'ideapark-fonts', $font_uri, array(), null, 'screen' );

		wp_enqueue_script( array( 'jquery' ) );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), false, true );
		}

		if ( is_archive() || is_home() ) {
			wp_enqueue_script( 'jquery-masonry', array( 'jquery' ) );
		}

		if ( ideapark_woocommerce_on() ) {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );

			if ( defined( 'WC_VERSION' ) && preg_match( '~^2\.~', WC_VERSION ) ) {
				wp_dequeue_script( 'wc-add-to-cart-variation' );
				wp_deregister_script( 'wc-add-to-cart-variation' );
				wp_enqueue_script( 'wc-add-to-cart-variation', IDEAPARK_THEME_URI . '/js/woocommerce/add-to-cart-variation.min.js', array(
					'jquery',
					'wp-util'
				), '2.x', true );
			} elseif ( defined( 'WC_VERSION' ) ) {
				wp_enqueue_script( 'wc-add-to-cart-variation-3-fix', IDEAPARK_THEME_URI . '/js/woocommerce/add-to-cart-variation-3-fix.min.js', array(
					'jquery',
					'wp-util',
					'wc-add-to-cart-variation'
				), WC_VERSION, true );

				wp_localize_script( 'wc-add-to-cart-variation-3-fix', 'ideapark_wc_add_to_cart_variation_vars', array(
					'in_stock_svg'     => esc_js( '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-check" /></svg>' ),
					'out_of_stock_svg' => esc_js( '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-close" /></svg>' )
				) );
			}

			if ( is_product() && ideapark_mod( 'shop_product_modal' ) ) {
				wp_enqueue_style( 'photoswipe', IDEAPARK_THEME_URI . '/css/photoswipe/photoswipe.css', array(), '4.1.1', 'all' );
				wp_enqueue_style( 'photoswipe-skin', IDEAPARK_THEME_URI . '/css/photoswipe/default-skin.css', array(), '4.1.1', 'all' );
				wp_enqueue_script( 'photoswipe', IDEAPARK_THEME_URI . '/js/photoswipe/photoswipe.min.js', array( 'jquery' ), '4.1.1' );
				wp_enqueue_script( 'photoswipe-ui', IDEAPARK_THEME_URI . '/js/photoswipe/photoswipe-ui-default.min.js', array( 'jquery' ), '4.1.1' );
			}
		}

		if ( ideapark_mod( 'use_minified_css' ) ) {
			wp_enqueue_style( 'ideapark-core', IDEAPARK_THEME_URI . '/css/min.css', array(), IDEAPARK_THEME_VERSION . '.1', 'all' );
		} else {
			wp_enqueue_style( 'bootstrap', IDEAPARK_THEME_URI . '/css/bootstrap.min.css', array(), '3.3.5', 'all' );
			wp_enqueue_style( 'slick-slider', IDEAPARK_THEME_URI . '/css/slick.css', array(), '1.5.7', 'all' );
			wp_enqueue_style( 'magnific-popup', IDEAPARK_THEME_URI . '/css/magnific-popup.css', array(), '1.1.0', 'all' );
			wp_enqueue_style( 'ideapark-core', IDEAPARK_THEME_URI . '/style.css', array(), IDEAPARK_THEME_VERSION . '.1', 'all' );
		}

		if ( ideapark_mod( 'use_minified_js' ) ) {
			wp_enqueue_script( 'ideapark-core', IDEAPARK_THEME_URI . '/js/min.js', array( 'jquery' ), IDEAPARK_THEME_VERSION, true );
		} else {
			wp_enqueue_script( 'html5shiv', IDEAPARK_THEME_URI . '/js/html5.js', '3.6' );
			wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply', false, array(), false, true );
			}
			wp_enqueue_script( 'waitforimages', IDEAPARK_THEME_URI . '/js/jquery.waitforimages.min.js', array( 'jquery' ), '2016-01-04', true );
			wp_enqueue_script( 'bg-srcset', IDEAPARK_THEME_URI . '/js/bg-srcset.min.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'slick-slider', IDEAPARK_THEME_URI . '/js/slick.min.js', array( 'jquery' ), '1.5.7', true );
			wp_enqueue_script( 'fitvids', IDEAPARK_THEME_URI . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
			wp_enqueue_script( 'customselect', IDEAPARK_THEME_URI . '/js/jquery.customSelect.min.js', array( 'jquery' ), '0.5.1', true );
			wp_enqueue_script( 'magnific-popup', IDEAPARK_THEME_URI . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '0.9.9', true );
			wp_enqueue_script( 'ideapark-core', IDEAPARK_THEME_URI . '/js/site.js', array( 'jquery' ), IDEAPARK_THEME_VERSION, true );
		}

		wp_localize_script( 'ideapark-core', 'ideapark_wp_vars', array(
			'themeDir'  => IDEAPARK_THEME_DIR,
			'themeUri'  => IDEAPARK_THEME_URI,
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'searchUrl' => home_url( '?s=' ),
			'svgUrl'    => esc_js( ideapark_svg_url() ),

			'sliderEnable'   => ideapark_mod( 'slider_enable' ),
			'sliderEffect'   => ideapark_mod( 'slider_effect' ),
			'sliderSpeed'    => ideapark_mod( 'slider_speed' ),
			'sliderInterval' => ideapark_mod( 'slider_interval' ),

			'shopProductModal' => ideapark_mod( 'shop_product_modal' ),

			'stickyMenu' => ideapark_mod( 'sticky_menu' ) && ideapark_woocommerce_on()

		) );
	}

	wp_add_inline_script( 'jquery-migrate', '
	var ideapark_svg_content = "";
	var ajax = new XMLHttpRequest();
		ajax.open("GET", "' . IDEAPARK_THEME_URI . '/img/sprite.svg", true);
		ajax.send();
		ajax.onload = function (e) {
			ideapark_svg_content = ajax.responseText;
			ideapark_download_svg_onload();
		};
		function ideapark_download_svg_onload() {
			if (typeof document.body != "undefined" && document.body != null && typeof document.body.childNodes != "undefined" && typeof document.body.childNodes[0] != "undefined") {
				var div = document.createElement("div");
				div.className = "svg-sprite-container";
				div.innerHTML = ideapark_svg_content;
				document.body.insertBefore(div, document.body.childNodes[0]);
			} else {
				setTimeout(ideapark_download_svg_onload, 100);
			}
		}
	', 'before' );
}

/*------------------------------------*\
	Widgets
\*------------------------------------*/

function ideapark_widgets_init() {

	include_once( IDEAPARK_THEME_DIR . "/inc/latest-posts-widget.php" );
	include_once( IDEAPARK_THEME_DIR . "/inc/advantages-widget.php" );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kidz' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'kidz' ),
		'id'            => 'footer-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s col-md-3 col-sm-6 col-xs-6">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		'description'   => esc_html__( 'Maximum 3 widgets', 'kidz' ),
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Product list', 'kidz' ),
		'id'            => 'shop-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Product page', 'kidz' ),
		'id'            => 'product-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	if ( IDEAPARK_THEME_DEMO ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar (All widgets)', 'kidz' ),
			'id'            => 'all-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer (All widgets)', 'kidz' ),
			'id'            => 'footer-all-sidebar',
			'before_widget' => '<aside id="%1$s" class="footer-widget %2$s col-md-3 hidden-sm hidden-xs">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			'description'   => esc_html__( 'Maximum 3 widgets', 'kidz' ),
		) );
	}

	if ( class_exists( 'WC_Widget' ) ) {
		include_once( IDEAPARK_THEME_DIR . "/inc/wc-color-filter-widget.php" );
	}
}

/*------------------------------------*\
	Remove demo templates
\*------------------------------------*/

function ideapark_remove_page_templates( $templates ) {
	if ( ! IDEAPARK_THEME_DEMO ) {
		unset( $templates['page-templates/sidebar-all-widgets.php'] );
		unset( $templates['page-templates/home-page-fixed-width.php'] );
	}

	return $templates;
}


/*------------------------------------*\
	Functions
\*------------------------------------*/

function ideapark_custom_excerpt_length( $length ) {
	return 84;
}

function ideapark_excerpt_more( $more ) {
	return '&hellip;';
}

function ideapark_ajax_search() {
	global $wpdb, $post, $product;

	if ( strlen( ( $s = trim( preg_replace( '~\s\s+~', ' ', $_POST['s'] ) ) ) ) > 0 ) {

		$e     = explode( ' ', $s );
		$where = array();
		$order = array();
		foreach ( $e AS $word ) {
			$s       = '%' . esc_sql( $wpdb->esc_like( $word ) ) . '%';
			$where[] = $wpdb->prepare( "( ({$wpdb->posts}.post_title LIKE %s) OR ({$wpdb->posts}.post_excerpt LIKE %s) OR ({$wpdb->posts}.post_content LIKE %s) )", $s, $s, $s );
			$order[] = $wpdb->prepare( "({$wpdb->posts}.post_title LIKE %s)", $s );
		}
		$limit = 10;

		if ( ideapark_woocommerce_on() ) {
			$sql = "
			SELECT {$wpdb->posts}.*
			FROM {$wpdb->posts}
			INNER JOIN {$wpdb->postmeta} ON ( {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id )
			WHERE 1=1 
			AND ( " . implode( " AND ", $where ) . " )
			AND ( {$wpdb->posts}.post_type IN ( 'product' ) )
			AND ( {$wpdb->posts}.post_status = 'publish' OR {$wpdb->posts}.post_status = 'private' )
			GROUP BY {$wpdb->posts}.ID
			ORDER BY {$wpdb->posts}.menu_order ASC, {$wpdb->posts}.post_title ASC
			LIMIT $limit;
		 ";
		} else {
			$sql = "
			SELECT {$wpdb->posts}.*
			FROM {$wpdb->posts}
			WHERE 1=1 AND ( " . implode( " AND ", $where ) . " )
			AND {$wpdb->posts}.post_type IN ( 'post', 'page', 'attachment' )
			AND (post_status = 'publish')
			ORDER BY (" . implode( " AND ", $order ) . ") DESC, {$wpdb->posts}.post_date DESC
			LIMIT $limit;
		 ";
		}

		$results = $wpdb->get_results( $sql, OBJECT ); ?>
		<ul>
			<?php
			if ( ! empty( $results ) ) {
				foreach ( $results as $post ) { ?>
					<li <?php post_class( 'ajax-search-row', $post->ID ); ?>>
						<a href="<?php echo get_permalink( $post->ID ); ?>">
							<?php
							if ( has_post_thumbnail( $post->ID ) ) {
								$image_id   = get_post_thumbnail_id( $post->ID );
								$post_thumb = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
								$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

								if ( isset( $post_thumb[0] ) && ! empty( $post_thumb[0] ) ) { ?>
									<div class="post-img">
										<img src="<?php echo esc_url( $post_thumb[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
									</div>
								<?php }
							} ?>
						</a>

						<div class="post-content">
							<a href="<?php echo get_permalink( $post->ID ); ?>">
								<h4><?php echo apply_filters( 'the_title', $post->post_title ); ?></h4>
							</a>

							<?php if ( ideapark_woocommerce_on() && ( $product = wc_get_product( $post->ID ) ) ) { ?>
								<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="price"><?php echo $price_html; ?></span>
								<?php endif; ?>
								<div class="actions">
									<?php woocommerce_template_loop_add_to_cart(); ?>
								</div>

							<?php } else { ?>
								<div class="meta-date">
									<div class="post-meta post-date">
										<?php echo date( get_option( 'date_format' ), strtotime( $post->post_date ) ); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</li>
				<?php } ?>
				<li>
					<a href="javascript:jQuery('#ajax-search form').submit()" class="view-all"><?php echo esc_html__( 'View all results', 'kidz' ); ?> &nbsp;<i class="fa fa-chevron-right"></i></a>
				</li>
			<?php } else { ?>
				<li class="no-results"><?php echo esc_html__( 'No results found', 'kidz' ); ?></li>
			<?php } ?>
		</ul>
		<?php
	} else {
		echo '';
	}
	die();
}

function ideapark_category( $separator ) {
	$catetories = array();

	foreach ( ( get_the_category() ) as $category ) {
		$catetories[] = '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( esc_html__( "View all posts in %s", 'kidz' ), $category->name ) . '" ' . '>' . $category->name . '</a>';
	}

	if ( $catetories ) {
		echo implode( $separator, $catetories );
	}
}

function ideapark_corenavi( $custom_query = null ) {
	global $wp_query;
	$pages = '';
	if ( ! $custom_query ) {
		$custom_query = $wp_query;
	}
	$max = $custom_query->max_num_pages;
	if ( ! $current = get_query_var( 'paged' ) ) {
		$current = 1;
	}
	$a['base']    = str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) );
	$a['total']   = $max;
	$a['current'] = $current;

	$total          = 0; // 1 - echo "Page N from N", 0 - without
	$a['mid_size']  = 3;
	$a['end_size']  = 1;
	$a['prev_text'] = esc_html__( '&larr;', 'kidz' );
	$a['next_text'] = esc_html__( '&rarr;', 'kidz' );

	if ( $max > 1 ) {
		echo '<div class="navigation">';
	}
	if ( $total == 1 && $max > 1 ) {
		$pages = '<span class="pages">' . esc_html__( 'Page', 'kidz' ) . ' ' . $current . ' ' . esc_html__( 'from', 'kidz' ) . ' ' . $max . '</span>' . "\r\n";
	}

	echo $pages . paginate_links( $a );
	if ( $max > 1 ) {
		echo '</div>';
	}
}

function ideapark_default_menu() {
	$menu = '';
	$menu .= '<ul class="menu">';

	if ( is_home() ) {
		$menu .= '<li class="current_page_item menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	} else {
		$menu .= '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	}

	$menu .= '</ul>';

	return $menu;
}

function ideapark_post_nav() {
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="post-navigation" role="navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', '<span class="meta-nav">' . esc_html__( 'Published In', 'kidz' ) . '</span>%title' );
			else :
				previous_post_link( '<div class="nav-previous"><span>' . esc_html__( 'Previous Post', 'kidz' ) . '</span>%link</div>', '<span class="meta-nav"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-angle-left" /></svg></span> %title' );
				next_post_link( '<div class="nav-next"><span>' . esc_html__( 'Next Post', 'kidz' ) . '</span>%link</div>', '%title <span class="meta-nav"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-angle-right" /></svg></span></span>' );
			endif;
			?>
		</div>
		<!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

function ideapark_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" class="comment">
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<header class="comment-meta">
			<div class="comment-author vcard">
				<?php if ( 0 != $args['avatar_size'] ) {
					echo '<div class="author-img">' . get_avatar( $comment, $args['avatar_size'] ) . '</div>';
				} ?>
				<?php printf( '%s <span class="says">' . esc_html__( 'says:', 'kidz' ) . '</span>', sprintf( '<strong class="author-name">%s</strong>', get_comment_author_link() ) ); ?>
			</div>
			<!-- .comment-author -->

			<div class="comment-metadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'kidz' ), get_comment_date(), get_comment_time() ); ?>
					</time>
				</a>

				<?php comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth']
				) ) ); ?>

				<!-- .reply -->
				<?php edit_comment_link( esc_html__( 'Edit', 'kidz' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
			<!-- .comment-metadata -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'kidz' ); ?></p>
			<?php endif; ?>
		</header>
		<!-- .comment-meta -->

		<div class="comment-content">
			<?php comment_text(); ?>
		</div>
		<!-- .comment-content -->

	</article><!-- .comment-body -->
	<?php
}

function ideapark_body_class( $classes ) {
	global $post;
	$is_front_page = basename( get_page_template() ) == 'home-page.php';
	if ( ideapark_woocommerce_on() ) {
		$is_list   = ( is_shop() || is_product_tag() || is_product_category() );
		$classes[] = $is_front_page || ( is_product() && ( ideapark_mod( 'product_hide_sidebar' ) || ideapark_mod( 'product_short_sidebar' ) ) ) || ( $is_list && ideapark_mod( 'shop_hide_sidebar' ) ) || ( ! is_product() && ! $is_list && ideapark_mod( 'home_sidebar' ) == 'disable' ) ? 'sidebar-disable' : ( $is_list ? 'sidebar-left' : 'sidebar-right' );
		if ( is_product() && ideapark_mod( 'product_short_sidebar' ) ) {
			$classes[] = 'sidebar-short';
		}
	} else {
		$classes[] = $is_front_page ? 'sidebar-disable' : 'sidebar-' . ideapark_mod( 'home_sidebar' );
	}

	$classes[] = ideapark_mod( 'header_type' );
	$classes[] = ideapark_mod( 'sticky_type' );
	$classes[] = ideapark_mod( 'home_fullwidth_slider' ) ? 'fullwidth-slider' : 'fixed-slider';
	$classes[] = ideapark_mod( 'mega_menu' ) ? 'mega-menu' : '';
	$classes[] = ideapark_woocommerce_on() ? 'woocommerce-on' : 'woocommerce-off';

	if ( ideapark_mod( 'slider_enable' ) ) {
		$classes[] = 'slick-slider-enable';
	}

	if ( class_exists( 'Ideapark_Wishlist' ) && ideapark_is_wishlist_page() ) {
		$classes[] = 'wishlist-page';
	}

	if ( IDEAPARK_THEME_DEMO ) {
		$classes[] = 'theme-demo';
	}

	return $classes;
}

function ideapark_empty_menu() {
}

function ideapark_category_menu() {
	global $wp_query;

	$current_cat_id = ( is_tax( 'product_cat' ) ) ? $wp_query->queried_object->term_id : '';

	$categories = get_categories( array(
		'type'         => 'post',
		'hide_empty'   => ideapark_mod( 'shop_categories_hide_empty' ),
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		'exclude'      => ideapark_mod( 'hide_uncategorized' ) ? get_option( 'default_product_cat' ) : false
	) );

	$output    = '';
	$count     = 0;
	$all_count = 0;

	foreach ( $categories as $category ) {
		if ( $category->parent == '0' ) {
			$all_count ++;
		}
	}

	foreach ( $categories as $category ) {
		if ( $category->parent == '0' ) {
			$count ++;
			if ( ideapark_mod( 'header_type' ) == 'header-type-1' && $count > 6 ) {
				continue;
			}

			if ( $product_cat_svg_id = function_exists( 'get_term_meta' ) ? get_term_meta( $category->term_id, 'product_cat_svg_id', true ) : get_metadata( 'woocommerce_term', $category->term_id, 'product_cat_svg_id', true ) ) {
				$icon = '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#' . esc_attr( $product_cat_svg_id ) . '" /></svg>';
			} elseif ( $thumbnail_id = function_exists( 'get_term_meta' ) ? get_term_meta( $category->term_id, 'thumbnail_id', true ) : get_metadata( 'woocommerce_term', $category->term_id, 'thumbnail_id', true ) ) {
				$image        = wp_get_attachment_image_src( $thumbnail_id, 'ideapark-category-thumb', true );
				$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, 'ideapark-category-thumb' ) : false;
				$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, 'ideapark-category-thumb' ) : false;
				$icon         = '<img src="' . esc_url( $image[0] ) . '" alt="' . esc_attr( $category->name ) . '"' . ( $image_srcset ? ' srcset="' . esc_attr( $image_srcset ) . '"' : '' ) . ( $image_sizes ? ' sizes="' . esc_attr( $image_sizes ) . '"' : '' ) . '/>';
			} else {
				$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"/>';
			}

			$submenu_ouput = '';
			foreach ( $categories as $category_submenu ) {
				if ( $category_submenu->parent == $category->term_id ) {
					$sub_submenu_ouput = '';
					foreach ( $categories as $category_sub_submenu ) {
						if ( $category_sub_submenu->parent == $category_submenu->term_id ) {
							$sub_submenu_ouput .= '<li' . ( $current_cat_id == $category_sub_submenu->term_id ? " class='current'" : "" ) . '><a href="' . esc_url( get_term_link( (int) $category_sub_submenu->term_id, 'product_cat' ) ) . '">' . esc_html( $category_sub_submenu->name ) . '</a>';
						}
					}
					$submenu_ouput .= '<li  class="' . ( $current_cat_id == $category_submenu->term_id ? " current" : "" ) . ( $sub_submenu_ouput ? " has-children" : "" ) . '"><a href="' . esc_url( get_term_link( (int) $category_submenu->term_id, 'product_cat' ) ) . '">' . esc_html( $category_submenu->name ) . '</a>';
					$submenu_ouput .= ( $sub_submenu_ouput ? '<ul class="submenu">' . $sub_submenu_ouput . '</ul>' : '' ) . '</li>';
				}
			}

			$output .= '<li class="' . ( $current_cat_id == $category->term_id ? " current" : "" ) . ( $submenu_ouput ? " has-children" : "" ) . ' items-' . ( $all_count > 12 ? 12 : ( $all_count < 6 ? 6 : $all_count ) ) . '"><a href="' . esc_url( get_term_link( (int) $category->term_id, 'product_cat' ) ) . '">' . $icon . '<span>' . esc_html( $category->name ) . '</span></a>' . ( $submenu_ouput ? '<ul class="submenu">' . $submenu_ouput . '</ul>' : '' ) . '</li>';
		}
	}
	echo '<ul>' . $output . '</ul>';
}

function ideapark_search_form( $form ) {

	$format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
	$format = apply_filters( 'search_form_format', $format );

	if ( 'html5' == $format ) {
		$form = '<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
				<div>
				<label>
					<span class="screen-reader-text">' . esc_html_x( 'Search for:', 'label', 'kidz' ) . '</span>
					<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder', 'kidz' ) . '" value="' . get_search_query() . '" name="s" />' .
		        ( ideapark_woocommerce_on() ? '<input type="hidden" name="post_type" value="product">' : '' ) .
		        '</label>
				<button type="submit" class="search-submit"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-search" /></svg></button>
				</div>
			</form>';
	} else {
		$form = '<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
				<div>
					<label class="screen-reader-text" for="s">' . esc_html_x( 'Search for:', 'label', 'kidz' ) . '</label>
					<input type="text" value="' . get_search_query() . '" name="s" id="s" />' .
		        ( ideapark_woocommerce_on() ? '<input type="hidden" name="post_type" value="product">' : '' ) .
		        '<button type="submit" class="search-submit"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-search" /></svg></button>
				</div>
			</form>';
	}

	return $form;
}

function ideapark_search_form_ajax( $form ) {

	$form = '
	<form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">
		<input id="ajax-search-input" autocomplete="off" type="text" name="s" placeholder="' . esc_html__( 'Type something', 'kidz' ) . '" value="' . esc_attr( get_search_query() ) . '" />' .
	        ( ideapark_woocommerce_on() ? '<input type="hidden" name="post_type" value="product">' : '' ) .
	        '<a id="search-close" href="#">
			<svg>
				<use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-close" />
			</svg>
		</a>
		<button type="submit" class="search">
			<svg>
				<use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-search" />
			</svg>
		</button>
	</form>';

	return $form;
}

function ideapark_svg_url() {
	return is_customize_preview() ? IDEAPARK_THEME_URI . '/img/sprite.svg' : '';
}

/*------------------------------------*\
	Woocommerce
\*------------------------------------*/

function ideapark_get_account_link() {
	$link_title = ( is_user_logged_in() ) ? ( '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-user" /></svg><span>' . esc_html__( 'My Account', 'kidz' ) . '</span>' ) : ( '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-login" /></svg><span>' . esc_html__( 'Login', 'kidz' ) . '</span>' );

	return '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" rel="nofollow">' . $link_title . '</a>';
}

function ideapark_woocommerce_on() {
	return class_exists( 'WooCommerce' );
}

function ideapark_cart_info() {
	return '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-cart" /></svg><span class="ip-cart-count"></span>';
}

function ideapark_header_add_to_cart_fragment( $fragments ) {
	$fragments['.ip-cart-count'] = '<span class="ip-cart-count' . ( ! WC()->cart->is_empty() ? ' animate' : '' ) . '">' . esc_html( WC()->cart->get_cart_contents_count() ? WC()->cart->get_cart_contents_count() : '' ) . '</span>';

	return $fragments;
}

function ideapark_woocommerce_show_product_loop_new_badge() {
	$postdate      = get_the_time( 'Y-m-d' );
	$postdatestamp = strtotime( $postdate );
	$newness       = (int) ideapark_mod( 'product_newness' );

	if ( $newness > 0 ) {
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
			echo '<span class="ip-shop-loop-new-badge">' . esc_html__( 'New', 'kidz' ) . '</span>';
		}
	}
}

function ideapark_woocommerce_breadcrumbs() {
	return array(
		'delimiter'   => '',
		'wrap_before' => '<nav class="woocommerce-breadcrumb"><ul>',
		'wrap_after'  => '</ul></nav>',
		'before'      => '<li>',
		'after'       => '</li>',
		'home'        => '',
	);
}

function ideapark_custom_woocommerce_thumbnail() {

	add_filter( 'woocommerce_placeholder_img_src', 'ideapark_custom_woocommerce_placeholder_img_src' );

	function ideapark_custom_woocommerce_placeholder_img_src( $src ) {
		$upload_dir = wp_upload_dir();
		$uploads    = untrailingslashit( $upload_dir['baseurl'] );
		$src        = IDEAPARK_THEME_URI . '/img/placeholder.png';

		return $src;
	}
}

function ideapark_woocommerce_account_menu_items( $items ) {
	unset( $items['customer-logout'] );

	return $items;
}

function ideapark_single_product_summary_break() {
	echo '</div><div class="col-md-12 col-xs-6 break">';
}

function ideapark_single_product_summary_availability() {
	global $product;

	if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {
		$availability = $product->get_availability();
		if ( $product->is_in_stock() ) {
			$availability_html = '<span class="ip-stock ip-in-stock ' . esc_attr( $availability['class'] ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-check" /></svg>' . ( $availability['availability'] ? esc_html( $availability['availability'] ) : esc_html__( 'In stock', 'kidz' ) ) . '</span>';
		} else {
			$availability_html = '<span class="ip-stock ip-out-of-stock ' . esc_attr( $availability['class'] ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-close" /></svg>' . esc_html( $availability['availability'] ) . '</span>';
		}
	} else {
		$availability_html = '';
	}

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
}

function ideapark_cut_product_categories( $links ) {
	if ( ideapark_woocommerce_on() && is_product() ) {
		$links = array_slice( $links, 0, 2 );
	}

	return $links;
}

function ideapark_remove_product_description_heading() {
	return '';
}

function ideapark_woocommerce_archive_description() {
	if ( is_search() ) {
		echo '<p>';
		get_search_form();
		echo '</p>';
	}
}

function ideapark_woocommerce_max_srcset_image_width_768( $max_width, $size_array ) {
	return 768;
}

function ideapark_woocommerce_max_srcset_image_width_360( $max_width, $size_array ) {
	return 360;
}


function ideapark_woocommerce_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
	foreach ( $sources AS $width => $data ) {
		if ( $width < 210 ) {
			unset( $sources[ $width ] );
		}
	}

	return $sources;
}

function ideapark_woocommerce_hide_uncategorized( $args ) {
	if ( ideapark_mod( 'hide_uncategorized' ) ) {
		$args['exclude'] = get_option( 'default_product_cat' );
	}

	return $args;
}

if ( IDEAPARK_THEME_DEMO ) {
	add_filter( 'term_links-product_cat', 'ideapark_cut_product_categories', 99, 1 );
}

/*------------------------------------*\
	Actions + Filters
\*------------------------------------*/


add_action( 'after_setup_theme', 'ideapark_setup' );
add_action( 'widgets_init', 'ideapark_widgets_init' );
add_action( 'wp_enqueue_scripts', 'ideapark_scripts_disable_cf7', 9 );
add_action( 'wp_enqueue_scripts', 'ideapark_scripts', 99 );
add_action( 'wp_ajax_ideapark_ajax_search', 'ideapark_ajax_search' );
add_action( 'wp_ajax_nopriv_ideapark_ajax_search', 'ideapark_ajax_search' );
add_action( 'after_switch_theme', 'ideapark_woocommerce_set_image_dimensions', 1 );
add_action( 'admin_init', 'ideapark_woocommerce_set_image_dimensions', 1000 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ideapark_woocommerce_show_product_loop_new_badge', 30 );
add_action( 'init', 'ideapark_custom_woocommerce_thumbnail' );

add_filter( 'body_class', 'ideapark_body_class' );
add_filter( 'ideapark_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );
add_filter( 'theme_page_templates', 'ideapark_remove_page_templates' );
add_filter( 'excerpt_more', 'ideapark_excerpt_more' );
add_filter( 'excerpt_length', 'ideapark_custom_excerpt_length', 999 );
add_filter( 'get_search_form', 'ideapark_search_form', 10 );

add_filter( 'woocommerce_enqueue_styles', '__return_false' );
add_filter( 'woocommerce_add_to_cart_fragments', 'ideapark_header_add_to_cart_fragment' );
add_filter( 'woocommerce_breadcrumb_defaults', 'ideapark_woocommerce_breadcrumbs' );
add_filter( 'woocommerce_account_menu_items', 'ideapark_woocommerce_account_menu_items' );
add_filter( 'woocommerce_product_description_heading', 'ideapark_remove_product_description_heading' );
add_action( 'woocommerce_archive_description', 'ideapark_woocommerce_archive_description' );
add_filter( 'woocommerce_product_subcategories_args', 'ideapark_woocommerce_hide_uncategorized' );