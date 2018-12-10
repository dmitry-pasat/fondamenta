<?php $description = get_the_author_meta( 'description' ); ?>

<?php if ( $description ) { ?>
	<div class="post-author clearfix">

		<div class="author-img">
			<?php echo get_avatar( get_the_author_meta( 'email' ) ); ?>
		</div>

		<div class="author-content">
			<h5><?php the_author_posts_link(); ?></h5>

			<p><?php echo $description; ?></p>

			<?php
			global $ideapark_customize;
			$is_founded = false;

			if ( ! empty( $ideapark_customize ) ) {
				?>
				<div class="soc">
					<?php
					foreach ( $ideapark_customize AS $section ) {
						if ( ! empty( $section['controls'] ) && array_key_exists( 'facebook', $section['controls'] ) ) {
							foreach ( $section['controls'] AS $control_name => $control ) { ?>
								<?php if ( get_the_author_meta( $control_name ) ) { ?>
									<a target="_blank" href="<?php echo esc_url( get_the_author_meta( $control_name ) ); ?>">
										<svg>
											<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-<?php echo esc_attr( $control_name ); ?>" />
										</svg>
									</a>
								<?php } ?>
							<?php }
							$is_founded = true;
						}
					}
					?>
				</div>
			<?php } ?>

		</div>

	</div>
<?php } ?>