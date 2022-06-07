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
	<!-- wp:query {
		"query":{
			"inherit":true
		},
		"className":"suki-loop",
		"layout":{
			"inherit":true
		}
	} --><div class="wp-block-query suki-loop">

		<!-- wp:post-template -->

			<?php
			/**
			 * Post entry
			 */
			suki_entry( suki_get_current_page_setting( 'loop_layout', 'default' ), true, false );
			?>

		<!-- /wp:post-template -->

		<?php
		/**
		 * Archive navigation
		 */
		suki_archive_navigation( true, false );
		?>

	</div><!-- /wp:query -->
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
