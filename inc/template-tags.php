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
	$svg = apply_filters( 'suki_icon', $svg, $key );
	$svg = apply_filters( "suki_icon__{$key}", $svg );

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
		echo ( $args['before_link'] ); // WPCS: XSS OK

		?><a href="<?php echo esc_url( $link['url'] ); ?>" class="suki-social-link" <?php '_blank' === suki_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener"' : ''; ?>>
			<?php suki_icon( $link['type'], array( 'title' => $labels[ $link['type'] ], 'class' => $args['link_class'] ) ); ?>
		</a><?php

		echo ( $args['after_link'] ); // WPCS: XSS OK
	endforeach;
	$html = ob_get_clean();

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

if ( ! function_exists( 'suki_popup_background' ) ) :
/**
 * Render popup background overlay.
 */
function suki_popup_background() {
	?>
	<div id="suki-popup-background" class="suki-popup-background suki-popup-close">
		<a href="#" class="suki-popup-close"><?php suki_icon( 'close' ); ?></a>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_mobile_vertical_header' ) ) :
/**
 * Render mobile vertical header.
 */
function suki_mobile_vertical_header() {
	$elements = suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() );
	$count = count( $elements );

	if ( 0 < $count ) : ?>
		<div id="mobile-vertical-header" class="suki-header-mobile-vertical-bar suki-header suki-header-vertical <?php echo esc_attr( implode( ' ', apply_filters( 'suki_header_mobile_vertical_bar_classes', array() ) ) ); ?> suki-hide-on-desktop" itemtype="https://schema.org/WPHeader" itemscope>
			<div class="suki-header-mobile-vertical-bar-inner suki-header-vertical-inner">
				<div class="suki-header-vertical-column">
					<div class="suki-header-mobile-vertical-bar-top suki-header-vertical-row suki-flex-align-left">
						<?php foreach ( $elements as $element ) suki_header_element( $element, 'mobile_vertical_top' ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php elseif ( is_customize_preview() ) : ?>
		<div id="mobile-vertical-header" class="suki-customizer-placeholder" itemtype="https://schema.org/WPHeader" itemscope></div>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_header' ) ) :
/**
 * Render main header section.
 */
function suki_header() {
	?>
	<header id="masthead" class="site-header" role="banner" itemtype="https://schema.org/WPHeader" itemscope>
		<?php
		suki_main_header();
		suki_mobile_header();
		?>
	</header>
	<?php
}
endif;

if ( ! function_exists( 'suki_main_header' ) ) :
/**
 * Render main header section.
 */
function suki_main_header() {
	?>
	<div id="header" class="suki-main-header suki-header suki-hide-on-tablet suki-hide-on-mobile <?php echo esc_attr( implode( ' ', apply_filters( 'suki_header_classes', array() ) ) ); ?>">

		<?php
		/**
		 * Hook: suki_header_start
		 */
		do_action( 'suki_header_start' );
		?>

		<?php
		foreach ( array( 'top', 'main', 'bottom' ) as $bar ) :
			$elements = array();
			$count = 0;
			$cols = array( 'left', 'center', 'right' );

			foreach ( $cols as $col ) {
				$elements[ $col ] = suki_get_theme_mod( 'header_elements_' . $bar . '_' . $col, array() );
				$count += count( $elements[ $col ] );
			}

			if ( 1 > $count ) continue;

			$height = floatval( suki_get_theme_mod( 'header_' . $bar . '_bar_height' ) );
			?>
			<div id="suki-header-<?php echo esc_attr( $bar ); ?>-bar" class="suki-header-<?php echo esc_attr( $bar ); ?>-bar suki-header-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( "suki_header_{$bar}_bar_classes", array() ) ) ); ?>" data-height="<?php echo esc_attr( $height ); ?>"
				<?php if ( $bar === suki_get_theme_mod( 'header_sticky_bar' ) ) {
					$sticky_height = floatval( suki_get_theme_mod( 'header_sticky_height' ) );
					$sticky_colors = suki_get_theme_mod( 'header_sticky_colors' );

					// Make sure sticky height is equal or lower than normal height.
					if ( '' === $sticky_height || $sticky_height > $height ) $sticky_height = $height;

					echo ' data-sticky_height="' . esc_attr( $sticky_height ) . '"';
					echo ' data-sticky_colors="' . esc_attr( $sticky_colors ) . '"';
				} ?>>
				<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-inner suki-section-inner">
					<div class="suki-wrapper">
						<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-row suki-header-row">
							<?php foreach ( $cols as $col ) : ?>
								<div class="<?php echo esc_attr( 'suki-header-' . $bar . '-bar-' . $col ); ?> suki-header-column <?php echo esc_attr( 'suki-flex-align-' . $col ); ?>">
									<?php foreach ( $elements[ $col ] as $element ) suki_header_element( $element, $bar . '_' . $col ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		endforeach; ?>

		<?php
		/**
		 * Hook: suki_header_end
		 */
		do_action( 'suki_header_end' );
		?>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'suki_mobile_header' ) ) :
/**
 * Render mobile header section.
 */
function suki_mobile_header() {
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
		<div id="suki-header-mobile-main-bar" class="suki-header-mobile-main-bar suki-header-section suki-section suki-section-full-width-padding <?php echo esc_attr( implode( ' ', apply_filters( 'suki_header_mobile_main_bar_classes', array() ) ) ); ?>">
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
		case 'mobile-logo':
			$logo_url = apply_filters( 'suki_logo_url', home_url( '/' ) );
			$logo_html = '<span>' . get_bloginfo( 'name', 'display' ) . '</span>';

			$logo_image_id = suki_get_theme_mod( 'header_' . $key . '_image' );
			if ( ! empty( $logo_image_id ) ) {
				$mime = get_post_mime_type( $logo_image_id );

				switch ( $mime ) {
					case 'image/svg+xml':
						ob_start();
						include( get_attached_file( $logo_image_id ) );
						$logo_image = ob_get_clean();
						break;
					
					default:
						$logo_image = wp_get_attachment_image( $logo_image_id , 'full', 0, array() );
						break;
				}

				$logo_html = $logo_image . '<span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
			}
			?>
			<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-element">
				<div class="suki-header-element-inner">
					<a href="<?php echo esc_url( $logo_url ); ?>" rel="home" class="site-title">
						<?php echo $logo_html; // WPCS: XSS OK ?>
					</a>
				</div>
			</div>
			<?php
			break;

		case 'menu':
			wp_nav_menu( array(
				'theme_location' => 'header-' . $element,
				'fallback_cb'    => 'suki_unassigned_menu',
				'menu_class'     => 'suki-header-menu suki-header-' . $element . ' suki-header-element menu suki-hover-menu',
				'container'      => false,
				'items_wrap'     => '<ul id="%1$s" class="%2$s" itemtype="https://schema.org/SiteNavigationElement" itemscope>%3$s</ul>',
			) );
			break;

		case 'mobile-menu':
			wp_nav_menu( array(
				'theme_location' => 'header-' . $element,
				'fallback_cb'    => 'suki_unassigned_menu',
				'menu_class'     => 'suki-header-menu suki-header-' . $element . ' suki-header-element menu suki-toggle-menu',
				'container'      => false,
				'items_wrap'     => '<ul id="%1$s" class="%2$s" itemtype="https://schema.org/SiteNavigationElement" itemscope>%3$s</ul>',
			) );
			break;

		case 'html':
			?>
			<div class="suki-header-html <?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-element">
				<div class="suki-header-element-inner">
					<div><?php echo do_shortcode( suki_get_theme_mod( 'header_' . $key . '_content' ) ); ?></div>
				</div>
			</div>
			<?php
			break;

		case 'search-bar':
			?>
			<div class="suki-header-search suki-header-search-bar suki-header-element">
				<div class="suki-header-element-inner"><?php get_search_form(); ?></div>
			</div>
			<?php
			break;

		case 'search-dropdown':
			?>
			<div class="suki-header-search suki-header-search-dropdown suki-header-element menu suki-toggle-menu">
				<div class="suki-header-element-inner menu-item">
					<a href="#" class="suki-sub-menu-toggle"><?php suki_icon( 'search', array( 'class' => 'suki-menu-icon' ) ); ?></a>
					<div class="sub-menu"><?php get_search_form(); ?></div>
				</div>
			</div>
			<?php
			break;

		case 'social':
			$types = suki_get_theme_mod( 'header_social_links' );

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
				<ul class="suki-header-social-links suki-header-element menu">
					<?php suki_social_links( $links, array(
						'before_link' => '<li class="suki-header-social-link menu-item">',
						'after_link'  => '</li>',
						'link_class'  => 'suki-menu-icon',
					) ); ?>
				</ul>
				<?php
			}
			break;

		case 'mobile-vertical-toggle':
			?>
			<div class="suki-header-mobile-vertical-bar-toggle suki-header-element menu">
				<div class="suki-header-element-inner menu-item">
					<a href="#mobile-vertical-header" class="suki-popup-toggle">
						<?php suki_icon( 'menu', array( 'class' => 'suki-menu-icon' ) ); ?>
						<span class="screen-reader-text"><?php suki_string( 'header_mobile_vertical_bar_toggle', true ); ?></span>
					</a>
				</div>
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
	$html = apply_filters( 'suki_header_element', $html, $element );
	$html = apply_filters( "suki_header_element__{$element}", $html );

	echo $html; // WPCS: XSS OK
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
		 * Hook: suki_footer_start
		 */
		do_action( 'suki_footer_start' );

		// Footer Widgets Bar
		suki_footer_widgets_bar();

		// Footer Bottom Bar (non-merged)
		suki_footer_bottom_bar();

		/**
		 * Hook: suki_footer_end
		 */
		do_action( 'suki_footer_end' );
		?>
	</footer>
	<?php
}
endif;

if ( ! function_exists( 'suki_footer_widgets_bar' ) ) :
/**
 * Render footer widgets area.
 */
function suki_footer_widgets_bar() {
	if ( 0 < suki_get_theme_mod( 'footer_widgets_bar' ) ) : ?>
		<div id="suki-footer-widgets-bar" class="suki-footer-widgets-bar suki-footer-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki_footer_widgets_bar_classes', array() ) ) ); ?>">
			<div class="suki-footer-widgets-bar-inner suki-section-inner">
				<div class="suki-wrapper">
					<div class="suki-footer-widgets-bar-row">
						<?php for ( $i = 1; $i <= suki_get_theme_mod( 'footer_widgets_bar' ); $i++ ) : ?>
							<div class="suki-footer-widgets-bar-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar-column <?php echo esc_attr( is_active_sidebar( 'footer-widgets-' . $i ) ? '' : 'suki-empty' ); ?>">
								<?php
								if ( is_active_sidebar( 'footer-widgets-' . $i ) ) :
									dynamic_sidebar( 'footer-widgets-' . $i );
								else :
									?>
									<div class="widget suki-inactive-widgets-area">
										<h4 class="widget-title">
											<?php
											/* translators: %d: footer widgets column number. */
											printf( esc_html__( 'Footer Widgets Column %d', 'suki' ), $i ); // WPCS: XSS OK.
											?>
										</h4>
										<p>
											<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add widget(s) to this column', 'suki' ); ?></a>
										</p>
									</div>
									<?php
								endif;
								?>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	<?php elseif ( is_customize_preview() ) : ?>
		<div id="suki-footer-widgets-bar" class="suki-customizer-placeholder"></div>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_footer_bottom_bar' ) ) :
/**
 * Render footer bottom bar.
 */
function suki_footer_bottom_bar() {
	$cols = array( 'left', 'center', 'right' );

	$elements = array();
	$count = 0;

	foreach ( $cols as $col ) {
		$elements[ $col ] = suki_get_theme_mod( 'footer_elements_bottom_' . $col );
		$count += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
	}

	if ( 1 > $count ) return;
	?>
	<div id="suki-footer-bottom-bar" class="suki-footer-bottom-bar site-info suki-footer-section suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki_footer_bottom_bar_classes', array() ) ) ); ?>">
		<div class="suki-footer-bottom-bar-inner suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-footer-bottom-bar-row suki-footer-row">
					<?php foreach ( $cols as $col ) : ?>
						<div class="suki-footer-bottom-bar-<?php echo esc_attr( $col ); ?> suki-footer-column <?php echo esc_attr( 'suki-text-align-' . $col ); ?>">
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
	if ( empty( $element ) ) return;

	$key = str_replace( '-', '_', $element );

	ob_start();
	switch ( $element ) {
		case 'logo':
			$logo_url = apply_filters( 'suki_logo_url', home_url( '/' ) );
			$logo_html = '<span>' . get_bloginfo( 'name', 'display' ) . '</span>';

			$logo_image_id = suki_get_theme_mod( 'footer_logo_image' );
			if ( ! empty( $logo_image_id ) ) {
				$mime = get_post_mime_type( $logo_image_id );

				switch ( $mime ) {
					case 'image/svg+xml':
						ob_start();
						include( get_attached_file( $logo_image_id ) );
						$logo_image = ob_get_clean();
						break;
					
					default:
						$logo_image = wp_get_attachment_image( $logo_image_id , 'full', 0, array() );
						break;
				}

				$logo_html = $logo_image . '<span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
			}
			?>
			<div class="suki-footer-logo suki-footer-element">
				<div class="suki-footer-element-inner">
					<a href="<?php echo esc_url( $logo_url ); ?>" rel="home" class="site-title">
						<?php echo $logo_html; // WPCS: XSS OK ?>
					</a>
				</div>
			</div>
			<?php
			break;

		case 'menu':
		case 'menu-1':
			wp_nav_menu( array(
				'theme_location' => 'footer-' . $element,
				'fallback_cb'    => 'suki_unassigned_menu',
				'menu_class'     => 'suki-footer-menu suki-footer-' . $element . ' suki-footer-element menu',
				'container'      => false,
				'items_wrap'     => '<ul id="%1$s" class="%2$s" itemtype="https://schema.org/SiteNavigationElement" itemscope>%3$s</ul>',
				// 'item_spacing'   => 'discard',
				'depth'          => -1,
			) );
			break;

		case 'copyright':
			$copyright = suki_get_theme_mod( 'footer_' . $key . '_content' );
			$copyright = str_replace( '{{current_year}}', date( 'Y' ), $copyright );
			$copyright = str_replace( '{{homepage_link}}', '<a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
			$copyright = str_replace( '{{author_link}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
			?>
			<div class="suki-footer-copyright suki-footer-element">
				<div class="suki-footer-element-inner"><div><?php echo do_shortcode( $copyright ); ?></div></div>
			</div>
			<?php
			break;

		case 'social':
			$types = suki_get_theme_mod( 'footer_social_links' );

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
				<ul class="suki-footer-social-links suki-footer-element menu">
					<?php suki_social_links( $links, array(
						'before_link' => '<li class="suki-footer-social-link menu-item">',
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
	$html = apply_filters( 'suki_footer_element', $html, $element );
	$html = apply_filters( "suki_footer_element__{$element}", $html );

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
	switch ( $element ) {
		case 'date':
			if ( 'post' === get_post_type() ) {
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

				echo '<span class="entry-meta-date"><a href="' . get_permalink() . '" class="posted-on">' . $time_string . '</a></span>'; // WPCS: XSS OK
			}
			break;

		case 'author':
			if ( 'post' === get_post_type() ) {
				// Use global $post variable to access author data, as currently none of author functions are working on Customizer's partial refresh.
				global $post;
				printf( // WPCS: XSS OK
					'<span class="entry-meta-author byline">' . suki_string( 'entry_meta_author' ) . '</span>',
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) . '</a></span>'
				);
			}
			break;

		case 'author-photo':
			if ( 'post' === get_post_type() ) {
				// Use global $post variable to access author data, as currently none of author functions are working on Customizer's partial refresh.
				global $post;
				echo '<span class="entry-meta-author byline">' . get_avatar( get_the_author_meta( 'ID' ), 24 ) . '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) . '</a></span></span>'; // WPCS: XSS OK
			}
			break;

		case 'categories':
			if ( 'post' === get_post_type() ) {
				$categories_list = get_the_category_list( suki_string( 'entry_meta_categories_separator' ) );
				if ( ! empty( $categories_list ) ) {
					echo '<span class="entry-meta-categories cat-links">' . sprintf( suki_string( 'entry_meta_categories' ), $categories_list ) . '</span>'; // WPCS: XSS OK
				}
			}
			break;

		case 'tags':
			if ( 'post' === get_post_type() ) {
				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', suki_string( 'entry_meta_tags_separator' ) );
				if ( $tags_list ) {
					echo ( '<span class="entry-meta-tags tags-links">' . sprintf( suki_string( 'entry_meta_tags' ), $tags_list ) . '</span>' ); // WPCS: XSS OK
				}
			}
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
	$class = 'small' === $size ? 'entry-small-title' : 'entry-title';

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
	if ( has_post_thumbnail() ) {
		global $content_width;

		printf( // WPCS: XSS OK
			'<%s class="entry-thumbnail' . ( suki_get_theme_mod( 'entry_featured_media_ignore_padding' ) ? ' suki-entry-thumbnail-ignore-padding' : '' ) . '">%s</%s>',
			is_singular() ? 'div' : 'a href="' . get_the_permalink() . '"',
			get_the_post_thumbnail( get_the_ID(), array( $content_width, 0 ) ),
			is_singular() ? 'div' : 'a'
		);
	}
}
endif;

if ( ! function_exists( 'suki_entry_header_meta' ) ) :
/**
 * Print entry header meta.
 */
function suki_entry_header_meta() {
	$elements = suki_get_theme_mod( 'entry_header_meta', array( 'date' ) );

	if ( count( $elements ) > 0 ) : ?>
		<div class="entry-meta">
			<?php foreach ( $elements as $element ) suki_entry_meta_element( $element ); ?>
		</div>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_entry_footer_meta' ) ) :
/**
 * Print entry footer meta.
 */
function suki_entry_footer_meta() {
	$elements = suki_get_theme_mod( 'entry_footer_meta', array( 'author', 'categories', 'comments' ) );

	if ( count( $elements ) > 0 ) : ?>
		<div class="entry-meta">
			<?php foreach ( $elements as $element ) suki_entry_meta_element( $element ); ?>
		</div>
	<?php endif;
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
	if ( has_post_thumbnail() ) {
		global $content_width;

		$width = ceil( floatval( $content_width ) / suki_get_theme_mod( 'blog_index_grid_columns' ) );

		printf( // WPCS: XSS OK
			'<%s class="entry-thumbnail">%s</%s>',
			is_singular() ? 'div' : 'a href="' . get_the_permalink() . '"',
			get_the_post_thumbnail( get_the_ID(), array( $width, 0 ) ),
			is_singular() ? 'div' : 'a'
		);
	}
}
endif;

if ( ! function_exists( 'suki_entry_grid_header_meta' ) ) :
/**
 * Print entry grid header meta.
 */
function suki_entry_grid_header_meta() {
	$elements = suki_get_theme_mod( 'entry_grid_header_meta', array( 'date' ) );

	if ( count( $elements ) > 0 ) : ?>
		<div class="entry-meta">
			<?php foreach ( $elements as $element ) suki_entry_meta_element( $element ); ?>
		</div>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_entry_grid_footer_meta' ) ) :
/**
 * Print entry grid footer meta.
 */
function suki_entry_grid_footer_meta() {
	$elements = suki_get_theme_mod( 'entry_grid_footer_meta', array( 'categories', 'comments' ) );

	if ( count( $elements ) > 0 ) : ?>
		<div class="entry-meta">
			<?php foreach ( $elements as $element ) suki_entry_meta_element( $element ); ?>
		</div>
	<?php endif;
}
endif;

/**
 * ====================================================
 * Posts archive template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_archive_title' ) ) :
/**
 * Render title of archive page.
 */
function suki_archive_title() {
	$title = get_the_archive_title();

	if ( ! empty( $title ) ) {
		echo '<h1 class="page-title">' . $title . '</h1>'; // WPCS: XSS OK
	}
}
endif;

if ( ! function_exists( 'suki_archive_description' ) ) :
/**
 * Render description of archive page.
 */
function suki_archive_description() {
	$description = get_the_archive_description();

	if ( ! empty( $description ) ) {
		echo '<div class="archive-description">' . $description . '</div>'; // WPCS: XSS OK
	}
}
endif;

if ( ! function_exists( 'suki_loop_navigation' ) ) :
/**
 * Render posts loop navigation.
 */
function suki_loop_navigation() {
	if ( ! is_archive() && ! is_home() ) return;
	
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
	if ( ! is_single() ) return;
	?>
	<div class="entry-author">
		<div class="entry-author-body">
			<div class="entry-author-name vcard">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'suki_entry_author_bio_avatar_size', 80 ), '', get_the_author_meta( 'display_name' ) ); ?>
				<b class="fn"><?php the_author_posts_link(); ?></b>
			</div>
			<div class="entry-author-content">
				<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
			</div>
			<div class="entry-author-links suki-social-links">
				<?php
				$array = suki_get_social_media_types();
				$links = array();

				foreach ( $array as $type => $label ) {
					$url = get_the_author_meta( $type );
					if ( empty( $url ) ) continue;
					$links[] = array( 'type' => $type, 'url' => $url, 'newtab' => true );
				}

				suki_social_links( $links );
				?>
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
	if ( ! is_single() ) return;

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
		<p class="no-comments"><?php echo suki_string( 'comments_closed' ); // WPCS: XSS OK ?></p>
	<?php endif;
}
endif;

/**
 * ====================================================
 * Other template functions:
 * ====================================================
 */

if ( ! function_exists( 'suki_search_title' ) ) :
/**
 * Render title of search results page.
 */
function suki_search_title() {
	?>
	<h1 class="page-title">
		<?php
		printf(
			/* translators: %s: search query. */
			esc_html__( 'Search Results for: %s', 'suki' ),
			'<em>' . get_search_query() . '</em>'
		); // WPCS: XSS OK
		?>
	</h1>
	<?php
}
endif;

if ( ! function_exists( 'suki_404_title' ) ) :
/**
 * Render title of 404 page.
 */
function suki_404_title() {
	?>
	<h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'suki' ); ?></h1>
	<?php
}
endif;