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
 */
function suki_unassigned_menu() {
	$labels = get_registered_nav_menus();

	if ( ! is_user_logged_in() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<ul class="menu">
		<li class="menu-item">
			<a href="<?php echo esc_attr( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>" class="suki-menu-item-link">
				<?php esc_html_e( 'Assign menu to this location', 'suki' ); ?>
			</a>
		</li>
	</ul>
	<?php
}
endif;

if ( ! function_exists( 'suki_inline_svg' ) ) :
/**
 * Print / return inline SVG HTML tags.
 */
function suki_inline_svg( $svg_file, $echo = true ) {
	// Return empty if no SVG file path is provided.
	if ( empty( $svg_file ) ) {
		return;
	}

	// Get SVG markup.
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$html = $wp_filesystem->get_contents( $svg_file );

	// Remove XML encoding tag.
	// This should not be printed on inline SVG.
	$html = preg_replace( '/<\?xml(?:.*?)\?>/', '', $html );

	// Add width attribute if not found in the SVG markup.
	// Width value is extracted from viewBox attribute.
	if ( ! preg_match( '/<svg.*?width.*?>/', $html ) ) {
		if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $html, $matches ) ) {
			$html = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $html );
		}
	}

	// Remove <title> from SVG markup.
	// Site name would be added as a screen reader text to represent the logo.
	$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

	if ( $echo ) {
		echo $html; // WPCS: XSS OK
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'suki_logo' ) ) :
/**
 * Print HTML markup for specified site logo.
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
				$svg_file = get_attached_file( $logo_image_id );

				$logo_image = suki_inline_svg( $svg_file, false );
				break;
			
			default:
				$logo_image = wp_get_attachment_image( $logo_image_id , 'full', 0, array() );
				break;
		}

		// Replace logo HTML if logo image is found.
		if ( ! empty( $logo_image ) ) {
			$html = '<span class="suki-logo-image">' . $logo_image . '</span><span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
		}
	}

	echo $html; // WPCS: XSS OK
}
endif;

if ( ! function_exists( 'suki_default_logo' ) ) :
/**
 * Print / return HTML markup for default logo.
 */
function suki_default_logo() {
	?>
	<span class="suki-default-logo suki-logo"><?php suki_logo( suki_get_theme_mod( 'custom_logo' ) ); ?></span>
	<?php
}
endif;

if ( ! function_exists( 'suki_default_mobile_logo' ) ) :
/**
 * Print / return HTML markup for default mobile logo.
 */
function suki_default_mobile_logo() {
	?>
	<span class="suki-default-logo suki-logo"><?php suki_logo( suki_get_theme_mod( 'custom_logo_mobile' ) ); ?></span>
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

	$classes = implode( ' ', array( 'suki-icon', $args['class'] ) );

	// Get SVG path.
	$path = get_template_directory() . '/assets/icons/' . $key . '.svg';

	// Allow modification via filter.
	$path = apply_filters( 'suki/frontend/svg_icon_path', $path, $key );
	$path = apply_filters( 'suki/frontend/svg_icon_path/' . $key, $path );

	// Get SVG markup.
	if ( file_exists( $path ) ) {
		$svg = suki_inline_svg( $path, false );
	} else {
		$svg = suki_inline_svg( get_template_directory() . '/assets/icons/_fallback.svg', false ); // fallback
	}

	// Allow modification via filter.
	$svg = apply_filters( 'suki/frontend/svg_icon', $svg, $key );
	$svg = apply_filters( 'suki/frontend/svg_icon/' . $key, $svg );

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

		?><a href="<?php echo esc_url( $link['url'] ); ?>" class="suki-social-link <?php echo esc_attr( 'suki-social-link--' . $link['type'] ); ?>" <?php echo '_blank' === suki_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener"' : ''; // WPCS: XSS OK ?>>
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
	if ( intval( suki_get_current_page_setting( 'disable_mobile_header' ) ) ) {
		return;
	}

	suki_get_template_part( 'header-mobile-vertical' );
}
endif;

if ( ! function_exists( 'suki_main_header' ) ) :
/**
 * Render main header.
 */
function suki_main_header() {
	if ( intval( suki_get_current_page_setting( 'disable_header' ) ) ) {
		return;
	}

	suki_get_template_part( 'header-desktop' );
}
endif;

