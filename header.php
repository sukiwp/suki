<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		/**
		 * Hook: wp_body_open
		 *
		 * `wp_body_open` is a native theme hook available since WordPress 5.2
		 */
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}

		/**
		 * Hook: suki/frontend/before_canvas
		 *
		 * @hooked suki_skip_to_content_link - 1
		 * @hooked suki_mobile_vertical_header - 10
		 */
		do_action( 'suki/frontend/before_canvas' );
		?>

		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">

				<?php
				/**
				 * Hook: suki/frontend/before_header
				 */
				do_action( 'suki/frontend/before_header' );

				/**
				 * Header
				 */
				?>
				<header id="masthead" class="site-header" role="banner" itemtype="https://schema.org/WPHeader" itemscope>
					<?php
					/**
					 * Hook: suki/frontend/header
					 *
					 * @hooked suki_main_header - 10
					 * @hooked suki_mobile_header - 10
					 */
					do_action( 'suki/frontend/header' );
					?>
				</header>
				<?php

				/**
				 * Hook: suki/frontend/after_header
				 *
				 * @hooked suki_page_header - 10
				 */
				do_action( 'suki/frontend/after_header' );

				/**
				 * Content - opening tag
				 */
				if ( apply_filters( 'suki/frontend/show_content_wrapper', true ) ) {
					suki_content_open();
				}