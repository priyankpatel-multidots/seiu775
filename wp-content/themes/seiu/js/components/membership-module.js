import $ from 'jquery';

let Flickity = require( 'flickity-imagesloaded' );

const selectors = {
	slider: '[data-membership-plus-slider]',
};

const sliderOptions = {
	cellAlign: 'center', contain: true, pageDots: false, adaptiveHeight: false, wrapAround: true,
};

const membersSecondaryMenu = '.top-menu #menu-members-secondary-menu',
	telIcon                = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M493.1 351.2L384.6 304.7c-12.78-5.531-27.8-1.812-36.48 8.969l-44.05 53.81c-69.25-34-125.5-90.28-159.5-159.5l53.83-44.09c10.75-8.781 14.42-23.66 8.984-36.44L160.8 18.93C154.7 5.027 139.7-2.598 124.1 .8079L24.22 24.06C9.969 27.31 0 39.84 0 54.5C0 306.8 205.2 512 457.5 512c14.67 0 27.2-9.969 30.47-24.22l23.25-100.8C514.6 372.4 507 357.2 493.1 351.2zM480 0h-96c-17.67 0-32 14.33-32 32s14.33 32 32 32h18.75l-105.4 105.4c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0L448 109.3V128c0 17.67 14.33 32 32 32s32-14.33 32-32V32C512 14.33 497.7 0 480 0z"/></svg>',
	emailIcon              = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 352c-16.53 0-33.06-5.422-47.16-16.41L0 173.2V400C0 426.5 21.49 448 48 448h416c26.51 0 48-21.49 48-48V173.2l-208.8 162.5C289.1 346.6 272.5 352 256 352zM16.29 145.3l212.2 165.1c16.19 12.6 38.87 12.6 55.06 0l212.2-165.1C505.1 137.3 512 125 512 112C512 85.49 490.5 64 464 64h-416C21.49 64 0 85.49 0 112C0 125 6.01 137.3 16.29 145.3z"/></svg>';
let telElem                = '',
	telText                = '',
	emailElem              = '',
	emailText              = '';

