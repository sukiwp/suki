<?php
/**
 * Footer copyright template.
 *
 * Passed variables:
 *
 * @type string $element Footer element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$copyright = suki_get_theme_mod( 'footer_copyright_content' );
$copyright = str_replace( '{{year}}', date( 'Y' ), $copyright );
$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
$copyright = str_replace( '{{theme}}', '<a href="' . suki_get_theme_info( 'url' ) . '">' . suki_get_theme_info( 'name' ) . '</a>', $copyright );
$copyright = str_replace( '{{themeauthor}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
$copyright = str_replace( '{{theme_author}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );

?>
<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
	<div class="suki-footer-copyright-content"><?php echo do_shortcode( $copyright ); ?></div>
</div>