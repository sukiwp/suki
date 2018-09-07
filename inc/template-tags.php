<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Global template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_unassigned_menu' ) ) :
/**
 * Fallback HTML if there is no nav menu assigned to a navigation location.
 * 
 * @param array $args
 */
function suki_unassigned_menu( $args ) {
	$labels = get_registered_nav_menus();
	?>
	<ul class="menu-blank menu">
		<li class="menu-item">
			<a href="<?php echo esc_url( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>">
				<span>
					<?php
					/* translators: %s: menu location name. */
					printf( esc_html__( 'Assign your menu to %s', 'suki' ), $labels[ $args['theme_location'] ] ); // WPCS: XSS OK
					?>
				</span>
			</a>
		</li>
	</ul>
	<?php
}
endif;

if ( ! function_exists( 'suki_logo' ) ) :
/**
 * Print / return HTML markup for specified site logo.
 *
 * @param integer $logo_image_id
 */
function suki_logo( $logo_image_id = null ) {
	// Default to site name.
	$html = get_bloginfo( 'name', 'display' );

	// Try to get logo image.
	if ( ! empty( $logo_image_id ) ) {
		$mime = get_post_mime_type( $logo_image_id );

		switch ( $mime ) {
			case 'image/svg+xml':
				ob_start();
				$svg_file = get_attached_file( $logo_image_id );

				if ( ! empty( $svg_file ) ) {
					include( $svg_file );
				}
				$logo_image = ob_get_clean();

				// Add width attribute if not found in the SVG markup.
				// Width value is extracted from viewBox attribute.
				if ( ! preg_match( '/<svg.*?width.*?>/', $logo_image ) ) {
					if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $logo_image, $matches ) ) {
						$logo_image = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $logo_image );
					}
				}

				// Remove <title> from SVG markup.
				// Site name would be added as a screen reader text to represent the logo.
				$logo_image = preg_replace( '/<title>.*?<\/title>/', '', $logo_image );
				break;
			
			default:
				$logo_image = wp_get_attachment_image( $logo_image_id , 'full', 0, array() );
				break;
		}

		// Replace logo HTML if logo image is found.
		if ( ! empty( $logo_image ) ) {
			$html = $logo_image . '<span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
		}
	}

	echo $html; // WPCS: XSS OK
}
endif;

if ( ! function_exists( 'suki_icon' ) ) :
/**
 * Print / return HTML markup for specified icon type in SVG format.
 *
 * @param string $key
 * @param array $args
 * @param boolean $echo
 */
function suki_icon( $key, $args = array(), $echo = true ) {
	$args = wp_parse_args( $args, array(
		'title' => '',
		'class' => '',
	) );

	$classes = implode( ' ', array( $args['class'], 'suki-icon' ) );

	// Get default SVG icons from theme's icons folder.
	$path = get_template_directory() . '/assets/icons/' . $key . '.svg';
	ob_start();
	if ( file_exists( $path ) ) {
		include( $path );
	} else {
		include( get_template_directory() . '/assets/icons/_fallback.svg' ); // fallback
	}
	$svg = ob_get_clean();
	
	// Filters to modify SVG icon.
	$svg = apply_filters( 'suki/frontend/icon', $svg, $key );
	$svg = apply_filters( 'suki/frontend/icon/' . $key, $svg );

	// Wrap the icon with "suki-icon" span tag.
	$html = '<span class="' . esc_attr( $classes ) . '" title="' . esc_attr( $args['title'] ) . '">' . $svg . '</span>';

	if ( $echo ) {
		echo $html; // WPCS: XSS OK
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'suki_social_links' ) ) :
/**
 * Print / return HTML markup for specified set of social media links.
 *
 * @param array $links
 * @param array $args
 * @param boolean $echo
 */
