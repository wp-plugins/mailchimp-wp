<?php

/**
 * @package    Easy Opt Ins
 */

$layout = array(

	'name' => __( 'Layout 4' ),

	'editables' => array(

		// Added to the fieldset "Form Background"
		'form' => array(
			'.fca_eoi_layout_4' => array(
				'background-color' => array( __( 'Form Background Color' ), '' ),
				'border-color' => array( __( 'Border Color' ), '' ),
			),
		),

		// Added to the fieldset "Headline"
		'headline' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_headline_copy_wrapper' => array(
				'font-size' => array( __('Font Size'), '25px'),
				'color' => array( __('Font Color'), '#000'),
			),
		),
		'description' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_description_copy_wrapper p' => array(
				'font-size' => array( __('Font Size'), '14px'),
				'color' => array( __('Font Color'), '#444'),
			),
		),
		'name_field' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_name_field_wrapper, .fca_eoi_layout_4 .fca_eoi_layout_4_name_field_wrapper input' => array(
				'color' => array( __( 'Font Color' ), '#999' ),
				'background-color' => array( __( 'Background Color' ), '' ),
			),
			'.fca_eoi_layout_4 .fca_eoi_layout_4_name_field_wrapper' => array(
				'border-color' => array( __('Border Color'), '#DDD'),
			),
		),
		'email_field' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_email_field_wrapper, .fca_eoi_layout_4 .fca_eoi_layout_4_email_field_wrapper input' => array(
				'color' => array( __( 'Font Color' ), '#999' ),
				'background-color' => array( __( 'Background Color' ), ''),
			),
			'.fca_eoi_layout_4 .fca_eoi_layout_4_email_field_wrapper' => array(
				'border-color' => array( __( 'Border Color' ), '#DDD'),
			),
		),
		'button' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input' => array(
				'font-size' => array( __('Font Size'), '14px'),
				'color' => array( __( 'Font Color' ), '#FFF' ),
				'background-color' => array( __( 'Background Color' ), '#39b0ff' ),
				'border-color' => array( __( 'Border Color' ), '#3498db' ),
			),
			'.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input:hover' => array(
				'background-color' => array( __( 'Hover Background Color' ), '#3498db' ),
			),
		),
		'privacy' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_privacy_copy_wrapper' => array(
				'font-size' => array( __('Font Size'), '14px'),
				'color' => array( __('Font Color'), '#999'),
			),
		),
		'fatcatapps' => array(
			'.fca_eoi_layout_4 .fca_eoi_layout_4_fatcatapps_link_wrapper a, .fca_eoi_layout_4 .fca_eoi_layout_4_fatcatapps_link_wrapper a:hover' => array(
				'color' => array( __('Font Color'), '#999'),
			),
		),
	),

	'autocolors' => array(
		array(
			'source' => '[.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input][border-color]',
			'operations' => array(
				'spin' => '0.13246234803119705',
				'desaturate' => '30.125523012552313',
				'darken' =>  '8.039215686274515',
			),
		),
		array(
			'source' => '[.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_layout_4 .fca_eoi_layout_4_submit_button_wrapper input:hover][background-color]',
			'operations' => array(
				'spin' => '0.13246234803119705',
				'desaturate' => '30.125523012552313',
				'darken' =>  '8.039215686274515',
			),
		),
	),
	
	'texts' => array(
		'headline_copy' => 'FREE EMAIL UPDATES',
		'description_copy' => 'Get the latest content first.',
		'name_placeholder' => 'Your name',
		'email_placeholder' => 'Your e-mail address',
		'button_copy' => 'SUBSCRIBE NOW',
		'privacy_copy' => "100% Privacy. We don't spam.",
	),
);
