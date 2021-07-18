<?php
/**
 * Migrate to 1.3.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_1_3_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_3_0
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Migrate_1_3_0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		$this->preserve_old_typography_styles();
		$this->migrate_page_template_slug();
		$this->migrate_featured_media_to_thumbnail();
		$this->migrate_header_shopping_cart();
		
		$this->migrate_page_settings_keys();
		$this->migrate_content_layout_narrow();
		$this->migrate_page_header_title_text();
		$this->migrate_page_header_to_hero_section();

		$this->migrate_page_settings_meta_box();

		$this->migrate_woocommerce_index_settings();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Migrate default typography.
	 *
	 * Installed theme will use the former default typography.
	 * New typography will only be applied to new installation.
	 */
	private function preserve_old_typography_styles() {
		set_theme_mod( 'base_font_size', '15px' );
		set_theme_mod( 'h4_font_size', '17px' );
	}

	/**
	 * Migrate all pages with "page-builder" page template to "page_builder".
	 *
	 * Why:
	 * "page-" is a reserved page template format (ref: https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use).
	 * The possible bad case: If user created a page with "builder" as its slug, WordPress will mistakenly use "page-builder" page template for that page even if user didn't set the page template to "page-builder".
	 */
	private function migrate_page_template_slug() {
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page-builder.php',
		) );

		foreach ( $posts as $post ) {
			update_post_meta( $post, '_wp_page_template', 'page-templates/page_builder.php' );
		}
	}

	/**
	 * Migrate customizer option keys "featured_media" to "thumbnail".
	 *
	 * The previous implementation:
	 * - Use "featured_media" as slug.
	 *
	 * The new implementation:
	 * - Use "thumbnail" as slug.
	 */
	private function migrate_featured_media_to_thumbnail() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, '_featured_media' ) ) {
				if ( strpos( $key, '_featured_media_position' ) ) {
					$key = str_replace( '_position', '', $key );
				}

				$new_key = str_replace( '_featured_media', '_thumbnail', $key );

				remove_theme_mod( $key );

				set_theme_mod( $new_key, $value );
			}
		}
	}

	/**
	 * Migrate header cart slug from "shopping-cart" to "cart"
	 *
	 * The previous implementation:
	 * - Use "shopping-cart" slug
	 *
	 * The new implementation:
	 * - Use "cart" as slug.
	 */
	private function migrate_header_shopping_cart() {
		// Desktop Header		
		$desktop_header_locations = array(
			'top_left', 'top_center', 'top_right',
			'main_left', 'main_center', 'main_right',
			'bottom_left', 'bottom_center', 'bottom_right',
		);
		foreach ( $desktop_header_locations as $location ) {
			$elements = suki_get_theme_mod( 'header_elements_' . $location );

			$has_cart = false;
			foreach ( $elements as &$element ) {
				if ( 0 === strpos( $element, 'shopping-cart' ) ) {
					$element = str_replace( 'shopping-cart', 'cart', $element );
					$has_cart = true;
				}
			}
			
			if ( $has_cart ) {
				set_theme_mod( 'header_elements_' . $location, $elements );
			}
		}
		
		// Mobile Header		
		$desktop_header_locations = array(
			'main_left', 'main_center', 'main_right',
		);
		foreach ( $desktop_header_locations as $location ) {
			$elements = suki_get_theme_mod( 'header_mobile_elements_' . $location );
			
			$has_cart = false;
			foreach ( $elements as &$element ) {
				if ( 0 === strpos( $element, 'shopping-cart' ) ) {
					$element = str_replace( 'shopping-cart', 'cart', $element );
					$has_cart = true;
				}
			}

			if ( $has_cart ) {
				set_theme_mod( 'header_mobile_elements_' . $location, $elements );
			}
		}
	}

	/**
	 * Migrate page settings keys from array to non array.
	 *
	 * The previous implementation:
	 * - Page settings on each type is saved in an array with "page_settings_{type}[ {key} ]" key. For example: page_settings_post_single['content_layout'].
	 * - For search results page, use "search" as slug.
	 * - For error 404 page, use "404" as slug.
	 *
	 * The new implementation:
	 * - Page settings on each type is saved in non array with "{type}_{key}". For example: post_single_content_layout.
	 * - For search results page, use "search_results" as slug.
	 * - For error 404 page, use "error_404" as slug.
	 */
	private function migrate_page_settings_keys() {
		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			if ( 'search_results' === $ps_type ) {
				$old_option_key = 'page_settings_search';
			}
			elseif ( 'error_404' === $ps_type ) {
				$old_option_key = 'page_settings_404';
			}
			elseif ( 0 < strpos( $ps_type, '_single' ) ) {
				$old_option_key = 'page_settings_' . str_replace( '_single', '_singular', $ps_type );
			}
			else {
				$old_option_key = 'page_settings_' . $ps_type;
			}

			// Get the values.
			$mod = get_theme_mod( $old_option_key, array() );

			foreach ( $mod as $key => $value ) {
				set_theme_mod( $ps_type . '_' . $key, $value );
			}

			remove_theme_mod( $old_option_key );
		}
	}

	/**
	 * Migrate content narrow to custom container width.
	 *
	 * Why:
	 * It doesn't make sense when user chooses "Full width" in "Content container" option and chooses "Narrow" in the "Content and sidebar layout" option.
	 *
	 * The previous implementation:
	 * - User choose between "Wrapped" and "Full width" in the "Content container" option.
	 * - User choose "Narrow" in the "Content and sidebar layout" option.
	 *
	 * The new implementation:
	 * - User choose between "Wrapped", "Full width", and the new "Custom" option in the "Content container" option.
	 * - Custom means user can manually input the container width.
	 * - There is no longer "Narrow" option in the "Content and sidebar layout" option (because user can set the container width).
	 */
	private function migrate_content_layout_narrow() {
		/**
		 * Global settings
		 */

		// If the selected value of "content_layout" is "narrow".
		if ( 'narrow' === get_theme_mod( 'content_layout' ) ) {
			// Change it to "wide".
			set_theme_mod( 'content_layout', 'wide' );

			// And then change the "content_container" value to "custom".
			set_theme_mod( 'content_container', 'narrow' );
		}

		/**
		 * Page settings
		 */

		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Get the values.
			$content_layout = get_theme_mod( $ps_type . '_content_layout' );

			// If the selected value of "content_layout" is "narrow".
			if ( 'narrow' === $content_layout ) {
				// Change it to "wide".
				set_theme_mod( $ps_type . '_content_layout', 'wide' );
				
				// And then set the "content_container" value to "narrow".
				set_theme_mod( $ps_type . '_content_container', 'narrow' );
			}
		}
	}

	/**
	 * Migrate all page header title text option keys.
	 *
	 * Why:
	 * The title text should affect the content header title as well not just the page header title.
	 */
	private function migrate_page_header_title_text() {
		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Process search page title text.
			if ( 'search_results' === $ps_type ) {
				// Check if user has filled the custom title text options.
				$title_text = get_theme_mod( $ps_type . '_page_header_title_text__search' );

				if ( false !== $title_text ) {
					// Set new option.
					set_theme_mod( $ps_type . '_title_text', $title_text );
	
					// Remove old option.
					remove_theme_mod( $ps_type . '_page_header_title_text__search' );
				}
			}

			// Process error 404 title text.
			elseif ( 'error_404' === $ps_type ) {
				// Check if user has filled the custom title text options.
				$title_text = get_theme_mod( $ps_type . '_page_header_title_text__404' );

				if ( false !== $title_text ) {
					// Set new option.
					set_theme_mod( $ps_type . '_title_text', $title_text );
	
					// Remove old option.
					remove_theme_mod( $ps_type . '_page_header_title_text__404' );
				}
			}

			// Process title text for archive pages.
			elseif ( 0 < strpos( $ps_type, '_archive' ) ) {
				// Check if user has filled the custom title text options.
				$title_text = get_theme_mod( $ps_type . '_page_header_title_text__post_type_archive' );

				if ( false !== $title_text ) {
					// Set new option.
					set_theme_mod( $ps_type . '_title_text', $title_text );
					
					// Remove old option.
					remove_theme_mod( $ps_type . '_page_header_title_text__post_type_archive' );
				}
				
				// Check if user ever filled the custom tax title text options.
				$tax_title_text = get_theme_mod( $ps_type . '_page_header_title_text__taxonomy_archive' );

				if ( false !== $tax_title_text ) {
					// Set new option.
					set_theme_mod( $ps_type . '_tax_title_text', $tax_title_text );
					
					// Remove old option.
					remove_theme_mod( $ps_type . '_page_header_title_text__taxonomy_archive' );
				}
			}
		}
	}

	/**
	 * Migrate page header settings to hero section.
	 *
	 * The previous implementation:
	 * - Use "page_header_" prefix.
	 *
	 * The new implementation:
	 * - Use "hero_" prefix.
	 */
	private function migrate_page_header_to_hero_section() {
		/**
		 * Global settings
		 */

		$mods = get_theme_mods();

		// Replace old option keys.
		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, 'page_header_' ) ) {
				$new_key = str_replace( 'page_header_', 'hero_', $key );

				remove_theme_mod( $key );

				set_theme_mod( $new_key, $value );
			}
		}

		// Remove global page header toggle option.
		remove_theme_mod( 'page_header' );

		/**
		 * Page settings
		 */

		$subkeys = array(
			'page_header',
			'page_header_bg',
			'page_header_bg_image',
		);

		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			foreach ( $subkeys as $subkey ) {
				// Check if user has configured the option.
				$value = get_theme_mod( $ps_type . '_' . $subkey );

				if ( false !== $value ) {
					set_theme_mod( $ps_type . '_' . str_replace( 'page_header', 'hero', $subkey ), $value );
				}
			}
		}

		/**
		 * Hero elements
		 *
		 * Use "hero" in the option key, because we have already changed "page_header" to "hero".
		 */

		$locations = array(
			'left', 'center', 'right',
		);

		$alignment = '';
		$has_title = false;
		$has_breadcrumb = false;

		foreach ( $locations as $location ) {
			$elements = get_theme_mod( 'hero_elements_' . $location, array() );

			if ( in_array( 'breadcrumb', $elements ) ) {
				$has_breadcrumb = true;
			}

			if ( in_array( 'title', $elements ) ) {
				$alignment = $location;
			}

			remove_theme_mod( 'hero_elements_' . $location );
		}

		// Assign the elements to all new pages.
		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Skip error 404 page.
			// There is no hero section in the new error 404 page.
			if ( 'error_404' == $ps_type ) {
				continue;
			}

			// Skip search results page.
			// Use the new content header's default because it's the same structure in older version.
			// It's set to "title" and "search-form".
			if ( 'search_results' == $ps_type ) {
				continue;
			}
			
			// Skip archive page.
			// Use the new content header's default because it's the same structure in older version.
			// It's set to "title" and "archive-description".
			if ( 0 < strpos( $ps_type, '_archive' ) ) {
				continue;
			}

			// Add breadcrumb.
			if ( $has_breadcrumb ) {
				set_theme_mod( $ps_type . '_content_header', array_merge(
					array( 'breadcrumb' ),
					suki_get_theme_mod( $ps_type . '_content_header', array() )
				) );
			}

			// Set hero alignment.
			if ( '' !== $alignment ) {
				set_theme_mod( $ps_type . '_hero_alignment', $alignment );
			}
		}
	}

	/**
	 * Migrate some keys on page settings meta box.
	 *
	 * Keys to be changed:
	 * - "content_hide_thumbnail" => "disable_thumbnail".
	 * - "content_hide_title" => "disable_content_header".
	 */
	private function migrate_page_settings_meta_box() {
		// Get all posts in any post type that already have page settings configured.
		$posts = get_posts( array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_suki_page_settings',
			'meta_compare'   => 'EXISTS',
		) );

		foreach ( $posts as $post ) {
			$value = get_post_meta( $post->ID, '_suki_page_settings', true );

			// Featured Image.
			if ( isset( $value['content_hide_thumbnail'] ) ) {
				$value['disable_thumbnail'] = $value['content_hide_thumbnail'];

				unset( $value['content_hide_thumbnail'] );
			}

			// Content header.
			if ( isset( $value['content_hide_title'] ) ) {
				$value['disable_content_header'] = $value['content_hide_title'];

				unset( $value['content_hide_title'] );
			}

			// Update post meta.
			update_post_meta( $post->ID, '_suki_page_settings', $value );
		}
	}

	/**
	 * Migrate page settings keys from array to non array.
	 *
	 * The previous implementation:
	 * - Page settings on each type is saved in an array with "page_settings_{type}[ {key} ]" key. For example: page_settings_post_single['content_layout'].
	 *
	 * The new implementation:
	 * - Page settings on each type is saved in non array with "{type}_{key}". For example: post_single_content_layout.
	 */
	private function migrate_woocommerce_index_settings() {
		/**
		 * Products archive page content header.
		 */

		$elements = array();

		if ( intval( get_theme_mod( 'woocommerce_index_page_breadcrumb', 1 ) ) ) {
			$elements[] = 'breadcrumb';
		}

		if ( intval( get_theme_mod( 'woocommerce_index_page_title', 1 ) ) ) {
			$elements[] = 'title';
		}

		set_theme_mod( 'product_archive_content_header', $elements );

		remove_theme_mod( 'woocommerce_index_page_breadcrumb' );
		remove_theme_mod( 'woocommerce_index_page_title' );
	}
}

Suki_Migrate_1_3_0::instance();