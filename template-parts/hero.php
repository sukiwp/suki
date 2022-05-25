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

// Build the content first.
ob_start();
foreach ( suki_get_current_page_setting( 'content_header' ) as $element ) {
	suki_content_header_element( $element );
}
$content_header = ob_get_clean();

// Build class.
$class = 'suki-hero has-text-align-' . suki_get_current_page_setting( 'content_header_alignment' ) . ' suki-section-' . suki_get_current_page_setting( 'hero_container' );

// Render the section.
echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'
	<!-- wp:group {
		"align":"full",
		"style":{
			"spacing":{
				"blockGap":"' . suki_scale_dimension( 0.5, suki_get_theme_mod( 'block_spacing' ) ) . '"
			}
		},
		"className":"' . $class . '",
		"layout":{
			"inherit":true
		}
	} --><div class="wp-block-group alignfull ' . $class . '" id="hero">
		' . $content_header . '
	</div><!-- /wp:group -->
	'
);

/**
 * Hook: suki/frontend/after_hero
 */
do_action( 'suki/frontend/after_hero' );
