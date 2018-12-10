<?php
/*
 * Plugin Name: Kidz Theme Functionality
 * Version: 1.4.2
 * Description: Slider, Banners, Brands and Reviews plugin for the Kidz theme.
 * Author: ideapark.kz
 * Author URI: http://ideapark.kz
 * Text Domain: ideapark-theme-functionality
 * Domain Path: /lang/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'IDEAPARK_THEME_FUNC_VERSION', '1.4.2' );

$theme_obj = wp_get_theme();

if ( empty( $theme_obj ) || strtolower( $theme_obj->get( 'Name' ) ) != 'kidz' && strtolower( $theme_obj->get( 'Name' ) ) != 'kidz-child' ) {

	function ideapark_theme_functionality_wrong_theme( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$row_meta = array(
				'warning' => '<b>' . esc_html__( 'This plugin works only with Kidz theme', 'ideapark-theme-functionality' ) . '</b>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	add_filter( 'plugin_row_meta', 'ideapark_theme_functionality_wrong_theme', 10, 2 );

	return;
}

$ip_dir = dirname( __FILE__ );

require_once( $ip_dir . '/importer/importer.php' );
require_once( $ip_dir . '/includes/class-ideapark-theme-functionality.php' );
require_once( $ip_dir . '/includes/lib/class-ideapark-theme-functionality-admin-api.php' );
require_once( $ip_dir . '/includes/lib/class-ideapark-theme-functionality-post-type.php' );
require_once( $ip_dir . '/megamenu/edit_custom_walker.php' );
require_once( $ip_dir . '/megamenu/custom_walker.php' );
require_once( $ip_dir . '/megamenu/mega-menu.php' );

new Ideaperk_Mega_Menu( __FILE__, IDEAPARK_THEME_FUNC_VERSION );

/**
 * Returns the main instance of ideapark_theme_functionality to prevent the need to use globals.
 *
 * @since  1.1
 * @return object ideapark_theme_functionality
 */
function Ideapark_Theme_Functionality() {
	$instance = Ideapark_Theme_Functionality::instance( __FILE__, IDEAPARK_THEME_FUNC_VERSION );

	return $instance;
}

function Ideapark_Importer() {
	$instance = Ideapark_Importer::instance( __FILE__, IDEAPARK_THEME_FUNC_VERSION );

	return $instance;
}

Ideapark_Importer();

Ideapark_Theme_Functionality()->register_post_type(
	'slider',
	esc_html__( 'Slides', 'ideapark-theme-functionality' ),
	esc_html__( 'Slide', 'ideapark-theme-functionality' ),
	'Home Page Slider',
	array(
		'menu_icon'           => 'dashicons-slides',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'thumbnail' ),
		'has_archive'         => true,
		'query_var'           => false,
		'can_export'          => true,
	) );

Ideapark_Theme_Functionality()->register_post_type(
	'banner',
	esc_html__( 'Banners', 'ideapark-theme-functionality' ),
	esc_html__( 'Banner', 'ideapark-theme-functionality' ),
	'Home Page Banners',
	array(
		'menu_icon'           => 'dashicons-images-alt2',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'thumbnail' ),
		'has_archive'         => true,
		'query_var'           => false,
		'can_export'          => true,
	) );

Ideapark_Theme_Functionality()->register_post_type(
	'brand',
	esc_html__( 'Brands', 'ideapark-theme-functionality' ),
	esc_html__( 'Brand', 'ideapark-theme-functionality' ),
	'Home Page Brands',
	array(
		'menu_icon'           => 'dashicons-images-alt',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'thumbnail' ),
		'has_archive'         => true,
		'query_var'           => false,
		'can_export'          => true,
	) );

Ideapark_Theme_Functionality()->register_post_type(
	'review',
	esc_html__( 'Reviews', 'ideapark-theme-functionality' ),
	esc_html__( 'Review', 'ideapark-theme-functionality' ),
	'Home Page Reviews',
	array(
		'menu_icon'           => 'dashicons-editor-quote',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'thumbnail', 'excerpt' ),
		'has_archive'         => true,
		'query_var'           => false,
		'can_export'          => true,
	) );