if ( ! function_exists( 'suki_main_header__bar' ) ) :
/**
 * Render main header bar.
 *
 * @param string $bar
 */
function suki_main_header__bar( $bar ) {
	suki_get_template_part( 'header-desktop-bar', null, array( 'bar' => $bar ) );
}
endif;

if ( ! function_exists( 'suki_mobile_header' ) ) :
/**
 * Render mobile header.
 */
function suki_mobile_header() {
	if ( intval( suki_get_current_page_setting( 'disable_mobile_header' ) ) ) {
		return;
	}

	suki_get_template_part( 'header-mobile' );
}
endif;

if ( ! function_exists( 'suki_header_element' ) ) :
/**
 * Wrapper function to print HTML markup for all header element.
 * 
 * @param string $slug
 */
function suki_header_element( $slug ) {
	if ( empty( $slug ) ) {
		return;
	}

	// Classify element into its type.
	$type = preg_replace( '/-\d$/', '', $slug );

	// Add passing variables.
	$variables = array( 'slug' => $slug );

	// Get header element template.
	$html = suki_get_template_part( 'header-element-' . $type, null, $variables, false );

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'suki/frontend/header_element', $html, $slug );
	$html = apply_filters( 'suki/frontend/header_element/' . $slug, $html );

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
	if ( ! intval( suki_get_current_page_setting( 'page_header' ) ) ) {
		return;
	}

	suki_get_template_part( 'page-header' );
}
endif;

if ( ! function_exists( 'suki_page_header_element' ) ) :
/**
 * Render page header element.
 */
function suki_page_header_element( $element ) {
	if ( empty( $element ) ) {
		return;
	}

	ob_start();
	switch ( $element ) {
		case 'title':
			$title = '';

			// If no custom title defined, use default title.
			if ( is_home() && is_front_page() ) {
				$title = get_bloginfo( 'description' );
			}

			elseif ( is_home() ) {
				$title = get_the_title( get_option( 'page_for_posts' ) );
			}

			elseif ( is_search() ) {
				$title = suki_get_current_page_setting( 'page_header_title_text__search' );

				if ( ! empty( $title ) ) {
					$title = str_replace( '{{keyword}}', get_search_query(), $title );
				} else {
					$title = suki_title__search( false );
				}
			}

			elseif ( is_post_type_archive() ) {
				$post_type_obj = get_queried_object();
				$title = suki_get_current_page_setting( 'page_header_title_text__post_type_archive' );

				if ( ! empty( $title ) ) {
					$title = str_replace( '{{post_type}}', $post_type_obj->labels->name, $title );
				} else {
					$title = post_type_archive_title( '', false );

					if ( empty( $title ) ) {
						$title = $post_type_obj->labels->name;
					}
				}
			}

			elseif ( is_date() || is_author() ) {
				$title = get_the_archive_title();
			}

			elseif ( is_archive() ) {
				$term_obj = get_queried_object();
				$taxonomy_obj = get_taxonomy( $term_obj->taxonomy );

				$title = suki_get_current_page_setting( 'page_header_title_text__taxonomy_archive' );

				if ( ! empty( $title ) ) {
					$title = str_replace( '{{taxonomy}}', $taxonomy_obj->labels->singular_name, $title );
					$title = str_replace( '{{term}}', $term_obj->name, $title );
				} else {
					$title = get_the_archive_title();
				}
			}

			elseif ( is_404() ) {
				$title = suki_get_current_page_setting( 'page_header_title_text__404' );

				if ( empty( $title ) ) {
					$title = suki_title__404( false );
				}
			}

			elseif ( is_singular() ) {
				$title = get_the_title();
			}

			if ( ! empty( $title ) ) {
				echo '<h1 class="suki-page-header-title">' . $title . '</h1>'; // WPCS: XSS OK
			}
			break;

		case 'breadcrumb':
			$breadcrumb = '';
			switch ( suki_get_theme_mod( 'breadcrumb_plugin', '' ) ) {
				case 'breadcrumb-trail':
					if ( function_exists( 'breadcrumb_trail' ) ) {
						$breadcrumb = breadcrumb_trail( array(
							'show_browse' => false,
							'echo' => false,
						) );
					}
					break;

				case 'breadcrumb-navxt':
					if ( function_exists( 'bcn_display' ) ) {
						$breadcrumb = bcn_display( true );
					}
					break;

				case 'yoast-seo':
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						$breadcrumb = yoast_breadcrumb( '', '', false );
					}
					break;

				case 'rank-math':
					if ( function_exists( 'rank_math_get_breadcrumbs' ) ) {
						$breadcrumb = rank_math_get_breadcrumbs();
					}
					break;

				case 'seopress':
					if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
						$breadcrumb = seopress_display_breadcrumbs( false );
					}
					break;
			}
			
			if ( ! empty( $breadcrumb ) ) {
				echo '<div class="suki-page-header-breadcrumb suki-breadcrumb">' . $breadcrumb . '</div>'; // WPCS: XSS OK
			}
			break;
	}
	$html = ob_get_clean();

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'suki/frontend/page_header_element', $html, $element );
	$html = apply_filters( 'suki/frontend/page_header_element/' . $element, $html );

	echo $html; // WPCS: XSS OK
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
	suki_get_template_part( 'content-open' );
}
endif;

