<?php if ( $brands = get_posts( array( 'posts_per_page' => - 1, 'post_type' => 'brand', 'meta_key' => '_thumbnail_id', 'suppress_filters' => false ) ) ) { ?>
	<section id="home-brand" <?php echo (ideapark_mod( 'home_brands_white_bg' ) ? ' class="white-bg"' : ''); ?>>
		<div class="container">
			<div class="slick-brands preloading">
				<?php foreach ( $brands as $post ) {
					setup_postdata( $post );
					$brand_link = get_post_meta( $post->ID, '_ip_brand_link', true );
					$attachment_id = get_post_thumbnail_id( $post->ID );
					$image = wp_get_attachment_image_src( $attachment_id, 'ideapark-home-brands' );
					$image_srcset  = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'ideapark-home-brands' ) : false;
					$image_alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
					if ( empty( $image_alt ) ) {
						$image_alt = get_the_title( );
					}
					?>
					<div class="bgimg brand" title="<?php echo esc_attr( $image_alt ); ?>" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);" <?php if ($image_srcset) { ?>data-bg-srcset="<?php echo esc_attr( $image_srcset ); ?>"<?php } ?>>
					<?php if ( $brand_link ) { ?>
						<a class="whole" href="<?php echo esc_url( $brand_link ); ?>" title="<?php echo esc_attr( $image_alt ); ?>"></a>
					<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>
<?php wp_reset_postdata(); ?>