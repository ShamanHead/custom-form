<?php

add_filter( 'wpsf_register_settings_custom_forms', 'wpsf_tabless_settings' );

function wpsf_tabless_settings( $wpsf_settings ) {
	// General Settings section
	$wpsf_settings[] = array(
		'section_id'          => 'general',
		'section_title'       => 'General Settings',
		'section_description' => 'Here you can set up form.',
		'section_order'       => 5,
		'fields'              => array(
			array(
				'id'          => 'hubspot-key',
				'title'       => 'Key',
				'desc'        => 'Oath2 key for hubspot.',
				'placeholder' => 'pat-eu1-7d6028c8-92d2-47f6-a237-67fbf355c40b',
				'type'        => 'text',
				'default'     => 'This is default',
			)
		)
	);

	// More Settings section.
	

	return $wpsf_settings;
}