document.addEventListener( 'DOMContentLoaded', () => {

	telElem   = membersSecondaryMenu + '> li.has-tel-icon-in-mobile a';
	telText   = $( telElem ).html();
	emailElem = membersSecondaryMenu + '> li.has-mail-icon-in-mobile a';
	emailText = $( emailElem ).html();

	$( membersSecondaryMenu ).prepend( '<li class="no-link menu-item"><a href="javascript:void(0)">Contact Us: </a></li>' );
	if ( $( selectors.slider ).length > 0 ) {
		window.testimonialsSlider = new Flickity( selectors.slider, sliderOptions );
		$( window ).on( 'load', () => {
			window.testimonialsSlider.resize();
		} );

		// Flickity instance
		// previous.
		$( '.slider-button.previous' ).on( 'click', function () {
			testimonialsSlider.previous();
		} );
		// next.
		$( '.slider-button.next' ).on( 'click', function () {
			testimonialsSlider.next();
		} );
	}

	const stickyHeight = getStickyElementsHeight();
	$( '#member-info-modal' ).css( {
		'height': `calc( 100vh - ${stickyHeight}px )`, 'top': `${stickyHeight}px`
	} );

	$( document ).on( 'click', 'a[rel^="modal:"]', function ( event ) {
		const target = $( this.hash );
		if ( '' !== target && null !== target ) {
			event.preventDefault();
			$( $( this ).attr( 'href' ) ).removeClass( 'd-none' );
			$( 'body' ).addClass( 'modal-visible' );
		}
	} );

	$( '#member-info-modal .close-panel--inner svg' ).click( function () {
		$( '#member-info-modal' ).addClass( 'd-none' );
		$( 'body' ).removeClass( 'modal-visible' );
	} );

	$( '#member-info-modal .member-info-panel #member-info--update > div > .edit-icon' ).click( function () {
		const elem_instance = $( this );
		elem_instance.parent().toggleClass( 'edit-enabled' );
		setTimeout( function () {
			elem_instance.siblings( '.input' ).trigger( 'focus' );
			SetCaretAtEnd( elem_instance.siblings( '.input' ).get( 0 ) );
		}, 100 );
	} );

	$( document ).on ( 'click', '.membership-events--list-item .wp-block-button__link', function(event) {
		event.preventDefault();
		const elem     = $( this ),
			event_id   = elem.attr( 'data-event-id' ),
			currentstage = elem.attr( 'data-event-cstage' ),
			nextstage = elem.attr( 'data-event-nstage' ),
			event_link = elem.attr( 'href' );

		elem.css( 'display', 'none' );
		elem.prev().css( 'display', 'inline-grid' );

		if ( event_id !== null && event_id !== '' ) {
			$.ajax( {
				url: seiuAjax.ajax_url, type: 'POST', data: {
					action: 'register_member_for_event', event_id: event_id,
				}, success: function ( response ) {
					// console.log( response );
					response = $.parseJSON( response );
					console.log(response);
					if ( response.code === 200 ) {
						if ( event_link === '#' ) {
							elem.prev().css( 'display', 'none' );
							elem.text( 'RSVPed' );
							elem.css( 'display', 'inline-block' ).addClass( 'disabled' );
						} else {
							setTimeout( function () {
								window.open ( event_link, '_blank' );
								elem.prev().css( 'display', 'none' );
								elem.css( 'display', 'inline-block' );
							}, 500 );
						}
					} else {
						$('.event-alert').css( 'display', 'show' );
						elem.remove();
					}
				},
			} );
		}
	} );

	const memberInfoForm = '#member-info-modal form#member-info--update';
	$( document ).on( 'submit', memberInfoForm, function ( event ) {

		event.preventDefault();

		$( memberInfoForm + ' > div input[type=submit]' ).css( 'display', 'none' );
		$( memberInfoForm + ' > div .btn.is-icon' ).css( 'display', 'block' );

		let numberOfFieldsChanged = 0;
		const requestObject       = {};
		requestObject.memberId    = $( 'input[name=memberId]', this ).val();
		requestObject.status      = 'Update';

		$( '.input-control', this ).each( function () {
			const value     = $( this ).children( '.input' ).val(),
				placeholder = $( this ).children( '.placeholder' ).text(),
				id          = $( this ).children( '.input' ).attr( 'name' );
			if ( value !== placeholder ) {
				requestObject[id] = value;
				numberOfFieldsChanged++;
			}
		} );

		if ( numberOfFieldsChanged > 0 ) {
			$.ajax( {
				url: seiuAjax.ajax_url, type: 'POST', data: {
					action: 'update_member_info', formData: requestObject,
				}, success: function ( response ) {
					// console.log( response );
					response = $.parseJSON( response );
					if ( response.code === 200 ) {
						$('.success').css( 'display', 'block' );
						$('#member-info--update').css( 'display', 'none' );
					} else {
						$('.error').css( 'display', 'block' );
						$('#member-info--update').css( 'display', 'none' );
					}
					$( memberInfoForm + ' > div .btn.is-icon' ).css( 'display', 'none' );
				},
			} );
		} else {
			$( memberInfoForm + ' > div input[type=submit]' ).css( 'display', 'block' );
			$( memberInfoForm + ' > div .btn.is-icon' ).css( 'display', 'none' );
		}
	} );
	$(window).trigger('resize');

	// Pre-populate Get Involved FormAssembly form with available member information.
	if ( seiuAjax.memberObject != 'undefined' ) {
		const formId = '.wFormContainer .wForm > form#4901705';
		$( formId + ' input#tfa_1987' ).val( seiuAjax.memberObject.memberId );
		$( formId + ' input#tfa_1' ).val( seiuAjax.memberObject.firstName );
		$( formId + ' input#tfa_2' ).val( seiuAjax.memberObject.lastName );
		$( formId + ' input#tfa_1873' ).val( seiuAjax.memberObject.email );
		$( formId + ' input#tfa_192' ).val( seiuAjax.memberObject.phone );
		$( formId + ` select#tfa_1890 option:contains(${seiuAjax.memberObject.language})` ).attr('selected', 'selected').trigger('change');
	}

} );

function getStickyElementsHeight() {
	let stickyHeight   = 0;
	const elemAdminbar = $( '#wpadminbar:visible' ),
		elemAlertbar   = $( '.site-header .site-header__alert-banner:visible' ),
		elemTopNav     = $( '.site-header--top.top-menu:visible' ),
		elemMainNav    = $( 'body.logged-in.members-nav .site-header__inner:visible' );

	if ( elemAdminbar.length && elemAdminbar.isInViewport() ) {
		stickyHeight += elemAdminbar.outerHeight();
	}

	if ( elemAlertbar.length && elemAlertbar.isInViewport() ) {
		stickyHeight += elemAlertbar.outerHeight();
	}

	if ( elemTopNav.length && elemTopNav.isInViewport() ) {
		stickyHeight += elemTopNav.outerHeight();
	}

	if ( elemMainNav.length && elemMainNav.isInViewport() ) {
		stickyHeight += elemMainNav.outerHeight();
	}

	return stickyHeight;
}