function suki_social_links( $links = array(), $args = array(), $echo = true ) {
	$labels = suki_get_social_media_types();

	$args = wp_parse_args( $args, array(
		'before_link' => '',
		'after_link'  => '',
		'link_class'  => '',
	) );

	ob_start();
	foreach ( $links as $link ) :
		echo $args['before_link']; // WPCS: XSS OK

		?><a href="<?php echo esc_url( $link['url'] ); ?>" class="suki-social-link" <?php '_blank' === suki_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener me nofollow"' : ' rel="me nofollow"'; ?>>
			<?php suki_icon( $link['type'], array( 'title' => $labels[ $link['type'] ], 'class' => $args['link_class'] ) ); ?>
		</a><?php

		echo $args['after_link']; // WPCS: XSS OK
	endforeach;
	$html = ob_get_clean();

	if ( $echo ) {
		echo $html; // WPCS: XSS OK
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'suki_title__search' ) ) :
/**
 * Print / return HTML markup for title text for search page.
 *
 * @param boolean $echo
 */
function suki_title__search( $echo = true ) {
	$html = sprintf(
		/* translators: %s: search query. */
		esc_html__( 'Search Results for: %s', 'suki' ),
		'<span>' . get_search_query() . '</span>'
	); // WPCS: XSS OK

	if ( $echo ) {
		echo $html; // WPCS: XSS OK
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'suki_title__404' ) ) :
/**
 * Print / return HTML markup for title text for 404 page.
 *
 * @param boolean $echo
 */
function suki_title__404( $echo = true ) {
	$html = esc_html__( 'Oops! That page can not be found.', 'suki' );

	if ( $echo ) {
		echo $html; // WPCS: XSS OK
	} else {
		return $html;
	}
}
endif;

/**
 * ====================================================
 * Header template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_skip_to_content_link' ) ) :
/**
 * Render skip to content link.
 */
function suki_skip_to_content_link() {
	?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'suki' ); ?></a>
	<?php
}
endif;

if ( ! function_exists( 'suki_mobile_vertical_header' ) ) :
/**
 * Render mobile vertical header.
 */
function suki_mobile_vertical_header() {
	if ( intval( suki_get_current_page_setting( 'disable_mobile_header' ) ) ) return;

	$elements = suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() );
	$count = count( $elements );

	if ( 0 < $count ) : ?>
		<div id="mobile-vertical-header" class="suki-popup suki-hide-on-desktop" itemtype="https://schema.org/WPHeader" itemscope>
			<div class="suki-popup-close-background suki-popup-close"></div>

			<div class="suki-header-mobile-vertical-bar suki-header suki-header-vertical <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_mobile_vertical_bar_classes', array() ) ) ); ?>">
				<div class="suki-header-mobile-vertical-bar-inner suki-header-vertical-inner">
					<div class="suki-header-vertical-column">
						<div class="suki-header-mobile-vertical-bar-top suki-header-vertical-row suki-flex-align-left">
							<?php foreach ( $elements as $element ) suki_header_element( $element, 'mobile_vertical_top' ); ?>
						</div>
					</div>
				</div>
			</div>

			<button class="suki-popup-close-icon suki-popup-close suki-toggle"><?php suki_icon( 'close' ); ?></button>
		</div>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_header' ) ) :
/**
 * Render horizontal header.
 */
function suki_header() {
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
}
endif;

if ( ! function_exists( 'suki_main_header' ) ) :
/**
 * Render main header.
 */