Ideapark_Theme_Functionality()->set_sorted_post_types( array( 'slider', 'banner', 'brand', 'review' ) );

add_action( 'add_meta_boxes', 'ideapark_theme_functionality_add_meta_box' );

function ideapark_theme_functionality_add_meta_box() {
	Ideapark_Theme_Functionality()->admin->add_meta_box( 'ideapark_metabox_slider_details', esc_html__( 'Slider details', 'ideapark-theme-functionality' ), array( "slider" ) );
	Ideapark_Theme_Functionality()->admin->add_meta_box( 'ideapark_metabox_banner_details', esc_html__( 'Banner details', 'ideapark-theme-functionality' ), array( "banner" ) );
	Ideapark_Theme_Functionality()->admin->add_meta_box( 'ideapark_metabox_brand_details', esc_html__( 'Brand details', 'ideapark-theme-functionality' ), array( "brand" ) );
	Ideapark_Theme_Functionality()->admin->add_meta_box( 'ideapark_metabox_review_details', esc_html__( 'Review details', 'ideapark-theme-functionality' ), array( "review" ) );
}

add_filter( "slider_custom_fields", "ideapark_theme_functionality_add_custom_fields" );

function ideapark_theme_functionality_add_custom_fields() {
	$fields   = array();
	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_slider_details"
		),
		'id'      => "_ip_slider_subheader",
		'label'   => esc_html__( 'Subheader', 'ideapark-theme-functionality' ),
		'type'    => 'text',
	);
	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_slider_details"
		),
		'id'      => "_ip_slider_link",
		'label'   => esc_html__( 'Link', 'ideapark-theme-functionality' ),
		'type'    => 'url',
	);

	return $fields;
}

add_filter( "banner_custom_fields", "ideapark_home_banner_add_custom_fields" );

function ideapark_home_banner_add_custom_fields() {
	$fields   = array();
	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_banner_details"
		),
		'id'      => "_ip_banner_price",
		'label'   => esc_html__( 'Price', 'ideapark-theme-functionality' ),
		'type'    => 'text',
	);

	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_banner_details"
		),
		'id'      => "_ip_banner_button_text",
		'label'   => esc_html__( 'Button Text', 'ideapark-theme-functionality' ),
		'type'    => 'text',
		'default' => 'Shop Now'
	);

	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_banner_details"
		),
		'id'      => "_ip_banner_button_link",
		'label'   => esc_html__( 'Button Link', 'ideapark-theme-functionality' ),
		'type'    => 'url',
	);

	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_banner_details"
		),
		'id'      => "_ip_banner_color",
		'label'   => esc_html__( 'Accent Color', 'ideapark-theme-functionality' ),
		'type'    => 'color',
		'default' => '#5DACF5'
	);

	return $fields;
}

add_filter( "brand_custom_fields", "ideapark_home_brand_add_custom_fields" );

function ideapark_home_brand_add_custom_fields() {
	$fields   = array();
	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_brand_details"
		),
		'id'      => "_ip_brand_link",
		'label'   => esc_html__( 'Link', 'ideapark-theme-functionality' ),
		'type'    => 'url',
	);

	return $fields;
}

add_filter( "review_custom_fields", "ideapark_home_review_add_custom_fields" );

function ideapark_home_review_add_custom_fields() {
	$fields   = array();
	$fields[] = array(
		"metabox" => array(
			'name' => "ideapark_metabox_review_details"
		),
		'id'      => "_ip_review_occupation",
		'label'   => esc_html__( 'Occupation', 'ideapark-theme-functionality' ),
		'type'    => 'text',
	);

	return $fields;
}

add_filter( 'manage_banner_posts_columns', 'ideapark_add_img_column' );
add_filter( 'manage_slider_posts_columns', 'ideapark_add_img_column' );
add_filter( 'manage_brand_posts_columns', 'ideapark_add_img_column' );

function ideapark_add_img_column( $columns ) {
	$columns['img'] = esc_html__( 'Featured Image', 'ideapark-theme-functionality' );

	return $columns;
}

add_filter( 'manage_posts_custom_column', 'ideapark_manage_img_column', 10, 2 );

