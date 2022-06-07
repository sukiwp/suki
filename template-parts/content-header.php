<?php
/**
 * Content header template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$elements = suki_get_current_page_setting( 'content_header', array() );

// Abort if there is no element.
if ( 1 > count( $elements ) ) {
	return;
}

?>
<div class="<?php suki_element_class( 'content_header', array( 'suki-content-header', 'wp-block-group' ) ); ?>">
	<?php
	// Render content header elements.
	foreach ( $elements as $element ) {
		suki_content_header_element( $element );
	}
	?>
</div>
<?php