if ( ! function_exists( 'suki_content_close' ) ) :
/**
 * Render content section closing tags.
 */
function suki_content_close() {
	suki_get_template_part( 'content-close' );
}
endif;

if ( ! function_exists( 'suki_primary_open' ) ) :
/**
 * Render main content opening tags.
 */
function suki_primary_open() {
	suki_get_template_part( 'content-primary-open' );
}
endif;

if ( ! function_exists( 'suki_primary_close' ) ) :
/**
 * Render main content closing tags.
 */
function suki_primary_close() {
	suki_get_template_part( 'content-primary-close' );
}
endif;

/**
 * ====================================================
 * Footer template functions
 * ====================================================
 */

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
	if ( intval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
		return;
	}

	suki_get_template_part( 'footer-widgets' );
}
endif;

if ( ! function_exists( 'suki_footer_bottom' ) ) :
/**
 * Render footer bottom bar.
 */
function suki_footer_bottom() {
	if ( intval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
		return;
	}

	suki_get_template_part( 'footer-bottom' );
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
			if ( has_nav_menu( 'footer-' . $element ) ) {
				?>
				<nav class="<?php echo esc_attr( 'suki-footer-' . $element ); ?> suki-footer-menu site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer-' . $element,
						'menu_class'     => 'menu',
						'container'      => false,
						'depth'          => -1,
					) ); ?>
				</nav>
				<?php
			} else {
				suki_unassigned_menu();
			}
			break;

		case 'copyright':
			$copyright = suki_get_theme_mod( 'footer_' . $key . '_content' );
			$copyright = str_replace( '{{year}}', date( 'Y' ), $copyright );
			$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
			$copyright = str_replace( '{{theme}}', '<a href="' . suki_get_theme_info( 'url' ) . '">' . suki_get_theme_info( 'name' ) . '</a>', $copyright );
			$copyright = str_replace( '{{themeauthor}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
			$copyright = str_replace( '{{theme_author}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
			?>
			<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
				<div class="suki-footer-copyright-content"><?php echo do_shortcode( $copyright ); ?></div>
			</div>
			<?php
			break;

		case 'social':
			$types = suki_get_theme_mod( 'footer_social_links', array() );

			if ( ! empty( $types ) ) {
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

if ( ! function_exists( 'suki_scroll_to_top' ) ) :
/**
 * Print scroll to top button.
 */
function suki_scroll_to_top() {
	if ( ! intval( suki_get_theme_mod( 'scroll_to_top' ) ) ) {
		return;
	}
	
	suki_get_template_part( 'scroll-to-top' );
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
			echo '<span class="entry-meta-author-avatar">' . get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'suki/frontend/meta_avatar_size', 24 ) ) . '</span>'; // WPCS: XSS OK
			break;

		case 'categories':
			echo '<span class="entry-meta-categories cat-links">' . get_the_category_list( esc_html_x( ', ', 'terms list separator', 'suki' ) ) . '</span>'; // WPCS: XSS OK
			break;

		case 'tags':
			echo ( '<span class="entry-meta-tags tags-links">' . get_the_tag_list( '', esc_html_x( ', ', 'terms list separator', 'suki' ) ) . '</span>' ); // WPCS: XSS OK
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
	if ( intval( suki_get_current_page_setting( 'content_hide_thumbnail' ) ) ) {
		return;
	}

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf( // WPCS: XSS OK
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'suki/frontend/entry/thumbnail_classes', array( 'entry-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			apply_filters( 'suki/frontend/entry/thumbnail_size', 'full' )
		),
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
	if ( 'post' !== get_post_type() ) {
		return;
	}

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
	suki_entry_meta( suki_get_theme_mod( 'entry_header_meta' ) );
}
endif;

if ( ! function_exists( 'suki_entry_footer_meta' ) ) :
/**
 * Print entry footer meta.
 */
function suki_entry_footer_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_footer_meta' ) );
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

	printf( // WPCS: XSS OK
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'suki/frontend/entry_grid/thumbnail_classes', array( 'entry-thumbnail', 'entry-grid-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			apply_filters( 'suki/frontend/entry_grid/thumbnail_size', 'medium_large' )
		),
		is_singular() ? 'div' : 'a'
	);
}
endif;

if ( ! function_exists( 'suki_entry_grid_header_meta' ) ) :
/**
 * Print entry grid header meta.
 */
function suki_entry_grid_header_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_grid_header_meta' ) );
}
endif;

