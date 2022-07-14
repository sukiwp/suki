<?php
/**
 * Hero section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Abort if Hero section doesn't have hooked actions.
if ( ! has_action( 'suki/frontend/hero' ) ) {
	return;
}

/**
 * Hook: suki/frontend/before_hero
 */
do_action( 'suki/frontend/before_hero' );

/**
 * Hero section
 *
 * Note: We rely on 'suki-hero' CSS class and our own Customizer options to style the section.
 */

// CSS classes.
$classes = implode(
	'',
	array(
		'suki-hero has-text-align-' . suki_get_current_page_setting( 'content_header_alignment' ),
		'suki-section--' . suki_get_current_page_setting( 'hero_container' ),
	)
);

ob_start();
?>
<!-- wp:group {
	"align":"full",
	"className":"<?php echo esc_js( $classes ); ?>",
	"layout":{
		"inherit":true
	}
} --><div id="hero" class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'suki' ); ?>">
	<?php
	foreach ( suki_get_current_page_setting( 'content_header' ) as $element ) {
		suki_content_header_element( $element );
	}
	?>
</div><!-- /wp:group -->
<?php
echo do_blocks( ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

/**
 * Hook: suki/frontend/after_hero
 */
do_action( 'suki/frontend/after_hero' );
