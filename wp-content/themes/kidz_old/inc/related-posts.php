<?php

if ( $categories = get_the_category( $post->ID ) ) {

	$category_ids = array();

	foreach ( $categories as $individual_category ) {
		$category_ids[] = $individual_category->term_id;
	}

	$args = array(
		'category__in'        => $category_ids,
		'post__not_in'        => array( $post->ID ),
		'meta_key'            => '_thumbnail_id',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand',
		'suppress_filters' => false
	);

	if ( $related_posts = get_posts( $args ) ) { ?>
		<section class="post-related">
			<h4><?php esc_html_e( 'You Might Also Like', 'kidz' ); ?></h4>

			<div class="row">
				<?php foreach ( $related_posts AS $post ) {
					setup_postdata( $post ); ?>
					<div class="col-sm-4">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) { ?>
								<div class="post-img">
									<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail( 'ideapark-related-thumb' ); ?></a>
								</div>
							<?php } ?>
							<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>

							<div class="post-meta post-date">
								<?php the_time( get_option( 'date_format' ) ); ?>
							</div>
						</article>
					</div>
				<?php }; ?>
			</div>
		</section>
	<?php }
	wp_reset_postdata();
}

