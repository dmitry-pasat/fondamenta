<?php if ( ideapark_woocommerce_on() ) { ?>
	<?php
	$tabs = array();

	if ( ideapark_mod( 'home_featured_order' ) > 0 ) {
		$tabs['featured_products'] = ideapark_mod( 'home_featured_order' );
	}

	if ( ideapark_mod( 'home_sale_order' ) > 0 ) {
		$tabs['sale_products'] = ideapark_mod( 'home_sale_order' );
	}

	if ( ideapark_mod( 'home_best_selling_order' ) > 0 ) {
		$tabs['best_selling_products'] = ideapark_mod( 'home_best_selling_order' );
	}

	if ( ideapark_mod( 'home_recent_order' ) > 0 ) {
		$tabs['recent_products'] = ideapark_mod( 'home_recent_order' );
	}
	?>
	<?php if ( !empty( $tabs ) && ideapark_mod( 'home_tab_products' ) > 0 ) { ?>
		<?php asort( $tabs );
		$is_first = true; ?>
		<div class="container">
			<div class="home-tabs-wrap">
				<ul class="home-tabs clear">
					<?php foreach ( $tabs as $tab => $sort ) { ?>
						<li<?php if ( $is_first ) { ?> class="current"<?php } ?>>
							<a href="#tab-<?php echo esc_attr( $tab ); ?>">
								<?php switch ( $tab ) {
									case 'featured_products':
										esc_html_e( 'Featured', 'kidz' );
										break;
									case 'sale_products':
										esc_html_e( 'On a Sale', 'kidz' );
										break;
									case 'best_selling_products':
										esc_html_e( 'Bestsellers', 'kidz' );
										break;
									case 'recent_products':
										esc_html_e( 'Latest', 'kidz' );
										break;
								} ?>
							</a>
						</li>
						<?php $is_first = false; ?>
					<?php } ?>
				</ul>
			</div>
			<?php wc_print_notices(); ?>
			<?php $is_first = true; ?>
			<?php foreach ( $tabs as $tab => $sort ) { ?>
				<div id="tab-<?php echo esc_attr( $tab ); ?>" class="home-tab<?php if ( $is_first ) { ?> visible current<?php } ?>">
					<?php
					$html_code = do_shortcode( '[' . $tab . ' per_page="' . ideapark_mod( 'home_tab_products' ) . '" columns="4"]' );
					if ( !$is_first ) {
						$html_code = preg_replace( '~src(set)?\s*=\s*"~i', 'data-\\0', $html_code );
					}
					?>
					<?php echo $html_code; ?>
				</div>
				<?php $is_first = false; ?>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>