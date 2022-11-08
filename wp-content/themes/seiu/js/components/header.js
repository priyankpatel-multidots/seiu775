/**
 * Header scripts.
 *
 * @package
 */
import $ from 'jquery';
import Cookies from 'js-cookie';

// Open Top Menu login nav.
$( '[data-login-nav-open]' ).on( 'click', ( event ) => {
	event.preventDefault();
	$( '.top-menu__login' ).toggleClass( 'opened' );
} );

// Close Top Menu login nav.
$( '[data-login-nav-close]' ).on( 'click', ( event ) => {
	event.preventDefault();
	$( '.top-menu__login' ).removeClass( 'opened' );
} );

$( '[data-logout-nav-open]' ).on( 'click', () => {
	$( '.top-menu__login, .mobile-login' ).toggleClass( 'logout-opened' );
} );

$( '[data-login-nav-open-trigger]' ).on( 'click', function( event ) {
	event.preventDefault();
	// $("html, body").animate({ scrollTop: 0 });

	$( '.top-menu__login' ).toggleClass( 'opened' );
} );

$( '.header-search__toggle-icon' ).on( 'click', function() {
	$( '.header-search form.is-search-form' ).fadeIn( 300, function() {
		$( '.header-search form.is-search-form input[type="search"]' ).focus();
	} );
} );

$( document ).click( function( e ) {
	const container = $( '.header-search' );
	const autocomplete = $( '.is-ajax-search-result' );

	// if the target of the click isn't the container nor a descendant of the container
	if ( ( ! container.is( e.target ) && container.has( e.target ).length === 0 ) && ( ! autocomplete.is( e.target ) && autocomplete.has( e.target ).length === 0 ) ) {
		$( 'div.header-search form.is-search-form' ).fadeOut();
	}
} );

$( document ).keydown( function( e ) {
	if ( e.keyCode === 27 ) {
		$( 'div.header-search form.is-search-form' ).fadeOut();
	}
} );

/*$('.header-search form.is-search-form input[type="search"]').on('blur', function (event){
	$('.header-search form.is-search-form').fadeOut();
});*/

$( 'body' ).on( 'mouseenter', '.site-header__inner .menu-item > a', function() {
	if ( ! $( '#primary-menu-content' ).hasClass( 'open' ) ) {
		$( '#primary-menu-content' ).addClass( 'open' );
	}
} ).on( 'mouseleave', '.site-header__inner', function() {
	// var $header = $(event.target).closest('.site-header');

	// if (typeof $header !== 'undefined' && $header.length == 1) {
	// return;
	// }
	$( '#primary-menu-content' ).removeClass( 'open' );
} );

// Homepage Sticky header
const $homepage = $( 'body.page-template-page-home' );
if ( typeof $homepage !== 'undefined' && $homepage.length == 1 ) {
	const $header = $( '.site-header' );

	$( window ).scroll( function() {
		const scrollTop = $( window ).scrollTop();
		if ( scrollTop >= 300 ) {
			$header.addClass( 'sticky--enabled' );
			setTimeout( function() {
				$header.addClass( 'sticky--animate' );
			}, 0 );
		} else {
			$header.removeClass( 'sticky--animate' ).removeClass( 'sticky--enabled' );
		}
	} );
}

const closedCookie = Cookies.get( 'alertClosed' );
const in30Minutes = 1 / 8;
// console.log( closedCookie );

if ( typeof closedCookie !== 'undefined' ) {
	if ( closedCookie === 'true' ) {
		Cookies.set( 'alertClosed', 'true', { expires: in30Minutes, path: '/' } );
	} else {
		$( '.site-header__alert-banner' ).show();
	}
} else {
	$( '.site-header__alert-banner' ).show();
}

$( '.alert-banner__exit' ).click( function() {
	$( '.site-header__alert-banner' ).hide();
	Cookies.set( 'alertClosed', 'true', { expires: in30Minutes, path: '/' } );
} );

$(document).on("click", ".page--new-members .page__content .content-with-video .wp-block-columns .wp-block-column p a", function (e) {
  e.preventDefault();
  var $section = $($(this).attr('href'));
  console.log($section);
  var topOffsetVal = $section.offset().top
  var headerHeight = $('.site-header').outerHeight();
  var paddingVal = 90;
  $('html, body').animate({
      scrollTop: topOffsetVal - paddingVal - headerHeight
    }, 500);
});
$("#wpml_dropdown_wrap #wpml_dropdown > li > a").on('click', function(e){
    e.preventDefault();
    $("#wpml_dropdown_wrap").toggleClass("open");
});