function suki_main_header() {
	if ( intval( suki_get_current_page_setting( 'disable_header' ) ) ) return;

	?>
	<div id="header" class="suki-main-header suki-header suki-hide-on-tablet suki-hide-on-mobile <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_classes', array() ) ) ); ?>">
		<?php
		// Top Bar (if not merged)
		if ( ! intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
			suki_main_header__bar( 'top' );
		}

		// Main Bar
		suki_main_header__bar( 'main' );

		// Bottom Bar (if not merged)
		if ( ! intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
			suki_main_header__bar( 'bottom' );
		}
		?>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_main_header__bar' ) ) :
/**
 * Render main header bar.
 *
 * @param string $bar
 */
function suki_main_header__bar( $bar ) {
	$elements = array();
	$count = 0;
	$cols = array( 'left', 'center', 'right' );

	foreach ( $cols as $col ) {
		$elements[ $col ] = suki_get_theme_mod( 'header_elements_' . $bar . '_' . $col, array() );
		$count += count( $elements[ $col ] );
	}

	if ( 1 > $count ) return;

	?>
	<div id="suki-header-<?php echo esc_attr( $bar ); ?>-bar" class="suki-header-<?php echo esc_attr( $bar ); ?>-bar suki-header-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_' . $bar . '_bar_classes', array() ) ) ); ?>">
		<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-inner suki-section-inner">
			<div class="suki-wrapper">

				<?php
				// Top Bar (if merged).
				if ( 'main' === $bar && intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
					suki_main_header__bar( 'top' );
				}
				?>

				<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-row suki-header-row">
					<?php foreach ( $cols as $col ) : ?>
						<div class="<?php echo esc_attr( 'suki-header-' . $bar . '-bar-' . $col ); ?> suki-header-column <?php echo esc_attr( 'suki-flex-align-' . $col ); ?>">
							<?php foreach ( $elements[ $col ] as $element ) suki_header_element( $element, $bar . '_' . $col ); ?>
						</div>
					<?php endforeach; ?>
				</div>

				<?php
				// Bottom Bar (if merged).
				if ( 'main' === $bar && intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
					suki_main_header__bar( 'bottom' );
				}
				?>

			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_mobile_header' ) ) :
/**
 * Render mobile header.
 */
function suki_mobile_header() {
	if ( intval( suki_get_current_page_setting( 'disable_mobile_header' ) ) ) return;

	?>
	<div id="mobile-header" class="suki-header-mobile suki-header suki-hide-on-desktop">
		<?php
		$elements = array();
		$count = 0;
		$cols = array( 'left', 'center', 'right' );

		foreach ( $cols as $col ) {
			$elements[ $col ] = suki_get_theme_mod( 'header_mobile_elements_main_' . $col, array() );
			$count += count( $elements[ $col ] );
		}

		if ( 1 > $count ) return;
		?>
		<div id="suki-header-mobile-main-bar" class="suki-header-mobile-main-bar suki-header-section suki-section suki-section-full-width-padding <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_mobile_main_bar_classes', array() ) ) ); ?>">
			<div class="suki-header-mobile-main-bar-inner suki-section-inner">
				<div class="suki-wrapper">
					<div class="suki-header-mobile-main-bar-row suki-header-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="<?php echo esc_attr( 'suki-header-mobile-main-bar-' . $col ); ?> suki-header-column <?php echo esc_attr( 'suki-flex-align-' . $col ); ?>">
								<?php foreach ( $elements[ $col ] as $element ) suki_header_element( $element, 'mobile_main_' . $col ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_header_element' ) ) :
/**
 * Wrapper function to print HTML markup for all header element.
 * 
 * @param string $element
 */
function suki_header_element( $element ) {
	if ( empty( $element ) ) {
		return;
	}

	// Classify element into its type.
	$type = preg_replace( '/-\d$/', '', $element );

	// Convert element slug into key format.
	$key = str_replace( '-', '_', $element );

	ob_start();
	switch ( $type ) {
		case 'logo':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding">
				<<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?> class="site-title">
					<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home"><?php suki_logo( suki_get_theme_mod( 'custom_logo' ) ); ?></a>
				</<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?>>
			</div>
			<?php
			break;

		case 'mobile-logo':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding">
				<div class="site-title">
					<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home"><?php suki_logo( suki_get_theme_mod( 'custom_logo_mobile' ) ); ?></a>
				</div>
			</div>
			<?php
			break;

		case 'menu':
			/* translators: %s: header menu number. */
			$aria_label = sprintf( esc_html__( 'Header Menu %s', 'suki' ), str_replace( 'menu-', '', $element ) );
			?>
			<nav class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-menu site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation" aria-label="<?php echo esc_attr( $aria_label ); ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'header-' . $element,
					'fallback_cb'    => 'suki_unassigned_menu',
					'menu_class'     => 'menu suki-hover-menu',
					'container'      => false,
				) ); ?>
			</nav>
			<?php 
			break;

		case 'mobile-menu':
			$aria_label = esc_html__( 'Header Mobile Menu', 'suki' );
			?>
			<nav class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-menu site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation" aria-label="<?php echo esc_attr( $aria_label ); ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'header-' . $element,
					'fallback_cb'    => 'suki_unassigned_menu',
					'menu_class'     => 'menu suki-toggle-menu',
					'container'      => false,
					'items_wrap'     => '<ul id="%1$s" class="%2$s" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation">%3$s</ul>',
				) ); ?>
			</nav>
			<?php
			break;

		case 'html':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
				<div><?php echo do_shortcode( suki_get_theme_mod( 'header_' . $key . '_content' ) ); ?></div>
			</div>
			<?php
			break;

		case 'search-bar':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-search">
				<?php get_search_form(); ?>
			</div>
			<?php
			break;

		case 'search-dropdown':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-search menu suki-toggle-menu">
				<div class="menu-item">
					<button class="suki-sub-menu-toggle suki-toggle">
						<?php suki_icon( 'search', array( 'class' => 'suki-menu-icon' ) ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Search', 'suki' ); ?></span>
					</button>
					<div class="sub-menu"><?php get_search_form(); ?></div>
				</div>
			</div>
			<?php
			break;

		case 'social':
			$types = suki_get_theme_mod( 'header_social_links', array() );

			if ( ! empty( $types ) ) {
				$target = suki_get_theme_mod( 'header_social_links_target' );
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
				<ul class="<?php echo esc_attr( 'suki-header-' . $element ); ?> menu suki-menu-icon">
					<?php suki_social_links( $links, array(
						'before_link' => '<li class="menu-item">',
						'after_link'  => '</li>',
						'link_class'  => 'suki-menu-icon',
					) ); ?>
				</ul>
				<?php
			}
			break;

		case 'mobile-vertical-toggle':
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
				<button class="suki-popup-toggle suki-toggle" data-target="mobile-vertical-header">
					<?php suki_icon( 'menu', array( 'class' => 'suki-menu-icon' ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Mobile Menu', 'suki' ); ?></span>
				</button>
			</div>
			<?php
			break;

		default:
			// Print nothing.
			// Other elements can be modified via filters.
			break;
	}
	$html = ob_get_clean();

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'suki/frontend/header_element', $html, $element );
	$html = apply_filters( 'suki/frontend/header_element/' . $element, $html );

	echo $html; // WPCS: XSS OK
}
endif;

/**
 * ====================================================
 * Page Header template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_page_header' ) ) :
/**
 * Render page header section.
 */
function suki_page_header() {
	if ( intval( suki_get_current_page_setting( 'disable_page_header' ) ) ) return;

	if ( ! intval( suki_get_theme_mod( 'page_header' ) ) ) return;

	?>
	<div class="suki-page-header <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/page_header_classes', array() ) ) ); ?>">
		<div class="suki-page-header-inner suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-page-header-row">
					<?php suki_page_title(); ?>

					<?php suki_breadcrumb(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_page_title' ) ) :
/**
 * Render page title.
 */
function suki_page_title() {
	// If no custom title defined, use default title.
	if ( empty( $title ) ) {
		if ( is_home() && is_front_page() ) {
			$title = get_bloginfo( 'description' );
		}

		elseif ( is_home() ) {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}

		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		elseif ( is_singular() ) {
			$title = get_the_title();
		}

		elseif ( is_archive() ) {
			$title = get_the_archive_title();
		}

		elseif ( is_search() ) {
			$title = suki_title__search( false );
		}

		elseif ( is_404() ) {
			$title = suki_title__404( false );
		}

		else {
			$title = '<!-- No title format matched for this page -->';
		}
	}

	echo '<h1 class="suki-page-header-title">' . $title . '</h1>'; // WPCS: XSS OK
}
endif;

if ( ! function_exists( 'suki_breadcrumb' ) ) :
/**
 * Render breadcrumb via 3rd party plugin.
 */
function suki_breadcrumb() {
	if ( ! intval( suki_get_theme_mod( 'page_header_breadcrumb' ) ) ) return;

	ob_start();
	switch ( suki_get_theme_mod( 'breadcrumb_plugin', '' ) ) {
		case 'breadcrumb-trail':
			if ( function_exists( 'breadcrumb_trail' ) ) {
				breadcrumb_trail( array(
					'show_browse' => false,
				) );
			}
			break;

		case 'breadcrumb-navxt':
			if ( function_exists( 'bcn_display' ) ) {
				bcn_display();
			}
			break;

		case 'yoast-seo':
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb();
			}
			break;
	}
	$breadcrumb = ob_get_clean();
	
	if ( ! empty( $breadcrumb ) ) {
		echo '<div class="suki-page-header-breadcrumb suki-breadcrumb">' . $breadcrumb . '</div>'; // WPCS: XSS OK
	}
}
endif;

/**
 * ====================================================
 * Content section template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_content_open' ) ) :
/**
 * Render content section opening tags.
 */
function suki_content_open() {
	?>
	<div id="content" class="site-content suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/content_classes', array() ) ) ); ?>">
		<div class="suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-content-row">
	<?php
}
endif;

if ( ! function_exists( 'suki_content_close' ) ) :
/**
 * Render content section closing tags.
 */
function suki_content_close() {
	?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_primary_open' ) ) :
/**
 * Render main content opening tags.
 */
function suki_primary_open() {
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
	<?php
}
endif;

if ( ! function_exists( 'suki_primary_close' ) ) :
/**
 * Render main content closing tags.
 */
function suki_primary_close() {
	?>
		</main>
	</div>
	<?php
}
endif;

/**
 * ====================================================
 * Footer template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_footer' ) ) :
/**
 * Render footer section.
 */
function suki_footer() {
	?>
	<footer id="colophon" class="site-footer suki-footer" role="contentinfo" itemtype="https://schema.org/WPFooter" itemscope>
		<?php
		/**
		 * Hook: suki/frontend/footer
		 *
		 * @hooked suki_main_footer - 10
		 */
		do_action( 'suki/frontend/footer' );
		?>
	</footer>
	<?php
}
endif;

if ( ! function_exists( 'suki_main_footer' ) ) :
/**
 * Render footer sections.
 */
function suki_main_footer() {
	// Widgets Bar
	suki_footer_widgets();
	
	// Bottom Bar (if not merged)
	if ( ! intval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		suki_footer_bottom();
	}
}
endif;

if ( ! function_exists( 'suki_footer_widgets' ) ) :
/**
 * Render footer widgets area.
 */
function suki_footer_widgets() {
	if ( intval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) ) return;

	$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

	if ( 1 > $columns ) return;
	?>
	<div id="suki-footer-widgets-bar" class="suki-footer-widgets-bar suki-footer-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/footer_widgets_bar_classes', array() ) ) ); ?>">
		<div class="suki-footer-widgets-bar-inner suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-footer-widgets-bar-row <?php echo esc_attr( 'suki-footer-widgets-bar-columns-' . suki_get_theme_mod( 'footer_widgets_bar' ) ); ?>">
					<?php for ( $i = 1; $i <= $columns; $i++ ) : ?>
						<div class="suki-footer-widgets-bar-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar-column <?php echo esc_attr( is_active_sidebar( 'footer-widgets-' . $i ) ? '' : 'suki-empty' ); ?>">
							<?php if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
								dynamic_sidebar( 'footer-widgets-' . $i );
							} ?>
						</div>
					<?php endfor; ?>
				</div>

				<?php
				// Bottom Bar (if merged)
				if ( intval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
					suki_footer_bottom();
				}
				?>

			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_footer_bottom' ) ) :
/**
 * Render footer bottom bar.
 */
function suki_footer_bottom() {
	if ( intval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) ) return;

	$cols = array( 'left', 'center', 'right' );

	$elements = array();
	$count = 0;

	foreach ( $cols as $col ) {
		$elements[ $col ] = suki_get_theme_mod( 'footer_elements_bottom_' . $col, array() );
		$count += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
	}

	if ( 1 > $count ) return;

	?>
	<div id="suki-footer-bottom-bar" class="suki-footer-bottom-bar site-info suki-footer-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/footer_bottom_bar_classes', array() ) ) ); ?>">
		<div class="suki-footer-bottom-bar-inner suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-footer-bottom-bar-row suki-footer-row">
					<?php foreach ( $cols as $col ) : ?>
						<div class="suki-footer-bottom-bar-<?php echo esc_attr( $col ); ?> suki-footer-bottom-bar-column suki-footer-column <?php echo esc_attr( 'suki-text-align-' . $col ); ?>">
							<?php foreach ( $elements[ $col ] as $element ) suki_footer_element( $element ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_footer_element' ) ) :
/**
 * Render each footer element.
 * 
 * @param string $element
 */
function suki_footer_element( $element ) {
	if ( empty( $element ) ) {
		return;
	}

	// Classify element into its type.
	$type = preg_replace( '/-\d$/', '', $element );

	// Convert element slug into key format.
	$key = str_replace( '-', '_', $element );

	ob_start();
	switch ( $type ) {
		case 'menu':
			?>
			<nav class="<?php echo esc_attr( 'suki-footer-' . $element ); ?> site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'footer-' . $element,
					'fallback_cb'    => 'suki_unassigned_menu',
					'menu_class'     => 'menu',
					'container'      => false,
					'depth'          => -1,
				) ); ?>
			</nav>
			<?php
			break;

		case 'copyright':
			$copyright = suki_get_theme_mod( 'footer_' . $key . '_content' );
			$copyright = str_replace( '{{year}}', date( 'Y' ), $copyright );
			$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
			$copyright = str_replace( '{{themeauthor}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
			?>
			<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
				<div class="suki-footer-copyright-content"><?php echo do_shortcode( $copyright ); ?></div>
			</div>
			<?php
			break;

		case 'social':
			$types = suki_get_theme_mod( 'footer_social_links', array() );

			if ( ! empty( $types ) ) {
				$target = suki_get_theme_mod( 'footer_social_links_target' );
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
				<ul class="<?php echo esc_attr( 'suki-footer-' . $element ); ?> menu">
					<?php suki_social_links( $links, array(
						'before_link' => '<li class="menu-item">',
						'after_link'  => '</li>',
						'link_class'  => 'suki-menu-icon',
					) ); ?>
				</ul>
				<?php
			}
			break;
	}
	$html = ob_get_clean();

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'suki/frontend/footer_element', $html, $element );
	$html = apply_filters( 'suki/frontend/footer_element/' . $element, $html );

	echo $html; // WPCS: XSS OK
}
endif;

/**
 * ====================================================
 * Entry template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_entry_meta_element' ) ) :
/**
 * Print entry meta element.
 */
function suki_entry_meta_element( $element ) {
	global $post;

	switch ( $element ) {
		case 'date':
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
			}
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			echo '<span class="entry-meta-date"><a href="' . esc_url( get_permalink() ) . '" class="posted-on">' . $time_string . '</a></span>'; // WPCS: XSS OK
			break;

		case 'author':
			echo '<span class="entry-meta-author author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>'; // WPCS: XSS OK
			break;

		case 'avatar':
			echo '<span class="entry-meta-author-avatar">' . get_avatar( get_the_author_meta( 'ID' ), 24 ) . '</span>'; // WPCS: XSS OK
			break;

		case 'categories':
			echo '<span class="entry-meta-categories cat-links">' . get_the_category_list( ', ' ) . '</span>'; // WPCS: XSS OK
			break;

		case 'tags':
			echo ( '<span class="entry-meta-tags tags-links">' . get_the_tag_list( '', ', ' ) . '</span>' ); // WPCS: XSS OK
			break;

		case 'comments':
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-meta-comments comments-link">';
				comments_popup_link();
				echo '</span>';
			}
			break;
	}
}
endif;

