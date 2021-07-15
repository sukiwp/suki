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
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
	<?php suki_breadcrumb(); ?>
</div>