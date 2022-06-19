<?php
/**
 * Header template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php
		/**
		 * Hook: wp_head
		 */
		wp_head();
		?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		/**
		 * Hook: wp_body_open
		 */
		wp_body_open();

		/**
		 * Hook: suki/frontend/before_canvas
		 *
		 * @hooked suki_skip_to_content_link - 1
		 */
		do_action( 'suki/frontend/before_canvas' );
		?>

		<div id="page" class="suki-canvas site wp-site-blocks">

			<?php
			/**
			 * Hook: suki/frontend/before_header
			 */
			do_action( 'suki/frontend/before_header' );

			/**
			 * Header
			 */
			suki_header();

			/**
			 * Hook: suki/frontend/after_header
			 */
			do_action( 'suki/frontend/after_header' );