function SetCaretAtEnd( elem ) {
	var elemLen = elem.value.length;
	// For IE Only
	if ( document.selection ) {
		// Set focus
		elem.focus();
		// Use IE Ranges
		var oSel = document.selection.createRange();
		// Reset position to 0 & then set at end
		oSel.moveStart( 'character', -elemLen );
		oSel.moveStart( 'character', elemLen );
		oSel.moveEnd( 'character', 0 );
		oSel.select();
	} else if ( elem.selectionStart || elem.selectionStart == '0' ) {
		// Firefox/Chrome
		elem.selectionStart = elemLen;
		elem.selectionEnd   = elemLen;
		elem.focus();
	}
}

$( window ).on( 'resize', function () {
	switchContactMenuIconAndText();
	adjustEqualHeightElements();
} );

function adjustEqualHeightElements() {

	if ( $( window ).outerWidth() <= 991 ) {
		const highestBox = 'auto';
		$( '.membership-info .membership-info--list-item h3.title' ).height( highestBox );
		//$( '.cards-grid .cards-grid--list--item .description' ).height( highestBox );
		$( '.alerts-wrapper .action-alert--container .action-alert--content .description' ).height( highestBox );
	} else {

		// Equal height for all posts.
		let highestBox = 0;
		$( '.membership-info .membership-info--list-item' ).each( function () {
			$( 'h3.title', this ).each( function () {
				if ( $( this ).height() > highestBox ) {
					highestBox = $( this ).height();
				}
			} );
		} );
		$( '.membership-info .membership-info--list-item h3.title' ).height( highestBox );

		/*highestBox = 0;
		$( '.cards-grid .cards-grid--list--item' ).each( function () {
			$( '.description', this ).each( function () {
				if ( $( this ).height() > highestBox ) {
					highestBox = $( this ).height();
				}
			} );
		} );
		$( '.cards-grid .cards-grid--list--item .description' ).height( highestBox );*/

		highestBox = 0;
		$( '.alerts-wrapper .action-alert--container .action-alert--content', this ).each( function () {
			$( '.description', this ).each( function () {
				if ( $( this ).height() > highestBox ) {
					highestBox = $( this ).height();
				}
			} );
		} );
		$( '.alerts-wrapper .action-alert--container .action-alert--content .description' ).height( highestBox );
	}
}

function switchContactMenuIconAndText() {
	if ( $( window ).outerWidth() <= 1300 ) {
		$( telElem ).html( telIcon );
		$( emailElem ).html( emailIcon );
	} else {
		$( telElem ).html( telText );
		$( emailElem ).html( emailText );
	}
}

$.fn.isInViewport = function ( predefined_scroll = 0 ) {
	var elementTop     = $( this ).offset().top + predefined_scroll;
	var elementBottom  = elementTop + $( this ).outerHeight();
	var viewportTop    = $( window ).scrollTop();
	var viewportBottom = viewportTop + $( window ).height();
	return elementBottom > viewportTop && elementTop < viewportBottom;
};

// Set timeout variables.
var timoutWarning = 840000; // Display warning in 14 Mins.
var timoutNow = 60000; // Warning has been shown, give the user 1 minute to interact
var logoutUrl = 'logout.php'; // URL to logout page.

var warningTimer;
var timeoutTimer;

// Start warning timer.
function StartWarningTimer() {
    warningTimer = setTimeout("IdleWarning()", timoutWarning);
}

// Reset timers.
function ResetTimeOutTimer() {
    clearTimeout(timeoutTimer);
    StartWarningTimer();
    $("#timeout").dialog('close');
}

// Show idle timeout warning dialog.
function IdleWarning() {
    clearTimeout(warningTimer);
    timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
    $("#timeout").dialog({
        modal: true
    });
    // Add code in the #timeout element to call ResetTimeOutTimer() if
    // the "Stay Logged In" button is clicked
}

// Logout the user.
function IdleTimeout() {
    window.location = logoutUrl;
}
