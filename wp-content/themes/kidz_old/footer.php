<footer id="footer">
	<div class="wrap">
		<div class="container">
			<?php get_sidebar( 'footer' ); ?>
			<div class="row bottom">
				<div class="col-xs-6 col-xs-push-6">
					<div class="soc">
						<?php
						$soc_count = 0;
						$soc_list  = array( 'facebook', 'instagram', 'twitter', 'google-plus', 'youtube', 'vimeo', 'linkedin', 'flickr', 'pinterest', 'tumblr', 'dribbble', 'github' );
						foreach ( $soc_list AS $soc_name ) {
							if ( ideapark_mod( $soc_name ) ): $soc_count ++; ?>
								<a href="<?php echo esc_url( ideapark_mod( $soc_name ) ); ?>" target="_blank">
									<svg>
										<use xlink:href="<?php echo esc_url( ideapark_svg_url() ); ?>#svg-<?php echo esc_attr( $soc_name ); ?>" />
									</svg>
								</a>
							<?php endif;
						} ?>
					</div>
				</div>
				<div class="col-xs-6 col-xs-pull-6 copyright"><?php echo esc_html( ideapark_mod( 'footer_copyright' ) ); ?></div>
			</div>
		</div>
	</div>
</footer>
</div><!-- #wrap -->
<div id="ip-quickview"></div>
<?php wp_footer(); ?>
</body>
</html>
