<?php

function provider_object( $settings ) {

	require_once $settings[ 'plugin_dir' ] . "providers/mailchimp/MailChimp.php";

	$eoi_form_meta = K::get_var( 'eoi_form_meta', $settings, array() );
	$api_key = K::get_var( 'mailchimp_api_key', $eoi_form_meta );
	if( preg_match( '/[a-z0-9]+-[a-z0-9]+/', $api_key ) ) {
		return new MailChimp( $api_key );
	} else {
		return false;
	}
}

function provider_get_lists( $settings ) {

	// Return an empty array if the object is not a valid MailChimp Api instance
	if ( ! is_a( $settings[ 'helper' ], 'MailChimp' ) ) {
		return array();
	}

	$lists = $settings[ 'helper' ]->call( 'lists/list' );
	$lists = K::get_var( 'data', $lists, array() );

	return $lists;
}

function provider_ajax_get_lists() {

	// Validate the API key
	$api_key = K::get_var( 'mailchimp_api_key', $_POST );
	$lists_formatted = array( '' => 'Not set' );

	// Make call and add lists if any
	if ( preg_match( '/[a-z0-9]+-[a-z0-9]+/', $api_key ) ) {

		global $dh_easy_opt_ins_plugin;
		$settings = $dh_easy_opt_ins_plugin->settings;
		require_once $settings[ 'plugin_dir' ] . "providers/mailchimp/MailChimp.php";

		$helper = new MailChimp( $api_key );
		$lists = $helper->call( 'lists/list' );
		$lists = K::get_var( 'data', $lists, array() );

		foreach ( $lists as $list ) {
			$lists_formatted[ $list[ 'id' ] ] = $list[ 'name' ];
		}
	}

	// Output response and exit
	echo json_encode( $lists_formatted );
	exit;
}

function provider_add_user( $settings, $user_data, $list_id ) {

	if( empty( $settings[ 'helper' ] ) ) {
		return false;
	}

	$eoi_form_meta = K::get_var( 'eoi_form_meta', $settings, array() );
	$double_opt_in = K::get_var( 'mailchimp_double_opt_in', $eoi_form_meta, 'true' );
	$double_opt_in = 'true' === $double_opt_in;

	// Subscribe user
	$subscribed = $settings[ 'helper' ]->call( 'lists/subscribe', array(
		'id'                => $list_id,
		'email'             => array( 'email' => K::get_var( 'email', $user_data ) ),
		'merge_vars'        => array( 'FNAME' => K::get_var( 'name', $user_data ) ),
		'double_optin'      => $double_opt_in,
		'replace_interests' => false,
		'send_welcome'      => false,
		'update_existing'   => true,
	) );

	// Return true if added, otherwise false
	if( 'error' === K::get_var( 'status', $subscribed ) ) {
		return false;
	} else {
		return true;
	}
}

function provider_admin_notices( $errors ) {

	/* Provider errors can be added here */

	return $errors;
}

function provider_string( $def_str ) {

	$strings = array(
		'Form integration' => __( 'MailChimp Integration' ),
	);

	return K::get_var( $def_str, $strings, $def_str );
}

function provider_integration( $helper ) {

	global $post;
	$fca_eoi = get_post_meta( $post->ID, 'fca_eoi', true );

	// Get lists from post cache $fca_eoi['_lists']
	if( FCA_EOI_CACHE_LISTS ) {
		$lists = K::get_var( '_lists', $fca_eoi );
	}
	if ( ! FCA_EOI_CACHE_LISTS || ! $lists || 'update' === K::get_var( 'cache', $_GET ) ) {
		$lists = provider_get_lists ( $helper );
		$fca_eoi[ '_lists' ] = $lists;
		delete_post_meta($post->ID, 'fca_eoi' );
		add_post_meta( $post->ID, 'fca_eoi', $fca_eoi );
	}

	// Prepare the lists for K
	$lists_formatted = array( '' => 'Not set' );
	foreach ( $lists as $list ) {
		$lists_formatted[ $list[ 'id' ] ] = $list[ 'name' ];
	}

	K::fieldset( provider_string( 'Form integration' ) ,
		array(
			array( 'input', 'fca_eoi[mailchimp_api_key]',
				array( 
					'class' => 'large-text',
					'value' => K::get_var( 'mailchimp_api_key', $fca_eoi ) 
						? K::get_var( 'mailchimp_api_key', $fca_eoi ) 
						: ''
					,
				),
				array( 'format' => '<p><label>API Key :input</label><em> <a tabindex="-1" href="http://admin.mailchimp.com/account/api" target="_blank">[Get my MailChimp API Key]</a></em></p>' )
			),
			array( 'select', 'fca_eoi[mailchimp_double_opt_in]'
				, null
				, array( 
					'format' => '<p id="double_opt_in_wrapper"><label>Double opt-in<br />:select</label></p>',
					'options' => array(
						'false' => 'No',
						'true' => 'Yes',
					),
					'selected' => K::get_var( 'mailchimp_double_opt_in', $fca_eoi ),
					'default' => 'true',
				),
			),
			array( 'select', 'fca_eoi[list_id]',
				array(
					'class' => 'select2',
					'style' => 'width: 100%;',
				),
				array(
					'format' => '<p id="list_id_wrapper"><label>List to subscribe to :select</label></p>',
					'options' => $lists_formatted,
					'selected' => K::get_var( 'list_id', $fca_eoi ),
				),
			),
		),
		array(
			'class' => 'k collapsible collapsed',
			'id' => 'fca_eoi_fieldset_form_integration',
		)
	);
}
