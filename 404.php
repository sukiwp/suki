<?php
/**
 * Error 404 page template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header
 */
get_header();

/**
 * Content
 */
ob_start();

/**
 * Image
 */
$image = suki_get_theme_mod( 'error_404_image' );
if ( intval( $image ) ) {
	$image_width = intval( suki_get_theme_mod( 'error_404_image_width' ) );
	$image_url   = wp_get_attachment_image_src( $image, 'full' )[0];
	?>
	<!-- wp:image {
		"align":"center",
		"id":<?php echo esc_attr( $image ); ?>,
		"width":<?php echo esc_attr( $image_width ); ?>,
		"sizeSlug":"full",
		"linkDestination":"none",
		"className":"error-404__image"
	} --><figure class="wp-block-image aligncenter size-full is-resized error-404__image">
		<img src="<?php echo esc_attr( $image_url ); ?>" alt="" class="wp-image-<?php echo esc_attr( $image ); ?>" width="<?php echo esc_attr( $image_width ); ?>"/>
	</figure><!-- /wp:image -->
	<?php
}

/**
 * Title
 */
$title_text = suki_get_theme_mod( 'error_404_title_text' );
if ( ! empty( $title_text ) ) {
	?>
	<!-- wp:heading {
		"textAlign":"center",
		"level":1,
		"className":"error-404__title suki-title"
	} --><h1 class="has-text-align-center error-404__title suki-title"><?php echo esc_html( $title_text ); ?></h1><!-- /wp:heading -->
	<?php
}

/**
 * Description
 */
$description_text = suki_get_theme_mod( 'error_404_description_text' );
if ( ! empty( $description_text ) ) {
	$paragraphs = explode( "\n\n", $description_text );

	foreach ( $paragraphs as $paragraph ) {
		?>
		<!-- wp:paragraph {
			"align":"center"
		} --><p class="has-text-align-center"><?php echo wp_kses_post( $paragraph ); ?></p><!-- /wp:paragraph -->
		<?php
	}
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
	<!-- wp:buttons {
		"layout":{
			"type":"flex",
			"justifyContent":"center",
			"flexWrap":"wrap"
		}
	} --><div class="wp-block-buttons">
		<!-- wp:button {
			"align":"center"
		} --><div class="wp-block-button aligncenter">
			<a class="wp-block-button__link"><?php echo wp_kses_post( $button_text ); ?></a>
		</div><!-- /wp:button -->
	</div><!-- /wp:buttons -->
	<?php
}

suki_content( ob_get_clean() );

/**
 * Footer
 */
get_footer();
