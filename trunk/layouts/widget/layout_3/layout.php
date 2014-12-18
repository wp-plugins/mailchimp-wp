<?php

/**
 * @package    Easy Opt Ins
 */

$layout = array(

	'name' => __( 'Layout 3' ),

	'editables' => array(

		// Added to the fieldset "Form Background"
		'form' => array(
			'.fca_eoi_layout_3' => array(
				'background-color' => array( __( 'Form Background Color' ), '#EEE' ),
				'border-color' => array( __( 'Border Color' ), '#D2D2D2' ),
			),
		),
		'headline' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_headline_copy_wrapper' => array(
				'font-size' => array( __( 'Font Size'), '30px'),
				'color' => array( __( 'Font Color'), '#FFF'),
				'background-color' => array( __( 'Background Color' ), '#344860' ),
			),
			'.fca_eoi_layout_3 .fca_eoi_layout_3_headline_copy_triangle' => array(
				'fill' => array( __( 'Fold Color' ), '#344860' ),
			)
		),
		'description' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_description_copy_wrapper' => array(
				'font-size' => array( __( 'Font Size' ), '14px'),
				'color' => array( __( 'Font Color' ), '#6D6D6D'),
			)
		),
		'name_field' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_name_field_wrapper, .fca_eoi_layout_3 .fca_eoi_layout_3_name_field_wrapper input' => array(
				'font-size' => array( __( 'Font Size' ), '14px'),
				'color' => array( __( 'Font Color' ), '#444' ),
			),
			'.fca_eoi_layout_3 .fca_eoi_layout_3_name_field_wrapper input' => array(
				'border-color' => array( __( 'Border Color' ), '#D2D2D2' ),
			),
		),
		'email_field' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_email_field_wrapper, .fca_eoi_layout_3 .fca_eoi_layout_3_email_field_wrapper input' => array(
				'font-size' => array( __( 'Font Size' ), '14px'),
				'color' => array( __( 'Font Color' ), '#444' ),
			),
			'.fca_eoi_layout_3 .fca_eoi_layout_3_email_field_wrapper input' => array(
				'border-color' => array( __( 'Border Color' ), '#D2D2D2' ),
			),
		),
		'button' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input' => array(
				'font-size' => array( __( 'Font Size' ), '14px'),
				'color' => array( __( 'Font Color' ), '#FFF' ),
				'background-color' => array( __( 'Background Color' ), '#D35500' ),
				'border-color' => array( __( 'Border Color' ), '#ac4500' ),
			),
			'.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input:hover' => array(
				'background-color' => array( __( 'Hover Background Color' ), '#ac4500' ),
			),
		),
		'privacy' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_privacy_copy_wrapper' => array(
				'font-size' => array( __( 'Font Size' ), '13px'),
				'color' => array( __( 'Font Color' ), '#B3B3B3' ),
			),
		),
		'fatcatapps' => array(
			'.fca_eoi_layout_3 .fca_eoi_layout_3_fatcatapps_link_wrapper a, .fca_eoi_layout_3 .fca_eoi_layout_3_fatcatapps_link_wrapper a:hover' => array(
				'color' => array( __( 'Font Color' ), '#D8722B'),
			),
		),
	),

	'autocolors' => array(
		array(
			'source' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_headline_copy_wrapper][background-color]',
			'destination' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_headline_copy_triangle][fill]',
			'operations' => array(),
		),
		array(
			'source' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input][border-color]',
			'operations' => array(
				'spin' => '-0.10084867188361457',
				'darken' =>  '7.647058823529407',
			),
		),
		array(
			'source' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input][background-color]',
			'destination' => '[.fca_eoi_layout_3 .fca_eoi_layout_3_submit_button_wrapper input:hover][background-color]',
			'operations' => array(
				'spin' => '-0.10084867188361457',
				'darken' =>  '7.647058823529407',
			),
		),
	),

	'texts' => array(
		'headline_copy' => 'Free Report',
		'description_copy' => 'Enter your email below and I\'ll send you my exclusive report on "The 10 Best Cat Memes Ever".',
		'name_placeholder' => 'Name',
		'email_placeholder' => 'Email',
		'button_copy' => 'Instant Download',
		'privacy_copy' => "No spam. Unsubscribe anytime.",
	),
);
