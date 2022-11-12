<?php
/**
 * Migrate to 2.0.0
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migration class for Suki 2.0.0.
 */
class Suki_Migrate_2_0_0 extends Suki_Migrate {
	/**
	 * Version
	 *
	 * @var string
	 */
	const VERSION = '2.0.0';

	/**
	 * ====================================================
	 * Migration functions
	 * ====================================================
	 */

	/**
	 * Run migration
	 */
	protected function run() {
		$this->migrate_page_settings_meta_key();

		$this->migrate_selected_google_fonts();

		$this->migrate_all_font_families_values();

		$this->migrate_all_line_height_values();

		$this->migrate_container_keys();

		$this->migrate_container_values();

		$this->migrate_content_layout_values();

		$this->migrate_blog_index_keys();

		$this->migrate_disable_mobile_header_key();

		$this->migrate_post_archive_navigation_mode_value();

		$this->migrate_heading_title_hover_color_keys();

		$this->migrate_gutter();
	}

	/**
	 * Migrate `_suki_page_settings` post meta key to `suki_page_settings`.
	 *
	 * Array post meta doesn't need to use `_` prefix, because it's automatically hidden.
	 * ref: https://developer.wordpress.org/plugins/metadata/managing-post-metadata/#hidden-arrays
	 */
	private function migrate_page_settings_meta_key() {
		global $wpdb;

		$updated = $wpdb->update(
			$wpdb->prefix . 'postmeta',
			array(
				'meta_key' => 'suki_page_settings',
			),
			array(
				'meta_key' => '_suki_page_settings',
			)
		);

		return $updated;
	}

