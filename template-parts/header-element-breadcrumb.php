<?php
/**
 * Header breadcrumb template.
 *
 * Passed variables:
 *
 * @type string $element Header element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Suki_Breadcrumb' ) ) {
	return;
}

?>
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
	<?php Suki_Breadcrumb::instance()->render_html(); ?>
</div>
