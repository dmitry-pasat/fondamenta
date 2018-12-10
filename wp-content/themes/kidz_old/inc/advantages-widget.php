<?php

class Ideapark_Advantages_Widget extends WP_Widget {

	function __construct() {
		$widget_options = array(
			'classname'   => 'custom-advantages-widget inv',
			'description' => esc_html__( 'A widget that displays an About widget', 'kidz' )
		);

		parent::__construct(
			'ideapark_advantages_widget', esc_html__( 'Custom Advantages', 'kidz' ), $widget_options
		);
	}


	function widget( $args, $instance ) {
		/**
		 * @var string $before_widget
		 * @var string $before_title
		 * @var string $after_title
		 * @var string $after_widget
		 */
		extract( $args );

		$title        = apply_filters( 'widget_title', $instance['title'] );
		$description  = $instance['description'];
		$more         = $instance['more'];
		$image        = ( $instance['image'] ) ? wp_get_attachment_image_src( $instance['image'], 'thumbnail' ) : 0;
		$image_bottom = ( $instance['image_bottom'] ) ? wp_get_attachment_image_src( $instance['image_bottom'], 'full' ) : 0;

		echo $before_widget;
		?>

		<?php if ( $more ) : ?>
			<a class="more" href="<?php echo esc_url( $more ); ?>">
		<?php endif; ?>

		<?php if ( $image ) : ?>
			<div class="img-advantages">
				<img alt="<?php echo esc_html( $title ); ?>" src="<?php echo esc_url( $image[0] ); ?>">
			</div>
		<?php endif; ?>

		<?php
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}
		?>
		<div class="clearfix"></div>

		<?php if ( $description ) : ?>
			<p><?php echo nl2br( wp_kses_post( $description ) ); ?></p>
		<?php endif; ?>

		<?php if ( $image_bottom ) : ?>
			<div class="image-bottom">
				<img src="<?php echo esc_url( $image_bottom[0] ); ?>" alt="<?php echo esc_html( $title ); ?>" />
			</div>
		<?php endif; ?>

		<?php if ( $more ) : ?>
			</a>
		<?php endif; ?>

		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['image']        = strip_tags( $new_instance['image'] );
		$instance['image_bottom'] = strip_tags( $new_instance['image_bottom'] );
		$instance['description']  = $new_instance['description'];
		$instance['more']         = strip_tags( $new_instance['more'] );

		return $instance;
	}


	function form( $instance ) {

		$defaults = array(
			'title'        => '',
			'image'        => 0,
			'image_bottom' => 0,
			'description'  => '',
			'more'         => '',
		);
		wp_enqueue_media();
		wp_enqueue_script( 'wpq-media-manager', get_template_directory_uri() . '/js/wpq.js', array( 'jquery' ), '1.0', true );
		$instance     = wp_parse_args( (array) $instance, $defaults );
		$image        = ( $instance['image'] ) ? wp_get_attachment_image_src( $instance['image'] ) : 0;
		$image_bottom = ( $instance['image_bottom'] ) ? wp_get_attachment_image_src( $instance['image_bottom'] ) : 0;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'kidz' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:96%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Header icon:', 'kidz' ); ?></label><br />
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
			<span class="ideapark-media-manager-target"><?php if ( $image ) { ?>
					<img src="<?php echo esc_url( $image[0] ); ?>" alt="" /><?php } ?></span><br />
			<a class="ideapark-media-manager-link button" data-controller="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
				<?php esc_html_e( 'Choose Image', 'kidz' ); ?>
			</a>
			<a class="ideapark-media-manager-remove button" data-controller="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
				<?php esc_html_e( 'Remove', 'kidz' ); ?>
			</a>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'About me text:', 'kidz' ); ?></label>
			<textarea id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" style="width:95%;" rows="6"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_bottom' ) ); ?>"><?php esc_html_e( 'Bottom image:', 'kidz' ); ?></label><br />
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image_bottom' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image_bottom' ) ); ?>" value="<?php echo esc_attr( $instance['image_bottom'] ); ?>" />
			<span class="ideapark-media-manager-target"><?php if ( $image_bottom ) { ?>
					<img src="<?php echo esc_url( $image_bottom[0] ); ?>" alt="" /><?php } ?></span><br />
			<a class="ideapark-media-manager-link button" data-controller="<?php echo esc_attr( $this->get_field_id( 'image_bottom' ) ); ?>">
				<?php esc_html_e( 'Choose Image', 'kidz' ); ?>
			</a>
			<a class="ideapark-media-manager-remove button" data-controller="<?php echo esc_attr( $this->get_field_id( 'image_bottom' ) ); ?>">
				<?php esc_html_e( 'Remove', 'kidz' ); ?>
			</a>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more' ) ); ?>"><?php esc_html_e( 'URL (Read More):', 'kidz' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more' ) ); ?>" value="<?php echo esc_attr( $instance['more'] ); ?>" style="width:96%;" />
		</p>
		<?php
	}
}

register_widget( 'Ideapark_Advantages_Widget' );