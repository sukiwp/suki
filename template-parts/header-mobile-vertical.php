<?php
/**
 * Mobile header vertical template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() );
$display = suki_get_theme_mod( 'header_mobile_vertical_bar_display' );
?>
<div id="mobile-vertical-header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_mobile_vertical_classes', array( 'suki-header-mobile-vertical', 'suki-header', 'suki-popup' ) ) ) ); ?>" itemscope itemtype="https://schema.org/WPHeader">
	<?php if ( 'drawer' === $display ) : ?>
		<div class="suki-popup-background suki-popup-close"></div>
	<?php endif; ?>

	<div class="suki-header-mobile-vertical-bar suki-header-section-vertical suki-popup-content">
		<div class="suki-header-section-vertical-column">
			<div class="suki-header-mobile-vertical-bar-top suki-header-section-vertical-row">
				<?php foreach ( $elements as $element ) suki_header_element( $element ); ?>
			</div>
		</div>

		<?php if ( 'full-screen' === $display ) : ?>
			<button class="suki-popup-close-icon suki-popup-close suki-toggle"><?php suki_icon( 'close' ); ?></button>
		<?php endif; ?>
	</div>
</div>