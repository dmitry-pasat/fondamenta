<?php if ( $posts = get_posts( array( 'posts_per_page' => 4, 'meta_key' => '_thumbnail_id', 'suppress_filters' => false ) ) ) { ?>
	<section id="home-post">
		<div class="container">
			<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><h2><?php esc_html_e('Blog Posts', 'kidz'); ?></h2></a>
			<div class="row">
				<?php foreach ( $posts as $i => $post ) {
					setup_postdata( $post );
					?>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12<?php if ($i == 2) { ?> hidden-sm hidden-xs<?php } ?>">
						<?php get_template_part( 'content', 'bottom'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>
<?php wp_reset_postdata(); ?>