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
		add_action( 'init', array( $this, 'init_term_meta_boxes' ) );

		// Render actions
		add_action( 'suki/admin/metabox/page_settings/fields', array( $this, 'render_meta_box_fields__standard' ), 10, 2 );
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Return the key and label of available tabs.
	 *
	 * @return array
	 */
	private function get_tabs() {
		return apply_filters( 'suki/admin/metabox/page_settings/tabs', array(
			'content'     => esc_html__( 'Content', 'suki' ),
			'header'      => esc_html__( 'Header', 'suki' ),
			'page_header' => esc_html__( 'Page Header (Title Bar)', 'suki' ),
			'footer'      => esc_html__( 'Footer', 'suki' ),
		) );
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
				'_builtin'           => false,
			), 'names' )
		);

		add_meta_box(
			'suki_page_settings',
			esc_html__( 'Page Settings (Suki)', 'suki' ),
			array( $this, 'render_meta_box__post' ),
			$post_types,
			'normal',
			'high'
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
		if ( ! isset( $_POST['suki_post_page_settings_nonce'] ) ) return;
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['suki_post_page_settings_nonce'] ), 'suki_post_page_settings' ) ) return;

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
	public function init_term_meta_boxes() {
		$taxonomies = array_merge(
			array( 'category', 'post_tag' ),
			get_taxonomies( array(
				'public'             => true,
				'publicly_queryable' => true,
				'_builtin'           => false,
			), 'names' )
		);
		foreach ( $taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields', array( $this, 'render_meta_box__term_add' ) );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'render_meta_box__term_edit' ) );

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
		// Check if our nonce is set.
		if ( ! isset( $_POST['suki_term_page_settings_nonce'] ) ) return;

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['suki_term_page_settings_nonce'] ), 'suki_term_page_settings' ) ) return;;

		// Sanitize values.
		$sanitized = array();
		if ( isset( $_POST['suki_page_settings'] ) && is_array( $_POST['suki_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_text_field', wp_unslash( $_POST['suki_page_settings'] ) );
			
			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) continue;

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
	 * @param WP_Post $post
	 */
	public function render_meta_box__post( $post ) {
		// Define an array of post IDs that will disable Page Settings meta box.
		// The Page Settings fields would not be displayed on those disabled IDs meta box.
		// Instead, The meta box would show the defined string specified on the disabled array.
		$disabled_ids = array();

		// Add posts page to disabled IDs.
		if ( 'page' === get_option( 'show_on_front' ) && $posts_page_id = get_option( 'page_for_posts' ) ) {
			$disabled_ids[ $posts_page_id ] = '<p><a href="' . esc_url( add_query_arg( array( 'autofocus[section]' => 'suki_section_page_settings_post_archive', 'url' => get_permalink( get_option( 'page_for_posts' ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		// Filter to modify disabled IDs.
		$disabled_ids = apply_filters( 'suki/admin/metabox/page_settings/disabled_posts', $disabled_ids, $post );

		// Check if current post ID is one of the disabled IDs
		if ( array_key_exists( $post->ID, $disabled_ids ) ) {
			// Print the notice here.
			echo $disabled_ids[ $post->ID ]; // WPCS: XSS OK

			// There is no other content should be rendered.
			return;
		}

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'suki_post_page_settings', 'suki_post_page_settings_nonce' );

		// Render meta box.
		$this->render_meta_box_content( $post );
	}

	/**
	 * Render page settings meta box on add term page.
	 *
	 * @param string $taxonomy
	 * @return string
	 */
	public function render_meta_box__term_add( $term ) {
		?>
		<div class="form-field suki-add-term-page-settings" style="margin: 2em 0;">
			<h2><?php esc_html_e( 'Page Settings (Suki)', 'suki' ); ?></h2>
			<?php
			// Add a nonce field so we can check for it later.
			wp_nonce_field( 'suki_term_page_settings', 'suki_term_page_settings_nonce' );

			// Render meta box
			echo '<div class="suki-term-meta-box-container">';
			$this->render_meta_box_content( $term );
			echo '</div>';
			?>
		</div>
		<?php
	}

	/**
	 * Render page settings meta box on edit term page.
	 *
	 * @param string $taxonomy
	 * @return string
	 */
	public function render_meta_box__term_edit( $term ) {
		?>
		<tr>
			<th colspan="2" style="padding: 0;">
				<h3><?php esc_html_e( 'Page Settings (Suki)', 'suki' ); ?></h3>
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'suki_term_page_settings', 'suki_term_page_settings_nonce' );
				
				// Render meta box
				echo '<div class="suki-term-meta-box-container">';
				$this->render_meta_box_content( $term );
				echo '</div>';
				?>
			</th>
		</tr>
		<tr>
			
		</tr>
		<?php
	}

	/**
	 * Render meta box wrapper.
	 *
	 * @param WP_Post|WP_Term $post
	 */
	public function render_meta_box_content( $obj ) {
		$tabs = $this->get_tabs();
		$first_tab = key( $tabs );
		?>
		<div id="suki-metabox-page-settings" class="suki-admin-metabox-page-settings suki-admin-metabox suki-admin-form">
			<ul class="suki-admin-metabox-nav">
				<?php foreach ( $tabs as $key => $label ) : ?>
					<li class="suki-admin-metabox-nav-item <?php echo esc_attr( $key == $first_tab ? 'active' : '' ); ?>">
						<a href="<?php echo esc_attr( '#suki-metabox-page-settings--' . $key ); ?>"><?php echo ( $label ); // WPCS: XSS OK ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="suki-admin-metabox-panels">
				<?php foreach ( $tabs as $key => $label ) : ?>
					<div id="<?php echo esc_attr( 'suki-metabox-page-settings--' . $key ); ?>" class="suki-admin-metabox-panel <?php echo esc_attr( $key == $first_tab ? 'active' : '' ); ?>">
						<?php
						/**
						 * Hook: suki/admin/metabox/page_settings/fields
						 */
						do_action( 'suki/admin/metabox/page_settings/fields', $obj, $key );
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render standard page settings meta box fields.
	 *
	 * @param WP_Post|WP_Term $obj
	 * @param string $tab
	 */
	public function render_meta_box_fields__standard( $obj, $tab ) {
		$option_key = 'suki_page_settings';

		if ( is_a( $obj, 'WP_Post' ) ) {
			$values = get_post_meta( $obj->ID, '_' . $option_key, true );
		} elseif ( is_a( $obj, 'WP_Term' ) ) {
			$values = get_term_meta( $obj->term_id, $option_key, true );
		} else {
			$values = array();
		}

		switch ( $tab ) {
			case 'header':
				?>
				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable main header', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_header';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable mobile header', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_mobile_header';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;

			case 'page_header':
				?>
				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable page header', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_page_header';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<hr>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Override page title text', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_page_title';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'text',
							'placeholder' => esc_html__( '-- Inherit from Customizer --', 'suki' ),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Keep main content title displayed', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_keep_content_header';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
						<p class="description"><?php esc_html_e( 'By default, when page header is active, the page title on content section would be hidden. Enabling this would make the page title on content section remains displayed.', 'suki' ); ?></p>
					</div>
				</div>

				<hr>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background image', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_bg_image';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'upload',
							'placeholder' => esc_html__( '-- Inherit from Customizer --', 'suki' ),
							'library'     => 'image',
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background position', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_bg_position';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''              => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'left top'      => esc_html__( 'Left top', 'suki' ),
								'left center'   => esc_html__( 'Left center', 'suki' ),
								'left bottom'   => esc_html__( 'Left bottom', 'suki' ),
								'center top'    => esc_html__( 'Center top', 'suki' ),
								'center center' => esc_html__( 'Center center', 'suki' ),
								'center bottom' => esc_html__( 'Center bottom', 'suki' ),
								'right top'     => esc_html__( 'Right top', 'suki' ),
								'right center'  => esc_html__( 'Right center', 'suki' ),
								'right bottom'  => esc_html__( 'Right bottom', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background size', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_bg_size';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''        => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'auto'    => esc_html__( 'Default', 'suki' ),
								'cover'   => esc_html__( 'Cover', 'suki' ),
								'contain' => esc_html__( 'Contain', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background repeat', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_bg_repeat';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''          => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'no-repeat' => esc_html__( 'No repeat', 'suki' ),
								'repeat-x'  => esc_html__( 'Repeat X (horizontally)', 'suki' ),
								'repeat-y'  => esc_html__( 'Repeat Y (vertically)', 'suki' ),
								'repeat'    => esc_html__( 'Repeat both axis', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background attachment', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'page_header_bg_attachment';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''       => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'scroll' => esc_html__( 'Scroll', 'suki' ),
								'fixed'  => esc_html__( 'Fixed', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Background overlay opacity', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$choices = array();
						for ( $i = 0; $i <= 100; $i += 5 ) {
							$choices[ (string)( $i / 100 ) ] = $i . '%';
						}

						$key = 'page_header_bg_overlay_opacity';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'placeholder' => esc_html__( '-- Inherit from Customizer --', 'suki' ),
							'choices'     => array_merge(
								array( '' => esc_html__( '-- Inherit from Customizer --', 'suki' ) ),
								$choices
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;

			case 'content':
				?>
				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Content container', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'content_container';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''                   => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'default'            => esc_html__( 'Fixed width container', 'suki' ),
								'full-width'         => esc_html__( 'Full container', 'suki' ),
								'full-width-padding' => esc_html__( 'Full container with side padding', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Content layout', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'content_layout';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''              => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'wide'          => esc_html__( 'Wide content', 'suki' ),
								'narrow'        => esc_html__( 'Narrow content', 'suki' ),
								'left-sidebar'  => esc_html__( 'Left Sidebar', 'suki' ),
								'right-sidebar' => esc_html__( 'Right Sidebar', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
					<?php if ( is_a( $obj, 'WP_Post' ) ) : ?>
						<script type="text/javascript">
						(function( $ ) {
							$( 'body.post-php' ).on( 'change', '#suki_page_settings__content_layout', function( e ) {
								var $body = $( '#content_ifr' ).contents().find( 'body' ),
								    inheritValue = '<?php echo suki_get_page_setting_by_post_id( 'content_layout', $obj->ID ); // WPCS: XSS OK ?>',
								    value = '' === this.value ? inheritValue : this.value;

								$body.removeClass( 'suki-editor-wide suki-editor-narrow suki-editor-right-sidebar suki-editor-left-sidebar' );
								$body.addClass( 'suki-editor-' + value );
							});
						})( jQuery );
						</script>
					<?php endif; ?>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable main content title', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_content_header';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;

			case 'footer':
				?>
				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable footer widgets', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_footer_widgets';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="suki-admin-form-row">
					<label class="suki-admin-form-label"><?php esc_html_e( 'Disable footer bottom', 'suki' ); ?></label>
					<div class="suki-admin-form-field">
						<?php
						$key = 'disable_footer_bottom';
						Suki_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '-- Inherit from Customizer --', 'suki' ),
								'0' => esc_html__( 'No', 'suki' ),
								'1' => esc_html__( 'Yes', 'suki' ),
							),
							'value'       => suki_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;
			
			default:
				# code...
				break;
		}
	}
}

Suki_Admin_Metabox_Page_Settings::instance();