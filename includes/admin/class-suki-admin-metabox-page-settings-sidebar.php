<?php
/**
 * Plugin Name: Suki Metabox
 * Plugin URI: http://sukiwp.com/
 * Description: lorem ipsume
 * Author: Suki Team
 * Author URI: http://sukiwp.com/
 *
 */

if (! defined('ABSPATH')) {
    exit;
}

class Suki_Metabox_Page_Settings_Sidebar {

    public function __construct() {
        add_action( 'init', array( $this, 'suki_metabox_page_settings_setup' ));
        add_action( 'init', array( $this, 'suki_register_meta_page_settings' ));
    }

    public function suki_metabox_page_settings_setup() {

        global $pagenow;
        if (in_array($pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ))) {
            $asset_file = include(get_template_directory().'/assets/js/admin/metabox/index.asset.php');
    
            wp_register_script(
                'suki-metabox-page-settings-editor-script',
                SUKI_JS_URL .'/admin/metabox/index.js',
                $asset_file['dependencies'],
                $asset_file['version']
            );

            $post_types_for_page_settings = suki_get_post_types_for_page_settings();
    
            $post_id = $_GET['post'];
            $post_meta = get_post_meta( $post_id, '_suki_page_settings', true );


            wp_localize_script(
                'suki-metabox-page-settings-editor-script',
                'suki_metabox_page_settings_globals',
                [
                    'suki_pro'   => get_option('suki_pro_active_modules'),
                    'post_types_for_page_settings' => $post_types_for_page_settings,
                    'post_meta' => $post_meta,
                ]
            );
    
            wp_enqueue_script('suki-metabox-page-settings-editor-script');
        
            wp_register_style(
                'suki-metabox-page-settings-editor-style',
                SUKI_CSS_URL .'/admin/sidebar.css',
                array( 'wp-edit-blocks' )
            );

            wp_enqueue_style('suki-metabox-page-settings-editor-style');

            register_block_type(
                'suki-metabox-page-settings',
                array(
                'script' => 'suki-metabox-page-settings-editor-script',
                'style'  => 'suki-metabox-page-settings-editor-style',
            )
            );
        }
    }

    public function suki_register_meta_page_settings() {
        register_meta(
            'post',
            '_suki_page_settings',
            array(
                'type'          => 'object',
                'single'        => true,
                'auth_callback' => function () {
                    return current_user_can( 'edit_posts' );
                },
                'show_in_rest'  => array(
                    'schema' => array(
                        'type'       => 'object',
                        'properties' => array(
                            'content_container'      => array(
                                'type' => 'string',
                            ),
                            'content_layout'         => array(
                                'type' => 'string',
                            ),
                            'sticky_sidebar'         => array(
                                'type' => 'number',
                            ),
                            'disable_content_header' => array(
                                'type' => 'number',
                            ),
                            'hero'                   => array(
                                'type' => 'number',
                            ),
                            'disable_thumbnail'      => array(
                                'type' => 'number',
                            ),
                            'disable_header'         => array(
                                'type' => 'number',
                            ),
                            'disable_mobile_header'  => array(
                                'type' => 'number',
                            ),
                            'header_transparent'  => array(
                                'type' => 'number',
                            ),
                            'header_mobile_transparent'  => array(
                                'type' => 'number',
                            ),
                            'header_sticky'  => array(
                                'type' => 'number',
                            ),
                            'header_mobile_sticky'  => array(
                                'type' => 'number',
                            ),
                            'header_alt_colors'  => array(
                                'type' => 'number',
                            ),
                            'header_mobile_alt_colors'  => array(
                                'type' => 'number',
                            ),
                            'disable_footer_widgets' => array(
                                'type' => 'number',
                            ),
                            'disable_footer_bottom'  => array(
                                'type' => 'number',
                            ),
                            'preloader_screen'       => array(
                                'type' => 'number',
                            ),
                        ),
                    ),
                ),
            )
        );
    }

}

new Suki_Metabox_Page_Settings_Sidebar();