if ( ! function_exists( 'suki_entry_grid_footer_meta' ) ) :
/**
 * Print entry grid footer meta.
 */
function suki_entry_grid_footer_meta() {
	suki_entry_meta( suki_get_theme_mod( 'entry_grid_footer_meta' ) );
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

if ( ! function_exists( 'suki_archive_header' ) ) :
/**
 * Render archive header.
 */
function suki_archive_header() {
	if ( has_action( 'suki/frontend/archive_header' ) ) : ?>
		<header class="page-header">
			<?php
			/**
			 * Hook: suki/frontend/archive_header
			 *
			 * @hooked suki_archive_title - 10
			 * @hooked suki_archive_description - 20
			 */
			do_action( 'suki/frontend/archive_header' );
			?>
		</header>
	<?php endif;
}
endif;

if ( ! function_exists( 'suki_archive_title' ) ) :
/**
 * Render archive title.
 */
function suki_archive_title() {
	the_archive_title( '<h1 class="page-title">', '</h1>' );
}
endif;

if ( ! function_exists( 'suki_archive_description' ) ) :
/**
 * Render archive description.
 */
function suki_archive_description() {
	the_archive_description( '<div class="archive-description">', '</div>' );
}
endif;

if ( ! function_exists( 'suki_search_header' ) ) :
/**
 * Render search header.
 */
function suki_search_header() {
	?>
	<header class="page-header">
		<?php
		/**
		 * Hook: suki/frontend/search_header
		 *
		 * @hooked suki_search_title - 10
		 * @hooked suki_search_form - 20
		 */
		do_action( 'suki/frontend/search_header' );
		?>
	</header>
	<?php
}
endif;

if ( ! function_exists( 'suki_search_title' ) ) :
/**
 * Render search title.
 */
function suki_search_title() {
	?>
	<h1 class="page-title"><?php suki_title__search(); ?></h1>
	<?php
}
endif;

if ( ! function_exists( 'suki_search_form' ) ) :
/**
 * Render search form.
 */
function suki_search_form() {
	get_search_form();
}
endif;

if ( ! function_exists( 'suki_loop_navigation' ) ) :
/**
 * Render posts loop navigation.
 */
function suki_loop_navigation() {
	if ( ! is_archive() && ! is_home() && ! is_search() ) {
		return;
	}
	
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
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( ! intval( suki_get_theme_mod( 'blog_single_author_bio' ) ) ) {
		return;
	}

	suki_get_template_part( 'blog-author-bio' );
}
endif;

if ( ! function_exists( 'suki_single_post_navigation' ) ) :
/**
 * Render prev / next post navigation in single post page.
 */
function suki_single_post_navigation() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( ! intval( suki_get_theme_mod( 'blog_single_navigation' ) ) ) {
		return;
	}

	the_post_navigation( array(
		/* translators: %s: title syntax. */
		'prev_text' => sprintf( esc_html__( '%s &raquo;', 'suki' ), '%title' ),
		/* translators: %s: title syntax. */
		'next_text' => sprintf( esc_html__( '&laquo; %s', 'suki' ), '%title' ),
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
				); // WPCS: XSS OK
			} else {
				printf(
					/* translators: %1$s: comment count number, %2$s: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_count, 'comments title', 'suki' ) ),
					number_format_i18n( $comments_count ),
					'<span>' . get_the_title() . '</span>'
				); // WPCS: XSS OK
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
