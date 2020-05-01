<?php
/**
 * Content header template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="content-header">
	<?php
	/**
	 * Hook: suki/frontend/content_header
	 */
	do_action( 'suki/frontend/content_header' );
	?>
</div>