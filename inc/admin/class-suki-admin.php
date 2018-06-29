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
		$this->_includes();

		// General admin hooks on every admin pages
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'upload_mimes', array( $this, 'upload_mimes' ) );
		add_filter( 'user_contactmethods', array( $this, 'add_user_contactmethods' ) );
		// add_action( 'admin_notices', array( $this, 'add_theme_notice' ), 99 );

		// Classic editor hooks
		add_action( 'admin_init', array( $this, 'add_editor_css' ) );
		add_action( 'tiny_mce_before_init', array( $this, 'modify_tiny_mce_config' ) );

		// Suki admin page hooks
		add_action( 'suki_admin_page_content', array( $this, 'render_content__welcome_panel' ), 1 );
		add_action( 'suki_admin_page_content', array( $this, 'render_content__pro_modules_table' ), 20 );
		add_action( 'suki_admin_page_sidebar', array( $this, 'render_sidebar__customizer' ), 10 );
		add_action( 'suki_admin_page_sidebar', array( $this, 'render_sidebar__pro' ), 20 );
		add_action( 'suki_admin_page_sidebar', array( $this, 'render_sidebar__documentation' ), 30 );
		add_action( 'suki_admin_page_sidebar', array( $this, 'render_sidebar__community' ), 40 );
		add_action( 'suki_admin_page_sidebar', array( $this, 'render_sidebar__feedback' ), 50 );
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-fields.php' );
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-metabox-page-settings.php' );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Suki > About.
	 */
	public function register_admin_menu() {
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'admin_page' )
		);
	}

	/**
	 * Add admin notice to import data like screenshot.
	 */
	public function add_theme_notice() {
		global $hook_suffix;

		if ( 'themes.php' == $hook_suffix ) : ?>
			<div class="suki-admin-theme-notice notice notice-info">
				<div class="suki-admin-theme-notice-arrow"></div>
				<p>
					<?php esc_html_e( 'Fell in love with this screenshot? Learn how to replicate same design as the screenscrot.', 'suki' ); ?>&nbsp;
					<a href=""></a>
				</p>
			</div>
			<script type="text/javascript">
				(function($) {
					$(function() {
						$( '.suki-admin-theme-notice' ).insertBefore( $( '.theme-browser' ) );
					});
				})( jQuery );
			</script>
		<?php endif;
	}

	/**
	 * Enqueue scripts for all Admin page.
	 *
	 * @param string $hook
	 */
	public function admin_enqueue_scripts( $hook ) {
		// Register JS files
		wp_register_script( 'wp-color-picker-alpha', SUKI_JS_URL . '/vendors/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '2.1.3', true );
		wp_enqueue_script( 'suki-admin', SUKI_JS_URL . '/admin/admin.js', array( 'jquery' ), SUKI_VERSION, true );

		// Register CSS files
		wp_enqueue_style( 'suki-admin', SUKI_CSS_URL . '/admin/admin.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-admin', 'rtl', 'replace' );
	}

	/**
	 * Change footer text on all Suki admin pages.
	 *
	 * @param array $mimes
	 * @return array
	 */
	public function upload_mimes( $mimes ) {
		$mimes['otf'] = 'application/x-font-otf';
		$mimes['woff2'] = 'application/x-font-woff2';
		$mimes['woff'] = 'application/x-font-woff';
		$mimes['ttf'] = 'application/x-font-ttf';
		$mimes['svg'] = 'image/svg+xml';
		$mimes['eot'] = 'application/vnd.ms-fontobject';

		return $mimes;
	}

	/**
	 * Add social media link options to user profile edit page.
	 * 
	 * @param array $contactmethods
	 * @return array
	 */
	public function add_user_contactmethods( $contactmethods ) {
		$contact_types = apply_filters( 'suki_user_contact_types', array(
			'facebook'    => esc_html__( 'Facebook', 'suki' ),
			'instagram'   => esc_html__( 'Instagram', 'suki' ),
			'linkedin'    => esc_html__( 'LinkedIn', 'suki' ),
			'twitter'     => esc_html__( 'Twitter', 'suki' ),
			'google-plus' => esc_html__( 'Google Plus', 'suki' ),
		) );

		foreach ( suki_get_social_media_types() as $key => $value ) {
			$contactmethods[ $key ] = $value . esc_html__( ' URL', 'suki' );
		}

		return $contactmethods;
	}

	/**
	 * Add CSS for editor page.
	 */
	public function add_editor_css() {
		add_editor_style( SUKI_CSS_URL . '/admin/editor' . SUKI_ASSETS_SUFFIX . '.css' );
		add_editor_style( Suki_Customizer::instance()->generate_google_fonts_embed_url() );
	}

	/**
	 * Modify TinyMCE configurations.
	 * - Add dymanic CSS for editor page.
	 * - Add content layout body class.
	 *
	 * @param array $mceinit
	 * @return array
	 */
	public function modify_tiny_mce_config( $mceinit ) {
		/**
		 * Add dynamic CSS.
		 */

		$css_array = array(
			'global' => array(),
		);

		// Typography
		$active_google_fonts = array();
		$typography_types = array( 'body', 'blockquote', 'h1', 'h2', 'h3', 'h4' );
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type ) {
			$selected_font_family = suki_get_theme_mod( $type . '_font_family' );

			if ( '' === $selected_font_family || 'inherit' === $selected_font_family ) {
				$select_font_stack = $selected_font_family;
			} else {
				$chunks = explode( '|', $selected_font_family );
				if ( 2 === count( $chunks ) ) {
					$select_font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}

			$css_array['global'][ $type ]['font-family'] = $select_font_stack;
			$css_array['global'][ $type ]['font-weight'] = suki_get_theme_mod( $type . '_font_weight' );
			$css_array['global'][ $type ]['font-style'] = suki_get_theme_mod( $type . '_font_style' );
			$css_array['global'][ $type ]['text-transform'] = suki_get_theme_mod( $type . '_text_transform' );
			$css_array['global'][ $type ]['font-size'] = suki_get_theme_mod( $type . '_font_size' );
			$css_array['global'][ $type ]['line-height'] = suki_get_theme_mod( $type . '_line_height' );
			$css_array['global'][ $type ]['letter-spacing'] = suki_get_theme_mod( $type . '_letter_spacing' );
		}

		// Container width for content layout with sidebar
		$css_array['global']['body']['max-width'] = suki_get_content_width_by_layout() . 'px';

		// Container width for narrow content layout
		$css_array['global']['body.suki-editor-narrow']['max-width'] = suki_get_content_width_by_layout( 'narrow' ) . 'px';

		// Container width for wide content layout
		$css_array['global']['body.suki-editor-wide']['max-width'] = suki_get_content_width_by_layout( 'wide' ) . 'px';

		// Build CSS string.
		// $styles = str_replace( '"', '\"', suki_convert_css_array_to_string( $css_array ) );
		$styles = wp_slash( suki_convert_css_array_to_string( $css_array ) );

		// Merge with existing styles or add new styles.
		if ( ! isset( $mceinit['content_style'] ) ) {
			$mceinit['content_style'] = $styles . ' ';
		} else {
			$mceinit['content_style'] .= ' ' . $styles . ' ';
		}

		/**
		 * Add body class.
		 */
		
		global $post;

		$class = 'suki-editor-' . suki_get_page_setting_by_post_id( 'content_layout', $post );

		// Merge with existing classes or add new class.
		if ( ! isset( $mceinit['body_class'] ) ) {
			$mceinit['body_class'] = $class . ' ';
		} else {
			$mceinit['body_class'] .= ' ' . $class . ' ';
		}

		return $mceinit;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	public function admin_page() {
		?>
		<div class="wrap suki-admin-wrap">
			<div class="suki-admin-header">
				<div class="suki-admin-wrapper wp-clearfix">
					<div class="suki-admin-logo">
						<img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ); ?>" height="30" alt="<?php echo esc_attr( get_admin_page_title() ); ?>">
						<span class="suki-admin-version"><?php echo suki_get_theme_info( 'version' ); // WPCS: XSS OK ?></span>
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
							 * Hook: suki_admin_page_content
							 *
							 * @hooked Suki_Admin::render_content__welcome_panel - 1
							 * @hooked Suki_Admin::render_content__pro_modules_table - 10
							 */
							do_action( 'suki_admin_page_content' );
							?>
						</div>
						<div class="suki-admin-secondary">
							<?php
							/**
							 * Hook: suki_admin_page_sidebar
							 *
							 * @hooked Suki_Admin::render_sidebar__customizer - 10
							 * @hooked Suki_Admin::render_sidebar__pro - 20
							 * @hooked Suki_Admin::render_sidebar__documentation - 30
							 * @hooked Suki_Admin::render_sidebar__community - 40
							 * @hooked Suki_Admin::render_sidebar__feedback - 50
							 */
							do_action( 'suki_admin_page_sidebar' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render welcome panel on Suki admin page content.
	 */
	public function render_content__welcome_panel() {
		?>
		<div class="suki-admin-welcome-panel welcome-panel">
			<div class="welcome-panel-content">
				<h2>
					<?php
					/* translators: %s: theme name */
					printf( esc_html__( 'Welcome to %s', 'suki' ), suki_get_theme_info( 'name' ) ); // WPCS: XSS OK
					?>
				</h2>
				<p class="about-description">
					<?php
					/* translators: %s: theme name */
					printf( esc_html__( 'You can start customizing by going to the Customizer page. Or if you need more details about how to use %s, please check our Documentation page.', 'suki' ), suki_get_theme_info( 'name' ) ); // WPCS: XSS OK
					?>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render pro modules table on Suki admin page content.
	 */
	public function render_content__pro_modules_table() {
		?>
		<div class="suki-admin-pro-modules postbox">
			<h2 class="hndle"><?php esc_html_e( 'Premium Modules in Suki Pro', 'suki' ); ?></h2>
			<div class="inside">
				<?php $modules = array(
					array(
						'id'    => 'header-advanced',
						'label' => esc_html__( 'Header (Advanced)', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/header-advanced/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'sticky-header',
						'label' => esc_html__( 'Sticky Header', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/sticky-header/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'transparent-header',
						'label' => esc_html__( 'Transparent Header', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/transparent-header/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'alternative-header-colors',
						'label' => esc_html__( 'Alternative Header Colors', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/alternative-header-colors/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'footer-advanced',
						'label' => esc_html__( 'Footer (Advanced)', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/footer-advanced/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'disable-elements',
						'label' => esc_html__( 'Disable Elements', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/disable-elements/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'preloader',
						'label' => esc_html__( 'Preloader Screen', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/preloader/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'blocks',
						'label' => esc_html__( 'Portable Content Blocks', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/blocks/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'blog-advanced',
						'label' => esc_html__( 'Blog (Advanced)', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/blog-advanced/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'woocommerce-advanced',
						'label' => esc_html__( 'WooCommerce (Advanced)', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/woocommerce-advanced/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'typography-advanced',
						'label' => esc_html__( 'Typography (Advanced)', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/typography-advanced/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'custom-fonts',
						'label' => esc_html__( 'Custom Fonts', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/custom-fonts/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'custom-icons',
						'label' => esc_html__( 'Custom Icons', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/custom-icons/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'color-palette',
						'label' => esc_html__( 'Color Palette', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/color-palette/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'white-label',
						'label' => esc_html__( 'White Label', 'suki' ),
						'url'   => trailingslashit( SUKI_PRO_URL ) . 'pro/modules/white-label/',
						'coming_soon' => true,
					),
				); ?>
				<table class="widefat plugins">
					<tbody>
						<?php foreach( $modules as $module ) : ?>
							<tr class="suki-admin-pro-table-item <?php echo esc_attr( suki_is_pro() && in_array( $module['id'], get_option( 'suki_active_pro_modules', array() ) ) ? 'active' : 'inactive' ); ?>">
								<th class="check-column"></th>
								<td class="suki-admin-pro-table-item-name plugin-title column-primary">
									<?php if ( isset( $module['coming_soon'] ) && $module['coming_soon'] ) : ?>
										<span class="suki-admin-pro-table-item-coming-soon"><?php echo $module['label']; // WPCS: XSS OK ?></span>
									<?php else: ?>
										<a href="<?php echo esc_url( $module['url'] ); ?>" target="_blank" rel="noopener"><?php echo $module['label']; // WPCS: XSS OK ?></a>
									<?php endif; ?>
								</td>
								<td class="suki-admin-pro-table-item-actions column-description desc">
									<?php if ( isset( $module['coming_soon'] ) && $module['coming_soon'] ) : ?>
										<span class="suki-admin-pro-table-item-coming-soon"><?php esc_html_e( 'Coming soon', 'suki' ); ?></span>
									<?php else : ?>
										<?php if ( suki_is_pro() ) : ?>
											<a href="<?php echo esc_url( $module['url'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Deactivate', 'suki' ); ?></a>
										<?php else : ?>
											<a href="<?php echo esc_url( $module['url'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Learn more &raquo;', 'suki' ); ?></a>
										<?php endif; ?>
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
	 * Render "Go to Customizer" button on Suki admin page sidebar.
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
	 * Render "Suki Pro" info box on Suki admin page sidebar.
	 */
	public function render_sidebar__pro() {
		?>
		<div class="suki-admin-secondary-pro postbox">
			<h2 class="hndle"><?php esc_html_e( 'Suki Pro', 'suki' ); ?></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Make your site even better with our premium modules, available in a very affordable price.', 'suki' ); ?></p>
				<p>
					<a href="<?php echo SUKI_PRO_URL; // WPCS: XSS OK ?>" class="button button-large button-secondary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-awards"></span>
						<?php echo esc_html_x( 'More about Suki Pro', 'Suki Pro upsell', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Documentation" info box on Suki admin page sidebar.
	 */
	public function render_sidebar__documentation() {
		?>
		<div class="suki-admin-secondary-docs postbox">
			<h2 class="hndle"><?php esc_html_e( 'Documentation', 'suki' ); ?></h2>
			<div class="inside">
				<p><?php esc_html_e( 'Not sure how something works? Our documentation might help you figure out the solution.', 'suki' ); ?></p>
				<p>
					<a href="https://docs.sukiwp.com/" class="button button-secondary" target="_blank" rel="noopener">
						<span class="dashicons dashicons-lightbulb"></span>
						<?php esc_html_e( 'Go to our Documentation', 'suki' ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Community" info box on Suki admin page sidebar.
	 */
	public function render_sidebar__community() {
		?>
		<div class="suki-admin-secondary-fb-group postbox">
			<h2 class="hndle"><?php esc_html_e( 'Community', 'suki' ); ?></h2>
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
	 * Render "Feedback" info box on Suki admin page sidebar.
	 */
	public function render_sidebar__feedback() {
		?>
		<?php if ( false ) : ?>
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
		<?php endif; ?>
		<?php
	}
}

Suki_Admin::instance();