if ( ! function_exists( 'suki_entry_tags' ) ) :
/**
 * Print tags links.
 */
function suki_entry_tags() {
	$tags_list = get_the_tag_list( '', '' );

	if ( $tags_list ) {
		echo '<div class="entry-tags tagcloud suki-float-container">' . $tags_list . '</div>'; // WPCS: XSS OK
	}
}
endif;

if ( ! function_exists( 'suki_entry_comments' ) ) :
/**
 * Print comments block in single post page.
 */
function suki_entry_comments() {
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}
endif;

if ( ! function_exists( 'suki_entry_title' ) ) :
/**
 * Print entry title on each post.
 *
 * @param boolean $size
 */
function suki_entry_title( $size = '' ) {
	$class = 'small' === $size ? 'entry-small-title h3' : 'entry-title h1';

	if ( is_singular() ) {
		the_title( '<h1 class="' . $class . '">', '</h1>' );
	} else {
		the_title( sprintf( '<h2 class="' . $class . '"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}
}
endif;

if ( ! function_exists( 'suki_entry_featured_media' ) ) :
/**
 * Print post's featured media based on the specified post format.
 */
function suki_entry_featured_media() {
	if ( intval( suki_get_current_page_setting( 'content_hide_thumbnail' ) ) ) {
		return;
	}

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	global $content_width;

	printf( // WPCS: XSS OK
		'<%s class="entry-thumbnail' . ( intval( suki_get_theme_mod( 'entry_featured_media_ignore_padding' ) ) ? ' suki-entry-thumbnail-ignore-padding' : '' ) . '">%s</%s>',
		is_singular() ? 'div' : 'a href="' . get_the_permalink() . '"',
		get_the_post_thumbnail( get_the_ID(), array( $content_width, 0 ) ),
		is_singular() ? 'div' : 'a'
	);
}
endif;

if ( ! function_exists( 'suki_entry_header_meta' ) ) :
/**
 * Print entry meta.
 *
 * @param string $format
 */
function suki_entry_meta( $format ) {
	if ( 'post' !== get_post_type() ) return;

	$format = trim( $format );
	$html = $format;

	if ( ! empty( $format ) ) {
		preg_match_all( '/{{(.*?)}}/', $format, $matches, PREG_SET_ORDER );
			
		foreach ( $matches as $match ) {
			ob_start();
			suki_entry_meta_element( $match[1] );
			$meta = ob_get_clean();

			$html = str_replace( $match[0], $meta, $html );
		}

		if ( '' !== trim( $html ) ) {
			echo '<div class="entry-meta">' . $html . '</div>'; // WPCS: XSS OK
		}
	}
}
endif;

if ( ! function_exists( 'suki_entry_header_meta' ) ) :
/**
 * Print entry header meta.
 */
function suki_entry_header_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_header_meta', array() ) );
}
endif;

if ( ! function_exists( 'suki_entry_footer_meta' ) ) :
/**
 * Print entry footer meta.
 */
function suki_entry_footer_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_footer_meta', array() ) );
}
endif;

if ( ! function_exists( 'suki_entry_grid_title' ) ) :
/**
 * Print entry grid title.
 */
function suki_entry_grid_title() {
	suki_entry_title( 'small' );
}
endif;

if ( ! function_exists( 'suki_entry_grid_featured_media' ) ) :
/**
 * Print entry grid featured media.
 */
function suki_entry_grid_featured_media() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	global $content_width;

	$width = ceil( intval( $content_width ) / intval( suki_get_theme_mod( 'blog_index_grid_columns' ) ) );

	printf( // WPCS: XSS OK
		'<%s class="entry-thumbnail">%s</%s>',
		is_singular() ? 'div' : 'a href="' . get_the_permalink() . '"',
		get_the_post_thumbnail( get_the_ID(), array( $width, 0 ) ),
		is_singular() ? 'div' : 'a'
	);
}
endif;

