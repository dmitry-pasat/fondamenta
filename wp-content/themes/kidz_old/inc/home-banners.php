<?php if ( $banners = get_posts( array( 'posts_per_page' => 4, 'post_type' => 'banner', 'meta_key' => '_thumbnail_id', 'suppress_filters' => false) ) ) { ?>
	<section id="home-banners"><!--
		<?php foreach ( $banners as $post ) {
		setup_postdata( $post );
		$banner_price       = get_post_meta( $post->ID, '_ip_banner_price', true );
		$banner_button_text = get_post_meta( $post->ID, '_ip_banner_button_text', true );
		$banner_button_link = preg_replace( '~^/~', home_url() . '/', get_post_meta( $post->ID, '_ip_banner_button_link', true ) );
		$banner_alfa        = get_post_meta( $post->ID, '_ip_banner_alfa', true );
		$banner_color       = trim( get_post_meta( $post->ID, '_ip_banner_color', true ) );
		$attachment_id      = get_post_thumbnail_id( $post->ID );
		$image              = wp_get_attachment_image_src( $attachment_id, 'ideapark-home-banners' );
		if ( $banner_alfa ) {
			add_filter( 'max_srcset_image_width', 'ideapark_woocommerce_max_srcset_image_width_360', 10, 2 );
		}
		$image_srcset       = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'ideapark-home-banners' ) : false;
		if ( $banner_alfa ) {
			remove_filter( 'max_srcset_image_width', 'ideapark_woocommerce_max_srcset_image_width_360', 10 );
		}
		$image_sizes        = false;
		$image_alt          = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
		if ( empty( $image_alt ) ) {
			$image_alt = get_the_title();
		}
		if ( ! preg_match( '~^#([ABCDEF0-9]{3}|[ABCDEF0-9]{6})$~i', $banner_color ) ) {
			$banner_color = '#5DACF5';
		}
		?>
			--><div class="banner <?php if ( $banner_alfa ) { ?> alfa-image<?php } else { ?> non-alfa-image<?php } ?>">
			<div class="bg" style="background: <?php echo( $banner_alfa ? esc_attr( $banner_color ) : '#FFF' ); ?>"></div>
			<img class="thumb" src="<?php echo esc_url( $image[0] ); ?>" <?php if ( $image_srcset ) { ?> srcset="<?php echo esc_attr( $image_srcset ); ?>" <?php } ?> <?php if ( $image_sizes ) { ?> sizes="<?php echo esc_attr( $image_sizes ); ?>" <?php } ?> alt="<?php echo esc_attr( $image_alt ); ?>">
			<div class="inner">
				<h3><?php the_title(); ?></h3>
				<?php if ( $banner_price ) { ?>
					<h4 style="color: <?php echo esc_attr( $banner_color ); ?>"><?php echo esc_html( $banner_price ); ?></h4>
				<?php } ?>
			</div>
			<?php if ( $banner_button_link ) { ?>
				<a class="more" href="<?php echo esc_url( $banner_button_link ); ?>" style="background: <?php echo esc_attr( $banner_color ); ?>"><?php echo esc_html( $banner_button_text ); ?></a>
			<?php } ?>
		</div><!--
		<?php } ?>
	--></section>
<?php } ?>
<?php wp_reset_postdata(); ?>