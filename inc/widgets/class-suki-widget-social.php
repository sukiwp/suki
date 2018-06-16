<?php
/**
 * Class to display social media links widget.
 *
 * @package Suki
 */

class Suki_Widget_Social extends WP_Widget {

	public $types;

	function __construct() {
		parent::__construct(
			'suki_widget_social',
			esc_html__( 'Suki: Social Links', 'suki' ),
			array(
				'classname' => 'suki_widget_social',
				'description' => esc_html__( 'Social Media Links', 'suki' ),
				'customize_selective_refresh' => true,
			)
		);

		$this->types = suki_get_social_media_types();
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; // WPCS: XSS OK
		echo ! empty( $title ) ? $args['before_title'] . $title . $args['after_title'] : ''; // WPCS: XSS OK

		$links = array();
		foreach ( $this->types as $id => $type ) {
			if ( empty( $instance[ $id ] ) ) continue;

			$links[] = array(
				'type'   => $id,
				'url'    => ! empty( $instance[ $id ] ) ? $instance[ $id ] : '#',
				'target' => ! empty( $instance['new_tab'] ) ? '_blank' : '_self',
			);
		}

		if ( 0 === count( $links ) ) return;
		?>
		<div class="suki-social-links">
			<?php suki_social_links( $links ); ?>
		</div>

		<?php echo $args['after_widget']; // WPCS: XSS OK
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : esc_html__( 'Connect with Us', 'suki' );
		$new_tab  = isset( $instance['new_tab'] ) ? (bool) $instance['new_tab'] : false; ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'suki' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>">
				<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" type="checkbox" <?php checked( $new_tab ); ?> name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>">
				<?php esc_html_e( 'Open links on new tab', 'suki' ); ?>
			</label>
		</p>

		<?php foreach ( $this->types as $id => $type ) :
			$url = isset( $instance[ $id ] ) ? strip_tags( $instance[ $id ] ) : '';?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>"><?php echo esc_attr( $this->types[ $id ] ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $id ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
			</p>
		<?php endforeach;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['new_tab']  = isset( $new_instance['new_tab'] ) ? (bool) $new_instance['new_tab'] : false;

		foreach ( $this->types as $id => $type ) :

			$instance[ $id ] = strip_tags( $new_instance[ $id ] );

		endforeach;

		return $instance;
	}

}

// register
function register_suki_widget_social() {
	register_widget( 'Suki_Widget_Social' );
}
add_action( 'widgets_init', 'register_suki_widget_social' );