<?php
/**
 * Suki Admin page basic functions
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin
	 */
	private static $instance;

	/**
	 * Parent menu slug of all theme pages
	 *
	 * @var string
	 */
	private $_menu_id = 'suki';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Admin
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
		// General admin hooks on every admin pages
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_javascripts' ) );

		add_action( 'admin_notices', array( $this, 'add_rating_notice' ) );
		add_action( 'wp_ajax_suki_rating_notice_close', array( $this, 'ajax_dismiss_rating_notice' ) );
		add_action( 'after_switch_theme', array( $this, 'reset_rating_notice_flag' ) );

		// Classic editor hooks
		add_action( 'admin_init', array( $this, 'add_editor_css' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_custom_css' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_body_class' ) );
		add_filter( 'block_editor_settings', array( $this, 'add_gutenberg_custom_css' ) );

		// Suki admin page hooks
		add_action( 'suki/admin/dashboard/logo', array( $this, 'render_logo__image' ), 10 );
		add_action( 'suki/admin/dashboard/logo', array( $this, 'render_logo__version' ), 20 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__welcome_panel' ), 1 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__pro_modules_table' ), 20 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__customizer' ), 10 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__pro' ), 20 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__documentation' ), 30 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__community' ), 40 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__feedback' ), 50 );
		
		$this->_includes();
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		require_once( SUKI_INCLUDES_DIR . '/admin/class-suki-admin-fields.php' );

		// Only include metabox on post add/edit page and term add/edit page.
		global $pagenow;
		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ) ) ) {
			require_once( SUKI_INCLUDES_DIR . '/admin/class-suki-admin-metabox-page-settings.php' );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Suki.
	 */
	public function register_admin_menu() {
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'render_admin_page' )
		);

		/**
		 * Hook: suki/admin/menu
		 */
		do_action( 'suki/admin/menu' );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_styles( $hook ) {
		/**
		 * Hook: Styles to be included before admin CSS
		 */
		do_action( 'suki/admin/before_enqueue_admin_css', $hook );

		// Enqueue CSS files
		wp_enqueue_style( 'suki-admin', SUKI_CSS_URL . '/admin/admin.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-admin', 'rtl', 'replace' );

		/**
		 * Hook: Styles to be included after admin CSS
		 */
		do_action( 'suki/admin/after_enqueue_admin_css', $hook );
	}

	/**
	 * Enqueue admin javascripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['wp-color-picker-alpha'] = '2.1.3';

		/**
		 * Hook: Styles to be included before admin JS
		 */
		do_action( 'suki/admin/before_enqueue_admin_js', $hook );

		// Register JS files
		wp_register_script( 'wp-color-picker-alpha', SUKI_JS_URL . '/vendors/wp-color-picker-alpha' . SUKI_ASSETS_SUFFIX . '.js', array( 'wp-color-picker' ), $ver['wp-color-picker-alpha'], true );

		// Enqueue JS files.
		wp_enqueue_script( 'suki-admin', SUKI_JS_URL . '/admin/admin' . SUKI_ASSETS_SUFFIX . '.js', array( 'jquery' ), SUKI_VERSION, true );

		/**
		 * Hook: Styles to be included after admin JS
		 */
		do_action( 'suki/admin/after_enqueue_admin_js', $hook );
	}

	/**
	 * Add notice to give rating on WordPress.org.
	 */
	public function add_rating_notice() {
		$time_interval = strtotime( '-7 days' );

		$installed_time = get_option( 'suki_installed_time' );
		if ( ! $installed_time ) {
			$installed_time = time();
			update_option( 'suki_installed_time', $installed_time );
		}

		// Abort if:
		// - Suki is installed less than 7 days.
		// - The notice is already dismissed before.
		// - Current user can't manage options.
		if ( $installed_time > $time_interval || intval( get_option( 'suki_rating_notice_is_dismissed', 0 ) ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>
		<div class="notice notice-info suki-rating-notice">
			<p><?php esc_html_e( 'Hey, it\'s me David from Suki WordPress theme. I noticed you\'ve been using Suki to build your website - that\'s awesome!', 'suki' ); ?><br><?php esc_html_e( 'Could you do us a BIG favor and give it a 5-star rating on WordPress.org? It would boost our motivation to keep adding new features in the future.', 'suki' ); ?></p>
			<p>
				<a href="https://wordpress.org/support/theme/suki/reviews/?rate=5#new-post" class="button button-primary" target="_blank"><?php esc_html_e( 'Okay, you deserve it', 'suki' ); ?></a>&nbsp;&nbsp;&nbsp;
				<a href="#" class="suki-rating-notice-close button-link" data-suki-rating-notice-repeat="<?php echo esc_attr( $time_interval ); ?>"><?php esc_html_e( 'Nope, maybe later', 'suki' ); ?></a>&nbsp;&nbsp;&nbsp;
				<a href="#" class="suki-rating-notice-close button-link" data-suki-rating-notice-repeat="-1"><?php esc_html_e( 'I already did', 'suki' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Reset theme installed time, for rating notice purpose.
	 */
	public function reset_rating_notice_flag() {
		update_option( 'suki_installed_time', time() );
		update_option( 'suki_rating_notice_is_dismissed', 0 );
	}

	/**
	 * Add CSS for editor page.
	 */
	public function add_editor_css() {
		add_editor_style( SUKI_CSS_URL . '/admin/editor' . SUKI_ASSETS_SUFFIX . '.css' );

		wp_enqueue_style( 'suki-editor-google-fonts', Suki_Customizer::instance()->generate_active_google_fonts_embed_url() );
	}

	/**
	 * Add custom CSS to classic editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_classic_editor_custom_css( $settings ) {
		// echo 'halo';
		global $post;

		if ( empty( $post ) ) {
			return $settings;
		}

		$css_array = array(
			'global' => array(),
		);

		// TinyMCE HTML
		$css_array['global']['html']['background-color'] = '#fcfcfc';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
		);
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = suki_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = suki_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}
			
			// Font style
			$font_style = suki_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}
			
			// Text transform
			$text_transform = suki_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = suki_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = suki_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = suki_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Content wrapper width for content layout with sidebar
		$css_array['global']['body.suki-editor-left-sidebar']['width'] =
		$css_array['global']['body.suki-editor-right-sidebar']['width'] = 'calc(' . suki_get_content_width_by_layout() . 'px + 2rem)';

		// Content wrapper width for narrow content layout
		$css_array['global']['body.suki-editor-narrow']['width'] = 'calc(' . suki_get_content_width_by_layout( 'narrow' ) . 'px + 2rem)';

		// Content wrapper width for full content layout
		$css_array['global']['body.suki-editor-wide']['width'] = 'calc(' . suki_get_content_width_by_layout( 'wide' ) . 'px + 2rem)';

		// Build CSS string.
		// $styles = str_replace( '"', '\"', suki_convert_css_array_to_string( $css_array ) );
		$styles = wp_slash( suki_convert_css_array_to_string( $css_array ) );

		// Merge with existing styles or add new styles.
		if ( ! isset( $settings['content_style'] ) ) {
			$settings['content_style'] = $styles . ' ';
		} else {
			$settings['content_style'] .= ' ' . $styles . ' ';
		}

		return $settings;
	}

	/**
	 * Add body class to classic editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_classic_editor_body_class( $settings ) {
		global $post;

		if ( empty( $post ) ) {
			return $settings;
		}

		$class = 'suki-editor-' . suki_get_page_setting_by_post_id( 'content_layout', $post->ID );

		// Merge with existing classes or add new class.
		if ( ! isset( $settings['body_class'] ) ) {
			$settings['body_class'] = $class . ' ';
		} else {
			$settings['body_class'] .= ' ' . $class . ' ';
		}

		return $settings;
	}

	/**
	 * Add custom CSS to Gutenberg editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_gutenberg_custom_css( $settings ) {
		$css_array = array();

		// Content width
		$css_array['global']['.wp-block']['max-width'] = 'calc(' . suki_get_theme_mod( 'content_narrow_width' ) . ' + ' . '30px)';
		$css_array['global']['.wp-block[data-align="wide"]']['max-width'] = 'calc(' . suki_get_theme_mod( 'container_width' ) . ' + ' . '30px)';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1, .editor-post-title__block .editor-post-title__input',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'title' => '.editor-post-title__block .editor-post-title__input',
		);
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = suki_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = suki_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}
			
			// Font style
			$font_style = suki_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}
			
			// Text transform
			$text_transform = suki_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = suki_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = suki_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = suki_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Add to settings array.
		$settings['styles'][] = array(
			'css' => suki_convert_css_array_to_string( $css_array ),
		);

		return $settings;
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to dismiss rating notice.
	 */
	public function ajax_dismiss_rating_notice() {
		$repeat_after = ( isset( $_REQUEST['repeat_after'] ) ) ? intval( $_REQUEST['repeat_after'] ) : false;

		if ( -1 == $repeat_after ) {
			// Dismiss rating notice forever.
			update_option( 'suki_rating_notice_is_dismissed', 1 );
		} else {
			// Repeat rating notice later.
			update_option( 'suki_installed_time', time() );
		}

		wp_send_json_success();
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap suki-admin-wrap">
			<div class="suki-admin-header">
				<div class="suki-admin-wrapper wp-clearfix">
					<div class="suki-admin-logo">
						<?php
						/**
						 * Hook: suki/admin/dashboard/logo
						 *
						 * @hooked Suki_Admin::render_logo__image - 10
						 * @hooked Suki_Admin::render_logo__version - 20
						 */
						do_action( 'suki/admin/dashboard/logo' );
						?>
					</div>
				</div>
			</div>

			<div class="suki-admin-notices">
				<div class="suki-admin-wrapper">
					<h1 style="display: none;"></h1>

					<?php settings_errors(); ?>
				</div>
			</div>

			<div class="suki-admin-content metabox-holder">
				<div class="suki-admin-wrapper">
					<div class="suki-admin-content-row">
						<div class="suki-admin-primary">
							<?php
							/**
							 * Hook: suki/admin/dashboard/content
							 *
							 * @hooked Suki_Admin::render_content__welcome_panel - 1
							 * @hooked Suki_Admin::render_content__quick_links - 5
							 * @hooked Suki_Admin::render_content__pro_modules_table - 20
							 */
							do_action( 'suki/admin/dashboard/content' );
							?>
						</div>

						<?php if ( has_action( 'suki/admin/dashboard/sidebar' ) ) : ?>
							<div class="suki-admin-secondary">
								<?php
								/**
								 * Hook: suki/admin/dashboard/sidebar
								 *
								 * @hooked Suki_Admin::render_sidebar__customizer - 10
								 * @hooked Suki_Admin::render_sidebar__pro - 20
								 * @hooked Suki_Admin::render_sidebar__documentation - 30
								 * @hooked Suki_Admin::render_sidebar__community - 40
								 * @hooked Suki_Admin::render_sidebar__feedback - 50
								 */
								do_action( 'suki/admin/dashboard/sidebar' );
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render logo on Suki admin page's content.
	 */
	public function render_logo__image() {
		?>
		<img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ); ?>" height="30" alt="<?php echo esc_attr( get_admin_page_title() ); ?>">
		<?php
	}

	/**
	 * Render logo on Suki admin page's content.
	 */
	public function render_logo__version() {
		?>
		<span class="suki-admin-version"><?php echo suki_get_theme_info( 'version' ); // WPCS: XSS OK ?></span>
		<?php
	}

	/**
	 * Render welcome panel on Suki admin page's content.
	 */
	public function render_content__welcome_panel() {
		?>
		<div class="suki-admin-welcome-panel welcome-panel">
			<div class="welcome-panel-content">
				<h2><?php esc_html_e( 'Welcome to Suki!', 'suki' ); ?></h2>
				<p class="about-description">
					<?php echo wp_kses_post(
						sprintf(
							/* translators: %s: Suki website URL. */
							__( 'Your website is now in good hands! Suki offers highly customizable design and lightning fast performance. Learn more about its full features and premium modules at <a href="%s">our website</a>.', 'suki' ),
							esc_url( suki_get_theme_info( 'url' ) )
						)
					); ?>
				</p>
				<h3><?php esc_html_e( 'Quick Links to Customizer', 'suki' ); ?></h3>
				<div class="welcome-panel-column-container">
					<?php
					$links = array(
						array(
							'label' => esc_html__( 'Page Layout', 'suki' ),
							'query' => array( 'autofocus[section]' => 'suki_section_page_container' ),
						),
						array(
							'label' => esc_html__( 'General Elements', 'suki' ),
							'query' => array( 'autofocus[panel]' => 'suki_panel_global_elements' ),
						),
						array(
							'label' => esc_html__( 'Header Builder', 'suki' ),
							'query' => array( 'autofocus[panel]' => 'suki_panel_header' ),
						),
						array(
							'label' => esc_html__( 'Page Header (Title Bar)', 'suki' ),
							'query' => array( 'autofocus[panel]' => 'suki_section_page_header' ),
						),
						array(
							'label' => esc_html__( 'Content & Sidebar', 'suki' ),
							'query' => array( 'autofocus[panel]' => 'suki_panel_content' ),
						),
						array(
							'label' => esc_html__( 'Footer Builder', 'suki' ),
							'query' => array( 'autofocus[panel]' => 'suki_panel_footer' ),
						),
					);
					?>
					<?php foreach ( $links as $i => $link ) : ?>
						<?php if ( 0 === $i % 3 ) : ?>
							<div class="welcome-panel-column">
								<ul>
						<?php endif; ?>
								<li><a href="<?php echo esc_attr( add_query_arg( $link['query'], admin_url( 'customize.php' ) ) ); ?>"><?php echo $link['label']; // WPCS: XSS OK. ?></a></li>
						<?php if ( 2 === $i % 3 ) : ?>
								</ul>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render pro modules table on Suki admin page's content.
	 */
	public function render_content__pro_modules_table() {
		?>
		<div class="suki-admin-pro-modules postbox">
			<h2 class="hndle">
				<?php echo wp_kses_post( apply_filters( 'suki/pro/modules/list_heading', esc_html__( 'More features are available on Suki Pro', 'suki' ) ) ); ?>
			</h2>
			<div class="inside">
				<?php
				// Get all pro modules list.
				$modules = suki_get_pro_modules();

				// Get active modules from DB.
				$active_modules = get_option( 'suki_pro_active_modules', array() );
				?>
				<table class="suki-admin-pro-table widefat plugins">
					<tbody>
						<?php foreach( $modules as $module_slug => $module_data ) : ?>
							<tr class="suki-admin-pro-table-item <?php echo esc_attr( suki_is_pro() && suki_array_value( $module_data, 'active' ) ? 'active' : 'inactive' ); ?>">
								<th class="check-column"></th>
								<td class="suki-admin-pro-table-item-name plugin-title column-primary">
									<span><?php echo suki_array_value( $module_data, 'label' ); // WPCS: XSS OK ?></span>
								</td>
								<td class="suki-admin-pro-table-item-actions column-description desc">
									<?php if ( ! suki_is_pro() ) : ?>

										<a href="<?php echo esc_url( suki_array_value( $module_data, 'url' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Learn more', 'suki' ); ?></a>

									<?php elseif ( 0 < count( suki_array_value( $module_data, 'actions' ) ) ) : ?>

										<?php
										foreach( suki_array_value( $module_data, 'actions' ) as $action_key => $action_data ) :
											if ( isset( $action_data['url'] ) ) :
											?>
												<a href="<?php echo esc_url( suki_array_value( $action_data, 'url' ) ); ?>"><?php echo suki_array_value( $action_data, 'label' ); // WPCS: XSS OK ?></a>
											<?php else : ?>
												<span class="suki-admin-pro-table-item-unavailable"><?php echo esc_html( $action_data['label'] ); ?></span>
											<?php
											endif;
										endforeach;
										?>

									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Go to Customizer" button on Suki admin page's sidebar.
	 */
	public function render_sidebar__customizer() {
		?>
		<div class="suki-admin-secondary-customize">
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="suki-admin-customize-button button button-hero button-primary">
				<?php esc_html_e( 'Go to Customizer', 'suki' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render "Suki Pro" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__pro() {
		if ( suki_is_pro() ) return;
		?>
		<div class="suki-admin-secondary-pro postbox">
			<h2 class="hndle"><?php esc_html_e( 'Premium Modules', 'suki' ); ?> <span><?php esc_html_e( 'Suki Pro', 'suki' ); ?></span></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Get more flexibility and stunning design options on Suki Pro, available in a very affordable price.', 'suki' ); ?></p>
				<p>
					<a href="<?php echo esc_url( SUKI_PRO_URL ); ?>" class="button button-large button-primary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-admin-network"></span>
						<?php echo esc_html_x( 'Upgrade to Pro', 'Suki Pro upsell', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Documentation" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__documentation() {
		?>
		<div class="suki-admin-secondary-docs postbox">
			<h2 class="hndle"><?php esc_html_e( 'Documentation', 'suki' ); ?></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Not sure how something works? Our documentation might help you figure out the solution.', 'suki' ); ?></p>
				<p>
					<a href="https://docs.sukiwp.com/" class="button button-secondary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-book-alt"></span>
						<?php esc_html_e( 'Go to Documentation', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Suki Community" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__community() {
		?>
		<div class="suki-admin-secondary-fb-group postbox">
			<h2 class="hndle"><?php esc_html_e( 'Suki Community', 'suki' ); ?></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Join our Facebook group for latest updates info and discussions with other Suki users.', 'suki' ); ?></p>
				<p>
					<a href="https://facebook.com/groups/sukiwp/" class="button button-secondary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-facebook"></span>
						<?php esc_html_e( 'Join our Facebook Group', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Feedback" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__feedback() {
		?>
		<div class="suki-admin-secondary-rate postbox">
			<h2 class="hndle"><?php esc_html_e( 'Enjoy Suki?', 'suki' ); ?></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Please take a minute to leave a review on Suki, we would really appreciate it!', 'suki' ); ?></p>
				<p>
					<a href="https://wordpress.org/support/theme/suki/reviews/?rate=5#new-post" class="button button-secondary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-thumbs-up"></span>
						<?php esc_html_e( 'Rate us &#9733;&#9733;&#9733;&#9733;&#9733;', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}
}

Suki_Admin::instance();