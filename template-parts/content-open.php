<?php
/**
 * Content section opening tag template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="content" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/content_classes', array( 'site-content', 'suki-section' ) ) ) ); ?>">
	<div class="suki-content-inner suki-section-inner">
		<div class="suki-wrapper">

			<?php
			/**
			 * Hook: suki/frontend/before_primary_and_sidebar
			 */
			do_action( 'suki/frontend/before_primary_and_sidebar' );
			?> 

			<div class="suki-content-row">