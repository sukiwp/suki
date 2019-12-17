<?php
/**
 * Header search dropdown template.
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
<div class="<?php echo esc_attr( 'suki-header-' . $slug ); ?> suki-header-search menu suki-toggle-menu">
	<div class="menu-item">
		<button class="suki-sub-menu-toggle suki-toggle">
			<?php suki_icon( 'search', array( 'class' => 'suki-menu-icon' ) ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'suki' ); ?></span>
		</button>
		<div class="sub-menu"><?php get_search_form(); ?></div>
	</div>
</div>