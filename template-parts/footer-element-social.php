<?php
/**
 * Footer social links template.
 *
 * Passed variables:
 *
 * @type string $slug Footer element slug.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$types = suki_get_theme_mod( 'footer_social_links', array() );

if ( empty( $types ) ) {
	return;
}

$target = '_' . suki_get_theme_mod( 'footer_social_links_target' );
$links = array();

foreach ( $types as $type ) {
	$url = suki_get_theme_mod( 'social_' . $type );
	$links[] = array(
		'type'   => $type,
		'url'    => ! empty( $url ) ? $url : '#',
		'target' => $target,
	);
}

?>
<ul class="<?php echo esc_attr( 'suki-footer-' . $slug ); ?> menu">
	<?php suki_social_links( $links, array(
		'before_link' => '<li class="menu-item">',
		'after_link'  => '</li>',
		'link_class'  => 'suki-menu-icon',
	) ); ?>
</ul>