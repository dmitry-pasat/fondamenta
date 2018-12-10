<?php
/*
 * Template Name: Home Page
 *
 * @package kidz
 */
get_header(); ?>

<?php if ( ideapark_mod( 'home_fullwidth_slider' ) == false ) { ?>
<div class="container">
<?php } ?>

<?php if ( ideapark_mod( 'slider_enable' ) == true ) { ?>
	<?php get_template_part( 'inc/home-slider' ); ?>
<?php } elseif ( ideapark_mod( 'slider_shortcode' ) ) { ?>
	<?php echo do_shortcode( ideapark_mod( 'slider_shortcode' ) ); ?>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_banners' )  ) { ?>
	<?php get_template_part( 'inc/home-banners' ); ?>
<?php } ?>

<?php if ( ideapark_mod( 'home_fullwidth_slider' ) == false ) { ?>
</div>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_tabs' )  ) { ?>
	<?php get_template_part( 'inc/home-tabs' ); ?>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_brands' )  ) { ?>
	<?php get_template_part( 'inc/home-brands' ); ?>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_post' )  ) { ?>
	<?php get_template_part( 'inc/home-posts' ); ?>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_reviews' )  ) { ?>
	<?php get_template_part( 'inc/home-reviews' ); ?>
<?php } ?>

<?php if ( !ideapark_mod( 'home_hide_about' ) && get_the_content() ) { ?>
	<section id="home-text">
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<div class="row">
				<div class="col-lg-12">
					<div class="entry-content">
						<?php the_content(); ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

<?php get_footer(); ?>











