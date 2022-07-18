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
	const META_KEY = 'suki_page_settings';

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
		// `admin_init` hook is used to make sure that all custom post types are already registered (mostly registered in `init` hook).
		add_action( 'admin_init', array( $this, 'init_post_meta_box' ) );

		// Term meta box.
		// `admin_init` hook is used to make sure that all custom taxonomies are already registered (mostly registered in `init` hook).
		add_action( 'admin_init', array( $this, 'init_term_meta_box' ) );

		// Page settings filters.
		add_filter( 'suki/page_settings/structures', array( $this, 'add_optional_page_settings' ), 10, 2 );
		add_filter( 'suki/page_settings/excluded_post_ids', array( $this, 'disable_page_settings_on_posts_page' ) );
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
	 * @param string $type       Page type with this format: [post_type]_[single/archive].
	 * @return array
	 */
	public function add_optional_page_settings( $structures, $type ) {
		$post_type = preg_replace( '/(_single|_archive)/', '', $type );

		// Abort if current post type doesn't support thumbnail.
		if ( ! post_type_supports( $post_type, 'thumbnail' ) ) {
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
	 * Disable page settings meta box on posts page.
	 *
	 * @param array $ids Post IDs.
	 * @return array
	 */
	public function disable_page_settings_on_posts_page( $ids ) {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$ids[] = get_option( 'page_for_posts' );
		}

		return $ids;
	}

	/**
	 * Register meta data for posts and terms.
	 */
	public function register_meta() {
		foreach ( suki_get_public_post_types() as $post_type ) {
			register_post_meta(
				$post_type,
				self::META_KEY,
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
							'properties'           => $this->get_fields_rest_schema( $post_type ),
							'additionalProperties' => array(
								'type' => 'string',
							),
						),
					),
				)
			);
		}
	}

	/**
	 * Initialize meta box on post edit page.
	 */
	public function init_post_meta_box() {
		add_action( 'add_meta_boxes', array( $this, 'add_post_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post_meta_box' ) );

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_js' ) );
	}

	/**
	 * Add page settings meta box to post edit page.
	 *
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Post object.
	 */
	public function add_post_meta_box( $post_type, $post ) {
		// Abort if current edited post is one of the excluded IDs.
		if ( in_array( $post->ID, $this->get_excluded_post_ids(), true ) ) {
			return;
		}

		// Abort if current loaded editor's post type is not public post types.
		if ( ! in_array( $post_type, suki_get_public_post_types(), true ) ) {
			return;
		}

		add_meta_box(
			self::META_KEY,
			esc_html__( 'Page Settings (Theme)', 'suki' ),
			array( $this, 'render_post_meta_box' ),
			suki_get_public_post_types(),
			'side',
			'default',
			array(
				'__back_compat_meta_box' => true, // Hide the meta box when Gutenberg is enabled, and use Gutenberg Sidebar instead.
			)
		);
	}

	/**
	 * Handle save action for page settings meta box on post edit page.
	 *
	 * @param integer $post_id Post ID.
	 */
	public function save_post_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST[ self::META_KEY . '_nonce' ] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST[ self::META_KEY . '_nonce' ] ), self::META_KEY ) ) {
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

		if ( isset( $_POST[ self::META_KEY ] ) && is_array( $_POST[ self::META_KEY ] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST[ self::META_KEY ] ) );

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
		update_post_meta( $post_id, self::META_KEY, $sanitized );
	}

	/**
	 * Enqueue scripts (JS) for page settings.
	 */
	public function enqueue_editor_js() {
		$post_id   = get_query_var( 'post' );
		$post_type = get_post_type( $post_id );

		// Abort if current edited post is one of the excluded IDs.
		if ( in_array( $post_id, $this->get_excluded_post_ids(), true ) ) {
			return;
		}

		// Abort if current loaded editor's post type is not public post types.
		if ( ! in_array( $post_type, suki_get_public_post_types(), true ) ) {
			return;
		}

		// Enqueue JS.
		$script_data = suki_get_script_data( 'page-settings' );
		wp_enqueue_script( 'suki-page-settings', $script_data['js_file_url'], $script_data['dependencies'], $script_data['version'], true );

		/**
		 * Pass data to JS
		 */

		// Pass data to JS via inline script.
		wp_add_inline_script(
			'suki-page-settings',
			'const SukiPageSettingsData = ' . wp_json_encode(
				array(
					'metaKey'    => self::META_KEY,
					'title'      => esc_html__( 'Page Settings (Theme)', 'suki' ),
					'structures' => $this->get_structures_as_simple_array( $post_type . '_single' ),
				)
			),
			'before'
		);
	}

	/**
	 * Initialize meta box on term edit page.
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
		if ( ! isset( $_POST[ self::META_KEY . '_nonce' ] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST[ self::META_KEY . '_nonce' ] ), self::META_KEY ) ) {
			return;
		}

		// Sanitize values.
		$sanitized = array();
		if ( isset( $_POST[ self::META_KEY ] ) && is_array( $_POST[ self::META_KEY ] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST[ self::META_KEY ] ) );

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
		update_term_meta( $term_id, self::META_KEY, $sanitized );
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
		wp_nonce_field( self::META_KEY, self::META_KEY . '_nonce' );

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
				<h3><?php esc_html_e( 'Page Settings (Theme)', 'suki' ); ?></h3>
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( self::META_KEY, self::META_KEY . '_nonce' );

				// Render meta box.
				$this->render_meta_box_content( $term );
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

		if ( is_a( $obj, 'WP_Post' ) ) {
			$type = get_post_type( $obj ) . '_single';
		} elseif ( is_a( $obj, 'WP_Term' ) ) {
			$type = get_taxonomy( $obj->taxonomy )->object_type[0] . '_archive';
		} else {
			return;
		}

		$structures = $this->get_structures( $type );
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
													'name'    => self::META_KEY . '[' . $field_key . ']',
													'choices' => $field['options'],
													'value'   => suki_array_value( $values, $field_key ),
												)
											);
											break;

										case 'toggle':
											break;
									}

									if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) {
										?>
										<p class="description"><?php echo wp_kses_post( $field['description'] ); ?></p>
										<?php
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

	/**
	 * ====================================================
	 * Other functions
	 * ====================================================
	 */

	/**
	 * Return all fields schema array for REST API meta.
	 *
	 * @param string $post_type Post type.
	 * @return array
	 */
	public function get_fields_rest_schema( $post_type ) {
		$schema = array();

		foreach ( $this->get_structures( $post_type . '_single' ) as $panel_key => $panel ) {
			foreach ( $panel['fields'] as $field_key => $field ) {
				$schema[ $field_key ] = array(
					'type' => 'string',
				);
			}
		}

		return $schema;
	}

	/**
	 * Return page settings values of the specified object (post or term object).
	 *
	 * @param WP_Post|WP_Term $obj Post or term object.
	 * @return array
	 */
	public function get_values( $obj ) {
		$option_key = self::META_KEY;

		if ( is_a( $obj, 'WP_Post' ) ) {
			$values = get_post_meta( $obj->ID, $option_key, true );
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
	 * @param string $type Page type with this format: [post_type]_[single/archive].
	 * @return array
	 */
	public function get_structures( $type ) {
		/**
		 * Structures should not be an assosiative array for easier handling on JS.
		 * Also, some choices has `''` (blank) and number values, JS will automatically sort these object properties, which break our original orders.
		 */
		$structures = array(
			'content' => array(
				'title'  => esc_html__( 'Content', 'suki' ),
				'fields' => array(
					'content_container'      => array(
						'type'          => 'select',
						'label'         => esc_html__( 'Container', 'suki' ),
						'description'   => esc_html__( 'Sidebar will be automatically disabled in Narrow container.', 'suki' ),
						'options'       => array(
							''       => esc_html__( '-- Inherit --', 'suki' ),
							'narrow' => esc_html__( 'Narrow', 'suki' ),
							'wide'   => esc_html__( 'Wide', 'suki' ),
							'full'   => esc_html__( 'Full', 'suki' ),
						),
						'outputs'       => array(
							array(
								'type'    => 'class',
								'element' => '.editor-styles-wrapper',
								'pattern' => 'suki-section--$',
							),
						),
						'inherit_value' => '' !== suki_get_theme_mod( $type . '_content_container', '' ) ? suki_get_theme_mod( $type . '_content_container' ) : suki_get_theme_mod( 'content_container' ),
					),
					'content_layout'         => array(
						'type'          => 'select',
						'label'         => esc_html__( 'Sidebar', 'suki' ),
						'options'       => array(
							''              => esc_html__( '-- Inherit --', 'suki' ),
							'no-sidebar'    => esc_html__( 'Disabled', 'suki' ),
							'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
							'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
						),
						'outputs'       => array(
							array(
								'type'    => 'class',
								'element' => '.editor-styles-wrapper',
								'pattern' => 'suki-content--layout-$',
							),
						),
						'inherit_value' => '' !== suki_get_theme_mod( $type . '_content_layout', '' ) ? suki_get_theme_mod( $type . '_content_layout' ) : suki_get_theme_mod( 'content_layout' ),
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
						'type'        => 'select',
						'label'       => esc_html__( 'Hero section', 'suki' ),
						'description' => esc_html__( 'Display content header in a separate section between header and content sections.', 'suki' ),
						'options'     => array(
							''  => esc_html__( '-- Inherit --', 'suki' ),
							'0' => esc_html__( 'Default', 'suki' ),
							'1' => esc_html__( 'Hero section', 'suki' ),
						),
					),
					'hero_container'         => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Hero section container', 'suki' ),
						'options' => array(
							''       => esc_html__( '-- Inherit --', 'suki' ),
							'narrow' => esc_html__( 'Narrow', 'suki' ),
							'wide'   => esc_html__( 'Wide', 'suki' ),
							'full'   => esc_html__( 'Full', 'suki' ),
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
		 * @param string $type       Page type with this format: [post_type]_[single/archive].
		 */
		$structures = apply_filters( 'suki/page_settings/structures', $structures, $type );

		return $structures;
	}

	/**
	 * Return all fields structures.
	 *
	 * @param string $type Page type with this format: [post_type]_[single/archive].
	 * @return array
	 */
	public function get_structures_as_simple_array( $type ) {
		// Get the original structures.
		$structures = $this->get_structures( $type );

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
	 * Return manually specified post meta box content to override the default post meta box.
	 *
	 * @return array
	 */
	public function get_excluded_post_ids() {
		$ids = array();

		/**
		 * Filter: suki/page_settings/excluded_post_ids
		 *
		 * Disable Page Settings on some posts (IDs).
		 * For example: Blog Posts Page.
		 *
		 * @param array $ids Post IDs.
		 * @return array
		 */
		$ids = apply_filters( 'suki/page_settings/excluded_post_ids', $ids );

		// Make sure all IDs are integer.
		$ids = array_map( 'intval', $ids );

		return $ids;
	}
}

Suki_Page_Settings_Meta_Box::instance();
