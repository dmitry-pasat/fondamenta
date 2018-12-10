<article id="bottom-post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( has_post_thumbnail() ) { ?>
			<?php
			$attachment_id = get_post_thumbnail_id( $post->ID );
			$image = wp_get_attachment_image_src( $attachment_id, 'ideapark-home-posts' );
			$image_srcset  = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'ideapark-home-posts' ) : false;
			$image_alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
			if ( empty( $image_alt ) ) {
				$image_alt = get_the_title( );
			}
			?>
			<div class="bgimg post-img" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);" <?php if ($image_srcset) { ?>data-bg-srcset="<?php echo esc_attr( $image_srcset ); ?>"<?php } ?>></div>
		<?php } ?>

		<div class="post-content">
			<div class="post-meta">
				<span class="post-date">
					<?php the_time( get_option( 'date_format' ) ); ?>
				</span>
			</div>
			<header class="post-header">
				<a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			</header>
			<span class="more"><?php esc_html_e( 'Read More', 'kidz' ) ?></span>
		</div>
		<a href="<?php echo get_permalink(); ?>" class="whole"></a>
</article>