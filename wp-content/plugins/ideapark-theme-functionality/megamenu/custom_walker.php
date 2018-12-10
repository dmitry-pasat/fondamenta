<?php

/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
class Ideapark_Megamenu_Walker extends Walker_Nav_Menu {
	private $items_counter = 0;
	private $root_count = 0;

	public function walk( $elements, $max_depth ) {
		$this->root_count = $this->get_number_of_root_elements( $elements );
		return call_user_func_array('parent::walk', func_get_args());
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "{$n}{$indent}<ul class=\"sub-menu\">{$n}";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( $depth == 0 ) {
			$this->items_counter ++;

		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( $depth == 0 ) {
			$classes[] = 'items-' . ( $this->root_count > 12 ? 12 : ( $this->root_count < 6 ? 6 : $this->root_count ) );
			if ( ! empty( $item->subheaders ) ) {
				$classes[] = $item->subheaders;
			}

			if ( ideapark_mod( 'header_type' ) == 'header-type-1' && $this->items_counter > 6 ) {
				$classes[] = "hidden";
			}
		}

		foreach ( $classes AS $i => $v ) {
			if ( $classes[ $i ] == 'menu-item' ) {
				unset( $classes[ $i ] );
			}
		}

		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$prepend = '<span>';
		$append  = '</span>';

		if ( $depth == 0 ) {
			$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"/>';

			if ( ! empty( $item->svg_id ) ) {
				$icon = '<svg><use xlink:href="' . esc_url( ideapark_svg_url() ) . '#' . esc_attr( $item->svg_id ) . '" /></svg>';
			} elseif ( ! empty( $item->img_id ) ) {
				$image        = wp_get_attachment_image_src( $item->img_id, 'ideapark-category-thumb', true );
				$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $item->img_id, 'ideapark-category-thumb' ) : false;
				$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $item->img_id, 'ideapark-category-thumb' ) : false;
				$icon         = '<img src="' . esc_url( $image[0] ) . '" alt="' . esc_attr( $item->title ) . '"' . ( $image_srcset ? ' srcset="' . esc_attr( $image_srcset ) . '"' : '' ) . ( $image_sizes ? ' sizes="' . esc_attr( $image_sizes ) . '"' : '' ) . '/>';
			}
		} else {
			$icon = '';
		}

		if ( $depth != 0 ) {
			$append = $prepend = "";
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $icon . $prepend . $title . $append . $args->link_after;
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}