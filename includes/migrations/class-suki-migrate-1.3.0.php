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
		$this->preserve_old_default_typography_styles();
		$this->migrate_page_template_slug();
		$this->migrate_featured_media_to_thumbnail();
		$this->migrate_header_shopping_cart();
		$this->migrate_header_mobile_vertical_bar_full_screen_position();
		$this->migrate_entry_default_to_post_single();
		
		$this->migrate_customizer_page_settings_keys();
		$this->migrate_customizer_page_header_title_text();
		$this->migrate_customizer_page_header_to_hero_section();
		$this->migrate_customizer_content_layout_narrow();

		$this->migrate_meta_box_all_settings();

		$this->migrate_woocommerce_settings();
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
	private function preserve_old_default_typography_styles() {
		if ( false === get_theme_mod( 'body_font_size' ) ) {
			set_theme_mod( 'body_font_size', '15px' );
		}

		if ( false === get_theme_mod( 'h4_font_size' ) ) {
			set_theme_mod( 'h4_font_size', '17px' );
		}
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
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page-builder.php',
		) );

		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page_builder.php' );
		}
	}

	/**
	 * Migrate customizer option keys "featured_media" to "thumbnail".
	 *
	 * The previous implementation:
	 * - Use "featured_media" as slug.
	 * - Use "-entry-header" suffix in the value.
	 *
	 * The new implementation:
	 * - Use "thumbnail" as slug.
	 * - Remove "-entry-header" suffix in the value.
	 */
	private function migrate_featured_media_to_thumbnail() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, '_featured_media' ) ) {
				// Replace "featured_media" with "thumbnail".
				$new_key = str_replace( 'featured_media', 'thumbnail', $key );

				// Remove "-entry-header" in the value.
				$new_value = str_replace( '-entry-header', '', $value );

				// Save the new option.
				set_theme_mod( $new_key, $new_value );

				// Remove the old option.
				remove_theme_mod( $key );
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
			$elements = get_theme_mod( 'header_elements_' . $location, array() );

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
			$elements = get_theme_mod( 'header_mobile_elements_' . $location, array() );
			
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
	 * Split header mobile vertical bar position
	 *
	 * The previous implementation:
	 * - Full screen mode doesn't have dedicated option for "position", and only use the "header_mobile_vertical_bar_position" option.
	 *
	 * The new implementation:
	 * - Full screen mode has dedicated option for "position", named "header_mobile_vertical_bar_full_screen_position".
	 */
	private function migrate_header_mobile_vertical_bar_full_screen_position() {
		// Copy value from "header_mobile_vertical_bar_position" option. 
		set_theme_mod( 'header_mobile_vertical_bar_full_screen_position', get_theme_mod( 'header_mobile_vertical_bar_position' ) );
		
		// If "header_mobile_vertical_bar_position" is set to "center", change to "left".
		if ( 'center' === get_theme_mod( 'header_mobile_vertical_bar_position' ) ) {
			set_theme_mod( 'header_mobile_vertical_bar_position', 'left' );
		}
	}

	/**
	 * Copy the existing settings of Post Layout: Default to the new Single Post Page settings.
	 *
	 * The previous implementation:
	 * - There is no dedicated Single Post Page settings, it automatically inherits from the Post Layout: Default settings.
	 *
	 * The new implementation:
	 * - There are dedicated settings for Single Post Page, we will copy the previous configured Post Layout: Default settings to these new settings.
	 */
	private function migrate_entry_default_to_post_single() {
		$keys = array(
			'entry_header',
			'entry_header_alignment',
			'entry_header_meta',
			'entry_thumbnail_position',
			'entry_footer',
			'entry_footer_alignment',
			'entry_footer_meta',
		);

		foreach ( $keys as $key ) {
			$value = get_theme_mod( $key );

			if ( false !== $value ) {
				set_theme_mod( str_replace( 'entry_', 'post_single_content_', $key ), $value );
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
	private function migrate_customizer_page_settings_keys() {
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
	 * Migrate all page header title text option keys.
	 *
	 * Why:
	 * The title text should affect the content header title as well not just the page header title.
	 */
	private function migrate_customizer_page_header_title_text() {
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
	private function migrate_customizer_page_header_to_hero_section() {
		/**
		 * Global settings
		 */

		$mods = get_theme_mods();

		// Replace old option keys.
		foreach ( $mods as $key => $value ) {
			if ( 0 === strpos( $key, 'page_header' ) ) {
				$new_key = str_replace( 'page_header', 'hero', $key );

				remove_theme_mod( $key );

				set_theme_mod( $new_key, $value );
			}
		}

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

		if ( intval( get_theme_mod( 'hero' ) ) ) {
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
	
				// Add breadcrumb if specified.
				if ( $has_breadcrumb ) {
					set_theme_mod( $ps_type . '_content_header', array_merge(
						array( 'breadcrumb' ),
						suki_get_theme_mod( $ps_type . '_content_header', array() ) // Get default value
					) );
				}
	
				// Set hero alignment.
				if ( '' !== $alignment ) {
					set_theme_mod( $ps_type . '_content_header_alignment', $alignment );
				}
			}
		} else {
			foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
				set_theme_mod( $ps_type . '_content_header_alignment', 'left' );
			}
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
	private function migrate_customizer_content_layout_narrow() {
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
	 * Migrate some keys on page settings meta box.
	 *
	 * Keys to be changed:
	 * - "content_hide_thumbnail" => "disable_thumbnail".
	 * - "content_hide_title" => "disable_content_header".
	 * - "page_header" => "hero".
	 */
	private function migrate_meta_box_all_settings() {
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

			// Hero section.
			if ( isset( $value['page_header'] ) ) {
				$value['hero'] = $value['page_header'];

				unset( $value['page_header'] );
			}

			// Narrow content container.
			if ( isset( $value['content_layout'] ) && 'narrow' === $value['content_layout'] ) {
				$value['content_layout'] = 'wide';
				$value['content_container'] = 'narrow';
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
	private function migrate_woocommerce_settings() {
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

		$elements[] = 'archive-description';

		set_theme_mod( 'product_archive_content_header', $elements );

		remove_theme_mod( 'woocommerce_index_page_breadcrumb' );
		remove_theme_mod( 'woocommerce_index_page_title' );

		/**
		 * Single product page content header.
		 */

		$elements = array();

		if ( intval( get_theme_mod( 'woocommerce_single_breadcrumb', 1 ) ) ) {
			$elements[] = 'breadcrumb';
		}

		set_theme_mod( 'product_single_content_header', $elements );

		remove_theme_mod( 'woocommerce_single_breadcrumb' );
	}
}

Suki_Migrate_1_3_0::instance();