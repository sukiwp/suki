<?php
/**
 * Fallback global page template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header template
 */
get_header();

/**
 * Canvas
 */

// Build main content.
ob_start();

$container = suki_get_current_page_setting( 'content_container' );
if ( suki_current_page_has_sidebar() && 'narrow' === $container ) {
	$container = 'wide';
}

$content_size = '';
if ( 'full' === $container ) {
	$content_size = '100%';
} elseif ( 'wide' === $container ) {
	$content_size = 'var(--wp--style--global--wide-size)';
}

?>
<!-- wp:group {
	"layout":{
		<?php
		if ( suki_current_page_has_sidebar() ) {
			?>
			"type":"default"
			<?php
		} else {
			?>
			"type":"constrained",
			"contentSize":"<?php echo esc_attr( $content_size ); ?>"
			<?php
		}
		?>
	}
} --><div class="wp-block-group">

	<?php
	suki_loop( suki_get_current_page_setting( 'loop_layout', 'default' ), false );
	?>

</div><!-- /wp:group -->
<?php

$main_content = ob_get_clean();

// Render Canvas.
suki_canvas(
	// Get Content section.
	suki_content( $main_content, '', false, false )
);

/**
 * Footer template
 */
get_footer();
