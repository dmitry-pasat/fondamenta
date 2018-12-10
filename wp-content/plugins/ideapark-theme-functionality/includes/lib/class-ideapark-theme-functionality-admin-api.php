<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Ideapark_Theme_Functionality_Admin_API {

	/**
	 * Constructor function
	 */
	public function __construct() {
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 1 );
		add_action( 'save_post', array( $this, 'save_thumb_tone' ), 11, 1 );
	}

	/**
	 * Generate HTML for displaying fields
	 *
	 * @param  array   $field Field data
	 * @param  boolean $echo  Whether to echo the field HTML or return it
	 *
	 * @return void
	 */
	public function display_field( $data = array(), $post = false, $echo = true ) {

		// Get field info
		if ( isset( $data['field'] ) ) {
			$field = $data['field'];
		} else {
			$field = $data;
		}

		// Check for prefix on option name
		$option_name = '';
		if ( isset( $data['prefix'] ) ) {
			$option_name = $data['prefix'];
		}

		// Get saved data
		$data = '';
		if ( $post ) {

			// Get saved field data
			$option_name .= $field['id'];
			$option = get_post_meta( $post->ID, $field['id'], true );

			// Get data to display in field
			if ( isset( $option ) && $option != '' ) {
				$data = $option;
			} else {
				if ( isset( $field['default'] ) ) {
					$data = $field['default'];
				} else {
					$data = '';
				}
			}

		} else {

			// Get saved option
			$option_name .= $field['id'];
			$option = get_option( $option_name );

			// Get data to display in field
			if ( isset( $option ) && $option != '' ) {
				$data = $option;
			} else {
				if ( isset( $field['default'] ) ) {
					$data = $field['default'];
				} else {
					$data = '';
				}
			}

		}

		// Show default data if no option saved and default is supplied
		if ( $data === false && isset( $field['default'] ) ) {
			$data = $field['default'];
		} elseif ( $data === false ) {
			$data = '';
		}

		$html = '';

		switch ( $field['type'] ) {

			case 'text':
			case 'url':
			case 'email':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . ( isset( $field['placeholder'] ) ? '" placeholder="' . esc_attr( $field['placeholder'] ) : '' ) . '" value="' . esc_attr( $data ) . '" />' . "\n";
				break;

			case 'password':
			case 'number':
			case 'hidden':
				$min = '';
				if ( isset( $field['min'] ) ) {
					$min = ' min="' . esc_attr( $field['min'] ) . '"';
				}

				$max = '';
				if ( isset( $field['max'] ) ) {
					$max = ' max="' . esc_attr( $field['max'] ) . '"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . ( isset( $field['placeholder'] ) ? '" placeholder="' . esc_attr( $field['placeholder'] ) : '' ) . '" value="' . esc_attr( $data ) . '"' . $min . '' . $max . '/>' . "\n";
				break;

			case 'text_secret':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . ( isset( $field['placeholder'] ) ? '" placeholder="' . esc_attr( $field['placeholder'] ) : '' ) . '" value="" />' . "\n";
				break;

			case 'textarea':
				$html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . ( isset( $field['placeholder'] ) ? '" placeholder="' . esc_attr( $field['placeholder'] ) : '' ) . '">' . $data . '</textarea><br/>' . "\n";
				break;

			case 'checkbox':
				$checked = '';
				if ( $data && 'on' == $data ) {
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
				break;

			case 'checkbox_multi':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( in_array( $k, $data ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '" class="checkbox_multi"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'radio':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( $k == $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
				break;

			case 'select_multi':
				$html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( in_array( $k, $data ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
				break;

			case 'image':
				$image_thumb = '';
				if ( $data ) {
					$image_thumb = wp_get_attachment_thumb_url( $data );
				}
				$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
				$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __( 'Upload an image', 'ideapark-theme-functionality' ) . '" data-uploader_button_text="' . __( 'Use image', 'ideapark-theme-functionality' ) . '" class="image_upload_button button" value="' . __( 'Upload new image', 'ideapark-theme-functionality' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="' . __( 'Remove image', 'ideapark-theme-functionality' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
				break;

			case 'color':
				$html .= '<div class="color-picker" style="position:relative;">';
				$html .= '<input type="text" name="' . esc_attr( $option_name ) . '" class="color" value="' . esc_attr( $data ) . '" />';
				$html .= '<div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>';
				$html .= '</div>';
				break;

		}

		switch ( $field['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $field['description'] . '</span>';
				break;

			default:
				if ( !$post ) {
					$html .= '<label for="' . esc_attr( $field['id'] ) . '">' . "\n";
				}

				if ( isset( $field['description'] ) ) {
					$html .= '<span class="description">' . $field['description'] . '</span>' . "\n";
				}

				if ( !$post ) {
					$html .= '</label>' . "\n";
				}
				break;
		}

		if ( !$echo ) {
			return $html;
		}

		echo $html;

	}

	/**
	 * Validate form field
	 *
	 * @param  string $data Submitted value
	 * @param  string $type Type of field to validate
	 *
	 * @return string       Validated value
	 */
	public function validate_field( $data = '', $type = 'text' ) {

		switch ( $type ) {
			case 'text':
				$data = esc_attr( $data );
				break;
			case 'url':
				$data = esc_url( $data );
				break;
			case 'email':
				$data = is_email( $data );
				break;
		}

		return $data;
	}

	/**
	 * Add meta box to the dashboard
	 *
	 * @param string $id            Unique ID for metabox
	 * @param string $title         Display title of metabox
	 * @param array  $post_types    Post types to which this metabox applies
	 * @param string $context       Context in which to display this metabox ('advanced' or 'side')
	 * @param string $priority      Priority of this metabox ('default', 'low' or 'high')
	 * @param array  $callback_args Any axtra arguments that will be passed to the display function for this metabox
	 *
	 * @return void
	 */
	public function add_meta_box( $id = '', $title = '', $post_types = array(), $context = 'advanced', $priority = 'default', $callback_args = null ) {

		// Get post type(s)
		if ( !is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}

		// Generate each metabox
		foreach ( $post_types as $post_type ) {
			add_meta_box( $id, $title, array( $this, 'meta_box_content' ), $post_type, $context, $priority, $callback_args );
		}
	}

	/**
	 * Display metabox content
	 *
	 * @param  object $post Post object
	 * @param  array  $args Arguments unique to this metabox
	 *
	 * @return void
	 */
	public function meta_box_content( $post, $args ) {

		$fields = apply_filters( $post->post_type . '_custom_fields', array(), $post->post_type );

		if ( !is_array( $fields ) || 0 == count( $fields ) ) {
			return;
		}

		echo '<div class="ideapark-custom-field-panel">' . "\n";

		foreach ( $fields as $field ) {

			if ( !isset( $field['metabox'] ) ) {
				continue;
			}

			if ( !is_array( $field['metabox'] ) ) {
				$field['metabox'] = array( $field['metabox'] );
			}

			if ( in_array( $args['id'], $field['metabox'] ) ) {
				$this->display_meta_box_field( $field, $post );
			}

		}

		echo '</div>' . "\n";

	}

	/**
	 * Dispay field in metabox
	 *
	 * @param  array  $field Field data
	 * @param  object $post  Post object
	 *
	 * @return void
	 */
	public function display_meta_box_field( $field = array(), $post ) {

		if ( !is_array( $field ) || 0 == count( $field ) ) {
			return;
		}

		$field = '<div class="form-field"><label for="' . $field['id'] . '">' . $field['label'] . '</label>' . $this->display_field( $field, $post, false ) . '</div>' . "\n";

		echo $field;
	}

	/**
	 * Save metabox fields
	 *
	 * @param  integer $post_id Post ID
	 *
	 * @return void
	 */
	public function save_meta_boxes( $post_id = 0 ) {

		if ( !$post_id ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		$fields = apply_filters( $post_type . '_custom_fields', array(), $post_type );

		if ( !is_array( $fields ) || 0 == count( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			if ( isset( $_REQUEST[$field['id']] ) ) {
				update_post_meta( $post_id, $field['id'], $this->validate_field( $_REQUEST[$field['id']], $field['type'] ) );
			} else {
				update_post_meta( $post_id, $field['id'], '' );
			}
		}
	}

	public function save_thumb_tone( $post_id = 0 ) {

		if ( !$post_id ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( ( get_post_type( $post_id ) == 'slider' ) && ( $post_thumbnail_id = get_post_thumbnail_id( $post_id ) ) ) {
			$luminance = - 1;
			if ( preg_match( '!image!', get_post_mime_type( $post_thumbnail_id ) ) ) {
				$image = new Ideapark_Slider_Image_Editor( get_attached_file( $post_thumbnail_id ) );
				if ( $image->load() ) {
					$luminance = $image->get_luminance();
				}
			}
			update_post_meta( $post_id, '_ip_slider_luminance', $luminance );
		}

		if ( ( get_post_type( $post_id ) == 'banner' ) && ( $post_thumbnail_id = get_post_thumbnail_id( $post_id ) ) ) {
			$has_alfa = '';
			if ( get_post_mime_type( $post_thumbnail_id ) == 'image/png' ) {
				$image = new Ideapark_Slider_Image_Editor( get_attached_file( $post_thumbnail_id ) );
				if ( $image->load() ) {
					$has_alfa = $image->has_alfa();
				}
			}
			update_post_meta( $post_id, '_ip_banner_alfa', $has_alfa );
		}
	}

}

require_once( ABSPATH . 'wp-includes/class-wp-image-editor.php' );
require_once( ABSPATH . 'wp-includes/class-wp-image-editor-gd.php' );

class Ideapark_Slider_Image_Editor extends WP_Image_Editor_GD {
	public function get_luminance() {
		if ( $this->image ) {
			$picker_x = round( imagesx( $this->image ) * 0.15 );
			$picker_y = round( imagesy( $this->image ) * 0.4 );
			$rgba     = imagecolorat( $this->image, $picker_x, $picker_y );
			$alpha    = ( $rgba & 0x7F000000 ) >> 24;
			$red      = ( $rgba & 0xFF0000 ) >> 16;
			$green    = ( $rgba & 0x00FF00 ) >> 8;
			$blue     = ( $rgba & 0x0000FF );
			$y        = round( ( 0.2126 * $red + 0.7152 * $green + 0.0722 * $blue ) * ( 127 - $alpha ) / 127 );

			return $y;
		}

		return false;
	}

	public function has_alfa() {
		if ( $this->image ) {

			if ( imagecolortransparent ( $this->image ) != -1 ) {
				return true;
			}
			$rgba  = imagecolorat( $this->image, 0, 0 );
			$alpha = ( $rgba & 0x7F000000 ) >> 24;

			return $alpha > 0;
		}

		return false;
	}
}

