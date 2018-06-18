<?php
/**
 * About admin page
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin_Page_Dashboard {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin_Page_About
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
	 * @return Suki_Admin_Page_About
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
		add_action( 'suki_admin_dashboard_content', array( $this, 'render_welcome_panel' ), 1 );
		add_action( 'suki_admin_dashboard_content', array( $this, 'render_pro_modules_table' ), 20 );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render admin submenu page: Suki > About.
	 */
	public function render_page() {
		do_action( 'suki_admin_dashboard_content' );
	}

	public function render_welcome_panel() {
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
					printf( esc_html__( 'You can start customizing the site by going to the Customizer page. Or if you need more details about how to use %s, please check our Documentation page.', 'suki' ), suki_get_theme_info( 'name' ) );
					?>
				</p>
			</div>
		</div>
		<?php
	}

	public function render_pro_modules_table() {
		?>
		<h2><?php esc_html_e( 'Premium Modules in Suki Pro:', 'suki' ); ?></h2>
		<?php $modules = array(
			'layout' => array(
				'label' => esc_html__( 'Layout Modules', 'suki' ),
				'modules' => array(
					array(
						'id'    => 'header',
						'label' => esc_html__( 'Header (Advanced)', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/header/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'sticky-header',
						'label' => esc_html__( 'Sticky Header', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/sticky-header/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'transparent-header',
						'label' => esc_html__( 'Transparent Header', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/transparent-header/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'footer',
						'label' => esc_html__( 'Footer (Advanced)', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/footer/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'disable-elements',
						'label' => esc_html__( 'Disable Elements', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/disable-elements/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'preloader',
						'label' => esc_html__( 'Preloader Screen', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/preloader/',
						'coming_soon' => true,
					),
				),
			),
			'content' => array(
				'label' => esc_html__( 'Content Modules', 'suki' ),
				'modules' => array(
					array(
						'id'    => 'blocks',
						'label' => esc_html__( 'Portable Content Blocks', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/blocks/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'blog',
						'label' => esc_html__( 'Blog (Advanced)', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/blog/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'woocommerce',
						'label' => esc_html__( 'WooCommerce (Advanced)', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/woocommerce/',
						'coming_soon' => true,
					),
				),
			),
			'design' => array(
				'label' => esc_html__( 'Design Modules', 'suki' ),
				'modules' => array(
					array(
						'id'    => 'alternative-header-colors',
						'label' => esc_html__( 'Alternative Header Colors', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/alternative-header-colors/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'typography',
						'label' => esc_html__( 'Typography (Advanced)', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/typography/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'custom-fonts',
						'label' => esc_html__( 'Custom Fonts', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/custom-fonts/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'custom-icons',
						'label' => esc_html__( 'Custom Icons', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/custom-icons/',
						'coming_soon' => true,
					),
					array(
						'id'    => 'color-palette',
						'label' => esc_html__( 'Color Palette', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/color-palette/',
						'coming_soon' => true,
					),
				),
			),
			'others' => array(
				'label' => esc_html__( 'Other Modules', 'suki' ),
				'modules' => array(
					array(
						'id'    => 'white-label',
						'label' => esc_html__( 'White Label', 'suki' ),
						'url'   => 'https://sukiwp.com/pro/modules/white-label/',
						'coming_soon' => true,
					),
				),
			),
		); ?>
		<table class="widefat suki-admin-pro-table plugins">
			<tbody>
				<?php foreach( $modules as $group_modules ) : ?>
					<tr class="suki-admin-pro-table-group inactive">
						<th colspan="3" class="suki-admin-pro-table-group-heading inactive"><?php echo $group_modules['label']; // WPCS: XSS OK ?></th>
					</tr>
					<?php foreach( $group_modules['modules'] as $module ) : ?>
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
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	}
}

Suki_Admin_Page_Dashboard::instance();