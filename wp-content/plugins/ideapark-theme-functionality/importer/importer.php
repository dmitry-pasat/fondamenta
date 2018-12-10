<?php

defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );

class Ideapark_Importer {

	private $file;
	private $dir;
	private $importer_dir;
	private $importer_url;
	private $_version;
	private static $_instance = null;
	private $export_path = '';
	private $demo_content_folder = 'data';
	private $options_to_export_page_id = array(
		'woocommerce_shop_page_id',
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_terms_page_id',
		'page_for_posts',
		'page_on_front'
	);

	private $options_to_export = array(
		'show_on_front',
		'posts_per_page'
	);

	function __construct( $file, $version = '1.0.0' ) {

		$this->_version     = $version;
		$this->file         = $file;
		$this->dir          = dirname( $this->file );
		$this->importer_dir = trailingslashit( $this->dir ) . 'importer';
		$this->importer_url = trailingslashit( plugins_url( '/importer/', $this->file ) );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_ajax_ideapark_importer', array( $this, 'importer' ) );
		add_action( 'wp_ajax_ideapark_exporter', array( $this, 'exporter' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	public static function instance( $file, $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}

		return self::$_instance;
	}

	function admin_menu() {
		add_theme_page( __( 'Import Demo Content', 'ideapark-theme-functionality' ), __( 'Import Demo Content', 'ideapark-theme-functionality' ), 'manage_options', 'ideapark_themes_importer_page', array(
			$this,
			'importer_page'
		) );
	}

	public function scripts( $hook ) {
		if ( 'appearance_page_ideapark_themes_importer_page' != $hook ) {
			return;
		}

		wp_enqueue_style( 'ideapark-importer', $this->importer_url . '/importer.css', array(), $this->_version, 'all' );
		wp_enqueue_script( 'ideapark-importer', $this->importer_url . '/importer.js', array( 'jquery' ), $this->_version );
		wp_localize_script( 'ideapark-importer', 'ideapark_wp_vars_importer', array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'please_wait'  => __( 'Please wait...', 'ideapark-theme-functionality' ),
			'are_you_sure' => __( 'Are you sure you want to import?', 'ideapark-theme-functionality' ),
			'importing'    => __( 'Importing ...', 'ideapark-theme-functionality' ),
			'progress'     => __( 'Progress', 'ideapark-theme-functionality' ),
			'output_error' => __( 'Output Error', 'ideapark-theme-functionality' ),
		) );
	}

	public function _sort_importer_page( $a, $b ) {
		if ($a == $b) {
			return 0;
		}
		return ($a < $b) ? -1 : 1;
	}

	function importer_page() {

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$folders = $wp_filesystem->dirlist( $this->importer_dir . '/', false );
		$themes  = array();
		foreach ( $folders as $name => $folder ) {
			if ( $folder['type'] == 'd' && $wp_filesystem->exists( $theme_title_fn = $this->importer_dir . '/' . $name . '/theme.txt' ) ) {
				$themes[ $name ] = array(
					'title' => $wp_filesystem->get_contents( $theme_title_fn )
				);

				if ( $wp_filesystem->exists( $theme_title_fn = $this->importer_dir . '/' . $name . '/theme.png' ) ) {
					$themes[ $name ]['screenshot'] = $this->importer_url . '/' . $name . '/theme.png';
				}
			}
		}

		$output = '';
		$output .= '<div id="ip-import" class="wrap">';
		$output .= '<h1>' . IDEAPARK_THEME_NAME . ' - ' . __( 'One-Click Import Demo Content', 'ideapark-theme-functionality' ) . '</h1>';
		$output .= '<div class="ip-import-block">';
		if ( ! empty( $themes ) ) {
			$output .= '<p><span class="subheader">' . __( 'Select the demo site you want to import: ', 'ideapark-theme-functionality' ) . '</span>' .
			           '<br />';
			$is_first = true;
			uksort($themes, array($this, '_sort_importer_page'));
			foreach ( $themes as $name => $theme ) {
				if ( ! empty( $theme['screenshot'] ) ) {
					$output .= '<label><input type="radio" name="import_demo" value="' . esc_attr( $name ) . '" ' . ( $is_first ? 'checked' : '' ) . '/><img class="screenshot" alt="' . esc_attr( $theme['title'] ) . '" src="' . esc_attr( $theme['screenshot'] ) . '" />' . esc_attr( $theme['title'] ) . '</label><br />';
				} else {
					$output .= '<label><input type="radio" name="import_demo" value="' . esc_attr( $name ) . '`" ' . ( $is_first ? 'checked' : '' ) . '/> ' . esc_attr( $theme['title'] ) . '</label><br />';
				}

				$is_first = false;
			}
		}
		$output .= '<p><span class="subheader">' . __( 'Select the data you want to import: ', 'ideapark-theme-functionality' ) . '</span>' .
		           '<br />
			<label><input type="radio" name="import_option" value="all" checked/>' . __( 'All', 'ideapark-theme-functionality' ) . '</label><br />
			<label><input type="radio" name="import_option" value="content"/>' . __( 'Content', 'ideapark-theme-functionality' ) . '</label><br />
			<label><input type="radio" name="import_option" value="widgets"/>' . __( 'Widgets', 'ideapark-theme-functionality' ) . '</label><br />
			<label><input type="radio" name="import_option" value="options"/>' . __( 'Options', 'ideapark-theme-functionality' ) . '</label><br />
			</p>';
		$output .= '<p><label><input type="checkbox" value="1" name="import_attachments" checked /> ' . __( 'Import attachments', 'ideapark-theme-functionality' ) . '</label></p>';
		$output .= '<p class="submit"><button class="button button-primary" id="ip-import-submit">' . __( 'Import', 'ideapark-theme-functionality' ) . '</button> ' . ( defined( 'IDEAPARK_THEME_DEMO' ) && IDEAPARK_THEME_DEMO ? '<button class="button button-primary" id="ip-export-submit">' . __( 'Export', 'ideapark-theme-functionality' ) . '</button> ' : '' ) . '</p>';
		$output .= '</div>';
		$output .= '<div class="ip-loading-progress"><div class="ip-loading-bar"><div class="ip-loading-state"></div><div class="ip-loading-info">' . __( 'Progress', 'ideapark-theme-functionality' ) . ': 0%...</div></div><div class="ip-import-output">' . __( 'Prepare data...', 'ideapark-theme-functionality' ) . '</div></div>';
		$output .= '<div class="ip-import-notes">';
		$output .= __( 'Important notes:', 'ideapark-theme-functionality' ) . '<br />';
		$output .= __( 'Please note that import process will take time needed to download all attachments from demo web site.', 'ideapark-theme-functionality' ) . '<br />';
		$output .= __( 'If you plan to use shop, please install WooCommerce before you run import.', 'ideapark-theme-functionality' ) . '<br />';
		$output .= sprintf( wp_kses( __( 'We recommend you to <a href="%s" target="_blank">reset data</a> & clean wp-content/uploads folder before import to prevent duplicate content.', 'ideapark-theme-functionality' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( 'https://wordpress.org/plugins/wordpress-reset/' ) ) . '<br />';
		$output .= '</div>';

		echo $output;
	}

	function importer() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Importer' ) ) {
			include ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}

		include $this->importer_dir . '/parsers.php';
		include $this->importer_dir . '/wordpress-importer.php';
		include $this->importer_dir . '/wordpress-importer-extend.php';

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->import_response( 'error', __( 'Error: Permission denied', 'ideapark-theme-functionality' ) );
		}

		if ( ! headers_sent() ) {
			if ( ! session_id() ) {
				session_start();
			}
		} else {
			$this->import_response( 'error', __( 'Error: Could not start session! Please try to turn off debug mode and error reporting', 'ideapark-theme-functionality' ) );
		}

		$importer = array();
		$code     = 'continue';
		$message  = '';
		$among    = 3;

		if ( isset( $_REQUEST['stage'] ) && $_REQUEST['stage'] == 'start' ) {
			if ( isset( $_REQUEST['import_option'] ) ) {

				if ( ! empty( $_REQUEST['import_demo'] ) ) {
					$this->demo_content_folder = trim( $_REQUEST['import_demo'] );
					if ( ! $wp_filesystem->exists( $theme_title_fn = $this->importer_dir . '/' . $this->demo_content_folder . '/' ) ) {
						$this->import_response( 'error', __( 'Error: Select the demo site you want to import', 'ideapark-theme-functionality' ) );
					}
				}

				switch ( $_REQUEST['import_option'] ) {

					case 'all':
						$importer['steps'] = array(
							'prepare',
							'terms',
							'post',
							'options',
							'widget',
							'finish',
							'completed'
						);
						break;

					case 'content':
						$importer['steps'] = array(
							'prepare',
							'terms',
							'post',
							'finish',
							'completed'
						);
						break;

					case 'options':
						$importer['steps'] = array(
							'options',
							'completed'
						);
						break;

					case 'widgets':
						$importer['steps'] = array(
							'widget',
							'completed'
						);
						break;

					default:
						$this->import_response( 'error', __( 'Error: Select the data you want to import', 'ideapark-theme-functionality' ) );
				}

			} else {
				$this->import_response( 'error', __( 'Error: Select the data you want to import', 'ideapark-theme-functionality' ) );
			}

			$importer['base']                       = new Ideapark_Importer_Base();
			$importer['base']->step_total           = sizeof( $importer['steps'] ) * $among;
			$importer['import_attachments']         = ! empty( $_REQUEST['import_attachments'] );
			$importer['import_demo_content_folder'] = ! empty( $_REQUEST['import_demo'] ) ? $_REQUEST['import_demo'] : '';

		} else {
			$importer                  = unserialize( $_SESSION['ideapark_importer'] );
			$importer['base']->message = '';
			$this->demo_content_folder = $importer['import_demo_content_folder'];
		}


		$step = $importer['steps'][0];

		if ( empty( $importer['steps'][0] ) ) {
			$this->import_response( 'error', __( 'Error: Select the data you want to import', 'ideapark-theme-functionality' ) );
		}

		ob_start();

		switch ( $step ) {

			case 'prepare':

				if ( function_exists( 'ideapark_woocommerce_set_image_dimensions' ) ) {
					ideapark_woocommerce_set_image_dimensions();
				}

				$this->import_options( true );

				$importer['base']                    = new WP_Importer_Extend();
				$importer['base']->fetch_attachments = $importer['import_attachments'];
				$importer['base']->step_total += sizeof( $importer['steps'] ) * $among;
				$importer['base']->placeholder_path = $this->importer_url . 'img/placeholder.jpg';

				$theme_xml = $this->importer_dir . '/' . $this->demo_content_folder . '/content.xml';
				$importer['base']->import_start( $theme_xml );

				array_shift( $importer['steps'] );
				$importer['base']->step_done = $among;
				$message                     = __( 'Prepared data successfully', 'ideapark-theme-functionality' );

				break;

			case 'terms':
				$importer['base']->import_terms();
				array_shift( $importer['steps'] );
				$importer['base']->step_done += $among;
				$message = __( 'Imported terms successfully', 'ideapark-theme-functionality' );
				break;

			case 'post':
				if ( ! $importer['base']->importing() ) {
					array_shift( $importer['steps'] );
					$message = __( 'Imported post data successfully', 'ideapark-theme-functionality' );
					$importer['base']->step_done += $among;
				} else {
					$message = $importer['base']->message;
				}
				break;

			case 'options':
				$this->import_options();
				array_shift( $importer['steps'] );
				$importer['base']->step_done += $among;
				$message = __( 'Imported options successfully', 'ideapark-theme-functionality' );
				break;

			case 'widget':
				$this->import_widgets();
				array_shift( $importer['steps'] );
				$importer['base']->step_done += $among;
				$message = __( 'Imported widgets successfully', 'ideapark-theme-functionality' );
				break;

			case 'finish':
				array_shift( $importer['steps'] );
				$importer['base']->import_end();
				$importer['base']->step_done += $among;
				$this->import_finish( );
				break;

			case 'completed':
				$importer['base']->step_done = $importer['base']->step_total;
				if ( ! count( $importer['base']->error_msg ) ) {
					$message = '<b style="color:#444">' . __( 'Cheers! The demo data has been imported successfully! Please reload this page to finish!', 'ideapark-theme-functionality' ) . '</b>';
				} else {
					$message = '<b style="color:#444">' . __( 'Data import completed!', 'ideapark-theme-functionality' ) . '</b><br />' . '<div>' . implode( '', $importer['base']->error_msg ) . '</div>';
				}
				$code = 'completed';
				break;

			default:
				$this->import_response( 'error', __( 'Error: step not found: ', 'ideapark-theme-functionality' ) . $step );
				break;
		}

		if ( $output = ob_get_clean() ) {
			$importer['base']->error_msg[] = wp_kses( $output, array( 'br' => array() ) );
		}

		/** store state to session */
		$_SESSION['ideapark_importer'] = serialize( $importer );

		// calculate processed percent
		$percent = round( ( $importer['base']->step_done / $importer['base']->step_total ) * 100 );

		/** response to client */
		$this->import_response( $code, $message, $percent );
	}

