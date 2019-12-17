<?php
/**
 * Header free text (HTML) template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-header-' . $slug ); ?>">
	<div><?php echo do_shortcode( suki_get_theme_mod( 'header_' . str_replace( '-', '_', $slug ) . '_content' ) ); ?></div>
</div>