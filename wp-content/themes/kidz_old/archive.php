<?php get_header();
if ( is_category() ) {
	$page_title = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$page_title = single_tag_title( '', false );
} elseif ( is_author() ) {
	the_post();
	$page_title = get_the_author();
	rewind_posts();
} elseif ( is_day() ) {
	$page_title = get_the_date();
} elseif ( is_month() ) {
	$page_title = get_the_date( 'F Y' );
} elseif ( is_year() ) {
	$page_title = get_the_date( 'Y' );
} else {
	$page_title = esc_html__( 'Archives', 'kidz' );
} ?>

<header class="main-header">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<h1><?php echo esc_html( $page_title ); ?></h1>
			</div>
		</div>
	</div>
</header>

<div class="container blog-container archive<?php if ( ideapark_mod( 'post_hide_sidebar' ) ) { ?> hide-sidebar<?php } ?>">
	<div class="row">
		<?php if ( ideapark_mod( 'post_hide_sidebar' ) ) { ?>
		<div class="col-md-12">
			<?php } else { ?>
			<div class="main-col col-md-9">
				<?php } ?>
				<section role="main">
					<?php if ( have_posts() ): ?>
						<div class="grid masonry">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'list' ); ?>
							<?php endwhile; ?>
							<div class="post-sizer"></div>
						</div>
						<div class="clearfix"></div>
						<?php ideapark_corenavi();
					else : ?>
						<p class="nothing"><?php esc_html_e( 'Sorry, no posts were found.', 'kidz' ); ?></p>
					<?php endif; ?>
				</section>
			</div>
			<?php if ( !ideapark_mod( 'post_hide_sidebar' ) ) { ?>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
			<?php } ?>
		</div>
	</div>


	<?php get_footer(); ?>
   