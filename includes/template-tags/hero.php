<?php
/**
 * Hero section template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hero section
 */
if ( ! function_exists( 'suki_hero' ) ) {
	/**
	 * Render page header section.
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_hero( $echo = true, $do_blocks = true ) {
		// Abort if hero section is disabled.
		if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
			return;
		}

		// Abort if disable content header option is checked on the current loaded page.
		if ( boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
			return;
		}

		// Abort if current page is the blog posts page and "Show content header on blog page" option is disabled.
		if ( is_home() && ! boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
			return;
		}

		// Get content header elements.
		$content_header_elements = suki_get_current_page_setting( 'content_header' );

		// Abort if there is no content header elements selected.
		if ( empty( $content_header_elements ) ) {
			return;
		}

		ob_start();
		?>
		<!-- wp:group {
			"align":"full",
			"className":"suki-hero <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'hero_container' ) ); ?>",
			"layout":{
				"inherit":true
			}
		} --><div id="hero" class="wp-block-group alignfull suki-hero <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'hero_container' ) ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'suki' ); ?>">

			<!-- wp:group {
				"className":"suki-content-header <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'hero_container' ) ); ?>"
			} --><div class="wp-block-group suki-content-header">

				<?php
				foreach ( $content_header_elements as $element ) {
					suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), true, false );
				}
				?>

			</div><!-- /wp:group -->

		</div><!-- /wp:group -->
		<?php
		$html = ob_get_clean();

		/**
		 * Result
		 */

		// Parse blocks.
		if ( boolval( $do_blocks ) ) {
			$html = do_blocks( $html );
		}

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}
