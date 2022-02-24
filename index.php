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
 * Content wrapper template -- Open
 */
suki_content_open();

/**
 * Hook: suki/frontend/before_main
 *
 * @see suki_archive_header() [10]
 */
do_action( 'suki/frontend/before_main' );

/**
 * Main content
 */
if ( have_posts() ) {
	/**
	 * Query loop
	 */
	?>
	<div class="<?php suki_element_class( 'loop', array( 'wp-block-post-template', 'suki-loop', 'suki-has-margin-block__300' ) ); ?>">
		<?php
		while ( have_posts() ) {
			the_post();

			/**
			 * Entry template
			 */
			suki_get_template_part( 'entry', suki_get_current_page_setting( 'loop_layout', 'default' ) );
		}
		?>
	</div>
	<?php

} else {
	/**
	 * No items found.
	 */
	?>
	<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
	<?php
}

/**
 * Hook: suki/frontend/after_main
 *
 * @see suki_archive_navigation() [10]
 */
do_action( 'suki/frontend/after_main' );

/**
 * Content wrapper template -- Close
 */
suki_content_close();

/**
 * Footer template
 */
get_footer();
