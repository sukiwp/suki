<?php
/**
 * Header free text (HTML) template.
 *
 * Passed variables:
 *
 * @type string $element Header element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
	<div><?php echo do_shortcode( suki_get_theme_mod( 'header_' . str_replace( '-', '_', $element ) . '_content' ) ); ?></div>
</div>