	/**
	 * Migrate Google Fonts list.
	 *
	 * Select all typography settings in the Customizer that are using Google Fonts.
	 * Populate the fonts to the new "Active Google Fonts" setting.
	 */
	private function migrate_selected_google_fonts() {
		$mods = get_theme_mods();

		$google_fonts = array();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, '_font_family' ) && 0 === strpos( $value, 'google_fonts' ) ) {
				$google_fonts[] = str_replace( 'google_fonts|', '', $value );
			}
		}

		// Save all detected Google Fonts to the new "Active Google Fonts" setting.
		set_theme_mod( 'google_fonts', $google_fonts );
	}

	/**
	 * Migrate all font families values.
	 *
	 * Remove the prefix `web_safe_fonts|`, `google_fonts|`, and `custom_fonts|` from the values.
	 */
	private function migrate_all_font_families_values() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, '_font_family' ) ) {
				$new_value = preg_replace( '/(web_safe_fonts|google_fonts|custom_fonts)\|/', '', $value );

				set_theme_mod( $key, $new_value );
			}
		}
	}

	/**
	 * Migrate all line height values.
	 *
	 * Add `em` unit to numeric only value (e.g. `1.5` becomes `1.5em`).
	 */
	private function migrate_all_line_height_values() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, '_line_height' ) ) {
				$new_value = $value . 'em';

				set_theme_mod( $key, $new_value );
			}
		}
	}

	/**
	 * Migrate container option keys
	 *
	 * Change `narrow_content_width` to `container_narrow_width`.
	 * Change `container_width` to `container_wide_width`.
	 */
	private function migrate_container_keys() {
		if ( false !== get_theme_mod( 'narrow_content_width' ) ) {
			set_theme_mod( 'container_narrow_width', get_theme_mod( 'narrow_content_width' ) );
			remove_theme_mod( 'narrow_content_width' );
		}

		if ( false !== get_theme_mod( 'container_width' ) ) {
			set_theme_mod( 'container_wide_width', get_theme_mod( 'container_width' ) );
			remove_theme_mod( 'container_width' );
		}
	}

	/**
	 * Migrate container values
	 *
	 * Change `default` to `wide`.
	 * Change `full-width` to `full`.
	 */
	private function migrate_container_values() {
		/**
		 * Customizer values
		 */

		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, '_container' ) ) {
				if ( 'default' === $value ) {
					set_theme_mod( $key, 'wide' );
				} elseif ( 'full-width' === $value ) {
					set_theme_mod( $key, 'full' );
				}
			}
		}

		/**
		 * Meta values
		 */

		// Get all posts in any post type that already have page settings configured.
		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => 'suki_page_settings',
				'meta_compare'   => 'EXISTS',
			)
		);
		foreach ( $posts as $post ) {
			$value = get_post_meta( $post->ID, 'suki_page_settings', true );

			foreach ( $value as $key => $value ) {
				if ( isset( $value['hero_container'] ) ) {
					switch ( $value['hero_container'] ) {
						case 'default':
							$value['hero_container'] = 'wide';
							break;

						case 'full-width':
							$value['hero_container'] = 'full';
							break;
					}

					// Update post meta.
					update_post_meta( $post->ID, 'suki_page_settings', $value );
				}

				if ( isset( $value['content_container'] ) ) {
					switch ( $value['content_container'] ) {
						case 'default':
							$value['content_container'] = 'wide';
							break;

						case 'full-width':
							$value['content_container'] = 'full';
							break;
					}

					// Update post meta.
					update_post_meta( $post->ID, 'suki_page_settings', $value );
				}
			}
		}
	}

	/**
	 * Migrate content layout values
	 *
	 * Change `wide` to `no-sidebar`.
	 */
	private function migrate_content_layout_values() {
		/**
		 * Customizer values
		 */

		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, '_content_layout' ) && 'wide' === $value ) {
				set_theme_mod( $key, 'no-sidebar' );
			}
		}

		/**
		 * Meta values
		 */

		// Get all posts in any post type that already have page settings configured.
		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => 'suki_page_settings',
				'meta_compare'   => 'EXISTS',
			)
		);
		foreach ( $posts as $post ) {
			$value = get_post_meta( $post->ID, 'suki_page_settings', true );

			if ( isset( $value['content_layout'] ) ) {
				if ( 'wide' === $value['content_layout'] ) {
					$value['content_layout'] = 'no-sidebar';
				}

				// Update post meta.
				update_post_meta( $post->ID, 'suki_page_settings', $value );
			}
		}
	}

	/**
	 * Migrate `blog_index_...` to `post_archive_...`.
	 */
	private function migrate_blog_index_keys() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_starts_with( $key, 'blog_index_' ) ) {
				set_theme_mod( str_replace( 'blog_index_', 'post_archive_', $key ), $value );
				remove_theme_mod( $key );
			}
		}
	}

	/**
	 * Migrate `disable_mobile_header` to `disable_header_mobile`.
	 */
	private function migrate_disable_mobile_header_key() {
		/**
		 * Customizer values
		 */

		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, 'disable_mobile_header' ) ) {
				set_theme_mod( str_replace( 'disable_mobile_header', 'disable_header_mobile', $key ), $value );
				remove_theme_mod( $key );
			}
		}

		/**
		 * Meta values
		 */

		// Get all posts in any post type that already have page settings configured.
		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => 'suki_page_settings',
				'meta_compare'   => 'EXISTS',
			)
		);
		foreach ( $posts as $post ) {
			$value = get_post_meta( $post->ID, 'suki_page_settings', true );

			if ( isset( $value['disable_mobile_header'] ) ) {
				$value['disable_header_mobile'] = $value['disable_mobile_header'];
				unset( $value['disable_mobile_header'] );

				// Update post meta.
				update_post_meta( $post->ID, 'suki_page_settings', $value );
			}
		}
	}

	/**
	 * Migrate navigation mode value from `pagination` to `page-numbers`.
	 */
	private function migrate_post_archive_navigation_mode_value() {
		// `blog_index_...` is already migrated to `post_archive_...`.
		if ( 'pagination' === get_theme_mod( 'post_archive_navigation_mode' ) ) {
			set_theme_mod( 'post_archive_navigation_mode', 'page-numbers' );
		}
	}

	/**
	 * Migrate heading, title, and small title's link hover color.
	 */
	private function migrate_heading_title_hover_color_keys() {
		if ( false !== get_theme_mod( 'heading_hover_text_color' ) ) {
			set_theme_mod( 'heading_link_hover_text_color', get_theme_mod( 'heading_hover_text_color' ) );
			remove_theme_mod( 'heading_hover_text_color' );
		}

		if ( false !== get_theme_mod( 'title_hover_text_color' ) ) {
			set_theme_mod( 'title_link_hover_text_color', get_theme_mod( 'title_hover_text_color' ) );
			remove_theme_mod( 'title_hover_text_color' );
		}

		if ( false !== get_theme_mod( 'small_title_hover_text_color' ) ) {
			set_theme_mod( 'small_title_link_hover_text_color', get_theme_mod( 'small_title_hover_text_color' ) );
			remove_theme_mod( 'small_title_hover_text_color' );
		}
	}

	/**
	 * Migrate `..._gutter` to `..._gap`.
	 */
	private function migrate_gutter() {
		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( str_ends_with( $key, '_gutter' ) ) {
				$number = floatval( $value );
				$unit   = str_replace( $number, '', $value );

				$new_value = ( $number * 2 ) . $unit;

				set_theme_mod( str_replace( 'gutter', 'gap', $key ), $new_value );
				remove_theme_mod( $key );
			}
		}
	}
}

Suki_Migrate_2_0_0::instance();
