<?php get_header(); ?>

<?php if ( get_option( 'page_for_posts' ) ) { ?>
	<header class="main-header">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h1><?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ); ?></h1>
				</div>
			</div>
		</div>
	</header>
<?php } ?>

<div class="container blog-container archive<?php if ( ideapark_mod( 'post_hide_sidebar' ) ) { ?> hide-sidebar<?php } ?>">
	<div class="row">
		<?php if (ideapark_mod( 'post_hide_sidebar' )) { ?>
			<div class="main-col col-md-12">
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
   