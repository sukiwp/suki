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
 * Canvas
 */

// Build content.
ob_start();

$padding = suki_get_theme_mod( 'content_padding' );

$styles = array(
	'padding-top'    => $padding[0],
	'padding-right'  => $padding[1],
	'padding-bottom' => $padding[2],
	'padding-left'   => $padding[3],
);
?>
<!-- wp:group {
	"style":{
		"layout":{
			"selfStretch":"fill",
			"flexSize":null
		},
		"spacing":{
			"padding":{
				"top":"<?php echo esc_attr( $padding[0] ); ?>",
				"right":"<?php echo esc_attr( $padding[1] ); ?>",
				"bottom":"<?php echo esc_attr( $padding[2] ); ?>",
				"left":"<?php echo esc_attr( $padding[3] ); ?>"
			}
		}
	},
	"layout":{
		"type":"flex",
		"orientation":"vertical",
		"justifyContent":"stretch",
		"verticalAlignment":"center"
	},
	"className":"suki-content site-content"
} --><div id="content" class="wp-block-group suki-content site-content" <?php suki_element_style( $styles ); ?>>

	<!-- wp:group {
		"layout":{
			"type":"constrained"
		}
	} --><div class="wp-block-group">

		<?php
		// Image.
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
				"linkDestination":"none"
			} --><figure class="wp-block-image aligncenter size-full is-resized">
				<img src="<?php echo esc_attr( $image_url ); ?>" alt="" class="wp-image-<?php echo esc_attr( $image ); ?>" width="<?php echo esc_attr( $image_width ); ?>"/>
			</figure><!-- /wp:image -->
			<?php
		}

		// Title.
		$title_text = suki_get_theme_mod( 'error_404_title_text' );
		if ( ! empty( $title_text ) ) {
			$title_typography = suki_get_title_typography();
			?>
			<!-- wp:heading {
				"textAlign":"center",
				"level":1,
				"className":"suki-title"
			} --><h1 class="wp-block-heading has-text-align-center suki-title"><?php echo esc_html( $title_text ); ?></h1><!-- /wp:heading -->
			<?php
		}

		// Description.
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

		// Search form.
		if ( boolval( suki_get_theme_mod( 'error_404_search_bar' ) ) ) {
			get_search_form();
		}

		// Home button.
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
					"textAlign":"center"
				} --><div class="wp-block-button">
					<a class="wp-block-button__link has-text-align-center wp-element-button" href="<?php echo esc_attr( home_url( '/' ) ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
				</div><!-- /wp:button -->
			</div><!-- /wp:buttons -->
			<?php
		}
		?>

	</div><!-- /wp:group -->

</div><!-- /wp:group -->
<?php
$content = ob_get_clean();

// Render Canvas.
suki_canvas( $content );

/**
 * Footer
 */
get_footer();
