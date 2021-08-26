<?php
/**
 * Hero section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Hook: suki/frontend/before_hero
 */
do_action( 'suki/frontend/before_hero' );

?>
<section id="hero" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/hero_classes', array( 'suki-hero' ) ) ) ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'suki' ); ?>">
	<div class="suki-hero-inner suki-section-inner">
		<div class="suki-wrapper">
			<?php suki_get_template_part( 'content-header' ) ?>
		</div>
	</div>
</section>
<?php

/**
 * Hook: suki/frontend/after_hero
 */
do_action( 'suki/frontend/after_hero' );
