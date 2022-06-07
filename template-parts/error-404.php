<?php
/**
 * Error 404 content template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="error-404 has-text-align-center suki-container">
	<?php
	/**
	 * Image
	 */
	$image = suki_get_theme_mod( 'error_404_image' );
	if ( boolval( $image ) ) {
		$image_width = suki_get_theme_mod( 'error_404_image_width' );
		$image_url   = wp_get_attachment_image_src( $image, 'full' );
		?>
		<div class="error-404-image">
			<?php echo wp_get_attachment_image( $image, 'full' ); ?>
		</div>
		<?php
	}

	/**
	 * Title
	 */
	$title_text = suki_get_theme_mod( 'error_404_title_text' );
	if ( ! empty( $title_text ) ) {
		?>
		<h1 class="error-404-title suki-title"><?php echo wp_kses_post( $title_text ); ?></h1>
		<?php
	}

	/**
	 * Description
	 */
	$description_text = suki_get_theme_mod( 'error_404_description_text' );
	if ( ! empty( $description_text ) ) {
		echo wp_kses_post( wpautop( $description_text ) );
	}

	/**
	 * Search form
	 */
	if ( boolval( suki_get_theme_mod( 'error_404_search_bar' ) ) ) {
		get_search_form();
	}

	/**
	 * Home button
	 */
	$button_text = suki_get_theme_mod( 'error_404_home_button_text' );
	if ( boolval( suki_get_theme_mod( 'error_404_home_button' ) ) && ! empty( $button_text ) ) {
		?>
		<a href="<?php echo esc_url( home_url() ); ?>" class="error-404-home-button button"><?php echo wp_kses_post( $button_text ); ?></a>
		<?php
	}
	?>
</div>
