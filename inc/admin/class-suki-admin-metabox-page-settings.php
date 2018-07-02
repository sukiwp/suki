<?php
/**
 * Suki Page Settings metabox
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin_Metabox_Page_Settings {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin_Metabox_Page_Settings
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
	 * @return Suki_Admin_Metabox_Page_Settings
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
		// Post meta box
		add_action( 'add_meta_boxes', array( $this, 'add_post_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post_meta_box' ) );

		// Term meta box
		add_action( 'wp_loaded', array( $this, 'init_all_taxonomies_meta_box' ) );

		// Render actions
		add_action( 'suki_post_page_settings_fields', array( $this, 'post_meta_box_fields' ) );
		add_action( 'suki_term_add_page_settings_fields', array( $this, 'add_term_meta_box_fields' ) );
		add_action( 'suki_term_edit_page_settings_fields', array( $this, 'edit_term_meta_box_fields' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add page settings meta box to post edit page.
	 *
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public function add_post_meta_box( $post_type, $post ) {
		$post_types = array_merge(
			array( 'post', 'page' ),
			get_post_types( array(
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite'            => true,
				'_builtin'           => false,
			), 'names' )
		);

		add_meta_box(
			'suki_page_settings',
			esc_html__( 'Page Settings (Suki)', 'suki' ),
			array( $this, 'render_post_meta_box' ),
			$post_types,
			'side'
		);
	}

	/**
	 * Handle save action for page settings meta box on post edit page.
	 *
	 * @param integer $post_id
	 * @return string
	 */
	public function save_post_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['suki_page_settings_nonce'] ) ) return;
		
		// Verify that the nonce is valid.
		check_admin_referer( 'suki_page_settings__' . $post_id, 'suki_page_settings_nonce' );

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		// Sanitize values.
		$sanitized = array();

		if ( isset( $_POST['suki_page_settings'] ) && is_array( $_POST['suki_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_text_field', wp_unslash( $_POST['suki_page_settings'] ) );
			
			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) continue;

				$sanitized[ $key ] = $value;
			}
		}

		$sanitized = apply_filters( 'suki_save_post_meta_box__page_settings', $sanitized, $post_id );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_suki_page_settings', $sanitized );
	}

	/**
	 * Initialize meta box on all public taxonomies.
	 */
	public function init_all_taxonomies_meta_box() {
		$taxonomies = array_merge(
			array( 'category', 'post_tag' ),
			get_taxonomies( array(
				'public'             => true,
				'publicly_queryable' => true,
				'_builtin'           => false,
			), 'names' )
		);

		foreach ( $taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields', array( $this, 'render_add_term_meta_box' ) );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'render_edit_term_meta_box' ) );

			add_action( 'create_' . $taxonomy, array( $this, 'save_term_meta_box' ), 10, 2 );
			add_action( 'edit_' . $taxonomy, array( $this, 'save_term_meta_box' ), 10, 2 );
		}
	}

	/**
	 * Handle save action for page settings meta box on edit term page.
	 *
	 * @param integer $term_id
	 * @param integer $tt_id
	 */
	public function save_term_meta_box( $term_id, $tt_id ) {
		// Verify that the nonce is valid.
		check_admin_referer( 'suki_term_settings', 'suki_term_settings_nonce' );

		// Sanitize values.
		$sanitized = array();
		if ( isset( $_POST['suki_page_settings'] ) && is_array( $_POST['suki_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_text_field', wp_unslash( $_POST['suki_page_settings'] ) );
			
			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) continue;
				
				$sanitized[ $key ] = $value;
			}
		}

		$sanitized = apply_filters( 'suki_save_term_meta_box__page_settings', $sanitized, $term_id, $tt_id );
		
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
	 * @param WP_Post $post
	 */
	public function render_post_meta_box( $post ) {
		// Define an array of post IDs that will ignore Page Settings meta box.
		// The Page Settings fields would not be displayed on those ignored IDs meta box.
		// Instead, The meta box would show the defined string specified on the ignored array.
		$ignored_post_ids = array();

		// Add posts page to ignored IDs.
		if ( 'page' === get_option( 'show_on_front' ) && $posts_page_id = get_option( 'page_for_posts' ) ) {
			$ignored_post_ids[ $posts_page_id ] = '<p><a href="' . esc_url( add_query_arg( array( 'autofocus[section]' => 'suki_section_post_archive_page', 'url' => get_permalink( get_option( 'page_for_posts' ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		// Filter to modify ignored IDs.
		$ignored_post_ids = apply_filters( 'suki_post_ids_without_page_settings', $ignored_post_ids, $post );

		// Check if current post ID is one of the ignored IDs
		if ( array_key_exists( $post->ID, $ignored_post_ids ) ) {
			// Print the notice here.
			echo $ignored_post_ids[ $post->ID ]; // WPCS: XSS OK
		} else {
			// Print the Page Settings fields.

			// Add a nonce field so we can check for it later.
			wp_nonce_field( 'suki_page_settings__' . $post->ID, 'suki_page_settings_nonce' );
			?>
			<div class="suki-admin-form">
				<?php
				/**
				 * Hook: suki_post_page_settings_fields
				 */
				do_action( 'suki_post_page_settings_fields', $post );
				?>
			</div>
			<?php
		}
	}

	/**
	 * Render standard page settings fields on post / page meta box.
	 *
	 * @param array $args
	 */
	public function post_meta_box_fields( $post ) {
		$option_key = 'suki_page_settings';
		$values = get_post_meta( $post->ID, '_' . $option_key, true );
		?>
		<div class="suki-admin-form-row">
			<label class="suki-admin-form-label"><?php esc_html_e( 'Content Container', 'suki' ); ?></label>
			<div class="suki-admin-form-field">
				<?php
				$key = 'content_container';

				Suki_Admin_Fields::render_field( array(
					'name'    => $option_key . '[' . $key . ']',
					'type'    => 'select',
					'choices' => array(
						''                   => esc_html__( '-- Use Customizer value --', 'suki' ),
						'default'            => esc_html__( 'Fixed width container', 'suki' ),
						'full-width'         => esc_html__( 'Full container', 'suki' ),
						'full-width-padding' => esc_html__( 'Full container with edge tolerance padding', 'suki' ),
					),
					'value'   => suki_array_value( $values, $key ),
				) );
				?>
			</div>
		</div>

		<div class="suki-admin-form-row">
			<label class="suki-admin-form-label"><?php esc_html_e( 'Content Layout', 'suki' ); ?></label>
			<div class="suki-admin-form-field">
				<?php
				$key = 'content_layout';

				Suki_Admin_Fields::render_field( array(
					'name'    => $option_key . '[' . $key . ']',
					'type'    => 'select',
					'choices' => array(
						''              => esc_html__( '-- Use Customizer value --', 'suki' ),
						'wide'          => esc_html__( 'Wide content', 'suki' ),
						'narrow'        => esc_html__( 'Narrow content', 'suki' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
					),
					'value'   => suki_array_value( $values, $key ),
				) );
				?>
			</div>

			<script type="text/javascript">
			(function( $ ) {
				$( 'body' ).on( 'change', '#suki_page_settings__content_layout', function( e ) {
					var $body = $( '#content_ifr' ).contents().find( 'body' ),
					    inheritValue = '<?php echo suki_get_page_setting_by_post_id( 'content_layout', $post ); // WPCS: XSS OK ?>',
					    value = '' === this.value ? inheritValue : this.value;

					$body.removeClass( 'suki-editor-wide suki-editor-narrow suki-editor-right-sidebar suki-editor-left-sidebar' );
					$body.addClass( 'suki-editor-' + value );
				});
			})( jQuery );
			</script>
		</div>
		<?php
	}

	/**
	 * Render page settings meta box on add term page.
	 *
	 * @param WP_Term $term
	 * @param WP_Taxonomy $taxonomy
	 * @return string
	 */
	public function render_add_term_meta_box( $obj ) {
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'suki_term_settings', 'suki_term_settings_nonce' );
		?>
		<div class="suki-add-term-page-settings" style="margin: 2em 0;">
			<h2><?php esc_html_e( 'Page Settings (Suki)', 'suki' ); ?></h2>
			<?php
			/**
			 * Hook: suki_term_add_page_settings_fields
			 */
			do_action( 'suki_term_add_page_settings_fields', $obj );
			?>
		</div>
		<?php
	}

	/**
	 * Render standard page settings fields on add term meta box.
	 *
	 * @param array $args
	 */
	public function add_term_meta_box_fields( $post ) {
		$option_key = 'suki_page_settings';

		if ( ! empty( $obj->ID ) ) {
			$values = get_term_meta( $obj->ID, $option_key, true );
		}

		if ( empty( $values ) ) {
			$values = array();
		}

		?>
		<div class="form-field">
			<label><?php esc_html_e( 'Content Layout', 'suki' ); ?></label>
			<?php
			$key = 'content_layout';

			Suki_Admin_Fields::render_field( array(
				'name'    => $option_key . '[' . $key . ']',
				'type'    => 'select',
				'choices' => array(
					''              => esc_html__( '-- Use Customizer value --', 'suki' ),
					'full-width'    => esc_html__( 'Full width content' , 'suki' ),
					'wide'          => esc_html__( 'Wide content', 'suki' ),
					'narrow'        => esc_html__( 'Narrow content', 'suki' ),
					'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
					'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
				),
				'value'   => suki_array_value( $values, $key ),
			) );
			?>
		</div>
		<?php
	}

	/**
	 * Render page settings meta box on edit term page.
	 *
	 * @param WP_Term $term
	 * @param WP_Taxonomy $taxonomy
	 * @return string
	 */
	public function render_edit_term_meta_box( $obj ) {
		?>
		<tr>
			<th colspan="2"><h3><?php esc_html_e( 'Page Settings (Suki)', 'suki' ); ?></h3></th>
		</tr>
		<tr>
			<td colspan="2">
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'suki_term_settings', 'suki_term_settings_nonce' );
				?>
			</td>
		</tr>

		<?php
		/**
		 * Hook: suki_term_edit_page_settings_fields
		 */
		do_action( 'suki_term_edit_page_settings_fields', $obj );

	}

	/**
	 * Render standard page settings fields on edit term meta box.
	 *
	 * @param array $args
	 */
	public function edit_term_meta_box_fields( $post ) {
		$option_key = 'suki_page_settings';
		$values = get_term_meta( $obj->term_id, $option_key, true );
		?>
		<tr class="form-field">
			<th scope="row"><?php esc_html_e( 'Content Layout', 'suki' ); ?></th>
			<td>
				<?php
				$key = 'content_layout';

				Suki_Admin_Fields::render_field( array(
					'name'    => $option_key . '[' . $key . ']',
					'type'    => 'select',
					'choices' => array(
						''              => esc_html__( '-- Use Customizer value --', 'suki' ),
						'full-width'    => esc_html__( 'Full width content' , 'suki' ),
						'wide'          => esc_html__( 'Wide content', 'suki' ),
						'narrow'        => esc_html__( 'Narrow content', 'suki' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
					),
					'value'   => suki_array_value( $values, $key ),
				) );
				?>
			</td>
		</tr>
		<?php
	}
}

Suki_Admin_Metabox_Page_Settings::instance();