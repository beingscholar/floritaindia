jQuery( document ).ready(
	
	function ($) {
		
		$( "#pages_list" ).select2(
			{
				closeOnSelect : false,
				placeholder : "Select Pages",
				allowHtml: true,
				allowClear: true,
				tags: true
			}
		);
		
		if ( $('#select_all_pages_radio').is(':checked') ) {
			allpages = true;
		}
		
		else if ( $('#show_to_specific_pages_radio').is(':checked') ) {
			allpages = false;
		}

		$('.hex-color-field').wpColorPicker();
		
		var allpages;
		var url_action = $( "input[name='url-action']:checked" ).val();

		$( "#url-action-complete-content" ).click(
			function(){

				$( '#buttonname' ).attr( 'hidden', 'hidden' );
				$('#url-action-call-to-action').removeProp("checked");
			}
		);
		$( '#url-action-call-to-action' ).click(
			function(){

				$( '#buttonname' ).removeProp( 'hidden' );
				$('#url-action-complete-content').removeProp("checked");
			}
		);

		var maxField  = 999; // Input fields increment limitation
		var addButton = $( '.add_button' ); // Add button selector
		var wrapper   = $( '.field_wrapper' ); // Input field wrapper
		var fieldHTML = '<div><textarea name="field_name[]" id="" cols="30" rows="4"></textarea><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; // New input field html
		var x         = 1; // Initial field counter is 1

		// Once add button is clicked
		$( addButton ).click(
			function(){
				// Check maximum number of input fields

				if (x < maxField) {
					x++; // Increment field counter
					$( wrapper ).append( fieldHTML ); // Add field html
				}
			}
		);

		// Once remove button is clicked
		$( wrapper ).on(
			'click',
			'.remove_button',
			function(e){
				e.preventDefault();
				$( this ).parent( 'div' ).remove(); // Remove field html
				x--; // Decrement field counter
			}
		);

		var banner_enable;
		$( document ).on(
			'load',
			function(){

				if ($( '#enable-disable-banner' ).checked) {
					banner_enable = true;
				}

			}
		);

		$( '#enable-disable-banner' ).click(
			function(){
				if (this.checked) {
					banner_enable = "yes";
				} else {
					banner_enable = "no";
				}
			}
		);

		$( '#select_all_pages_radio' ).click(
			function () {

				$( '#shop_page_div' ).attr( 'hidden', 'hidden' );
				allpages = true;
			}
		);

		$( '#show_to_specific_pages_radio' ).click(
			function(){

				$( '#shop_page_div' ).removeProp( 'hidden' );
				allpages = false;
			}
		);

		$( "#banner_settings_submit" ).click(
			function() {

				var nonce_banner_settings = $( "#banner_settings" ).val();
				var pages_list            = [];
				var background_color      = $( "#background-color" ).val();
				var font_color            = $( "#font-color" ).val();
				var font_size             = $( "#font-size" ).val();
				var delay                 = $( "#font-delay" ).val();
				var banner_size           = $( "#banner-size" ).val();
				var pages_shown           = $( "input[name='pages_selection']:checked" ).val();
				var banner_postion        = $( "input[name='banner-position']:checked" ).val();
				if (pages_shown == 'show_to_all_pages') {

					pages_list = '';

				} else if (pages_shown == 'show_to_specific_pages') {
					$( '#pages_list' ).find( 'option:selected' ).each(
						function() {
							pages_list.push( $( this ).val() );
						}
					);
				}

				$.ajax(
					{
						type: 'POST',
						url: cpb_ajax_vars.url,
						data: {
							action: 'cpb_save_banner_settings',
							'banner_settings': nonce_banner_settings,
							'background-color': background_color,
							'font-color': font_color,
							'allpages' :allpages,
							'pages_shown': pages_shown,
							'pages_list': pages_list,
							'font-size':font_size,
							'font-delay':delay,
							'banner-position':banner_postion,
							'banner_size':banner_size,
						},
						beforeSend: function () {
							$( "#loader" ).show( "slow" );
						},
						success: function (data) {
							$( "#message" ).html( data ).show( 'slow' );
							$( "#loader" ).hide( "slow" );
							setTimeout(
								function () {
									$( "#message" ).hide( 'slow' );
								},
								4000
							);
						}
					}
				);

			}
		);

		$( '#general_settings_submit' ).click(
			function () {

				if ($( '#enable-disable-banner' ).prop( "checked" )) {
					banner_enable = "yes";
				} else {
					banner_enable = "no";
				}

				var nonce_general_settings = $( "#banner_general_settings" ).val();

				var targeturl       = $( "#banner-url" ).val();
				var bannerexpiry    = $( "#banner-expiry" ).val();
				var url_button_text = $( "#button_text" ).val();

				var list = wrapper.find( 'textarea' ).map(
					function() {
						if ($( this ).val() == "") {

						} else {
							return $( this ).val();
						}}
				).get();
				// send to server here

				var url_action = $( "input[name='url-action']:checked" ).val();

				$.ajax(
					{
						type: 'POST',
						url: cpb_ajax_vars.url,
						data: {
							action: 'cpb_save_general_settings',
							'banner_general_settings':nonce_general_settings,
							'enable-disable-banner':banner_enable,
							'button_text_url':url_button_text,
							'banner-text': list,
							'url_action':url_action,
							'banner-url':targeturl,
							'banner-expiry':bannerexpiry,

						},
						beforeSend: function () {
							$( "#loader" ).show( "slow" );
						},
						success: function (data) {
							$( "#message" ).html( data ).show( 'slow' );
							$( "#loader" ).hide( "slow" );
							setTimeout(
								function () {
									$( "#message" ).hide( 'slow' );
								},
								4000
							);
						}
					}
				);
			}
		);

		$( '#enable-disable-banner' ).change(
			function(){
				if (this.checked) {
					$( '.show_hide' ).removeProp( 'hidden' );
				} else {
					$( '.show_hide' ).attr( 'hidden', "hidden" );
				}
			}
		);

	}
);
