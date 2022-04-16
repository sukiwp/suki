<?php
/**
 * Suki Page Settings meta box
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
		add_action( 'admin_init', array( $this, 'init_post_meta_box' ) );

		// Term meta box.
		add_action( 'admin_init', array( $this, 'init_term_meta_box' ) );

		// Enqueue JS.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_js' ) );

		// Page settings filters.
		add_filter( 'suki/page_settings/structures', array( $this, 'add_optional_page_settings' ), 10, 2 );
		add_filter( 'suki/page_settings/post_meta_box', array( $this, 'exclude_page_settings_on_posts_page' ), 10, 2 );
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
			'content' => array(
				'title'  => esc_html__( 'Content', 'suki' ),
				'fields' => array(
					'content_container'      => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Container', 'suki' ),
						'options' => array(
							''       => esc_html__( '-- Inherit --', 'suki' ),
							'narrow' => esc_html__( 'Narrow', 'suki' ),
							'wide'   => esc_html__( 'Wide', 'suki' ),
							'full'   => esc_html__( 'Full', 'suki' ),
						),
					),
					'content_layout'         => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Sidebar', 'suki' ),
						'options' => array(
							''              => esc_html__( '-- Inherit --', 'suki' ),
							'no-sidebar'    => esc_html__( 'Disabled', 'suki' ),
							'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
							'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
						),
					),
					'disable_content_header' => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Content header', 'suki' ),
						'options' => array(
							''  => esc_html__( '✓ Visible', 'suki' ),
							'1' => esc_html__( '✗ Hidden', 'suki' ),
						),
					),
					'hero'                   => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Content header location', 'suki' ),
						'options' => array(
							''  => esc_html__( '-- Inherit --', 'suki' ),
							'0' => esc_html__( 'Default', 'suki' ),
							'1' => esc_html__( 'Hero section', 'suki' ),
						),
					),
				),
			),
			'header'  => array(
				'title'  => esc_html__( 'Header', 'suki' ),
				'fields' => array(
					'disable_header'        => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Desktop header', 'suki' ),
						'options' => array(
							''  => esc_html__( '✓ Visible', 'suki' ),
							'1' => esc_html__( '✗ Hidden', 'suki' ),
						),
					),
					'disable_header_mobile' => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Mobile header', 'suki' ),
						'options' => array(
							''  => esc_html__( '✓ Visible', 'suki' ),
							'1' => esc_html__( '✗ Hidden', 'suki' ),
						),
					),
				),
			),
			'footer'  => array(
				'title'  => esc_html__( 'Footer', 'suki' ),
				'fields' => array(
					'disable_footer_widgets' => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Footer widgets', 'suki' ),
						'options' => array(
							''  => esc_html__( '✓ Visible', 'suki' ),
							'1' => esc_html__( '✗ Hidden', 'suki' ),
						),
					),
					'disable_footer_bottom'  => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Footer bottom', 'suki' ),
						'options' => array(
							''  => esc_html__( '✓ Visible', 'suki' ),
							'1' => esc_html__( '✗ Hidden', 'suki' ),
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
		$structures = apply_filters( 'suki/page_settings/structures', $structures, $context );

		return $structures;
	}

	/**
	 * Return all fields structures.
	 *
	 * @param string $context Page settings context (post or term).
	 * @return array
	 */
	public function get_structures_as_simple_array( $context = 'post' ) {
		// Get the original structures.
		$structures = $this->get_structures( $context );

		// Iterate through the structures and refactor the associative array to simple array.
		foreach ( $structures as $panel_key => &$panel ) {
			// Add key as an array item.
			$panel['key'] = $panel_key;

			foreach ( $panel['fields'] as $field_key => &$field ) {
				// Add key as an array item.
				$field['key'] = $field_key;

				// Refactor options array for 'select' type..
				if ( 'select' === $field['type'] ) {
					$options = array();

					foreach ( $field['options'] as $value => $label ) {
						$options[] = array(
							'value' => $value,
							'label' => $label,
						);
					}

					$field['options'] = $options;
				}
			}

			// Convert fields (associative array) to simple array.
			$panel['fields'] = array_values( $panel['fields'] );
		}

		// Convert panels (associative array) to simple array.
		$structures = array_values( $structures );

		return $structures;
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add optional page settings to the structures.
	 *
	 * @param array  $structures Fields structures.
	 * @param string $context    Page settings context (post or term).
	 * @return array
	 */
	public function add_optional_page_settings( $structures, $context ) {
		// Abort if it's not post meta box.
		if ( 'post' !== $context ) {
			return $structures;
		}

		// Abort if current post type doesn't support thumbnail.
		if ( ! post_type_supports( get_current_screen()->post_type, 'thumbnail' ) ) {
			return $structures;
		}

		// Add "Featured image" field.
		$structures['content']['fields']['disable_thumbnail'] = array(
			'type'    => 'select',
			'label'   => esc_html__( 'Featured image', 'suki' ),
			'options' => array(
				''  => esc_html__( '✓ Visible', 'suki' ),
				'1' => esc_html__( '✗ Hidden', 'suki' ),
			),
		);

		return $structures;
	}

	/**
	 * Exclude page settings meta box on posts page.
	 *
	 * @param string  $html Meta box HTML.
	 * @param WP_Post $post Post object.
	 * @return string
	 */
	public function exclude_page_settings_on_posts_page( $html, $post ) {
		// Add posts page to disabled IDs.
		if ( 'page' === get_option( 'show_on_front' ) && intval( get_option( 'page_for_posts' ) ) === $post->ID ) {
			$html = '<p><a href="' . esc_url(
				add_query_arg(
					array(
						'autofocus[section]' => 'suki_section_post_archive',
						'url'                => esc_url( get_permalink( get_option( 'page_for_posts' ) ) ),
					),
					admin_url( 'customize.php' )
				)
			) . '">' . esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		return $html;
	}

	/**
	 * Enqueue scripts (JS) for page settings.
	 */
	public function enqueue_editor_js() {
		// Abort if current loaded editor's post type is not public post types.
		if ( ! in_array( get_current_screen()->post_type, suki_get_public_post_types(), true ) ) {
			return;
		}

		// Enqueue JS.
		$script_data = suki_get_script_data( 'page-settings' );
		wp_enqueue_script( 'suki-page-settings', $script_data['js_file_url'], $script_data['dependencies'], $script_data['version'], true );

		// Pass data to JS via inline script.
		wp_add_inline_script(
			'suki-page-settings',
			'const SukiPageSettingsData = ' . wp_json_encode(
				array(
					'metaKey'    => '_suki_page_settings',
					'structures' => $this->get_structures_as_simple_array(),
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
							'type'                 => 'object',
							/**
							 * Set all fields types to `string`.
							 *
							 * Page settings are used to override Customizer values, therefore string `inherit` is always one of each setting choices.
							 * So all the field values will be in `string` type.
							 *
							 * Use `additionalProperties` to skip setting all keys.
							 * ref: https://make.wordpress.org/core/2019/10/03/wp-5-3-supports-object-and-array-meta-types-in-the-rest-api/
							 */
							'additionalProperties' => 'string',
						),
					),
				)
			);
		}
	}

	/**
	 * Add page settings meta box to post edit page.
	 */
	public function init_post_meta_box() {
		add_action(
			'add_meta_boxes',
			function() {
				// Abort if current loaded editor is Gutenberg.
				// If the current post type supports Gutenberg, we will use Gutenberg Sidebar for Page Settings.
				if ( get_current_screen()->is_block_editor() ) {
					return;
				}

				add_meta_box(
					'suki_page_settings',
					esc_html__( 'Theme Page Settings', 'suki' ),
					array( $this, 'render_post_meta_box' ),
					suki_get_public_post_types(),
					'side'
				);
			}
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
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'suki_post_page_settings', 'suki_post_page_settings_nonce' );

		// Early filter to bypass the default meta box.
		$meta_box = apply_filters( 'suki/page_settings/post_meta_box', '', $post );

		// If any filter detected, return the markup from the filters.
		if ( '' !== trim( $meta_box ) ) {
			echo $meta_box; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		// Render the default meta box.
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
				<h3><?php esc_html_e( 'Theme Page Settings', 'suki' ); ?></h3>
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'suki_term_page_settings', 'suki_term_page_settings_nonce' );

				// Render meta box.
				echo '<div class="suki-term-meta-box-container">';
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
	 * @param WP_Post|WP_Term $obj  Post or term object.
	 */
	public function render_meta_box_content( $obj = null ) {
		// Abort if no object specified.
		if ( empty( $obj ) ) {
			return;
		}

		$meta_key   = 'suki_page_settings';
		$structures = $this->get_structures();
		$values     = $this->get_values( $obj );
		$first_key  = key( $structures );
		?>
		<div class="suki-admin-meta-box__wrapper">
			<?php foreach ( $structures as $panel_key => $panel ) { ?>
				<details id="<?php echo esc_attr( 'suki-page-settings__' . $panel_key ); ?>" class="suki-admin-accordion">
					<summary><?php echo esc_html( $panel['title'] ); ?></summary>
					<div class="suki-admin-form-rows">
						<?php foreach ( $panel['fields'] as $field_key => $field ) { ?>
							<div class="suki-admin-form-row">
								<label class="suki-admin-form-label"><?php echo esc_html( $field['label'] ); ?></label>
								<div>
									<?php
									switch ( $field['type'] ) {
										case 'select':
											Suki_Admin_Fields::render_field(
												array(
													'type'    => 'select',
													'name'    => $meta_key . '[' . $field_key . ']',
													'choices' => $field['options'],
													'value'   => suki_array_value( $values, $field_key ),
												)
											);
											break;

										case 'toggle':
											break;
									}
									?>
								</div>
							</div>
						<?php } ?>
					</div>
				</details>
			<?php } ?>
		</div>
		<?php
	}
}

Suki_Page_Settings_Meta_Box::instance();