function ideapark_manage_img_column( $column_name, $post_id ) {
	if ( $column_name == 'img' ) {
		echo get_the_post_thumbnail( $post_id, 'thumbnail' );
	}
}

add_filter( 'wp_calculate_image_srcset', 'ideapark_wp_calculate_image_srcset_slider', 100, 5 );

function ideapark_wp_calculate_image_srcset_slider( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {

	if ( $size_array[1] == 590 ) {
		foreach ( $sources AS $i => $source ) {
			$height = $source['value'] / $size_array[0] * $size_array[1];
			if ( $height < 300 ) {
				unset( $sources[ $i ] );
			}
		}
	}

	return $sources;
}

add_action( 'woocommerce_product_options_advanced', 'ideapark_woo_add_custom_advanced_fields' );

function ideapark_woo_add_custom_advanced_fields() {
	echo '<div class="options_group">';
	woocommerce_wp_text_input(
		array(
			'id'          => '_ip_product_video_url',
			'label'       => esc_html__( 'Video URL', 'ideapark-theme-functionality' ),
			'placeholder' => 'http://',
			'desc_tip'    => 'true',
			'description' => esc_html__( 'Enter the url to product video (Youtube, Vimeo etc.).', 'ideapark-theme-functionality' )
		)
	);
	echo '</div>';
}

add_filter( 'user_contactmethods', 'ideapark_contactmethods', 10, 1 );

function ideapark_contactmethods( $contactmethods ) {
	global $ideapark_customize;

	$is_founded = false;

	if ( ! empty( $ideapark_customize ) ) {
		foreach ( $ideapark_customize AS $section ) {
			if ( ! empty( $section['controls'] ) && array_key_exists( 'facebook', $section['controls'] ) ) {
				foreach ( $section['controls'] AS $control_name => $control ) {
					$contactmethods[ $control_name ] = $control['label'];
				}
				$is_founded = true;
			}
		}
	}

	if ( ! $is_founded ) {
		$contactmethods['facebook']  = esc_html__( 'Facebook url', 'ideapark-theme-functionality' );
		$contactmethods['instagram'] = esc_html__( 'Instagram url', 'ideapark-theme-functionality' );
		$contactmethods['twitter']   = esc_html__( 'Twitter url', 'ideapark-theme-functionality' );
		$contactmethods['google']    = esc_html__( 'Google Plus url', 'ideapark-theme-functionality' );
		$contactmethods['tumblr']    = esc_html__( 'Tumblr url', 'ideapark-theme-functionality' );
		$contactmethods['pinterest'] = esc_html__( 'Pinterest url', 'ideapark-theme-functionality' );
	}

	return $contactmethods;
}

add_action( 'woocommerce_process_product_meta', 'ideapark_woo_add_custom_general_fields_save' );

function ideapark_woo_add_custom_general_fields_save( $post_id ) {

	$woocommerce_text_field = $_POST['_ip_product_video_url'];
	if ( ! empty( $woocommerce_text_field ) ) {
		update_post_meta( $post_id, '_ip_product_video_url', esc_attr( $woocommerce_text_field ) );
	}

}

add_shortcode( 'ip-two-col', 'ideapark_shortcode_two_col' );
add_shortcode( 'ip-left', 'ideapark_shortcode_left' );
add_shortcode( 'ip-right', 'ideapark_shortcode_right' );
add_shortcode( 'ip-post-share', 'ideapark_shortcode_post_share' );

function ideapark_shortcode_two_col( $atts, $content ) {
	$content = '<div class="clear"></div><div class="two-col">' . do_shortcode( $content ) . '</div><div class="clear"></div>';

	return force_balance_tags( $content );
}

function ideapark_shortcode_left( $atts, $content ) {
	$content = '<div class="left"><div>' . $content . '</div></div>';

	return $content;
}

function ideapark_shortcode_right( $atts, $content ) {
	$content = '<div class="right"><div>' . $content . '</div></div>';

	return $content;
}

function ideapark_shortcode_post_share( $atts ) {
	global $post;
	ob_start();
	if ( ! empty( $post ) && is_single( $post ) && function_exists( 'ideapark_svg_url' ) ) {
		?>
		<span><?php echo esc_html__( 'Share', 'kidz' ); ?></span>
		<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo rawurlencode( get_permalink( $post ) ); ?>">
			<svg>
				<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-facebook" />
			</svg>
		</a>
		<a target="_blank" href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php echo rawurlencode( get_the_title() ); ?>%20-%20<?php echo rawurlencode( get_permalink( $post ) ); ?>">
			<svg>
				<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-twitter" />
			</svg>
		</a>
		<a target="_blank" data-pin-do="skipLink" href="https://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink( $post ) ); ?>&media=<?php echo rawurlencode( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>&description=<?php echo rawurlencode( get_the_title() ); ?>">
			<svg>
				<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-pinterest" />
			</svg>
		</a>
		<a target="_blank" href="https://plus.google.com/share?url=<?php echo rawurlencode( get_permalink( $post ) ); ?>">
			<svg>
				<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-google-plus" />
			</svg>
		</a>
		<?php
	}
	$content = ob_get_clean();

	return $content;
}

function ideapark_product_share( ) {
	global $post;

	$esc_permalink = esc_url( get_permalink() );
	$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );

	$share_links = array(
		'<a href="//www.facebook.com/sharer.php?u=' . $esc_permalink . '" target="_blank" title="' . esc_html__( 'Share on Facebook', 'kidz' ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-facebook" /></svg></a>',
		'<a href="//twitter.com/share?url=' . $esc_permalink . '" target="_blank" title="' . esc_html__( 'Share on Twitter', 'kidz' ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-twitter" /></svg></a>',
		'<a href="//pinterest.com/pin/create/button/?url=' . $esc_permalink . '&amp;media=' . esc_url( $product_image[0] ) . '&amp;description=' . urlencode( get_the_title() ) . '" target="_blank" title="' . esc_html__( 'Pin on Pinterest', 'kidz' ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-pinterest" /></svg></a>',
		'<a href="//plus.google.com/share?url=' . $esc_permalink . '" target="_blank" title="' . esc_html__( 'Share on Google+', 'kidz' ) . '"><svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#svg-google-plus" /></svg></a>'
	);
	?>

	<div class="ip-product-share-wrap">
		<?php if ( ideapark_mod( 'wishlist_enabled' ) && class_exists( 'Ideapark_Wishlist' ) ) { ?>
			<div class="ip-product-wishlist-button"><?php Ideapark_Wishlist()->button( true ) ?></div>
		<?php } ?>

		<div class="ip-product-share">
			<span><?php echo __( 'Share', 'kidz' ); ?></span>
			<?php
			foreach ( $share_links as $link ) {
				echo $link;
			}
			?>
		</div>

	</div>
	<?php
}

add_action( 'woocommerce_share', 'ideapark_product_share' );

add_filter( 'the_content', 'ideapark_shortcode_empty_paragraph_fix' );

function ideapark_shortcode_empty_paragraph_fix( $content ) {
	$shortcodes = array( 'ip-two-col', 'ip-left', 'ip-right' );
	foreach ( $shortcodes as $shortcode ) {
		$array   = array(
			'<p>[' . $shortcode    => '[' . $shortcode,
			'<p>[/' . $shortcode   => '[/' . $shortcode,
			$shortcode . ']</p>'   => $shortcode . ']',
			$shortcode . ']<br />' => $shortcode . ']'
		);
		$content = strtr( $content, $array );
	}

	return $content;
}

add_filter( 'upload_mimes', 'ideapark_mime_types' );

function ideapark_mime_types( $mimes ) {
	if ( current_user_can( 'administrator' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}

	return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'ideapark_ignore_upload_ext', 10, 4 );

function ideapark_ignore_upload_ext( $checked, $file, $filename, $mimes ) {

	if ( ! $checked['type'] ) {
		$wp_filetype     = wp_check_filetype( $filename, $mimes );
		$ext             = $wp_filetype['ext'];
		$type            = $wp_filetype['type'];
		$proper_filename = $filename;

		if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
			$ext = $type = false;
		}

		$checked = compact( 'ext', 'type', 'proper_filename' );
	}

	return $checked;
}
