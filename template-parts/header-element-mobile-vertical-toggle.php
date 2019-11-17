<?php
/**
 * Mobile header vertical toggle template.
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
	<button class="suki-popup-toggle suki-toggle" data-target="mobile-vertical-header">
		<?php suki_icon( 'menu', array( 'class' => 'suki-menu-icon' ) ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Mobile Menu', 'suki' ); ?></span>
	</button>
</div>