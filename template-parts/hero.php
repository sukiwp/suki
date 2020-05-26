<?php
/**
 * Page header section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<section id="page-header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/page_header_classes', array( 'suki-page-header' ) ) ) ); ?>" role="region" aria-label="<?php esc_attr_e( 'Page Header', 'suki' ); ?>">
	<div class="suki-page-header-inner suki-section-inner">
		<div class="suki-wrapper">
			<?php
			/**
			 * Hook: suki/frontend/content_header
			 */
			do_action( 'suki/frontend/content_header' );
			?>
		</div>
	</div>
</section>