<?php if ( $reviews = get_posts( array( 'posts_per_page' => - 1, 'post_type' => 'review', 'suppress_filters' => false ) ) ) { ?>
	<section id="home-review">
		<div class="container">
			<div class="slick-review preloading">
				<?php foreach ( $reviews as $i => $post ) {
				setup_postdata( $post );
				$review_occupation = get_post_meta( $post->ID, '_ip_review_occupation', true );
				?>
				<div class="review">
					<svg class="quote">
						<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-quote" />
					</svg>
					<?php the_excerpt(); ?>
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="thumb" style="background-image: url(<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
					echo esc_url( $image[0] ); ?>);"></div>
						<?php } ?>
						<div class="author"><?php the_title(); ?></div>
						<?php if ($review_occupation) { ?>
							<div class="occupation">
								<?php echo esc_html( $review_occupation ); ?>
							</div>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
	</section>
<?php } ?>
<?php wp_reset_postdata(); ?>