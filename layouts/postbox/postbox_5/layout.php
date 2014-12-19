<?php

/**
 * @package Easy Opt Ins
 */

$layout = array(

	'name' => __( 'Postbox 5' ),

	'editables' => array(

		// Added to the fieldset "Form Background"
		'form' => array(
			'.fca_eoi_postbox_5' => array(
				'background-color' => array( __( 'Form Background' ), '#f6f6f6' ),
				'border-color' => array( __( 'Border Color' ), '#ccc' ),
			),
		),

		// Added to the fieldset "Headline"
		'headline' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_headline_copy_wrapper' => array(
				'font-size' => array( __('Font Size'), '28px'),
				'color' => array( __('Font Color'), '#1A78D7'),
			),
		),
		'description' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_description_copy_wrapper p' => array(
			),
		),
		'name_field' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_name_field_wrapper, .fca_eoi_postbox_5 .fca_eoi_postbox_5_name_field_wrapper input' => array(
				'font-size' => array( __( 'Font Size' ), '18px' ),
				'color' => array( __( 'Font Color' ), '#777' ),
				'background-color' => array( __( 'Background Color' ), '#FFF' ),
			),
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_name_field_wrapper' => array(
				'border-color' => array( __('Border Color'), '#CCC'),
			),
		),
		'email_field' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_email_field_wrapper, .fca_eoi_postbox_5 .fca_eoi_postbox_5_email_field_wrapper input' => array(
				'font-size' => array( __( 'Font Size' ), '18px' ),
				'color' => array( __( 'Font Color' ), '#777' ),
				'background-color' => array( __( 'Background Color' ), '#FFF'),
			),
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_email_field_wrapper' => array(
				'border-color' => array( __( 'Border Color' ), '#CCC'),
			),
		),
		'button' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input' => array(
				'font-size' => array( __('Font Size'), '18px' ),
				'color' => array( __( 'Font Color' ), '#FFF' ),
				'background-color' => array( __( 'Button Color' ), '#FF7746' ),
				'border-color' => array( __( 'Border Color' ), '#FF2828' ),
			),
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input:hover' => array(
				'background-color' => array( __( 'Hover Background Color' ), '#fc561f' ),
			),
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper' => array(
				'background-color' => array( __( 'Container Background Color' ), '#FF7746' ),
				'border-color' => array( __( 'Container Bottom Bolor' ), '#FF7746' ),
			),
		),
		'privacy' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_privacy_copy_wrapper' => array(
				'font-size' => array( __('Font Size'), '14px'),
				'color' => array( __('Font Color'), '#8F8F8F'),
			),
		),
		'fatcatapps' => array(
			'.fca_eoi_postbox_5 .fca_eoi_postbox_5_fatcatapps_link_wrapper a, .fca_eoi_postbox_5 .fca_eoi_postbox_5_fatcatapps_link_wrapper a:hover' => array(
				'color' => array( __('Font Color'), '#8F8F8F'),
			),
		),
	),

	'autocolors' => array(
		array(
			'source' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input][border-color]',
			'operations' => array(
				'spin' => '-15.89189189189189',
				'darken' => '5.882352941176472',
			),
		),
		array(
			'source' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input:hover][background-color]',
			'operations' => array(
				'spin' => '-0.95976519505931',
				'desaturate' => '2.643171806167388',
				'darken' => '8.235294117647052',
			),
		),
		array(
			'source' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper][background-color]',
			'operations' => array(
				'spin' => '3.4022257551669366',
				'darken' => '13.725490196078427',
			),
		),
		array(
			'source' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_postbox_5 .fca_eoi_postbox_5_submit_button_wrapper][border-color]',
			'operations' => array(
				'spin' => '3.4022257551669366',
				'darken' => '13.725490196078427',
			),
		),

	),

	'texts' => array(
		'headline_copy' => 'Free Email Updates',
		'description_copy' => 'Get the latest content first.',
		'name_placeholder' => 'Name',
		'email_placeholder' => 'Email',
		'button_copy' => 'Join Now',
		'privacy_copy' => "100% Privacy. We don't spam.",
	),
);
