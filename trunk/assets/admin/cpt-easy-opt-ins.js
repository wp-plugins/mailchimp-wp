jQuery( document ).ready( function( $ ) {

	// How long to throttle
	var t = 100;

	// Used to decide weither to show a message on beforeunload or not
	var ts = time();

	// Is this a new opt-in form
	var fca_eoi_new_post = Boolean( $( 'body.post-new-php').length );

	// Use Layout 2 by default
	$( '#fca_eoi_layout_select' )
		.filter( function() { return fca_eoi_new_post; } )
		.val( 'layout_2' )
	;

	// Use Mailchimp by default
	$( '[name="fca_eoi[provider]"]' )
		.filter( function() { return fca_eoi_new_post; } )
		.val( 'mailchimp' )
	;

	// Helpers
	var providers_fieldsets_selector = '[id^=fca_eoi_fieldset_form_][id$=_integration]';

	// Prompt before close if the user spends more than 3 seconds in the page
	$( window ).bind( 'beforeunload' , function() {

		var message = 'The form has not been saved.';
		var ts_diff = time() - ts;

		if ( 3 < ts_diff ) {
			return message;
		}
	});

	// Unbind beforeunload event handler
	$( document ).on( 'click', '#publish', function () {

		$( window ).unbind( 'beforeunload' );
	} );

	// Remove main postbox frame
	$( '#fca_eoi_meta_box_nav' )
		.removeClass( 'postbox' )
		.find( ' > :not(.inside)' )
		.remove()
	;

	// Show only the selected provider
	$( '[name="fca_eoi[provider]"]' )
		.change( function() {

			var $this = $( this );
			var provider_id = $this.val();

			$( providers_fieldsets_selector )
				.slideUp( 'fast' )
			;

			if ( provider_id ) {
				$( '#fca_eoi_fieldset_form_' + provider_id + '_integration' )
					.slideDown( 'fast' )
				;
			}
		} )
		.change()
	;

	// Use tabs in the main metabox
	$( '.nav-tab-wrapper > a' ).click( function( e ) {

		var target_hash = $( this ).attr( 'href' );

		e.preventDefault();
		$( '.nav-tab-wrapper > a' ).removeClass( 'nav-tab-active' );
		$( this ).blur().addClass( 'nav-tab-active' );

		$( 'div[id^=fca_eoi_meta_box_]' )
			.not( '#fca_eoi_meta_box_nav' )
			.hide()
		;
		$( target_hash ).show();
		if( '#fca_eoi_meta_box_build' == target_hash ) {
			$( '#fca_eoi_meta_box_provider' ).show();
			$( '#fca_eoi_meta_box_publish' ).show();
			$( '#fca_eoi_meta_box_thanks' ).show();
			$( '#fca_eoi_meta_box_powerups' ).show();
		}
	} );

	// Use smaller tabs for layout types
	$( 'a[href^="#layouts_type_"]' ).click( function( e ) {

		var $this = $( this );

		e.preventDefault();

		$( 'a[href^="#layouts_type_"]' ).parent().removeClass( 'tabs' );
		$this.parent().addClass( 'tabs' );

		$( 'div[id^="layouts_type_"]' ).hide();
		$( $this.attr( 'href' ) ).show();
		$this.blur();
	} );

	// Show the mini-tab containing the current layout
	$( 'a[href^="#layouts_type_' + fca_eoi_layout_type( fca_eoi_current_layout_id() ) + '"]' ).click();

	// Hide Tabs
	$( '#fca_eoi_meta_box_nav' ).hide();
	$( '[href="#fca_eoi_meta_box_build"]' ).click();

	// Apply select2
	$( '.select2' ).select2();

	// Switch layout when screenshot clicked
	$( '.fca_eoi_layout' ).click( function( e ) {
		// Determine the layout that was clicked
		var layout_id = $( e.target ).closest( '.fca_eoi_layout' ).data( 'layout-id' );
		// Mark active
		$( '.fca_eoi_layout' )
			.removeClass( 'active' )
			.filter( function() { return $( this ).data( 'layout-id' ) == layout_id; } )
			.addClass( 'active' )
		;
		// Update select box
		$( '#fca_eoi_layout_select' ).val( layout_id ).change();

		// Show corresponding publication fields
		$( '[id^=fca_eoi_publish_]').hide();
		$( '#fca_eoi_publish_' + fca_eoi_layout_type( fca_eoi_current_layout_id() ) ).show();
		$( '[href="#fca_eoi_meta_box_build"]' ).click();
	} );

	// Handle "Switch layout button"
	$( document ).on( 'click', '#fca_eoi_show_setup', function( e ) {

		e.preventDefault();
		$( '[href="#fca_eoi_meta_box_setup"]' ).click();
	} );

	// Mark current layout
	$( '.fca_eoi_layout' )
		.filter( function() { return ( $( this ).data( 'layout-id' ) == $( '#fca_eoi_layout_select option:selected').val() ); } )
		.click()
	;

	// Add editables settings
	$( 'script[id^=fca_eoi_editables_]' ).each( function() {
		
		var $this = $( this );
		var layout_id = $this.attr( 'id' ).replace( 'fca_eoi_editables_', '' );
		var editables = JSON.parse( $this.html() );
		var label, group, html, property, selector, value;
		var post_meta = JSON.parse( $( '#fca_eoi_post_meta').html() );

		// Exit here if the layout has no editables
		if ( ! editables ) {
			return;
		}

		for ( group in editables ) {
			html = '<div class="fca_eoi_settings_' + layout_id + '"><hr />';
			for ( selector in editables[ group ] ) {
				for ( property in editables[ group ][ selector ] ) {
					name = 'fca_eoi[:layout_id][:selector][:property]';
					name = name
						.replace( ':layout_id', layout_id )
						.replace( ':selector', selector )
						.replace( ':property', property )
					;
					label = editables[ group ][ selector ][ property ][0];
					if ( /* Has value */
						true
						&& 'undefined' !== typeof( post_meta[ layout_id ] ) 
						&& 'undefined' !== typeof( post_meta[ layout_id ][ selector ] ) 
						&& post_meta[ layout_id ][ selector ][ property ] 
					) {
						if ( [ 'font-style', 'font-weight', 'text-decoration' ].indexOf( property ) > -1 ) { 
							/* Toggles should pass true or false to fca_eoi_property_field_html() */
							value = ( 'undefined' !== typeof( post_meta[ layout_id ][ selector ][ property ] ) )
								? 'true'
								: 'false'
							;
						} else {
							// Not a toggle, and has a value
							value = post_meta[ layout_id ][ selector ][ property ];
						}
					} else { 
						// No value? Then use the default
						value = editables[ group ][ selector ][ property ][1];
						// Unless it's a (1) color (2) on an existing form (3) using this layout
						if (
							! fca_eoi_new_post
							&& [ 'fill', 'color', 'background-color', 'border-color', 'border-top-color', 'border-bottom-color' ].indexOf( property ) >= 0
							&& post_meta.layout === layout_id
						) {
							value = '';
						}
					}
					html += fca_eoi_property_field_html( property, name, label, selector, value );
				}
			}
			html += '</div>';
			$( '#fca_eoi_fieldset_' + group ).append( html );
		}
	} );

	// Load template into preview zone on template change
	$( '#fca_eoi_layout_select' ).change( function() {
		
		var layout_id, template_html;
		
		layout_id = $( '#fca_eoi_layout_select option:selected').val();
		template_html = $( '#fca_eoi_template_' + layout_id ).html();
		$( '#fca_eoi_preview' ).html( template_html );

		// Show current layout settings and hide for others
		$( '[class^=fca_eoi_settings_]' ).hide();
		$( '.fca_eoi_settings_' + layout_id ).show();

		// Fake trigger to force template re-fill
		$( 'input, select, textarea', '#fca_eoi_settings' ).first().change();
	} );

	// Load default text when first creating an opt-in
	$( '#fca_eoi_layout_select' ).filter( function() { return fca_eoi_new_post; } ).change( function() {

		var layout_location_names = [ 'headline_copy', 'description_copy', 'name_placeholder', 'email_placeholder', 'button_copy', 'privacy_copy' ];
		var layout_id = $( '#fca_eoi_layout_select option:selected').val();
		var layout_texts_defaults_json = JSON.parse( $( '#fca_eoi_texts' ).html() );
		var layout_texts_json = JSON.parse( $( '#fca_eoi_texts_' + layout_id ).html() );
		var layout_text;

		for( i in layout_location_names ) {
			if( ! layout_texts_json || 'undefined' === typeof( layout_texts_json[ layout_location_names[ i ] ] ) ) {
				layout_text = layout_texts_defaults_json[ layout_location_names[ i ] ];
			} else {
				layout_text = layout_texts_json[ layout_location_names[ i ] ];
			}
			$( '[name="fca_eoi[' + layout_location_names[ i ] + ']"]' ).val( layout_text ).change();
			// Handle the naughty WP editors
			if( 'description_copy' === layout_location_names[ i ] ) {
				var $description_wpe = $( '[id^=wp-fca_eoi_description_copy]' );
				var $description_wpe_iframe = $( 'iframe', $description_wpe );
				var $description_wpe_iframe_body = $description_wpe_iframe.contents().find( 'body' );
				$description_wpe_iframe_body.html( layout_text );
			}
		}
	} );

	// Reset data-selected
	$( 'select[data-selected]' ).change( function() {
		
		var $this = $( this );
		var selected = $( 'option:selected', $this ).val()

		$this.data( 'selected', selected );
	} );

	// Setup toggle checked property
	$( '[data-is-checked=true]' ).prop( 'checked', 'checked' );

	// Colorize toggles
	function update_toggles() {
		$( 'input[type=checkbox]:not(:checked)' ).parent( '.fca_eoi_toggle' ).removeClass( 'active' );
		$( 'input[type=checkbox]:checked' ).parent( '.fca_eoi_toggle' ).addClass( 'active' );
	}
	update_toggles();
	$( 'input[type=checkbox]' ).change( update_toggles );

	// Rebuild preview when an element is changed,
	// We should debounce, but we get errors (unsolved yet)
	$( 'input, select, textarea', '#fca_eoi_settings' )
		.bind( 'change keyup', debounce( function() {

			// var start_time = new Date().getMilliseconds();
			var $field, layout_editables_json, layout_id, output, template_html, view;

			layout_id = $( '#fca_eoi_layout_select option:selected').val();
			template_html = $( '#fca_eoi_tpl_' + layout_id ).html();
			view = {
				headline_copy          : $( '[name="fca_eoi[headline_copy]"]' ).val()
				, description_copy     : $( '[name="fca_eoi[description_copy]"]' ).val()
				, privacy_copy         : $( '[name="fca_eoi[privacy_copy]"]' ).val()
				, name_placeholder     : $( '[name="fca_eoi[name_placeholder]"]' ).val()
				, email_placeholder    : $( '[name="fca_eoi[email_placeholder]"]' ).val()
				, button_copy          : $( '[name="fca_eoi[button_copy]"]' ).val()
				, show_name_field      : $( '[name="fca_eoi[show_name_field]"]:checked' ).length
				, show_fatcatapps_link : $( '[name="fca_eoi[show_fatcatapps_link]"]:checked' ).length
			};
			Mustache.parse( template_html );
			output_html = Mustache.render( template_html, view );
			// Add button for changing type and layout

			output_html = '<p style="text-align: end; width: 100%;" ><a class="button" href="#" id="fca_eoi_show_setup">Change Layout</a></p>' + output_html;

			// Editables 
			output_html += '<style>';
			layout_editables_json = JSON.parse( $( '#fca_eoi_editables_' + layout_id ).html() );
			for ( group in layout_editables_json ) {
				for ( selector in layout_editables_json[ group ] ) {
					output_html += selector + '{';
					for ( property in layout_editables_json[ group ][ selector ] ) {
						name = 'fca_eoi[:layout_id][:selector][:property]';
						name = name
							.replace( ':layout_id', layout_id )
							.replace( ':selector', selector )
							.replace( ':property', property )
						;
						$field = $( '[name="' + name + '"]' );
						value = $field.val();
						// Skip unchecked checboxes
						if( $field.is( ':checkbox:not(:checked)' ) ) {
							continue;
						}
						output_html += property + ':' + value + ' !important;'
					}
					output_html += '}';
				}
			}
			output_html += '</style>';

			$( '#fca_eoi_preview' ).html( output_html );

			// Update select boxes
			$( 'select[data-selected]' ).each( function() {
				
				var $this = $( this );
				var selected = $( this ).data( 'selected' );

				if ( selected ) {
					$( 'option[value=' + selected + ']', $this ).attr( 'selected', 'selected' );
				}
			} );

			// console.log( 'Template Rebuilt (in ' + ( new Date().getMilliseconds() - start_time) + 'ms)' )
		} , t ) );
	;

	// Detect remote change
	$( 'input, textarea' ).each( function() {
		var $this = $( this );

		$this.data( 'value', $this.val() );
		setInterval( function() {
			if( $this.val() !== $this.data( 'value' ) ) {
				// Trigger a change only if the element is not currently focused
				if( $this.not( ':focus' ) ) {
					$this.change();
				}
				$this.data( 'value', $this.val() );
			}
		}, t );
	} );

	// Expand working fieldset
	$( '#fca_eoi_preview' ).click( function() {
		$( '#fca_eoi_fieldset_form:not(.expanded) legend').click();
	} );
	$( document ).on( 'click', '[data-fca-eoi-fieldset-id]', function() {

		var $this = $( this );
		var fieldset_id = $this.data( 'fca-eoi-fieldset-id' );

		$( '#fca_eoi_fieldset_' + fieldset_id + ':not(.expanded) legend').click();
	} );

	// Highlight current preview element
	setInterval( function() {

		$( '.fca_eoi_highlighted', '#fca_eoi_preview' ).removeClass( 'fca_eoi_highlighted' );
		$( '#fca_eoi_settings fieldset.expanded' ).each( function() {
			
			var $fieldset = $( this );
			var $fieldset_id = $fieldset.attr( 'id' ).replace( 'fca_eoi_fieldset_', '' );
			var $element = $( '[data-fca-eoi-fieldset-id=' + $fieldset_id + ']', '#fca_eoi_preview' );

			// Highlight element or closest block level element
			if( $element.is( 'p, div, h1, h2, h3, h4, h5, h6' ) ) {
				$element.addClass( 'fca_eoi_highlighted' );
			} else {
				$element.closest( 'p, div, h1, h2, h3, h4, h5, h6' ).addClass( 'fca_eoi_highlighted' );
			}
		} );
	}, t );

	// Disable submit of from the preview form
	$( document ).on( 'keypress', '#fca_eoi_preview input', function( e ) {

		if (e.keyCode == 13) {
			e.preventDefault();
		}
	} );
	$( document ).on( 'click', '#fca_eoi_preview input[type=submit]', function( e ) {

		e.preventDefault();
	} );

	// Detect change on WordPress editors
	setInterval( function() {

		$( '.wp-editor-wrap' ).each( function() {
			
			var $this = $( this );
			var $iframe = $( 'iframe', $this );
			var value = $iframe.contents().find('body').html();
			var value_old = $this.data('value');


			// Exit if the iframe was not added yet
			if( ! $iframe.length ) {
				return;
			}

			// Ignore <p></p>
			if( - 1 != [ '<p>&nbsp;</p>', '<p><br data-mce-bogus="1"></p>' ].indexOf( value ) ) {
				value = '';
			}

			// Value changed? Update textarea
			if( value !== value_old ) {
				$this.data( 'value', value );
				$( '.wp-editor-area', $this ).val( value ).change();
			}
		} );
	}, t );

	// Generates editables fields html 
	function fca_eoi_property_field_html( property, property_name, property_label, property_field, property_value ){

		var $ = jQuery;
		var property_tpl;
		var view;
		var post_meta = JSON.parse( $( '#fca_eoi_post_meta').html() );
		var layout_id = $( '#fca_eoi_layout_select option:selected' ).val();

		view = {
			property_name: property_name
			, property_label: property_label
			, property_value: property_value
			, selected: property_value
			, property_is_checked: property_value
		};

		// Colors
		if ( [ 'fill', 'color', 'background-color', 'border-color', 'border-top-color', 'border-bottom-color' ].indexOf( property ) >= 0 ) {
			property_tpl = $( '#fca_eoi_property_color' ).html();
		} else if ( [ 'font-size' ].indexOf( property ) >= 0 ) {
			property_tpl = $( '#fca_eoi_property_font-size' ).html();
		} else if ( [ 'font-style', 'font-weight', 'text-decoration' ].indexOf( property ) >= 0 ) {
			property_tpl = $( '#fca_eoi_property_icon' ).html();
			switch ( property ) {
			case 'font-style' : 
				view[ 'icon' ] = '<i class="fa fa-italic"></i>';
				view[ 'property_value' ] = 'italic';
				view[ 'property_value_unchecked' ] = 'normal';
				break;
			case 'font-weight' : 
				view[ 'icon' ] = '<i class="fa fa-bold"></i>';
				view[ 'property_value' ] = 'bold';
				view[ 'property_value_unchecked' ] = 'normal';
				break;
			case 'text-decoration' : 
				view[ 'icon' ] = '<i class="fa fa-underline"></i>';
				view[ 'property_value' ] = 'underline';
				view[ 'property_value_unchecked' ] = 'none';
				break;
			}
		} else {
			return '<p>Property <em>' + property + '</em> not yet implemented.</p>';
		}
		return Mustache.render( property_tpl, view );
	}

	function fca_eoi_current_layout_id() {

		return $( '#fca_eoi_layout_select option:selected' ).val();
	}

	function fca_eoi_layout_type( id ) {

		return $( '[data-layout-id=' + id + ']' ).data( 'layout-type' );
	}

	// If creating a new opt-in tick some checkboxes
	$( '[name="fca_eoi[show_name_field]"]' )
		.filter( function() { return fca_eoi_new_post; } )
		.attr( 'checked', 'checked' )
	;
	// $( '[name="fca_eoi[show_fatcatapps_link]"]' )
	// 	.filter( function() { return fca_eoi_new_post; } )
	// 	.attr( 'checked', 'checked' )
	// ;

	// If editing an existing post, focus on the "Build" tab
	$( 'a[href="#fca_eoi_meta_box_build"]', 'body.post-php' ).click();

	// If adding a new opt-in form, focus on the title
	setTimeout( 
		function() {
			if( $( '#title' ).val() ) {
				return;
			}
			$( '#title' ).focus();
			$( '#title-prompt-text' ).removeClass( 'screen-reader-text' );
		} , 500
	);

	// Make sure the form is updates once (headline size would't update if we don't)
	setTimeout( function() { jQuery( '[name="fca_eoi[name_placeholder]"]' ).change(); } , 500 );
	setTimeout( function() { jQuery( '[name="fca_eoi[name_placeholder]"]' ).change(); } , 1500 );
	setTimeout( function() { jQuery( '[name="fca_eoi[name_placeholder]"]' ).change(); } , 2500 );

	// Handle jscolor's #transparent link
	$( 'a[href="#transparent"]' ).click( function( e ) {

		e.preventDefault();
		$( this ).siblings('input').val( '' ).css( 'background-color', '' );
	} );

	// Make sure JScolor is updated on change
	$( 'input.color' ).change( function() {

		var $this = $( this );
		$this.css( 'background-color', $this.val() );
	} );

	// Actions when form is complete
	$( '[name="fca_eoi[provider]"],[name="fca_eoi[thank_you_page]"],[name^="fca_eoi["][name$="_list_id]"]', '#fca_eoi_settings' ).change( function() {
		var $this = $( this );
		var $provider = $( '[name="fca_eoi[provider]"] option:selected' );
		var provider = $provider.val();
		var list_id = false;
		var thank_you_page = $( '[name="fca_eoi[thank_you_page]"] option:selected' ).val();
		var form_is_ready = false;

		if( provider ) {
			list_id = $( '[name="fca_eoi[' + provider + '_list_id]"] option:selected' ).val();
			if( list_id && thank_you_page ) {
				form_is_ready = true;
			}
		} else {
			list_id = $( '[name$="_list_id]"] option:selected' ).val();
			if( list_id && thank_you_page ) {
				form_is_ready = true;
			}
		}

		if( form_is_ready ) {
			/* Nothing here for now */
		}
	} ).change();

	// Hide new page link if Thank You Page is set
	$( 'select', '#fca_eoi_meta_box_thanks' ).change( function() {

		var $this = $( this );
		var $p = $( 'p', '#fca_eoi_meta_box_thanks' ).filter( ':last' );

		if( $this.val() ) {
			$p.hide();
		} else {
			$p.show();
		}
	} ).change();

	// Override saving throbber text
	$( '#publish' ).click(function(){
		postL10n.publish = 'Saving';
		postL10n.update= 'Saving';
	});

	// Duplicate the Save button and add to the button of the page
	$( '#submitdiv' ).clone( true ).appendTo( '#normal-sortables' );

	// Autoselect
	$(".autoselect")
		.bind( 'click focus mouseenter', function() { $( this ).select() } )
		.mouseup( function( e ) { e.preventDefault } )
	;

	// Debounce
	function debounce( fn, threshold ) {

		var timeout;
		return function debounced() {
			if ( timeout ) {
				clearTimeout( timeout );
			}
			function delayed() {
				fn();
				timeout = null;
			}
			timeout = setTimeout( delayed, threshold || 100 );
		}
	}

	function time() {

		return Math.floor( new Date().getTime() / 1000 );
	}
} );

jQuery( window ).load( function( $ ) {

	// Remove FOUC, don't show metaboxes and likes until page is fully loaded
	jQuery( '#fca_eoi_layout_select' ).change();
	
	// Fake triggers to load template
	jQuery( '#poststuff' ).fadeTo( 'fast', '1' );
} );