if ( ! function_exists( 'suki_entry_grid_header_meta' ) ) :
/**
 * Print entry grid header meta.
 */
function suki_entry_grid_header_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_grid_header_meta', array() ) );
}
endif;

if ( ! function_exists( 'suki_entry_grid_footer_meta' ) ) :
/**
 * Print entry grid footer meta.
 */
function suki_entry_grid_footer_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_grid_footer_meta', array() ) );
}
endif;

if ( ! function_exists( 'suki_entry_small_title' ) ) :
/**
 * Print entry small title.
 */
function suki_entry_small_title() {
	suki_entry_title( 'small' );
}
endif;

/**
 * ====================================================
 * All index pages template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_content_header' ) ) :
/**
 * Render content header.
 */
function suki_content_header() {
	if ( is_archive() ) {
		?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>
		<?php
	}

	elseif ( is_search() ) {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php suki_title__search(); ?></h1>
			<?php get_search_form(); ?>
		</header>
		<?php
	}
}
endif;

if ( ! function_exists( 'suki_loop_navigation' ) ) :
/**
 * Render posts loop navigation.
 */
function suki_loop_navigation() {
	if ( ! is_archive() && ! is_home() && ! is_search() ) return;
	
	// Render posts navigation.
	switch ( suki_get_theme_mod( 'blog_index_navigation_mode' ) ) {
		case 'pagination':
			the_posts_pagination( array(
				'mid_size'  => 3,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			) );
			break;
		
		default:
			the_posts_navigation( array(
				'prev_text' => esc_html__( 'Older Posts', 'suki' ) . ' &raquo;',
				'next_text' => '&laquo; ' . esc_html__( 'Newer Posts', 'suki' ),
			) );
			break;
	}
}
endif;

