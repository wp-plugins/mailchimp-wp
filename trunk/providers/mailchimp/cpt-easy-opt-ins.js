jQuery( document ).ready( function( $ ) {

	var $api_key = $( '[name="fca_eoi[mailchimp_api_key]"]' );
	var $lists = $( '[name="fca_eoi[list_id]"]' );
	var $lists_wrapper = $( '#list_id_wrapper' );
	var $double_opt_in_wrapper = $( '#double_opt_in_wrapper' );
            
	toggle_fields();

	// Track value to prevent duplicate AJAX request
	$api_key.data( 'value', $api_key.val() );

	$api_key.change( function() {

		var $this = $( this );
		var data = {
			'action': 'fca_eoi_get_lists', /* API action name, do not change */
			'mailchimp_api_key' : $api_key.val()
		};

		// Did the value really change
		if ( $this.val() == $api_key.data( 'value' ) ) {
			return;
		} else {
			$api_key.data( 'value', $this.val() );
		}

		$.post( ajaxurl, data, function( response ) {

			var lists = JSON.parse( response );
			var $lists = $( '<select class="select2" style="width: 100%;" name="fca_eoi[list_id]" >' );

			for ( list_id in lists ) {
				$lists.append( '<option value="' + list_id + '">' + lists[ list_id ] + '</option>' );
			}

			// Replace dropdown with new list of lists, apply Select2 then show
			$( '[name="fca_eoi[list_id]"]' ).select2( 'destroy' );
			$( '[name="fca_eoi[list_id]"]' ).replaceWith( $lists );
			$( '[name="fca_eoi[list_id]"]' ).select2();
			toggle_fields();
		} );
	} );

	/**
	 * Show/hide some fields if there are/aren't list options
	 *
	 * Don't forget that there is always the option "Not Set", 
	 * so take it into consideration when cheking the number of options
	 */
	function toggle_fields() {

		var options = $( 'option', '[name="fca_eoi[list_id]"]' );

		if( options.length > 1 ) {
			$()
				.add( $double_opt_in_wrapper )
				.add( $lists_wrapper )
				.show( 'fast' )
			;
		} else {
			$()
				.add( $double_opt_in_wrapper )
				.add( $lists_wrapper )
				.hide( )
			;
		}
	}
} );
