<?php
/**
 * Hero section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Abort if Hero section doesn't have hooked actions.
if ( ! has_action( 'suki/frontend/hero' ) ) {
	return;
}

/**
 * Hook: suki/frontend/before_hero
 */
do_action( 'suki/frontend/before_hero' );

?>
<div id="hero" class="<?php suki_element_class( 'hero', array( 'suki-hero', 'suki-block-container' ) ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'suki' ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/hero
	 *
	 * @see suki_content_header() [10]
	 */
	do_action( 'suki/frontend/hero' );
	?>
</div>
<?php

/**
 * Hook: suki/frontend/after_hero
 */
do_action( 'suki/frontend/after_hero' );
