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

class Suki_Metabox {

    public function __construct() {
        add_action( 'init', array( $this, 'suki_metabox_plugin_setup' ));
        add_action( 'init', array( $this, 'suki_register_meta' ));
        add_filter( 'rest_prepare_suki_block', array( $this, 'filter_suki_block_json' ), 10, 3);
    }

    public function suki_metabox_plugin_setup() {
        $asset_file = include( get_template_directory().'/assets/js/admin/metabox/index.asset.php' );
    
        wp_register_script(
            'suki-metabox-editor-script',
            SUKI_JS_URL .'/admin/metabox/index.js',
            $asset_file['dependencies'],
            $asset_file['version']
        );

        $post_types = suki_get_post_types_for_page_settings();
    
        wp_localize_script(
            'suki-metabox-editor-script',
            'suki_metabox_globals',
            [
            'suki_pro'   => get_option( 'suki_pro_active_modules' ),
            'post_types' => $post_types,
        ]
        );
    
        wp_enqueue_script( 'suki-metabox-editor-script' );

        wp_register_style(
            'suki-metabox-editor-style',
            SUKI_JS_URL .'/admin/metabox/editor.css',
            array( 'wp-edit-blocks' )
        );

        register_block_type(
            'suki/metabox',
            array(
            'script' => 'suki-metabox-editor-script',
            'style'  => 'suki-metabox-editor-style',
        )
        );
    }

    public function suki_register_meta() {
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
                            'type' => 'string',
                        ),
                        'disable_content_header' => array(
                            'type' => 'string',
                        ),
                        'hero'                   => array(
                            'type' => 'string',
                        ),
                        'disable_thumbnail'      => array(
                            'type' => 'string',
                        ),
                        'disable_header'         => array(
                            'type' => 'string',
                        ),
                        'disable_mobile_header'  => array(
                            'type' => 'string',
                        ),
                        'header_transparent'  => array(
                            'type' => 'string',
                        ),
                        'header_mobile_transparent'  => array(
                            'type' => 'string',
                        ),
                        'header_sticky'  => array(
                            'type' => 'string',
                        ),
                        'header_mobile_sticky'  => array(
                            'type' => 'string',
                        ),
                        'header_alt_colors'  => array(
                            'type' => 'string',
                        ),
                        'header_mobile_alt_colors'  => array(
                            'type' => 'string',
                        ),
                        'disable_footer_widgets' => array(
                            'type' => 'string',
                        ),
                        'disable_footer_bottom'  => array(
                            'type' => 'string',
                        ),
                        'preloader_screen'       => array(
                            'type' => 'string',
                        ),
                    ),
                ),
            ),
        )
        );
    }

    public function filter_suki_block_json( $data, $post, $context ) {

        $post_meta = get_post_meta( $post->ID, '_suki_block_settings', true );
    
        if ($post_meta) {
            $data->data['meta'] = $post_meta;
        }
    
        return $data;
    }
}

new Suki_Metabox();