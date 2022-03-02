<?php
/**
 * Customizer control's conditional contexts.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$add = array();

/**
 * ====================================================
 * Individual Page Settings
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_page_types( 'all' ) as $page_type_key => $page_type_data ) {
	$add[ $page_type_key . '_hero_bg_image' ] = array(
		array(
			'setting' => $page_type_key . '_hero_bg',
			'value'   => 'custom',
		),
	);

	$add[ $page_type_key . '_content_layout' ] = array(
		array(
			'setting'  => $page_type_key . '_content_container',
			'operator' => '!=',
			'value'    => 'narrow',
		),
	);

	// Archives.
	if ( preg_match( '/(_archive)/', $page_type_key ) ) {
		$add[ $page_type_key . '_title_text' ] = array(
			array(
				'setting'  => $page_type_key . '_content_header',
				'operator' => 'contain',
				'value'    => 'title',
			),
		);

		$add[ $page_type_key . '_tax_title_text' ] = array(
			array(
				'setting'  => $page_type_key . '_content_header',
				'operator' => 'contain',
				'value'    => 'title',
			),
		);
	}
}

return $add;
