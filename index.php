<?php
/**
 * Fallback global page template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header template
 */
get_header();

/**
 * Hero
 */
suki_hero();

/**
 * Content
 */
ob_start();
if ( have_posts() ) {
	/**
	 * Query loop
	 */
	?>
	<!-- wp:pattern {
		"slug":"suki/query--<?php echo esc_attr( suki_get_current_page_setting( 'loop_layout', 'default' ) ); ?>"
	} /-->
	<?php
} else {
	/**
	 * No items found.
	 */
	?>
	<!-- wp:paragraph --><p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p><!-- /wp:paragraph -->
	<?php
}
suki_content( ob_get_clean() );

/**
 * Footer template
 */
get_footer();
