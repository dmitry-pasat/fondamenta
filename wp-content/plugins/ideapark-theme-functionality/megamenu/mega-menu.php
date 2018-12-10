<?php

class Ideaperk_Mega_Menu {

	public $assets_url;
	public $script_suffix;
	public $_version;
	public $_token;
	private $icon_ids = array();

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	function __construct( $file = '' , $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token   = 'ideapark_mega_menu';

		$this->assets_url    = esc_url( trailingslashit( plugins_url( '/assets/', $file ) ) );
		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		add_action( 'wp_loaded', array( $this, 'init' ), 100 );

	} // end constructor

	public function init(  ) {

		ideapark_init_theme_mods();

		if (ideapark_mod('mega_menu')) {

			$filename = get_template_directory() . '/img/sprite.svg';

			if ( is_file( $filename ) ) {
				$t_xml = new DOMDocument();
				$t_xml->load( $filename );
				$symbols = $t_xml->getElementsByTagName( 'symbol' );
				foreach ( $symbols as $symbol ) {
					if ( preg_match( '~^svg-icon-\d+$~', $symbol->getAttribute( 'id' ) ) ) {
						$this->icon_ids[] = $symbol->getAttribute( 'id' );
					}
				}
			}

			// add custom menu fields to menu
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_nav_fields' ) );

			// save menu custom fields
			add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields' ), 10, 3 );

			// edit menu walker
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), 10, 2 );

			// scripts & styles
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

			add_action( 'wp_ajax_ideapark_load_mega_menu', array( $this, 'select_icon' ) );
		}

	}

	public function select_icon(  ) {

		if ( isset( $_POST['item_id'] ) && ($item_id = (int) $_POST['item_id'] ) && ( isset( $_POST['img_id'] ) && ($img_id = (int)$_POST['img_id']) || isset( $_POST['svg_id'] ) && ( empty($_POST['svg_id']) || ($svg_id = trim($_POST['svg_id'])) && in_array( $svg_id, $this->icon_ids) ) ) ) {
			if ( empty($svg_id) ) {
				$svg_id = '';
			}
			if ( empty($img_id) ) {
				$img_id = 0;
			}
			?>

			<label><?php esc_html_e( 'SVG Icon', 'ideapark-theme-functionality' ); ?></label>
			<input type="hidden" name="menu-item-svg-id[<?php echo $item_id; ?>]" value="">
			<ul>
				<?php foreach ( $this->icon_ids as $icon_id ) { ?>
					<li>
						<label>
							<input type="radio" name="menu-item-svg-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $icon_id ); ?>" <?php checked( $icon_id, $svg_id ); ?>>
								<svg>
									<use xlink:href="#<?php echo esc_attr( $icon_id ); ?>" />
								</svg>
							<i></i>
						</label>
					</li>
				<?php } ?>
				<li class="custom" id="menu-item-custom-<?php echo $item_id; ?>">
					<label>
						<input type="radio" class="menu-item-custom" data-item-id="<?php echo $item_id; ?>"  name="menu-item-svg-id[<?php echo $item_id; ?>]" value="custom<?php if ( !empty($img_id) ) { ?>-<?php echo $img_id; ?><?php } ?>" <?php if ( !empty($img_id) ) { ?>checked<?php } ?>>
						<span class="text"><?php esc_html_e('Custom image', 'ideapark-theme-functionality'); ?></span>
						<span class="img">
							<?php if ( !empty($img_id) && ($image = wp_get_attachment_image_src($img_id) ) ) { ?>
								<img src="<?php echo esc_url($image[0]); ?>">
							<?php } ?>
						</span>
						<i></i>
					</label>
				</li>
			</ul>
			<a class="clear<?php if (!empty($svg_id) || !empty($img_id)) { ?> show<?php } ?>" href="#">
				<svg>
					<use xlink:href="#svg-close" />
				</svg>
				<?php esc_html_e('clear icon', 'ideapark-theme-functionality'); ?>
			</a>

			<?php
		}

		wp_die();

	}

	public function scripts( $hook ) {
		if ( 'nav-menus.php' != $hook ) {
			return;
		}

		wp_register_style( $this->_token . '-megamenu', esc_url( $this->assets_url ) . 'css/mega-menu.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-megamenu' );

		wp_enqueue_media();
		wp_register_script( $this->_token . '-megamenu', esc_url( $this->assets_url ) . 'js/mega-menu' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_token . '-megamenu' );
		wp_localize_script( $this->_token . '-megamenu', 'ideapark_wp_vars_mega_menu', array(
			'themeUri' => get_template_directory_uri(),
			'chose_image_text' => esc_html__( "Choose an image", 'ideapark-theme-functionality' ),
			'use_image_text' => esc_html__( "Use image", 'ideapark-theme-functionality' ),
			'select_icon_text' => esc_html__('Select Icon', 'ideapark-theme-functionality')
		) );
	}

	function add_custom_nav_fields( $menu_item ) {

		$menu_item->svg_id = get_post_meta( $menu_item->ID, '_menu_item_svg_id', true );
		$menu_item->img_id = get_post_meta( $menu_item->ID, '_menu_item_img_id', true );
		$menu_item->subheaders = get_post_meta( $menu_item->ID, '_menu_item_subheaders', true );

		return $menu_item;

	}

	function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

		if ( isset($_POST['menu-item-svg-id']) && is_array( $_POST['menu-item-svg-id'] ) && array_key_exists($menu_item_db_id, $_POST['menu-item-svg-id']) ) {
			$svg_id = $_POST['menu-item-svg-id'][ $menu_item_db_id ];
			if ( empty($svg_id ) || in_array($svg_id, $this->icon_ids) || preg_match('~^custom-(\d+)$~', $svg_id, $match) ) {
				if (!empty($match[1])) {
					update_post_meta( $menu_item_db_id, '_menu_item_img_id', (int)$match[1] );
					delete_post_meta( $menu_item_db_id, '_menu_item_svg_id' );
				} else {
					update_post_meta( $menu_item_db_id, '_menu_item_svg_id', $svg_id );
					delete_post_meta( $menu_item_db_id, '_menu_item_img_id' );
				}
			}
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_svg_id' );
			delete_post_meta( $menu_item_db_id, '_menu_item_img_id' );
		}

		if ( isset($_POST['menu-item-subheaders']) && is_array( $_POST['menu-item-subheaders'] ) && array_key_exists($menu_item_db_id, $_POST['menu-item-subheaders']) ) {
			update_post_meta( $menu_item_db_id, '_menu_item_subheaders', $_POST['menu-item-subheaders'][ $menu_item_db_id ] );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_subheaders' );
		}
	}

	function edit_walker( $walker, $menu_id ) {

		return 'Walker_Nav_Menu_Edit_Ideapark';

	}

}
