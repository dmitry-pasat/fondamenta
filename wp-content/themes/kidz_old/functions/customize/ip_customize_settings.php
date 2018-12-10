<?php

$ideapark_customize_custom_css = array();
$ideapark_customize            = array();
$ideapark_customize_mods       = array();

function ideapark_init_theme_customize() {
	global $ideapark_customize;
	$ideapark_customize = array(
		array(
			'title'       => esc_html__( 'Social Media Links', 'kidz' ),
			'description' => esc_html__( 'Add the full url of your social media page e.g http://twitter.com/yoursite', 'kidz' ),
			'controls'    => array(
				'facebook'    => array(
					'label'             => esc_html__( 'Facebook url:', 'kidz' ),
					'type'              => 'text',
					'default'           => '#',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'instagram'   => array(
					'label'             => esc_html__( 'Instagram url:', 'kidz' ),
					'type'              => 'text',
					'default'           => '#',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'twitter'     => array(
					'label'             => esc_html__( 'Twitter url:', 'kidz' ),
					'type'              => 'text',
					'default'           => '#',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'google-plus' => array(
					'label'             => esc_html__( 'Google+ url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'youtube'     => array(
					'label'             => esc_html__( 'YouTube url:', 'kidz' ),
					'type'              => 'text',
					'default'           => '#',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'vimeo'       => array(
					'label'             => esc_html__( 'Vimeo url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'linkedin'    => array(
					'label'             => esc_html__( 'LinkedIn url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'flickr'      => array(
					'label'             => esc_html__( 'Flickr url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'pinterest'   => array(
					'label'             => esc_html__( 'Pinterest url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'tumblr'      => array(
					'label'             => esc_html__( 'Tumblr url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'dribbble'    => array(
					'label'             => esc_html__( 'Dribbble url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'github'      => array(
					'label'             => esc_html__( 'Github url:', 'kidz' ),
					'type'              => 'text',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
			)
		),

		array(
			'title'       => esc_html__( 'Logo and Header Settings', 'kidz' ),
			'description' => esc_html__( 'This is a settings section to change header options and upload logo.', 'kidz' ),
			'controls'    => array(
				'logo'            => array(
					'label'             => esc_html__( 'Retina Logo', 'kidz' ),
					'description'       => esc_html__( 'Retina Ready Image logo. It should has width 310px (for landscape style logo) or height 310px (for portrait style log)', 'kidz' ),
					'class'             => 'WP_Customize_Image_Control',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),
				'favicon'         => array(
					'label'             => esc_html__( 'Favicon', 'kidz' ),
					'description'       => esc_html__( 'Use if favicon has not been set in section Site Identity -> Site Icon', 'kidz' ),
					'class'             => 'WP_Customize_Image_Control',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),
				'header_type'     => array(
					'label'             => esc_html__( 'Header type', 'kidz' ),
					'default'           => 'header-type-1',
					'sanitize_callback' => 'ideapark_sanitize_text',
					'type'              => 'radio',
					'choices'           => array(
						'header-type-1' => esc_html__( 'Left Logo ', 'kidz' ),
						'header-type-2' => esc_html__( 'Center Logo', 'kidz' ),
					),
				),
				'logo_extra_size' => array(
					'label'             => esc_html__( 'Big logo', 'kidz' ),
					'description'       => esc_html__( 'Only for center logo header', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'top_menu'        => array(
					'label'             => esc_html__( 'Enable Top Menu', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'mega_menu'       => array(
					'label'             => esc_html__( 'Enable Mega Menu', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'sticky_menu'     => array(
					'label'             => esc_html__( 'Sticky menu', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'sticky_type'     => array(
					'label'             => esc_html__( 'Sticky menu type', 'kidz' ),
					'default'           => 'sticky-type-1',
					'sanitize_callback' => 'ideapark_sanitize_text',
					'type'              => 'radio',
					'choices'           => array(
						'sticky-type-1' => esc_html__( 'Only Icons', 'kidz' ),
						'sticky-type-2' => esc_html__( 'Only Text', 'kidz' ),
					),
				),
			),
		),
		array(
			'title'       => esc_html__( 'Home Slider', 'kidz' ),
			'description' => esc_html__( 'This is a settings section to change home page slider properties.', 'kidz' ),
			'controls'    => array(

				'slider_shortcode' => array(
					'label'             => esc_html__( 'Third-party slider shortcode', 'kidz' ),
					'description'       => esc_html__( 'Enter shortcode and disable slider below, if you want to use a third-party slider instead of the theme slider', 'kidz' ),
					'type'              => 'text',
					'default'           => '',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),

				'slider_enable'   => array(
					'label'             => esc_html__( 'Enable Slider', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_fullwidth_slider' => array(
					'label'             => esc_html__( 'Fullwidth', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'slider_effect'   => array(
					'label'             => esc_html__( 'Effect', 'kidz' ),
					'default'           => 'slide',
					'sanitize_callback' => 'ideapark_sanitize_text',
					'type'              => 'radio',
					'choices'           => array(
						'fade'  => esc_html__( 'Fade', 'kidz' ),
						'slide' => esc_html__( 'Slide', 'kidz' ),
					),
				),

				'slider_items'    => array(
					'label'             => esc_html__( 'Slider Items', 'kidz' ),
					'default'           => 5,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'slider_speed'    => array(
					'label'             => esc_html__( 'Effect speed (ms)', 'kidz' ),
					'default'           => 500,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'slider_interval' => array(
					'label'             => esc_html__( 'Autoplay interval (ms)', 'kidz' ),
					'description'       => esc_html__( 'Set to zero if you want to disable autoplay', 'kidz' ),
					'default'           => 5000,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),
			),
		),
		array(
			'title'    => esc_html__( 'Home/Blog Layout', 'kidz' ),
			'controls' => array(

				'home_brands_white_bg' => array(
					'label'             => esc_html__( 'Brands on white background', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_bottom_category' => array(
					'label'             => esc_html__( 'Home Page Bottom Posts Category', 'kidz' ),
					'description'       => esc_html__( 'Select category if you want the posts from this category to be shown at the bottom of the home page', 'kidz' ),
					'default'           => 0,
					'class'             => 'WP_Customize_Category_Control',
					'sanitize_callback' => 'absint',
				),

				'home_hide_banners'       => array(
					'label'             => esc_html__( 'Hide Home Banners', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_hide_tabs'       => array(
					'label'             => esc_html__( 'Hide Home Product Tabs', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_hide_brands'       => array(
					'label'             => esc_html__( 'Hide Home Brands', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_hide_post'       => array(
					'label'             => esc_html__( 'Hide Home Blog Posts', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_hide_reviews'       => array(
					'label'             => esc_html__( 'Hide Home Reviews', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_hide_about'       => array(
					'label'             => esc_html__( 'Hide Home About Text', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

			),
		),
		array(
			'title'    => esc_html__( 'Fonts', 'kidz' ),
			'controls' => array(

				'theme_font_1'    => array(
					'label'             => esc_html__( 'Main Font 1 (Google Font)', 'kidz' ),
					'default'           => 'Fredoka One',
					'description'       => esc_html__( 'Default font: Fredoka One', 'kidz' ),
					'sanitize_callback' => 'ideapark_sanitize_font_choice',
					'type'              => 'select',
					'choices'           => ideapark_get_font_choices(),
				),
				'theme_font_1_weight'    => array(
					'label'             => esc_html__( 'Font 1 Weight', 'kidz' ),
					'default'           => '400',
					'description'       => esc_html__( 'Default: 400', 'kidz' ),
					'sanitize_callback' => 'ideapark_sanitize_text',
					'type'              => 'select',
					'choices'           => array(
						'100' => '100',
						'200' => '200',
						'300' => '300',
						'400' => '400 (normal)',
						'500' => '500',
						'600' => '600',
						'700' => '700 (bold)',
						'800' => '800',
						'900' => '900',
					),
				),
				'theme_font_2'    => array(
					'label'             => esc_html__( 'Main Font 2 (Google Font)', 'kidz' ),
					'default'           => 'Montserrat',
					'description'       => esc_html__( 'Default font: Montserrat', 'kidz' ),
					'sanitize_callback' => 'ideapark_sanitize_font_choice',
					'type'              => 'select',
					'choices'           => ideapark_get_font_choices(),
				),
			),
		),
		array(
			'title'    => esc_html__( 'Post/Page Settings', 'kidz' ),
			'controls' => array(
				'home_sidebar' => array(
					'label'             => esc_html__( 'Sidebar', 'kidz' ),
					'default'           => 'right',
					'sanitize_callback' => 'ideapark_sanitize_text',
					'type'              => 'radio',
					'choices'           => array(
						'right'   => esc_html__( 'Right', 'kidz' ),
						'disable' => esc_html__( 'Disable', 'kidz' ),
					),
				),
				'post_hide_sidebar'        => array(
					'label'             => esc_html__( 'Hide Sidebar', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_featured_image' => array(
					'label'             => esc_html__( 'Hide Featured Image', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_category'       => array(
					'label'             => esc_html__( 'Hide Category', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_date'           => array(
					'label'             => esc_html__( 'Hide Date', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_share'          => array(
					'label'             => esc_html__( 'Hide Share Buttons', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_tags'           => array(
					'label'             => esc_html__( 'Hide Tags', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_comment'        => array(
					'label'             => esc_html__( 'Hide Comment Link', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_author'         => array(
					'label'             => esc_html__( 'Hide Author Info', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_postnav'        => array(
					'label'             => esc_html__( 'Hide Post Navigation', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'post_hide_related'        => array(
					'label'             => esc_html__( 'Hide Related Posts', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
			),
		),
		array(
			'title'    => esc_html__( 'Footer', 'kidz' ),
			'controls' => array(
				'logo_footer'      => array(
					'label'             => esc_html__( 'Retina Logo (optional)', 'kidz' ),
					'description'       => esc_html__( 'Retina Ready Image logo. It should has width 220px (for landscape style logo) or height 220px (for portrait style logo)', 'kidz' ),
					'class'             => 'WP_Customize_Image_Control',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),
				'footer_contacts'  => array(
					'label'             => esc_html__( 'Contacts:', 'kidz' ),
					'description'       => esc_html__( 'Only in Widgets Footer Design', 'kidz' ),
					'type'              => 'textarea',
					'default'           => '',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
				'footer_copyright' => array(
					'label'             => esc_html__( 'Copyright:', 'kidz' ),
					'type'              => 'text',
					'default'           => '&copy; Copyright 2018, Kidz WordPress Theme',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),
			),
		),
		array(
			'title'       => esc_html__( 'Performance', 'kidz' ),
			'description' => esc_html__( 'Use these options to put your theme to a high speed as well as save your server resources!', 'kidz' ),
			'controls'    => array(
				'use_minified_css' => array(
					'label'             => esc_html__( 'Use minified CSS', 'kidz' ),
					'description'       => esc_html__( 'Load all theme css files combined and minified into a single file', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
				'use_minified_js'  => array(
					'label'             => esc_html__( 'Use minified JS', 'kidz' ),
					'description'       => esc_html__( 'Load all theme js files combined and minified into a single file', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),
			),
		),
		array(
			'section'  => 'colors',
			'controls' => array(

				'accent_color_custom' => array(
					'label'             => esc_html__( 'Accent Color:', 'kidz' ),
					'class'             => 'WP_Customize_Color_Control',
					'default'           => '#56B0F2',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),

				'accent_color_2_custom' => array(
					'label'             => esc_html__( 'Second Accent Color:', 'kidz' ),
					'class'             => 'WP_Customize_Color_Control',
					'default'           => '#FF5B4B',
					'sanitize_callback' => 'ideapark_sanitize_text',
				),

				'custom_css' => array(
					'label'             => esc_html__( 'Custom CSS:', 'kidz' ),
					'priority'          => 100,
					'type'              => 'textarea',
					'default'           => '',
					'sanitize_callback' => 'ideapark_sanitize_url',
				),
			)
		),

		array(
//			'section'  => 'woocommerce',
			'title'       => esc_html__( 'WooCommerce (Kidz)', 'kidz' ),
			'description' => esc_html__( 'This is a settings section to change Kidz WooCommerce properties.', 'kidz' ),
			'controls'    => array(

				'product_newness' => array(
					'label'             => esc_html__( 'Product Newness', 'kidz' ),
					'description'       => esc_html__( 'Display the New flash for how many days? Set 0 for disable badge.', 'kidz' ),
					'default'           => 5,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'wishlist_enabled' => array(
					'label'             => esc_html__( 'Wishlist', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'wishlist_share' => array(
					'label'             => esc_html__( 'Wishlist Share', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'wishlist_page' => array(
					'label'             => esc_html__( 'Wishlist page', 'kidz' ),
					'description'       => esc_html__( 'Used to create the share links and wishlist button in header', 'kidz' ),
					'default'           => 0,
					'class'             => 'WP_Customize_Page_Control',
					'sanitize_callback' => 'absint',
				),

				'quickview_enabled' => array(
					'label'             => esc_html__( 'Quick View', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'home_tab_products' => array(
					'label'             => esc_html__( 'Tab Products', 'kidz' ),
					'description'       => esc_html__( 'The number of products in the home tabs.', 'kidz' ),
					'default'           => 12,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'home_featured_order' => array(
					'label'             => esc_html__( 'Featured Products tab sort order on the front page', 'kidz' ),
					'description'       => esc_html__( 'Set 0 for disable this tab.', 'kidz' ),
					'default'           => 1,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'home_sale_order' => array(
					'label'             => esc_html__( 'Sale Products tab sort order on the front page', 'kidz' ),
					'description'       => esc_html__( 'Set 0 for disable this tab.', 'kidz' ),
					'default'           => 2,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'home_best_selling_order' => array(
					'label'             => esc_html__( 'Best-Selling Products tab sort order on the front page', 'kidz' ),
					'description'       => esc_html__( 'Set 0 for disable this tab.', 'kidz' ),
					'default'           => 3,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'home_recent_order' => array(
					'label'             => esc_html__( 'Recent Products tab sort order on the front page', 'kidz' ),
					'description'       => esc_html__( 'Set 0 for disable this tab.', 'kidz' ),
					'default'           => 4,
					'class'             => 'WP_Customize_Number_Control',
					'type'              => 'number',
					'sanitize_callback' => 'absint',
				),

				'hide_uncategorized' => array(
					'label'             => esc_html__( 'Hide Uncategorized category', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'shop_hide_sidebar' => array(
					'label'             => esc_html__( 'Hide sidebar on product list', 'kidz' ),
					'default'           => false,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'product_hide_sidebar' => array(
					'label'             => esc_html__( 'Hide sidebar on product pages', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'product_short_sidebar' => array(
					'label'             => esc_html__( 'Short sidebar on product pages', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'shop_product_modal' => array(
					'label'             => esc_html__( 'Product Modal Gallery', 'kidz' ),
					'description'       => esc_html__( 'Viewing full-size product images in modal gallery.', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

				'shop_product_navigation_same_term' => array(
					'label'             => esc_html__( 'Product Navigation In Same Category', 'kidz' ),
					'description'       => esc_html__( 'Keep product navigation within the same category.', 'kidz' ),
					'default'           => true,
					'type'              => 'checkbox',
					'sanitize_callback' => 'ideapark_sanitize_checkbox',
				),

			),

		),
	);
}

if ( ! function_exists( 'ideapark_init_theme_mods' ) ) {
	function ideapark_init_theme_mods() {
		global $ideapark_customize, $ideapark_customize_mods;


		$all_mods_default = array();
		$all_mods_names   = array();
		if ( ! empty( $ideapark_customize ) ) {
			foreach ( $ideapark_customize AS $section ) {
				if ( ! empty( $section['controls'] ) ) {
					foreach ( $section['controls'] AS $control_name => $control ) {
						if ( isset( $control['default'] ) ) {
							$all_mods_default[ $control_name ] = $control['default'];
						}
						$all_mods_names[] = $control_name;
					}
				}
			}
		}

		$ideapark_customize_mods = get_theme_mods();

		foreach ( $all_mods_names AS $name ) {
			if ( ! is_array( $ideapark_customize_mods ) || ! array_key_exists( $name, $ideapark_customize_mods ) ) {
				$ideapark_customize_mods[ $name ] = apply_filters( "theme_mod_{$name}", array_key_exists( $name, $all_mods_default ) ? $all_mods_default[ $name ] : null );
			} else {
				$ideapark_customize_mods[ $name ] = apply_filters( "theme_mod_{$name}", $ideapark_customize_mods[ $name ] );
			}
		}
	}

	if ( is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
		if ( ideapark_mod( 'theme_fonts_set' ) == 2 && ( ideapark_mod( 'theme_font_1' ) == 'Fredoka One' || ideapark_mod( 'theme_font_1_weight' ) == 400 )) {
			set_theme_mod( 'theme_font_1', 'Exo 2' );
			set_theme_mod( 'theme_font_1_weight', '900' );
			set_theme_mod( 'theme_font_2', 'Open Sans' );
			ideapark_mod_set_temp( 'theme_font_1', 'Exo 2' );
			ideapark_mod_set_temp( 'theme_font_1_weight', '900' );
			ideapark_mod_set_temp( 'theme_font_2', 'Open Sans' );
			remove_theme_mod( 'theme_fonts_set' );
		}
	}

	if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
		add_action( 'wp_loaded', 'ideapark_init_theme_mods' );
	}
}

function ideapark_mod( $mod_name ) {
	global $ideapark_customize_mods;

	if ( array_key_exists( $mod_name, $ideapark_customize_mods ) ) {
		return $ideapark_customize_mods[ $mod_name ];
	} else {
		return null;
	}
}

function ideapark_mod_set_temp( $mod_name, $value ) {
	global $ideapark_customize_mods;

	$ideapark_customize_mods[ $mod_name ] = $value;
}

function ideapark_register_theme_customize( $wp_customize ) {
	global $ideapark_customize_custom_css, $ideapark_customize;

	if ( class_exists( 'WP_Customize_Control' ) ) {

		class WP_Customize_Number_Control extends WP_Customize_Control {
			public $type = 'number';

			public function render_content() {
				?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<input type="number" name="quantity" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>" style="width:70px;">
				</label>
				<?php
			}
		}

		class WP_Customize_CustomCss_Control extends WP_Customize_Control {
			public $type = 'custom_css';

			public function render_content() {
				?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea style="width:100%; height:150px;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
				<?php
			}
		}

		class WP_Customize_Category_Control extends WP_Customize_Control {

			public function render_content() {
				$dropdown = wp_dropdown_categories(
					array(
						'name'              => '_customize-dropdown-categories-' . $this->id,
						'echo'              => 0,
						'show_option_none'  => '&mdash; ' .esc_html__( 'Select', 'kidz' ) . ' &mdash;',
						'option_none_value' => '0',
						'selected'          => $this->value(),
					)
				);

				$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

				printf(
					'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
					$this->label,
					$dropdown
				);
			}
		}

		class WP_Customize_Page_Control extends WP_Customize_Control {

			public function render_content() {
				$dropdown = wp_dropdown_pages(
					array(
						'name'              => '_customize-dropdown-pages-' . $this->id,
						'echo'              => 0,
						'show_option_none'  => '&mdash; ' .esc_html__( 'Select', 'kidz' ) . ' &mdash;',
						'option_none_value' => '0',
						'selected'          => $this->value(),
					)
				);

				$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

				printf(
					'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
					$this->label,
					$dropdown
				);
			}
		}
	}

	foreach ( $ideapark_customize AS $i_section => $section ) {
		if ( ! empty( $section['controls'] ) ) {

			if ( ! array_key_exists( 'section', $section ) ) {
				$wp_customize->add_section( $section_name = 'ideapark_section_' . $i_section, array(
					'title'       => ! empty( $section['title'] ) ? $section['title'] : '',
					'description' => ! empty( $section['description'] ) ? $section['description'] : '',
					'priority'    => 100 + $i_section,
				) );
			} else {
				$section_name = $section['section'];
			}

			$control_priority = 1;
			foreach ( $section['controls'] AS $control_name => $control ) {
				if ( ! empty( $control['label'] ) && ( ! empty( $control['type'] ) || ! empty( $control['class'] ) ) ) {
					$a = array();
					if ( isset( $control['default'] ) ) {
						$a['default'] = $control['default'];
					}
					if ( isset( $control['sanitize_callback'] ) ) {
						$a['sanitize_callback'] = $control['sanitize_callback'];
					} else {
						die( 'No sanitize_callback found!' . print_r( $control, true ) );
					}
					call_user_func( array( $wp_customize, 'add_setting' ), $control_name, $a );

					if ( empty( $control['class'] ) ) {
						$wp_customize->add_control(
							new WP_Customize_Control(
								$wp_customize,
								$control_name,
								array(
									'label'    => $control['label'],
									'section'  => $section_name,
									'settings' => $control_name,
									'type'     => $control['type'],
									'priority' => ! empty( $control['priority'] ) ? $control['priority'] : $control_priority + 1,
									'choices'  => ! empty( $control['choices'] ) ? $control['choices'] : null,
								)
							)
						);
					} else {
						$wp_customize->add_control(
							new $control['class'](
								$wp_customize,
								$control_name,
								array(
									'label'    => $control['label'],
									'section'  => $section_name,
									'settings' => $control_name,
									'type'     => ! empty( $control['type'] ) ? $control['type'] : null,
									'priority' => ! empty( $control['priority'] ) ? $control['priority'] : $control_priority + 1,
									'choices'  => ! empty( $control['choices'] ) ? $control['choices'] : null,
								)
							)
						);
					}

					if ( ! empty( $control['description'] ) ) {
						$ideapark_customize_custom_css[ '#customize-control-' . $control_name ] = $control['description'];
					}
				}
			}
		}
	}

}

function ideapark_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ideapark_sanitize_url( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ideapark_sanitize_html( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ideapark_sanitize_checkbox( $input ) {
	if ( $input ):
		$output = true;
	else:
		$output = false;
	endif;

	return $output;
}

function ideapark_customize_admin_style() {
	global $ideapark_customize_custom_css;
	if ( ! empty( $ideapark_customize_custom_css ) && is_array( $ideapark_customize_custom_css ) ) {
		?>
		<style type="text/css">
			<?php foreach ( $ideapark_customize_custom_css AS $style_name => $text ) { ?>
			<?php echo esc_attr( $style_name ); ?>:after {
				content:       "<?php echo esc_attr($text) ?>";
				font-size:     12px;
				font-style:    italic;
				color:         #999;
				display:       block;
				margin-bottom: 15px;
				margin-top:    5px;
			}

			<?php } ?>
		</style>
		<?php
	}
}

add_action( 'init', 'ideapark_init_theme_customize', 0 );
add_action( 'customize_register', 'ideapark_register_theme_customize' );
add_action( 'customize_controls_print_styles', 'ideapark_customize_admin_style' );


function ideapark_get_all_fonts() {
	$google_fonts   = ideapark_get_google_fonts();

	/**
	 * Allow for developers to modify the full list of fonts.
	 *
	 * @since 1.3.0.
	 *
	 * @param array $fonts The list of all fonts.
	 */
	return apply_filters( 'ideapark_all_fonts', $google_fonts );
}

function ideapark_get_font_choices() {
	$fonts   = ideapark_get_all_fonts();
	$choices = array();

	// Repackage the fonts into value/label pairs
	foreach ( $fonts as $key => $font ) {
		$choices[ $key ] = $font['label'];
	}

	return $choices;
}

function ideapark_get_google_font_uri( $fonts ) {

	// De-dupe the fonts
	$fonts         = array_unique( $fonts );
	$allowed_fonts = ideapark_get_google_fonts();
	$family        = array();

	// Validate each font and convert to URL format
	foreach ( $fonts as $font ) {
		$font = trim( $font );

		// Verify that the font exists
		if ( array_key_exists( $font, $allowed_fonts ) ) {
			// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
			$family[] = urlencode( $font . ':' . join( ',', ideapark_choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) );
		}
	}

	// Convert from array to string
	if ( empty( $family ) ) {
		return '';
	} else {
		$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
	}

	// Load the font subset
	$subset = get_theme_mod( 'font-subset' );

	if ( 'all' === $subset ) {
		$subsets_available = ideapark_get_google_font_subsets();

		// Remove the all set
		unset( $subsets_available['all'] );

		// Build the array
		$subsets = array_keys( $subsets_available );
	} else {
		$subsets = array(
			'latin',
			$subset,
		);
	}

	// Append the subset string
	if ( ! empty( $subsets ) ) {
		$request .= urlencode( '&subset=' . join( ',', $subsets ) );
	}

	return esc_url( $request );
}

function ideapark_get_google_font_subsets() {
	return array(
		'all'          => esc_html__( 'All', 'kidz' ),
		'cyrillic'     => esc_html__( 'Cyrillic', 'kidz' ),
		'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'kidz' ),
		'devanagari'   => esc_html__( 'Devanagari', 'kidz' ),
		'greek'        => esc_html__( 'Greek', 'kidz' ),
		'greek-ext'    => esc_html__( 'Greek Extended', 'kidz' ),
		'khmer'        => esc_html__( 'Khmer', 'kidz' ),
		'latin'        => esc_html__( 'Latin', 'kidz' ),
		'latin-ext'    => esc_html__( 'Latin Extended', 'kidz' ),
		'vietnamese'   => esc_html__( 'Vietnamese', 'kidz' ),
	);
}

function ideapark_choose_google_font_variants( $font, $variants = array() ) {
	$chosen_variants = array();
	if ( empty( $variants ) ) {
		$fonts = ideapark_get_google_fonts();

		if ( array_key_exists( $font, $fonts ) ) {
			$variants = $fonts[ $font ]['variants'];
		}
	}

	// If a "regular" variant is not found, get the first variant
	if ( ! in_array( 'regular', $variants ) ) {
		$chosen_variants[] = $variants[0];
	} else {
		$chosen_variants[] = 'regular';
	}

	// Only add "italic" if it exists
	if ( in_array( 'italic', $variants ) ) {
		$chosen_variants[] = 'italic';
	}

	// Only add "700" if it exists
	if ( in_array( '700', $variants ) ) {
		$chosen_variants[] = '700';
	}

	return apply_filters( 'ideapark_font_variants', array_unique( $chosen_variants ), $font, $variants );
}


function ideapark_sanitize_font_choice( $value ) {
	if ( is_int( $value ) ) {
		// The array key is an integer, so the chosen option is a heading, not a real choice
		return '';
	} else if ( array_key_exists( $value, ideapark_get_font_choices() ) ) {
		return $value;
	} else {
		return '';
	}
}

$_ideapark_google_fonts_cache = false;

function ideapark_get_google_fonts() {
	global $_ideapark_google_fonts_cache, $wp_filesystem;

	if ($_ideapark_google_fonts_cache) {
		return $_ideapark_google_fonts_cache;
	}

	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$decoded_google_fonts = json_decode( $wp_filesystem->get_contents( IDEAPARK_THEME_DIR . '/functions/customize/webfonts.json'), true );
	$webfonts             = array();
	foreach ( $decoded_google_fonts['items'] as $key => $value ) {
		$font_family                          = $decoded_google_fonts['items'][ $key ]['family'];
		$webfonts[ $font_family ]             = array();
		$webfonts[ $font_family ]['label']    = $font_family;
		$webfonts[ $font_family ]['variants'] = $decoded_google_fonts['items'][ $key ]['variants'];
		$webfonts[ $font_family ]['subsets']  = $decoded_google_fonts['items'][ $key ]['subsets'];
	}

	return $_ideapark_google_fonts_cache = apply_filters( 'ideapark_get_google_fonts', $webfonts );
}
