<?php
/**
 * Footer free text (HTML) template.
 *
 * Passed variables:
 *
 * @type string $element Footer element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
	<div><?php echo do_shortcode( suki_get_theme_mod( 'footer_' . str_replace( '-', '_', $element ) . '_content' ) ); ?></div>
</div>