/**
 * ====================================================
 * Single post template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_single_post_author_bio' ) ) :
/**
 * Render author bio block in single post page.
 */
function suki_single_post_author_bio() {
	if ( ! is_singular( 'post' ) ) return;

	?>
	<div class="entry-author">
		<div class="entry-author-body">
			<div class="entry-author-name vcard">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'suki/frontend/entry_author_bio_avatar_size', 80 ), '', get_the_author_meta( 'display_name' ) ); ?>
				<b class="fn"><?php the_author_posts_link(); ?></b>
			</div>
			<div class="entry-author-content">
				<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
			</div>
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_single_post_navigation' ) ) :
/**
 * Render prev / next post navigation in single post page.
 */
function suki_single_post_navigation() {
	if ( ! is_singular( 'post' ) ) return;

	the_post_navigation( array(
		'prev_text' => esc_html__( '%title &raquo;', 'suki' ),
		'next_text' => esc_html__( '&laquo; %title', 'suki' ),
	) );
}
endif;

if ( ! function_exists( 'suki_comments_title' ) ) :
/**
 * Render comments title.
 */
function suki_comments_title() {
	?>
	<h2 class="comments-title">
		<?php
			$comments_count = get_comments_number();
			if ( '1' === $comments_count ) {
				printf(
					/* translators: %1$s: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'suki' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: %1$s: comment count number, %2$s: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_count, 'comments title', 'suki' ) ),
					number_format_i18n( $comments_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
	</h2>
	<?php
}
endif;

if ( ! function_exists( 'suki_comments_navigation' ) ) :
/**
 * Render comments navigation.
 */
function suki_comments_navigation() {
	the_comments_navigation();
}
endif;

if ( ! function_exists( 'suki_comments_closed' ) ) :
/**
 * Render comments closed message.
 */
function suki_comments_closed() {
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'suki' ); ?></p>
	<?php endif;
}
endif;

/**
 * ====================================================
 * Customizer's partial refresh callback aliases
 * ====================================================
 */

function suki_header_element__html_1() {
	suki_header_element( 'html-1' );
}
function suki_header_element__social() {
	suki_header_element( 'social' );
}

function suki_footer_element__logo() {
	suki_footer_element( 'logo' );
}
function suki_footer_element__copyright() {
	suki_footer_element( 'copyright' );
}
function suki_footer_element__social() {
	suki_footer_element( 'social' );
}
