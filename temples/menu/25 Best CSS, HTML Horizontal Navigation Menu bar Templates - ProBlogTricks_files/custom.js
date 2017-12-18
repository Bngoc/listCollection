(function($){
	$(document).ready(function() {

		$( 'body' ).on( 'click', '.et_social_share', function() {
			var $this_el = $(this),
				social_network = $this_el.data( 'social_name' ),
				social_type = $this_el.data( 'social_type' ),
				media_url = 'media' == social_type ? $this_el.closest( '.et_social_media_wrapper' ).find( 'img' ).attr( 'src' ) : '',
				post_id = $this_el.data( 'post_id' ),
				share_link = 'media' == social_type ? $this_el.data( 'social_link' ) : $this_el.prop( 'href' );

			update_stats_table( social_type, social_network, media_url, post_id );

			if ( 'media' == social_type ){
				update_total_media_shares( $this_el.closest( '.et_social_media_wrapper' ) );
				update_single_shares( $this_el, media_url, post_id, social_network, 'media' );
			}

			if ( 'like' === social_network ) {
				update_single_shares( $this_el, '', post_id, social_network, 'like' );
				return false;
			}

			var left  = ( $( window ).width()/2 ) - ( 550/2 );
    		var top   = ( $( window ).height()/2 ) - ( 450/2 );
			var new_window = window.open( share_link, '', 'scrollbars=1, height=450, width=550, left=' + left + ', top=' + top );

			if ( window.focus ) {
				new_window.focus();
			}

			return false;
		} );

		$( '.et_social_follow' ).click( function() {
			var $this_el = $(this),
				social_network = $this_el.data( 'social_name' ),
				social_type = $this_el.data( 'social_type' ),
				media_url = 'media' == social_type ? $this_el.closest( '.et_social_media_wrapper' ).find('img').attr('src') : '',
				post_id = $this_el.data( 'post_id' );

			update_stats_table( social_type, social_network, media_url, post_id );

			if ( 'like' === social_network ) {
				update_single_shares( $this_el, '', post_id, social_network, 'like' );
				return false;
			}
		});

		$( 'body' ).on( 'click', '.et_social_share_pinterest', function() {
			$( '.et_social_pin_images_outer' ).fadeToggle( 400 );
			return false;
		});

		function update_stats_table( $action, $social_network, $media_url, $post_id ) {
			$stats_data = JSON.stringify({ 'action' : $action, 'network' : $social_network, 'media_url' : $media_url, 'post_id' : $post_id });
			$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'add_stats_record_db',
						stats_data_array : $stats_data,
						add_stats_nonce : monarchSettings.stats_nonce
					},
			});
		}

		function append_share_counts( $current_network ) {
			var network = $current_network.data( 'social_name' ),
				min_count = $current_network.data( 'min_count' ),
				post_id = $current_network.data( 'post_id' ),
				url = window.location.href,
				label_div = $current_network.find( '.et_social_network_label' ),
				append_to = ( 0 != ( label_div.length ) ) ? label_div : $current_network;

			$share_count_data = JSON.stringify({ 'network' : network, 'min_count' : min_count, 'post_id' : post_id, 'url' : url });

			$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_shares_count',
						share_count_array : $share_count_data,
						get_share_counts_nonce : monarchSettings.share_counts
					},
					beforeSend: function( data ){
						append_to.append( '<span class="et_social_placeholder"></span>' );
					},
					success: function( data ){
						$current_network.find( 'span.et_social_placeholder' ).remove();
						append_to.append( data );
					}
			});
		}

		function append_total_shares( $current_area ) {
			var post_id = $current_area.data( 'post_id' ),
				url = monarchSettings.pageurl !== '' ? monarchSettings.pageurl : window.location.href,
				append_to = $current_area;

			$share_total_count_data = JSON.stringify({ 'post_id' : post_id, 'url' : url });

			$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_total_shares',
						share_total_count_array : $share_total_count_data,
						get_total_counts_nonce : monarchSettings.total_counts
					},
					beforeSend: function( data ){
						append_to.append( '<span class="et_social_placeholder"></span>' );
					},
					success: function( data ){
						append_to.find( 'span.et_social_placeholder' ).remove();
						append_to.append( data );
					}
			});
		}

		function append_follow_counts( $current_area ) {
			var network = $current_area.data( 'network' ),
				min_count = $current_area.data( 'min_count' ),
				index = $current_area.data( 'index' ),
				append_to = $current_area;

			$follow_count_data = JSON.stringify({ 'network' : network, 'min_count' : min_count, 'index' : index });
			$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_follow_counts',
						follow_count_array : $follow_count_data,
						get_follow_counts_nonce : monarchSettings.follow_counts
					},
					beforeSend: function( data ){
						append_to.append( '<span class="et_social_placeholder"></span>' );
					},
					success: function( data ){
						$current_area.find( 'span.et_social_placeholder' ).remove();
						append_to.append( data );
					}
			});
		}

		function append_total_follows( $current_area ) {
			var append_to = $current_area;
			$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_follow_total',
						get_total_counts_nonce : monarchSettings.total_counts
					},
					beforeSend: function( data ){
						append_to.append( '<span class="et_social_placeholder"></span>' );
					},
					success: function( data ){
						append_to.find( 'span.et_social_placeholder' ).remove();
						append_to.append( data );
					}
			});
		}

		if ( $( '.et_social_display_follow_counts' ).length ) {
			$( '.et_social_display_follow_counts' ).each( function(){
				append_follow_counts( $( this) );
			});
		}

		if ( $( '.et_social_follow_total' ).length ) {
			$( '.et_social_follow_total' ).each( function(){
				append_total_follows( $( this) );
			});
		}


		if ( $( '.et_social_total_share' ).length ) {
			$( '.et_social_total_share' ).each( function(){
				append_total_shares( $( this) );
			});
		}

		if ( $( '.et_social_display_count' ).length ) {
			$( '.et_social_display_count' ).each( function(){
				append_share_counts( $( this) );
			});
		}

		if ( $( '.et_social_media_wrapper' ).length && $( '.et_social_media_wrapper .et_social_totalcount' ).length ) {

			$( '.et_social_media_wrapper' ).each( function() {
				 update_total_media_shares( $( this ) );
			});
		}

		if ( $( '.et_social_media_wrapper' ).length && $( '.et_social_media_wrapper .et_social_withcounts' ).length ) {

				$( '.et_social_media_wrapper .et_social_share' ).each( function() {
					var this_el = $( this ),
						media_url = this_el.closest( '.et_social_media_wrapper' ).find('img').attr('src'),
						post_id = this_el.data( 'post_id' ),
						social_network = this_el.data( 'social_name' );

					update_single_shares( this_el, media_url, post_id, social_network, 'media' );

				});
		}

		function update_total_media_shares( $element ) {
			if ( $( '.et_social_totalcount' ).length ) {
				var this_el = $element,
					media_url = this_el.find( 'img' ).attr( 'src' ),
					post_id = this_el.find( '.et_social_share' ).first().data( 'post_id' ),
					media_data = JSON.stringify({ 'media_url' : media_url, 'post_id' : post_id });

				$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_media_shares_total',
						media_total : media_data,
						get_media_shares_total_nonce : monarchSettings.media_total
					},
					success: function( data ){
						this_el.find( '.et_social_totalcount_count' ).empty().append( data );
					}
				});
			}
		}

		function update_single_shares( $this_el, $media_url, $post_id, $network, $action ) {
			if( $( '.et_social_withcounts' ).length ) {
				var media_data = JSON.stringify({ 'media_url' : $media_url, 'post_id' : $post_id, 'network' : $network, 'action' : $action });
				$.ajax({
				type: 'POST',
				url: monarchSettings.ajaxurl,
				data: {
						action : 'get_shares_single',
						media_single : media_data,
						get_media_shares_nonce : monarchSettings.media_single
					},
					success: function( data ){
						$this_el.find( '.et_social_count span' ).not('.et_social_count_label').empty().append( data );
					}
				});
			}
		}

		function setCookieExpire(days) {

			var ms = days*24*60*60*1000;

			var date = new Date();
			date.setTime(date.getTime() + ms);

			return "; expires=" + date.toUTCString();
		}

		function checkCookieValue(cookieName, value) {
			return parseCookies()[cookieName] === value;
		}

		function parseCookies() {
			var cookies = document.cookie.split('; ');

			var ret = {};
			for (var i = cookies.length - 1; i >= 0; i--) {
			  var el = cookies[i].split('=');
			  ret[el[0]] = el[1];
			}
			return ret;
		}

		function set_cookie( $expire ) {
			cookieExpire = setCookieExpire( $expire );
			document.cookie = 'etSocialCookie=true' + cookieExpire;
		}

		//separate function for the setTimeout to make it work properly within the loop.
		function make_popup_visible( $popup, $delay ){
			setTimeout( function() {
				$popup.addClass( 'et_social_visible et_social_animated' );
				if ( $( '.et_social_resize' ).length ) {
					$( '.et_social_resize' ).each( function() {
						define_popup_position( $( this ) );
					});
				}
			}, $delay );
		}

		 if( $( '.et_social_auto_popup' ).length ) {
			$( '.et_social_auto_popup' ).each( function() {
				var $current_popup_auto = $( this );
				if ( ! $current_popup_auto.hasClass( 'et_social_animated' ) ) {
					var $cookies_expire_auto = $current_popup_auto.data( 'cookie_duration' ) ? $current_popup_auto.data( 'cookie_duration' ) : false,
						$delay = '' !== $current_popup_auto.data( 'delay' ) ? $current_popup_auto.data( 'delay' ) * 1000 : 0;

					if ( ( false !== $cookies_expire_auto && ! checkCookieValue( 'etSocialCookie', 'true' ) ) || false == $cookies_expire_auto ) {

						make_popup_visible ( $current_popup_auto, $delay );

						if ( false !== $cookies_expire_auto ) {
							set_cookie( $cookies_expire_auto );
						}
					}
				}
			});
		 }

		$( '.et_social_pinterest_window .et_social_close' ).on( 'click', function(){
			$( '.et_social_pin_images_outer' ).fadeToggle( 400 );
		});

		$( '.et_social_icon_cancel' ).on( 'click', function(){
			var this_el = $( this );
			if ( this_el.parent().hasClass( 'et_social_flyin' ) ) {
				$popup = $( this ).parent();
			} else {
				$popup = $( this ).parent().parent();
			}

			$popup.fadeToggle( 400 );

			setTimeout( function() {
				$popup.remove();
			}, 400 );
			return false;
		});

		if( $( '.et_social_trigger_bottom' ).length ) {

			$( '.et_social_trigger_bottom' ).each(function(){
				var current_popup_bottom = $( this );
				if ( ! current_popup_bottom.hasClass( 'et_social_animated' ) ) {
					var	cookies_expire_bottom = current_popup_bottom.data( 'cookie_duration' ) ? current_popup_bottom.data( 'cookie_duration' ) : false,
						bottom_trigger = $( '.et_social_bottom_trigger' ).length ? $( '.et_social_bottom_trigger' ).offset().top : $( document ).height() - 500;

					$( window ).scroll( function(){
						if ( ( false !== cookies_expire_bottom && ! checkCookieValue( 'etSocialCookie', 'true' ) ) || false == cookies_expire_bottom ) {
							if( $( window ).scrollTop() + $( window ).height() > bottom_trigger ) {
								current_popup_bottom.addClass( 'et_social_visible et_social_animated' );
								if ( $( '.et_social_resize' ).length ) {
									$( '.et_social_resize' ).each( function() {
										define_popup_position( $( this ) );
									});
								}
								if ( false !== cookies_expire_bottom ) {
									set_cookie( cookies_expire_bottom );
								}
							}
						}
					});
				}
			});

		}

		if( $( '.et_social_ouibounce_modal' ).length ) {
			$( '.et_social_ouibounce_modal' ).each( function() {
				var this_el = $( this );
				$cookie_duration = this_el.data( 'cookie_duration' );
				if ( $cookie_duration > 0 ) {
					ouibounce( this_el[ 0 ], {
						cookieExpire: $cookie_duration,
						callback: function() {
									this_el.addClass('et_social_visible et_social_animated');
									if ( $( '.et_social_resize' ).length ) {
										$( '.et_social_resize' ).each( function() {
											define_popup_position( $( this ) );
										});
									}
								}
					});
				} else {
					ouibounce( this_el[ 0 ], {
						aggressive: true,
						callback: function() {
									this_el.addClass('et_social_visible et_social_animated');
									if ( $( '.et_social_resize' ).length ) {
										$( '.et_social_resize' ).each( function() {
											define_popup_position( $( this ) );
										});
									}
								}
					});
				}
			});
		}

		// open close the mobile sideabr on header click
		$( '.et_social_heading, .et_social_mobile_button' ).click( function(){
			$this_mobile_div = $( '.et_social_mobile' );

			$this_mobile_div.css( {'display' : 'block' } );
			$( '.et_social_mobile_button').removeClass( 'et_social_active_button' );

			if ( $this_mobile_div.hasClass( 'et_social_opened' ) ) {
				$this_mobile_div.find( '.et_social_networks' ).slideToggle( 600 );
				$this_mobile_div.removeClass( 'et_social_opened' ).addClass( 'et_social_closed' );
				$( '.et_social_mobile_overlay' ).removeClass( 'et_social_visible_overlay' );
				$( '.et_social_mobile_overlay' ).fadeToggle( 600 );
			} else {
				$this_mobile_div.removeClass( 'et_social_closed' ).addClass( 'et_social_opened' );
				$this_mobile_div.find( '.et_social_networks' ).slideToggle( 600 );
				$( '.et_social_mobile_overlay' ).addClass( 'et_social_visible_overlay' ).css({ 'display' : 'block' });
			}
		});

		//if close button clicked - hide the mobile sidebar from screen
		$( '.et_social_mobile .et_social_close' ).click( function(){
			$mobile_div = $( '.et_social_mobile' );
			$mobile_div.fadeToggle( 600 );
			$( '.et_social_mobile_button' ).addClass( 'et_social_active_button' );

			if ( $mobile_div.hasClass( 'et_social_opened' ) ) {
				$( '.et_social_mobile_overlay' ).fadeToggle( 600 );
				$mobile_div.removeClass( 'et_social_opened' );
				$mobile_div.find( '.et_social_networks' ).fadeToggle( 600 );
			}

		});

		// Move inline icons into appropriate sections in Divi theme
		if( $( '.et_social_inline' ).length ) {
			if ( $( 'body' ).hasClass( 'et_pb_pagebuilder_layout' ) ) {
				var top_inline = $( '.et_social_inline_top' ),
					bottom_inline = $( '.et_social_inline_bottom' ),
					divi_container = '<div class="et_pb_row"><div class="et_pb_column et_pb_column_4_4"></div></div>';

				if ( top_inline.length ) {
					$( '.et_pb_section' ).not( '.et_pb_fullwidth_section' ).first().prepend( divi_container ).find( '.et_pb_row' ).first().find( '.et_pb_column' ).append( top_inline );
				}

				if ( bottom_inline.length ) {
					$( '.et_pb_section' ).not( '.et_pb_fullwidth_section' ).last().append( divi_container ).find( '.et_pb_row' ).last().find( '.et_pb_column' ).append( bottom_inline );
				}
			}
		}

		function define_popup_position( $this_popup ) {
			setTimeout( function() { // make sure all css transitions are finished to calculate the heights correctly
				var this_popup = $this_popup,
					networks_div = this_popup.find( '.et_social_networks' ),
					header_height = this_popup.find( '.et_social_header' ).outerHeight(),
					total_count_height = this_popup.find( '.et_social_totalcount' ).height(),
					extra_height = 0 < total_count_height ? 20 : 0;

				this_popup.height( this_popup.find( '.et_social_icons_container' ).innerHeight() + header_height + total_count_height + 20 + extra_height );

				var	popup_max_height = this_popup.hasClass( 'et_social_popup_content' ) ? $( window ).height() : $( window ).height() - 60;

				if ( this_popup.hasClass( 'et_social_popup_content' ) && 768 < $( window ).width() ) {
					popup_max_height = popup_max_height - 50;
				}

				this_popup.css( { 'max-height' : popup_max_height } );

				if( this_popup.hasClass( 'et_social_popup_content' ) ) {
					var top_position = $( window ).height() / 2 - this_popup.innerHeight() / 2;
					this_popup.css( { 'top' : top_position + 'px' } );
				}

				var networks_div_height = this_popup.height() - header_height + total_count_height - extra_height;
				networks_div.height( networks_div_height );
			}, 400 );
		}

		function set_mobile_sidebar_height() {
			setTimeout( function() { // make sure all css transitions are finished to calculate the heights correctly
				var	mobile_div = $( '.et_social_mobile' );

				if ( !mobile_div.hasClass( 'et_social_opened' ) ){
					$('.et_social_mobile .et_social_networks').css({'display' : 'block'});
				}
				if( $('.et_social_active_button').length ) {
					mobile_div.css({'display' : 'block'});
				}

				var inner_contatiner_height = mobile_div.find( '.et_social_icons_container' ).innerHeight() + 45;

				if ( !mobile_div.hasClass( 'et_social_opened' ) ){
					$('.et_social_mobile .et_social_networks').css({'display' : 'none'});
				}
				if( $('.et_social_active_button').length ) {
					mobile_div.css({'display' : 'none'});
				}

				mobile_div.find( '.et_social_networks' ).css( { 'max-height' : inner_contatiner_height, 'height' : inner_contatiner_height } );
				if ( $( window ).height() < inner_contatiner_height ) {
					var inner_height = $( window ).height() - mobile_div.find( '.et_social_heading' ).innerHeight() + 10;
					mobile_div.find( '.et_social_networks' ).css({ 'height' : inner_height });
				}
			}, 400 );
		}

		function set_sidebar_position(){
			if( $( '.et_social_sidebar_networks' ).length ){
				var this_sidebar = $( '.et_social_sidebar_networks' ),
					top_position = $( window ).height() / 2 - this_sidebar.innerHeight() / 2;
					top_position = 0 > top_position ? 0 : top_position;
				this_sidebar.css( { 'top' : top_position + 'px' } );
			}
		}

		set_mobile_sidebar_height();

		set_sidebar_position();

		$( window ).resize( function(){
			if ( $( '.et_social_resize' ).length ) {
				$( '.et_social_resize' ).each( function() {
					define_popup_position( $( this ) );
				});
			}
			if ( $('.et_social_mobile') ) {
				set_mobile_sidebar_height();
			}
			if( $( '.et_social_sidebar_networks' ).length ){
				set_sidebar_position();
			}
		});

	});
})(jQuery)