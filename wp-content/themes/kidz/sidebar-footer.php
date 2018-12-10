<div class="row footer-sidebar">
	<div class="col-md-3 col-sm-6 col-xs-6 first">
		<div class="footer-logo">
			<?php if ( !is_front_page() ): ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php endif ?>
				<?php if ( ideapark_mod( 'logo_footer' ) ) { ?>
					<img src="<?php echo stripslashes( ideapark_mod( 'logo_footer' ) ); ?>" alt="" />
				<?php } elseif ( ideapark_mod( 'logo' ) ) { ?>
					<img src="<?php echo stripslashes( ideapark_mod( 'logo' ) ); ?>" alt="" />
				<?php } else { ?>
					<img src="<?php echo esc_url( get_template_directory_uri() ) ?>/img/logo.svg" class="svg" alt="" />
				<?php } ?>

				<?php if ( !is_front_page() ): ?></a><?php endif ?>
		</div>
		<?php if ( ideapark_mod( 'footer_contacts' ) ) { ?>
			<div class="contacts">
				<?php echo make_clickable( str_replace( ']]>', ']]&gt;', ideapark_mod( 'footer_contacts' ) ) ); ?>
			</div>
		<?php } ?>
	</div>
	<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( ideapark_mod( 'footer_sidebar' ) ? ideapark_mod( 'footer_sidebar' ) : 'footer-sidebar' ) ) {} ?>
</div>