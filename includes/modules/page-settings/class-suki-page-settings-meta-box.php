<?php
/**
 * Suki Individual Page Settings metabox
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page Settings Meta Box class.
 */
class Suki_Page_Settings_Meta_Box {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Page_Settings_Meta_Box
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
	 * @return Suki_Page_Settings_Meta_Box
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
		// Register meta.
		add_action( 'init', array( $this, 'register_meta' ) );

		// Post meta box.
		add_action( 'add_meta_boxes', array( $this, 'init_post_meta_box' ), 10, 2 );

		// Term meta box.
		add_action( 'admin_init', array( $this, 'init_term_meta_box' ) );

		// Enqueue JS.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_js' ) );
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return page settings values of the specified object (post or term object).
	 *
	 * @param WP_Post|WP_Term $obj Post or term object.
	 * @return array
	 */
	public function get_values( $obj ) {
		$option_key = 'suki_page_settings';

		if ( is_a( $obj, 'WP_Post' ) ) {
			$values = get_post_meta( $obj->ID, '_' . $option_key, true );
		} elseif ( is_a( $obj, 'WP_Term' ) ) {
			$values = get_term_meta( $obj->term_id, $option_key, true );
		} else {
			$values = array();
		}

		return $values;
	}

	/**
	 * Return all fields structures.
	 *
	 * @param string $context Page settings context (post or term).
	 * @return array
	 */
	public function get_structures( $context = 'post' ) {
		/**
		 * Structures should not be an assosiative array for easier handling on JS.
		 * Also, some choices has `''` (blank) and number values, JS will automatically sort these object properties, which break our original orders.
		 */
		$structures = array(
			array(
				'key'    => 'content',
				'title'  => esc_html__( 'Content', 'suki' ),
				'fields' => array(
					array(
						'key'     => 'content_container',
						'type'    => 'select',
						'label'   => esc_html__( 'Container', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '-- Inherit --', 'suki' ),
							),
							array(
								'value' => 'narrow',
								'label' => esc_html__( 'Narrow', 'suki' ),
							),
							array(
								'value' => 'wide',
								'label' => esc_html__( 'Wide', 'suki' ),
							),
							array(
								'value' => 'full',
								'label' => esc_html__( 'Full', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'content_layout',
						'type'    => 'select',
						'label'   => esc_html__( 'Sidebar', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '-- Inherit --', 'suki' ),
							),
							array(
								'value' => 'no-sidebar',
								'label' => esc_html__( 'Disabled', 'suki' ),
							),
							array(
								'value' => 'left-sidebar',
								'label' => esc_html__( 'Left Sidebar', 'suki' ),
							),
							array(
								'value' => 'right-sidebar',
								'label' => esc_html__( 'Right Sidebar', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'disable_content_header',
						'type'    => 'select',
						'label'   => esc_html__( 'Content header', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'hero',
						'type'    => 'select',
						'label'   => esc_html__( 'Content header location', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '-- Inherit --', 'suki' ),
							),
							array(
								'value' => '0',
								'label' => esc_html__( 'Default', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( 'Hero section', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'disable_thumbnail',
						'type'    => 'select',
						'label'   => esc_html__( 'Featured Thumbnail', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
				),
			),
			array(
				'key'    => 'header',
				'title'  => esc_html__( 'Header', 'suki' ),
				'fields' => array(
					array(
						'key'     => 'disable_header',
						'type'    => 'select',
						'label'   => esc_html__( 'Desktop header', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'disable_header_mobile',
						'type'    => 'select',
						'label'   => esc_html__( 'Mobile header', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
				),
			),
			array(
				'key'    => 'footer',
				'title'  => esc_html__( 'Footer', 'suki' ),
				'fields' => array(
					array(
						'key'     => 'disable_footer_widgets',
						'type'    => 'select',
						'label'   => esc_html__( 'Footer widgets', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
					array(
						'key'     => 'disable_footer_bottom',
						'type'    => 'select',
						'label'   => esc_html__( 'Footer bottom', 'suki' ),
						'options' => array(
							array(
								'value' => '',
								'label' => esc_html__( '✓ Visible', 'suki' ),
							),
							array(
								'value' => '1',
								'label' => esc_html__( '✗ Hidden', 'suki' ),
							),
						),
					),
				),
			),
		);

		/**
		 * Filter: suki/page_settings/structures
		 *
		 * @param array  $structures Fields structures.
		 * @param string $context    Page settings context (post or term).
		 */
		apply_filters( 'suki/page_settings/structures', $structures, $context );

		return $structures;
	}

	/**
	 * Return array of fields schema for REST API meta schema.
	 *
	 * @return array
	 */
	public function get_fields_rest_schema() {
		$schema = array();

		foreach ( $this->get_structures() as $group_key => $group_data ) {
			foreach ( $group_data['fields'] as $field_key => $field_data ) {
				switch ( $field_data['type'] ) {
					default:
						$type = 'string';
						break;
				}

				$schema[ $field_key ] = array(
					'type' => $type,
				);
			}
		}

		return $schema;
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue scripts (JS) for page settings.
	 */
	public function enqueue_editor_js() {
		// Abort if current loaded editor's post type is not public post types.
		if ( ! in_array( get_current_screen()->post_type, suki_get_public_post_types(), true ) ) {
			return;
		}

		$script_data = suki_get_script_data( 'page-settings' );
		wp_enqueue_script( 'suki-page-settings', $script_data['js_file_url'], $script_data['dependencies'], $script_data['version'], true );

		wp_add_inline_script(
			'suki-page-settings',
			'const SukiPageSettingsData = ' . wp_json_encode(
				array(
					'metaKey'    => '_suki_page_settings',
					'structures' => $this->get_structures(),
				)
			),
			'before'
		);
	}

	/**
	 * Register meta data for posts and terms.
	 */
	public function register_meta() {
		foreach ( suki_get_public_post_types() as $post_type ) {
			register_post_meta(
				$post_type,
				'_suki_page_settings',
				array(
					'type'          => 'object', // Associative array requires JSON format.
					'single'        => true,
					'default'       => array(),
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
					'show_in_rest'  => array(
						'schema' => array(
							'type'       => 'object',
							'properties' => $this->get_fields_rest_schema(),
						),
					),
				)
			);
		}
	}

	/**
	 * Add page settings meta box to post edit page.
	 *
	 * @param string  $post_type Post type string.
	 * @param WP_Post $post      Post object.
	 */
	public function init_post_meta_box( $post_type, $post ) {
		// Abort if current loaded editor is Gutenberg.
		// If the current post type supports Gutenberg, we will use Gutenberg Sidebar for Page Settings.
		if ( get_current_screen()->is_block_editor() ) {
			return;
		}

		add_meta_box(
			'suki_page_settings',
			/* translators: %s: theme name. */
			sprintf( esc_html__( 'Individual Page Settings (%s)', 'suki' ), esc_html( suki_get_theme_info( 'name' ) ) ),
			array( $this, 'render_post_meta_box' ),
			suki_get_public_post_types(),
			'normal',
			apply_filters( 'suki/admin/metabox/page_settings/priority', 'high' )
		);

		add_action( 'save_post', array( $this, 'save_post_meta_box' ) );
	}

	/**
	 * Handle save action for page settings meta box on post edit page.
	 *
	 * @param integer $post_id Post ID.
	 */
	public function save_post_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['suki_post_page_settings_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['suki_post_page_settings_nonce'] ), 'suki_post_page_settings' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sanitize values.
		$sanitized = array();

		if ( isset( $_POST['suki_page_settings'] ) && is_array( $_POST['suki_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST['suki_page_settings'] ) );

			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) {
					continue;
				}

				// If value is 0 or 1, cast to integer.
				if ( '0' === $value || '1' === $value ) {
					$value = intval( $value );
				}

				$sanitized[ $key ] = $value;
			}
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, '_suki_page_settings', $sanitized );
	}

	/**
	 * Initialize meta box on all public taxonomies.
	 */
	public function init_term_meta_box() {
		$taxonomies = array_merge(
			array( 'category', 'post_tag' ),
			get_taxonomies(
				array(
					'public'             => true,
					'publicly_queryable' => true,
					'rewrite'            => true,
					'_builtin'           => false,
				),
				'names'
			)
		);
		foreach ( $taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'render_term_meta_box' ) );

			add_action( 'edit_' . $taxonomy, array( $this, 'save_term_meta_box' ), 10, 2 );
		}
	}

	/**
	 * Handle save action for page settings meta box on edit term page.
	 *
	 * @param integer $term_id Term ID.
	 * @param integer $tt_id   Term Taxonomy ID.
	 */
	public function save_term_meta_box( $term_id, $tt_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['suki_term_page_settings_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['suki_term_page_settings_nonce'] ), 'suki_term_page_settings' ) ) {
			return;
		}

		// Sanitize values.
		$sanitized = array();
		if ( isset( $_POST['suki_page_settings'] ) && is_array( $_POST['suki_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST['suki_page_settings'] ) );

			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) {
					continue;
				}

				// If value is 0 or 1, cast to integer.
				if ( '0' === $value || '1' === $value ) {
					$value = intval( $value );
				}

				$sanitized[ $key ] = $value;
			}
		}

		// Update the meta field in the database.
		update_term_meta( $term_id, 'suki_page_settings', $sanitized );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render page settings meta box on post / page edit page.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render_post_meta_box( $post ) {
		// Define an array of post IDs that will disable Individual Page Settings meta box.
		// The Individual Page Settings fields would not be displayed on those disabled IDs meta box.
		// Instead, The meta box would show the defined string specified on the disabled array.
		$disabled_ids = array();

		// Add posts page to disabled IDs.
		if ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) === $post->ID ) {
			$disabled_ids[ $posts_page_id ] = '<p><a href="' . esc_url(
				add_query_arg(
					array(
						'autofocus[section]' => 'suki_section_page_settings_post_archive',
						'url'                => esc_url( get_permalink( get_option( 'page_for_posts' ) ) ),
					),
					admin_url( 'customize.php' )
				)
			) . '">' . esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		// Filter to modify disabled IDs.
		$disabled_ids = apply_filters( 'suki/admin/metabox/page_settings/disabled_posts', $disabled_ids, $post );

		// Check if current post ID is one of the disabled IDs.
		if ( array_key_exists( $post->ID, $disabled_ids ) ) {
			// Print the notice here.
			echo $disabled_ids[ $post->ID ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			// There is no other content should be rendered.
			return;
		}

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'suki_post_page_settings', 'suki_post_page_settings_nonce' );

		// Render meta box.
		$this->render_meta_box_content( $post );
	}

	/**
	 * Render page settings meta box on edit term page.
	 *
	 * @param string $term Term.
	 */
	public function render_term_meta_box( $term ) {
		?>
		<tr class="form-field suki-edit-term-page-settings">
			<td colspan="2" style="padding: 0;">
				<h3>
					<?php
					/* translators: %s: tdeme name. */
					printf( esc_html__( 'Individual Page Settings (%s)', 'suki' ), esc_html( suki_get_theme_info( 'name' ) ) );
					?>
				</h3>
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'suki_term_page_settings', 'suki_term_page_settings_nonce' );

				// Render meta box.
				echo '<div class="suki-term-metabox-container">';
				$this->render_meta_box_content( $term );
				echo '</div>';
				?>
			</th>
		</tr>
		<?php
	}

	/**
	 * Render meta box wrapper.
	 *
	 * @param WP_Post|WP_Term $obj Post or term object.
	 */
	public function render_meta_box_content( $obj = null ) {
		// Abort if no object specified.
		if ( empty( $obj ) ) {
			return;
		}

		$option_key = 'suki_page_settings';
		$structures = $this->get_structures();
		$values     = $this->get_values( $obj );
		?>
		<div id="suki-metabox-page-settings" class="suki-admin-metabox-page-settings suki-admin-metabox suki-admin-form">
			<ul class="suki-admin-metabox-nav">
				<?php foreach ( $structures as $i => $panel ) : ?>
					<li class="suki-admin-metabox-nav-item <?php echo esc_attr( 0 === $i ? 'active' : '' ); ?>">
						<a href="<?php echo esc_attr( '#suki-metabox-page-settings--' . $panel['key'] ); ?>"><?php echo $panel['title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="suki-admin-metabox-panels">
				<?php
				foreach ( $structures as $i => $panel ) {
					?>
					<div id="<?php echo esc_attr( 'suki-metabox-page-settings--' . $panel['key'] ); ?>" class="suki-admin-metabox-panel <?php echo esc_attr( 0 === $i ? 'active' : '' ); ?>">
						<?php
						foreach ( $panel['fields'] as $field ) {
							?>
							<div class="suki-admin-form-row">
								<div class="suki-admin-form-label">
									<label><?php echo $field['label']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></label>
								</div>
								<div class="suki-admin-form-field">
									<?php
									switch ( $field['type'] ) {
										case 'select':
											$choices = array();

											foreach ( $field['options'] as $option ) {
												$choices[ $option['value'] ] = $option['label'];
											}

											Suki_Admin_Fields::render_field(
												array(
													'type' => 'select',
													'name' => $option_key . '[' . $field['key'] . ']',
													'choices' => $choices,
													'value' => suki_array_value( $values, $field['key'] ),
												)
											);
											break;
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
}

Suki_Page_Settings_Meta_Box::instance();
