<?php $post_per_page = ideapark_mod( 'slider_items' ); ?>
<?php if ( ideapark_mod( 'slider_enable' ) && $post_per_page && ( $sliders = get_posts( array( 'posts_per_page' => $post_per_page, 'post_type' => 'slider', 'meta_key' => '_thumbnail_id', 'suppress_filters' => false ) ) ) ) { ?>
	<section id="home-slider">

		<?php $post = $sliders[0]; setup_postdata( $post ); ?>
		<?php
		$attachment_id = get_post_thumbnail_id( $post->ID );
		$image = wp_get_attachment_image_src( $attachment_id, 'medium' );
		?>
		<div class="slick-preloader" >
			<div class="img" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);"></div>
			<span class="ip-shop-loop-loading"><i></i><i></i><i></i></span>
		</div>

		<div class="slick preloading">
			<?php foreach ( $sliders as $post ) {
				setup_postdata( $post );
				$slide_subheader = get_post_meta( $post->ID, '_ip_slider_subheader', true );
				$slide_link      = get_post_meta( $post->ID, '_ip_slider_link', true );
				$slide_luminance = get_post_meta( $post->ID, '_ip_slider_luminance', true );
				$attachment_id = get_post_thumbnail_id( $post->ID );
				$image = wp_get_attachment_image_src( $attachment_id, 'large' );
				$image_srcset  = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'large' ) : false;
				if (!empty($image[0])) { ?>
					<div class="bgimg <?php if ( $slide_luminance < 127 ) { ?>dark-image<?php } ?>" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);" <?php if ($image_srcset) { ?>data-bg-srcset="<?php echo esc_attr( $image_srcset ); ?>"<?php } ?>>
						<div class="inner">
							<h3><?php the_title(); ?></h3>
							<?php if ( $slide_subheader ) { ?>
								<h4><?php echo esc_html( $slide_subheader ); ?></h4>
							<?php } ?>
						</div>
						<?php if ( $slide_link ) { ?>
							<a class="whole" href="<?php echo esc_url( $slide_link ); ?>"></a>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</section>
<?php } ?>
<?php wp_reset_postdata(); ?>