<?php get_header(); ?>
<?php global $post;
$is_fullwidth_header_page = ideapark_woocommerce_on() && (is_cart() || is_checkout() || is_account_page()) || class_exists( 'Ideapark_Wishlist' ) && ideapark_is_wishlist_page();
$has_sidebar = !ideapark_mod( 'post_hide_sidebar' ) && !$is_fullwidth_header_page;
$is_hide_header = ideapark_woocommerce_on() && !is_user_logged_in() && is_account_page();
?>

<?php if ( !$is_hide_header ) { ?>
<header class="main-header">
	<div class="container">
		<div class="row">
			<div class="<?php if ( $is_fullwidth_header_page ) { ?>col-lg-12<?php } else { ?>col-md-9<?php } ?>">
				<?php if ( !is_page() && !ideapark_mod( 'post_hide_category' ) ) { ?>
					<ul class="post-categories">
						<li><?php ideapark_category( '</li><li>' ); ?></li>
					</ul>
				<?php } ?>
				<h1><?php the_title(); ?></h1>
				<?php if ( !is_page() && !ideapark_mod( 'post_hide_date' ) ) { ?>
					<div class="post-meta">
						<?php $comments_count = wp_count_comments( $post->ID ); ?>
						<span class="post-date">
							<?php the_time( get_option( 'date_format' ) ); ?>
						</span>
						<?php if ( $comments_count->total_comments > 0 ) { ?>
							<span class="post-comments-count"><svg><use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-comment" /></svg><?php echo esc_html( $comments_count->total_comments ); ?></span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</header>
<?php } ?>

<div class="container post-container">

	<div class="row">
		<div class="col-md-<?php if ( $has_sidebar ) { ?>9<?php } else { ?>12<?php } ?>">
			<section role="main" class="post-open">
				<?php if ( have_posts() ): ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content' ); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</section>
		</div>
		<?php if ( $has_sidebar ) { ?>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>
	</div>

</div>

<?php get_footer(); ?>











