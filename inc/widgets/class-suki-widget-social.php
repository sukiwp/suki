<?php
/**
 * Custom Social Links Widget
 *
 * @package Suki
 */

class Suki_Widget_Social extends WP_Widget {

	function __construct() {
		parent::__construct(
			'suki_widget_social',
			/* translators: %s: theme name. */
			sprintf( esc_html__( '%s - Social Links', 'suki' ), suki_get_theme_info( 'name' ) ),
			array(
				'classname' => 'suki_widget_social',
				// 'description' => esc_html__( 'Social links', 'suki' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title     = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) : '';
		$alignment = isset( $instance['alignment'] ) ? sanitize_key( $instance['alignment'] ) : 'post_date';
		$links     = isset( $instance['links'] ) ? $instance['links'] : $category_default;
		$new_tab   = isset( $instance['new_tab'] ) ? (bool) $instance['new_tab'] : false;

		$social_args = array();
		foreach ( $links as $type ) {
			$url = suki_get_theme_mod( 'social_' . $type );

			$social_args[] = array(
				'type'   => $type,
				'url'    => ! empty( $url ) ? $url : '#',
				'target' => $new_tab ? '_blank' : '',
			);
		}

		ob_start();

		echo $args['before_widget']; // WPCS: XSS OK
		echo ! empty( $title ) ? $args['before_title'] . $title . $args['after_title'] : ''; // WPCS: XSS OK

		?>
		<div class="suki-widget-social <?php echo esc_attr( 'suki-text-align-' . $alignment ); ?>">
			<?php suki_social_links( $social_args ); ?>
		</div>
		<?php

		echo $args['after_widget']; // WPCS: XSS OK

		ob_end_flush();
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
		$alignment = isset( $instance['alignment'] ) ? sanitize_key( $instance['alignment'] ) : 'center';
		$links     = isset( $instance['links'] ) ? $instance['links'] : array( 'facebook', 'twitter', 'instagram' );
		$new_tab   = isset( $instance['new_tab'] ) ? (bool) $instance['new_tab'] : false;

		$alignment_choices = array(
			'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
			'center' => esc_html__( 'Center', 'suki' ),
			'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
		);

		$social_choices = suki_get_social_media_types();
		$social_keys = array_keys( $social_choices );
		sort( $social_keys );

		if ( ! empty( $links ) ) {
			$social_keys = array_merge( $links, array_diff( $social_keys, $links ) );
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Social links to display:', 'suki' ); ?></label>
			<ul id="<?php echo esc_attr( $this->get_field_id( 'links' ) ); ?>" class="suki-widget-social-links-select">
				<?php foreach ( $social_keys as $social_key ) : ?>
					<li>
						<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'links--' . $social_key ) ); ?>" type="checkbox" <?php checked( in_array( $social_key, $links ) ); ?> name="<?php echo esc_attr( $this->get_field_name( 'links' ) ); ?>[]" value="<?php echo esc_attr( $social_key ); ?>">
						<div>
							<?php echo esc_html( $social_choices[ $social_key ] ); ?>
							<span class="dashicons dashicons-menu"></span>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>">
				<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" type="checkbox" <?php checked( $new_tab ); ?> name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>">
				<?php esc_html_e( 'Open links in new tab', 'suki' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>"><?php esc_html_e( 'Alignment', 'suki' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alignment' ) ); ?>">
				<?php foreach ( $alignment_choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $alignment, $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<script type="text/javascript">
			(function( $ ) {
				'use strict';

				$( '#<?php echo esc_attr( $this->get_field_id( 'links' ) ); ?>' ).sortable();
			})( jQuery );
		</script>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;

		$instance['title']     = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['alignment'] = isset( $new_instance['alignment'] ) ? sanitize_key( $new_instance['alignment'] ) : 'center';
		$instance['links']     = isset( $new_instance['links'] ) ? $new_instance['links'] : array();
		$instance['new_tab']   = isset( $new_instance['new_tab'] ) ? (bool) $new_instance['new_tab'] : false;

		return $instance;
	}
}

register_widget( 'Suki_Widget_Social' );