	function import_finish() {
		global $wp_taxonomies, $wpdb;

		$taxonomy_names = array_keys($wp_taxonomies);

		foreach ($taxonomy_names AS $taxonomy_name) {
			$sql = $wpdb->prepare( "
				SELECT term_taxonomy_id
				FROM $wpdb->term_taxonomy
				WHERE taxonomy = %d
			", $taxonomy_name );

			if ($term_taxonomy_ids = $wpdb->get_col( $sql )) {
				wp_update_term_count_now( $term_taxonomy_ids, $taxonomy_name );
			}
		}
	}

	function import_options( $is_preliminary = false ) {
		global $wp_filesystem, $wpdb;

		if ( ! $is_preliminary ) {
			$theme_options_fn = $this->importer_dir . '/' . $this->demo_content_folder . '/theme_options.txt';
			if ( $wp_filesystem->exists( $theme_options_fn ) ) {
				$theme_options_txt        = $wp_filesystem->get_contents( $theme_options_fn );
				$options                  = unserialize( base64_decode( $theme_options_txt ) );
				$ideapark_customize_types = $this->_get_customize_types();

				foreach ( $options AS $mod_name => $val ) {
					if ( $mod_name === 'nav_menu_locations' ) {
						$menu_names = array();
						$menus      = wp_get_nav_menus();
						foreach ( $menus as $menu ) {
							$menu_names[ $menu->name ] = $menu->term_id;
						}
						if ( is_array( $val ) ) {
							foreach ( $val as $menu_slug => $menu_name ) {
								if ( array_key_exists( $menu_name, $menu_names ) ) {
									$val[ $menu_slug ] = $menu_names[ $menu_name ];
								}
							}
						}
					} elseif ( array_key_exists( $mod_name, $ideapark_customize_types ) ) {
						if ( $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Image_Control' ) {
							$val = str_replace( '{{site_url}}', home_url(), $val );
						} elseif ( $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Category_Control' ) {
							$term = get_term_by( 'name', $val, 'category' );
							$val  = isset( $term->term_id ) ? $term->term_id : 0;
						} elseif ( $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Page_Control' ) {
							$page = get_page_by_title( $val );
							$val  = isset( $page->ID ) ? $page->ID : 0;
						}
					}

					if ($mod_name != '0') {
						$options[ $mod_name ] = $val;
						set_theme_mod( $mod_name, $val );
					}
				}
			} else {
				$this->import_response( 'error', __( 'Error: file not found: ', 'ideapark-theme-functionality' ) . $theme_options_fn );
			}
		}

		$options_fn  = $this->importer_dir . '/' . $this->demo_content_folder . '/options.txt';
		$options_txt = $wp_filesystem->get_contents( $options_fn );
		$options     = unserialize( base64_decode( $options_txt ) );

		foreach ( $options AS $option_name => $val ) {
			if ( $option_name == 'wc_get_attribute_taxonomies' && function_exists( 'wc_get_attribute_taxonomies' ) ) {
				foreach ( $val AS $taxonomy ) {
					if ( ! taxonomy_exists( wc_attribute_taxonomy_name( $taxonomy->attribute_name ) ) ) {
						$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', array(
							'attribute_name'    => $taxonomy->attribute_name,
							'attribute_label'   => $taxonomy->attribute_label,
							'attribute_type'    => $taxonomy->attribute_type,
							'attribute_orderby' => $taxonomy->attribute_orderby,
							'attribute_public'  => $taxonomy->attribute_public,
						) );
						do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $taxonomy );
						$transient_name       = 'wc_attribute_taxonomies';
						$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies" );
						set_transient( $transient_name, $attribute_taxonomies );
					}
				}
			} elseif ( ! $is_preliminary ) {
				if ( in_array( $option_name, $this->options_to_export_page_id ) ) {
					$page = get_page_by_title( $val );
					$val  = isset( $page->ID ) ? $page->ID : 0;
				}
				update_option( $option_name, $val );
			}
		}

		wp_cache_flush();

		if ( ! $is_preliminary ) {
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );
			if ( class_exists( 'WC_Admin_Notices' ) ) {
				WC_Admin_Notices::remove_notice( 'template_files' );
				WC_Admin_Notices::remove_notice( 'install' );
			}

			flush_rewrite_rules();
		}
	}

	function import_menu() {

		// Set imported menus to registered theme locations
		$locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
		$menus     = wp_get_nav_menus(); // registered menus

		if ( $menus ) {
			foreach ( $menus as $menu ) { // assign menus to theme locations
				if ( $menu->name == 'Main Menu' ) {
					$locations['primary'] = $menu->term_id;
				}
				if ( $menu->name == 'OnePage' ) {
					$locations['onepage'] = $menu->term_id;
				}
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations

	}

	function import_widgets() {
		global $wp_filesystem;

		$widgets_json = $this->importer_dir . '/' . $this->demo_content_folder . '/widgets.txt';
		$widget_data  = $wp_filesystem->get_contents( $widgets_json );
		$this->import_widget_data( $widget_data );
	}

	function import_response( $code, $message, $percent = 0 ) {
		$response            = array();
		$response['code']    = $code;
		$response['msg']     = $message;
		$response['percent'] = $percent . '%';
		echo json_encode( $response );
		exit;
	}

	function import_widget_data( $widget_data ) {
		$data = unserialize( base64_decode( $widget_data ) );

		$sidebar_data = $data[0];
		$widget_data  = $data[1];

		$menus  = wp_get_nav_menus();
		$new_wg = array();

		foreach ( $widget_data as $key => $tp_widgets ) {
			if ( $key == 'nav_menu' ) {
				foreach ( $tp_widgets as $key => $tp_widget ) {
					foreach ( $menus as $menu ) {
						if ( $tp_widget['nav_menu'] == $menu->name ) {
							$tp_widget['nav_menu'] = $menu->term_id;
							break;
						}
					}
					$new_wg[ $key ] = $tp_widget;
				}
				$widget_data['nav_menu'] = $new_wg;
			} elseif ( $key == 'ip_woocommerce_color_filter' ) {
				foreach ( $tp_widgets as $key => $val ) {
					if (!empty($val['colors'])) {
						$a = array();
						foreach ($val['colors'] as $color_key => $color_val) {
							if ($term = get_term_by('name', $color_key, 'pa_color')) {
								$a[$term->term_id] = $color_val;
							}
						}
						$tp_widgets[$key]['colors'] = $a;
					}
				}
				$widget_data['ip_woocommerce_color_filter'] = $tp_widgets;
			}

		}

		foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
			$widgets[ $widget_data_title ] = array();
			foreach ( $widget_data_value as $widget_data_key => $widget_data_array ) {
				if ( is_int( $widget_data_key ) ) {
					$widgets[ $widget_data_title ][ $widget_data_key ] = 'on';
				}
			}
		}
		unset( $widgets[""] );

		foreach ( $sidebar_data as $title => $sidebar ) {
			$count = count( $sidebar );
			for ( $i = 0; $i < $count; $i ++ ) {
				$widget               = array();
				$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
				$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
				if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
					unset( $sidebar_data[ $title ][ $i ] );
				}
			}
			$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
		}

		foreach ( $widgets as $widget_title => $widget_value ) {
			foreach ( $widget_value as $widget_key => $widget_value ) {
				$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
			}
		}

		$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

		$this->parse_import_data( $sidebar_data );
	}

	function parse_import_data( $import_array, $is_allow_clones = false ) {
		global $wp_registered_sidebars;
		$sidebars_data    = $import_array[0];
		$widget_data      = $import_array[1];
		$current_sidebars = $is_allow_clones ? get_option( 'sidebars_widgets' ) : array();
		$new_widgets      = array();

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

			foreach ( $import_widgets as $import_widget ) :

				if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) :
					$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );

					if ( $is_allow_clones ) {
						$new_widget_name = $this->get_new_widget_name( $title, $index );
						$new_index       = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
						if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
								$new_index ++;
							}
						}
					} else {
						$new_index = $index;
					}

					if ( array_key_exists( $import_sidebar, $current_sidebars ) ) {
						if ( $is_allow_clones || ! is_array( $current_sidebars[ $import_sidebar ] ) || ! in_array( $title . '-' . $new_index, $current_sidebars[ $import_sidebar ] ) ) {
							$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
							if ( array_key_exists( $title, $new_widgets ) ) {
								$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
							} else {
								$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];

								$current_multiwidget = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : '';
								$new_multiwidget     = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
								$multiwidget         = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
								unset( $current_widget_data['_multiwidget'] );
								$current_widget_data['_multiwidget'] = $multiwidget;
								$new_widgets[ $title ]               = $current_widget_data;
							}
						} elseif ( in_array( $title . '-' . $new_index, $current_sidebars[ $import_sidebar ] ) ) {
							$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
						}
					} elseif ( array_key_exists( $import_sidebar, $wp_registered_sidebars ) ) {
						$current_sidebars[ $import_sidebar ] = array( $title . '-' . $new_index );
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
						} else {
							$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];

							$current_multiwidget = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : '';
							$new_multiwidget     = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
							$multiwidget         = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[ $title ]               = $current_widget_data;
						}
					}

				endif;
			endforeach;
		endforeach;

		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );

			foreach ( $new_widgets as $title => $content ) {
				update_option( 'widget_' . $title, $content );
			}

			return true;
		}

		return false;
	}

	function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array();
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index ++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;

		return $new_widget_name;
	}

	function exporter() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! function_exists( 'export_wp' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/export.php' );
		}

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Importer' ) ) {
			include ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}

		include $this->importer_dir . '/wordpress-importer.php';

		if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'export' ) ) {
			$this->import_response( 'error', __( 'Error: Permission denied', 'ideapark-theme-functionality' ) );
		}

		$this->export_path = $this->importer_dir . "/" . $this->demo_content_folder . "/";

		if ( ! $wp_filesystem->is_dir( $this->export_path ) ) {
			if ( ! $wp_filesystem->mkdir( $this->export_path, 0755 ) ) {
				$this->import_response( 'error', __( 'Error: Permission denied', 'ideapark-theme-functionality' ) . ': ' . $this->export_path );
			}
		}

		$this->export_options();
		$this->export_content();
		$this->export_widgets();

		$code    = 'completed';
		$message = '<b style="color:#444">' . __( 'The demo data has been exported successfully!', 'ideapark-theme-functionality' ) . '</b>';

		$this->import_response( $code, $message, 100 );
	}

	private function _get_customize_types() {
		global $ideapark_customize;

		$ideapark_customize_types = array();
		foreach ( $ideapark_customize as $group ) {
			foreach ( $group['controls'] AS $mod_name => $mod ) {
				$ideapark_customize_types[ $mod_name ] = isset( $mod['class'] ) ? $mod['class'] : ( isset( $mod['type'] ) ? $mod['type'] : null );
			}
		}

		return $ideapark_customize_types;
	}

	function export_options() {
		global $wp_filesystem, $ideapark_customize_mods;

		$theme_title_fn = $this->export_path . "theme.txt";

		if ( $wp_filesystem->exists( $theme_title_fn ) ) {
			$wp_filesystem->delete( $theme_title_fn );
		}

		$wp_filesystem->put_contents( $theme_title_fn, get_bloginfo( 'name' ) );

		$image = wp_get_image_editor( get_template_directory() . '/screenshot.png' );
		if ( ! is_wp_error( $image ) ) {
			$image->resize( 300, '' );
			$image->save( $this->export_path . 'theme.png' );
		}

		$ideapark_customize_types = $this->_get_customize_types();

		ideapark_init_theme_mods();
		$options = $ideapark_customize_mods;

		foreach ( $options AS $mod_name => $val ) {
			if ( array_key_exists( $mod_name, $ideapark_customize_types ) && $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Image_Control' ) {
				if ( preg_match( '~^' . preg_quote( home_url(), '~' ) . '~', $val, $match ) ) {
					$options[ $mod_name ] = str_replace( $match[0], '{{site_url}}', $val );
				}
			} elseif ( array_key_exists( $mod_name, $ideapark_customize_types ) && $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Category_Control' ) {
				$options[ $mod_name ] = get_cat_name( $val );
			} elseif ( array_key_exists( $mod_name, $ideapark_customize_types ) && $ideapark_customize_types[ $mod_name ] == 'WP_Customize_Page_Control' ) {
				$options[ $mod_name ] = get_the_title( $val );
			}
		}

		$menu_names = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $menu ) {
			$menu_names[ $menu->term_id ] = $menu->name;
		}

		if ( $menus = get_theme_mod( 'nav_menu_locations' ) ) {
			foreach ( $menus as $menu_slug => $menu_id ) {
				$menus[ $menu_slug ] = $menu_names[ $menu_id ];
			}
			$options['nav_menu_locations'] = $menus;
		}

		$options_fn = $this->export_path . "theme_options.txt";

		if ( $wp_filesystem->exists( $options_fn ) ) {
			$wp_filesystem->delete( $options_fn );
		}

		$wp_filesystem->put_contents( $options_fn, base64_encode( serialize( $options ) ) );

		$options = array();

		foreach ( $this->options_to_export_page_id AS $option_name ) {
			$post                    = get_post( (int) get_option( $option_name ) );
			$options[ $option_name ] = $post->post_title;
		}

		foreach ( $this->options_to_export AS $option_name ) {
			$options[ $option_name ] = get_option( $option_name );
		}

		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$options['wc_get_attribute_taxonomies'] = wc_get_attribute_taxonomies();
		}

		$options_fn = $this->export_path . "options.txt";

		if ( $wp_filesystem->exists( $options_fn ) ) {
			$wp_filesystem->delete( $options_fn );
		}

		$wp_filesystem->put_contents( $options_fn, base64_encode( serialize( $options ) ) );
	}

	function export_content() {
		global $wp_filesystem;

		$args = array( 'content' => 'all' );
		ob_start();
		export_wp( $args );

		$content_fn = $this->export_path . "content.xml";
		if ( $wp_filesystem->exists( $content_fn ) ) {
			$wp_filesystem->delete( $content_fn );
		}
		$wp_filesystem->put_contents( $content_fn, ob_get_clean() );

		if ( ! headers_sent() ) {
			header_remove( 'Content-Description' );
			header_remove( 'Content-Disposition' );
			header_remove( 'Content-Type' );
			header( 'Content-Type:text/html; charset=UTF-8' );
		}
	}

	function export_widgets() {
		global $wp_filesystem;

		$sidebars_array = get_option( 'sidebars_widgets' );
		$sidebar_export = array();
		$posted_array   = array();
		foreach ( $sidebars_array as $sidebar => $widgets ) {
			if ( ! empty( $widgets ) && is_array( $widgets ) ) {
				foreach ( $widgets as $sidebar_widget ) {
					if ( $sidebar != 'wp_inactive_widgets' ) {
						$sidebar_export[ $sidebar ][] = $sidebar_widget;
						$posted_array[]               = $sidebar_widget;
					}
				}
			}
		}
		$widgets = array();
		foreach ( $posted_array as $k ) {
			$widget                = array();
			$widget['type']        = trim( substr( $k, 0, strrpos( $k, '-' ) ) );
			$widget['type-index']  = trim( substr( $k, strrpos( $k, '-' ) + 1 ) );
			$widget['export_flag'] = true;
			$widgets[]             = $widget;
		}

		$menus = wp_get_nav_menus();

		$widgets_array = array();
		foreach ( $widgets as $widget ) {
			$widget_val = get_option( 'widget_' . $widget['type'] );
			$widget_val = apply_filters( 'widget_data_export', $widget_val, $widget['type'] );

			if ( $widget['type'] == 'nav_menu' ) {
				foreach ( $widget_val as $key => $val ) {
					foreach ( $menus as $menu ) {
						if ( $val['nav_menu'] == $menu->term_id ) {
							$widget_val[ $key ]['nav_menu'] = $menu->name;
							break;
						}
					}
				}
			} elseif ( $widget['type'] == 'ip_woocommerce_color_filter' ) {
				foreach ( $widget_val as $key => $val ) {
					if (!empty($val['colors'])) {
						$a = array();
						foreach ($val['colors'] as $color_key => $color_val) {
							if ($term = get_term_by('term_taxonomy_id', $color_key, 'pa_color')) {
								$a[$term->name] = $color_val;
							}
						}
						$widget_val[ $key ]['colors'] = $a;
					}
				}
			}

			$multiwidget_val                                           = $widget_val['_multiwidget'];
			$widgets_array[ $widget['type'] ][ $widget['type-index'] ] = $widget_val[ $widget['type-index'] ];
			if ( isset( $widgets_array[ $widget['type'] ]['_multiwidget'] ) ) {
				unset( $widgets_array[ $widget['type'] ]['_multiwidget'] );
			}
			$widgets_array[ $widget['type'] ]['_multiwidget'] = $multiwidget_val;
		}
		unset( $widgets_array['export'] );
		$export_array = array( $sidebar_export, $widgets_array );

		$options_fn = $this->export_path . "widgets.txt";

		if ( $wp_filesystem->exists( $options_fn ) ) {
			$wp_filesystem->delete( $options_fn );
		}

		$wp_filesystem->put_contents( $options_fn, base64_encode( serialize( $export_array ) ) );
	}
}

class Ideapark_Importer_Base {
	var $message = '';
	var $step_total = 0;
	var $step_done = 0;
	var $error_msg = array();
}