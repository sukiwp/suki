<?php
/**
 * Suki module: Breadcrumb
 *
 * @package Suki
 *
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Breadcrumb module class.
 */
class Suki_Breadcrumb extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'breadcrumb';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Class constructor
	 */
	protected function __construct() {
		parent::__construct();

		/**
		 * Customizer
		 */

		// Add breadcrumb as content header elements on all page types (Customizer).
		foreach ( Suki_Customizer::instance()->get_page_types( 'all' ) as $page_type_key => $page_type_data ) {
			add_filter( 'suki/dataset/' . $page_type_key . '_content_header_elements', array( $this, 'add_content_header_elements' ) );
		}

		// Add breadcrumb as header builder elements (Customizer).
		add_filter( 'suki/dataset/header_builder/elements', array( $this, 'add_header_builder_elements' ) );

		// Add Customizer options.
		add_action( 'customize_register', array( $this, 'add_customizer_settings' ) );

		// Add Customizer default values.
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		// Add Customizer dependency control contexts.
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		/**
		 * Frontend
		 */

		// Add breadcrumb HTML to content header rendering filter.
		add_filter( 'suki/frontend/content_header_element/breadcrumb', array( $this, 'get_html' ) );

		// Add breadcrumb HTML to header element rendering filter.
		add_filter( 'suki/frontend/header_element/breadcrumb', array( $this, 'get_html' ) );
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return breadcrumb HTML markup.
	 */
	public function get_html() {
		/**
		 * Filter: suki/frontend/breadcrumb
		 *
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/breadcrumb', '' );

		// If markup is still empty, proceed to the normal procedures.
		if ( empty( $html ) ) {
			// Get breadcrumb markup based on the breadcrumb module mode.
			switch ( suki_get_theme_mod( 'breadcrumb_plugin', '' ) ) {
				case 'breadcrumb-trail':
					if ( function_exists( 'breadcrumb_trail' ) ) {
						$html = breadcrumb_trail(
							array(
								'show_browse' => false,
								'echo'        => false,
							)
						);
					}
					break;

				case 'breadcrumb-navxt':
					if ( function_exists( 'bcn_display' ) ) {
						$html = bcn_display( true );
					}
					break;

				case 'yoast-seo':
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						$html = yoast_breadcrumb( '', '', false );
					}
					break;

				case 'rank-math':
					if ( function_exists( 'rank_math_get_breadcrumbs' ) ) {
						$html = rank_math_get_breadcrumbs();
					}
					break;

				case 'seopress':
					if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
						$html = seopress_display_breadcrumbs( false );
					}
					break;

				default:
					$html = $this->generate_html__builtin();
					break;
			}
		}

		// Wrap with "suki-breadcrumb" div.
		$html = '<div class="suki-breadcrumb">' . $html . '</div>';

		return $html;
	}

	/**
	 * Render breadcrumb HTML markup.
	 */
	public function render_html() {
		echo $this->get_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Return theme's builtin breadcrumb's HTML markup.
	 *
	 * @return string
	 */
	public function generate_html__builtin() {
		$items = array();

		// Home.
		if ( boolval( suki_get_theme_mod( 'breadcrumb_trail_home' ) ) ) {
			$items['home'] = array(
				'label' => esc_html__( 'Home', 'suki' ),
				'url'   => home_url( '/' ),
			);
		}

		if ( boolval( suki_get_theme_mod( 'breadcrumb_trail_home' ) ) ) {
			$items['home'] = array(
				'label' => esc_html__( 'Home', 'suki' ),
				'url'   => home_url( '/' ),
			);
		}

		// Search results page.
		if ( is_search() && ! is_archive() ) {
			$items['search'] = array(
				/* translators: %s: search keyword. */
				'label' => sprintf( esc_html__( 'Search: %s', 'suki' ), get_search_query() ),
			);
		}

		// 404 page.
		if ( is_404() ) {
			$items['404'] = array(
				'label' => esc_html__( 'Page Not Found', 'suki' ),
			);
		}

		// Other kind of archives: taxonomy archive.
		if ( is_archive() || is_home() ) {
			$post_type     = get_post_type();
			$post_type_obj = get_post_type_object( $post_type );

			// Add post type archive page if it's not same with home page.
			if ( trailingslashit( get_post_type_archive_link( $post_type ) ) !== home_url( '/' ) ) {
				$post_type_obj = get_post_type_object( $post_type );

				$items['post_type_archive'] = array(
					'label' => 'post' === $post_type ? get_the_title( get_option( 'page_for_posts' ) ) : $post_type_obj->labels->name,
					'url'   => is_post_type_archive() || is_home() ? '' : get_post_type_archive_link( $post_type ),
				);
			}

			// Date archive.
			if ( is_date() ) {
				// Add published year info for year archive, month archive, and day archive.
				if ( is_year() || is_month() || is_day() ) {
					$items['year'] = array(
						'label' => get_the_time( 'Y' ),
						'url'   => is_year() ? '' : get_year_link( get_the_time( 'Y' ) ),
					);
				}
				// Add published month info for month archive, and day archive.
				if ( is_month() || is_day() ) {
					$items['month'] = array(
						'label' => get_the_time( 'F' ),
						'url'   => is_month() ? '' : get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
					);
				}
				// Add published day info for day archive.
				if ( is_day() ) {
					$items['day'] = array(
						'label' => get_the_time( 'd' ),
					);
				}
			}

			// Author archive.
			if ( is_author() ) {
				$author = get_userdata( get_query_var( 'author' ) );

				$items['author_archive'] = array(
					/* translators: %s: author display name. */
					'label' => $author->display_name,
				);
			}

			// Taxonomy archive.
			if ( is_category() || is_tag() || is_tax() ) {
				$term    = get_queried_object();
				$tax     = get_taxonomy( $term->taxonomy );
				$parents = get_ancestors( $term->term_id, $term->taxonomy );

				$i = count( $parents );

				while ( $i > 0 ) {
					$parent_term = get_term( $parents[ $i - 1 ], $term->taxonomy );

					$items[ 'term_parent__' . $i ] = array(
						'label' => $parent_term->name,
						'url'   => get_term_link( $parent_term, $parent_term->taxonomy ),
					);

					$i--;
				}

				$items['term'] = array(
					'label' => $term->name,
				);
			}
		}

		// All singular types.
		if ( is_singular() && ! is_front_page() ) {

			// All singular types except attachments.
			if ( ! is_attachment() ) {
				$post_type = get_post_type();

				// Post type archive link for Post and other CPT.
				if ( is_single() ) {
					// Add post type archive page if it's not same with home page.
					if ( trailingslashit( get_post_type_archive_link( $post_type ) ) !== home_url( '/' ) ) {
						$post_type_obj = get_post_type_object( $post_type );

						$items['post_type_archive'] = array(
							'label' => 'post' === $post_type ? get_the_title( get_option( 'page_for_posts' ) ) : $post_type_obj->labels->name,
							'url'   => get_post_type_archive_link( $post_type ),
						);
					}
				}

				// Category trails for Post.
				if ( 'post' === $post_type ) {
					$cats    = get_the_category();
					$cat_id  = $cats[0]->term_id;
					$parents = get_ancestors( $cat_id, 'category' );

					$i = count( $parents );

					while ( $i > 0 ) {
						$items[ 'term_parent__' . $i ] = array(
							'label' => get_cat_name( $parents[ $i - 1 ] ),
							'url'   => get_category_link( $parents[ $i - 1 ] ),
						);

						$i--;
					}

					$items['term'] = array(
						'label' => get_cat_name( $cat_id ),
						'url'   => get_category_link( $cat_id ),
					);
				}

				// Ancestors Trails for Page and other CPT.
				$ancestors = get_post_ancestors( get_post() );

				$i = count( $ancestors );
				while ( $i > 0 ) {
					$items[ 'post_parent__' . $i ] = array(
						'label' => get_the_title( $ancestors[ $i - 1 ] ),
						'url'   => get_permalink( $ancestors[ $i - 1 ] ),
					);

					$i--;
				}
			}

			// Current singular page.
			$items['post'] = array(
				'label' => get_the_title(),
			);
		}

		// Paginated.
		$paged    = get_query_var( 'page' ) || get_query_var( 'paged' );
		$keys     = array_keys( $items );
		$last_key = end( $keys );

		if ( $paged ) {
			/* translators: %s: page number. */
			$items[ $last_key ]['label'] .= sprintf( esc_html__( ' (Page %d)', 'suki' ), get_query_var( 'paged' ), $paged );
		}

		// Remove last item in the trail if "current page" is set to hidden.
		if ( ! boolval( suki_get_theme_mod( 'breadcrumb_trail_current_page' ) ) ) {
			unset( $items[ $last_key ] );
		}

		/**
		 * Filter: suki/frontend/breadcrumb_trail
		 *
		 * @param array $items Breadcrumb trail array.
		 */
		$items = apply_filters( 'suki/frontend/breadcrumb_trail', $items );

		// Abort if there is no trail.
		if ( empty( $items ) ) {
			return;
		}

		// Abort if breadcrumb trail only contain 1 item and the "Hide if home or current page is the only item" mode is enabled.
		if ( 1 === count( $items ) && boolval( suki_get_theme_mod( 'breadcrumb_hide_when_only_home_or_current' ) ) ) {
			// If home or current page (doesn't contain URL).
			if ( 'home' === array_key_first( $items ) || ! isset( $items[0]['url'] ) ) {
				return;
			}
		}

		/**
		 * Render breadcrumb markup.
		 */

		// Opening tag.
		$html = '<ol class="suki-breadcrumb-native" itemscope itemtype="https://schema.org/BreadcrumbList">';

		// Build breadcrumb markup.
		$i = 0;
		foreach ( $items as $index => $item ) {
			$html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

			if ( isset( $item['url'] ) && ! empty( $item['url'] ) ) {
				$html .= '<a itemprop="item" href="' . esc_url( $item['url'] ) . '"><span itemprop="name">' . esc_html( $item['label'] ) . '</span></a>';
			} else {
				$html .= '<span itemprop="name">' . esc_html( $item['label'] ) . '</span>';
			}
			$html .= '<meta itemprop="position" content="' . esc_attr( ++$i ) . '" />';

			$html .= '</li>';
		}

		// Closing tag.
		$html .= '</ol>';

		return $html;
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add breadcrumb as content header elements.
	 *
	 * @param array $elements Elements array.
	 * @return array
	 */
	public function add_content_header_elements( $elements ) {
		$elements['breadcrumb'] = esc_html__( 'Breadcrumb', 'suki' );

		return $elements;
	}

	/**
	 * Add breadcrumb as header builder elements.
	 *
	 * @param array $elements Elements array.
	 * @return array
	 */
	public function add_header_builder_elements( $elements ) {
		$elements['breadcrumb'] = array(
			'icon'              => 'networking',
			'label'             => esc_html__( 'Breadcrumb', 'suki' ),
			'unsupported_areas' => array(),
		);

		return $elements;
	}

	/**
	 * Add Customizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function add_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/structures/global--breadcrumb.php';
	}

	/**
	 * Add Customizer default values.
	 *
	 * @param array $defaults Default values.
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/defaults.php';

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add Customizer dependency control contexts.
	 *
	 * @param array $contexts Dependency contexts.
	 * @return array
	 */
	public function add_customizer_control_contexts( $contexts = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/contexts.php';

		return array_merge_recursive( $contexts, $add );
	}
}

Suki_Breadcrumb::instance();
