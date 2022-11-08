/* Version 1.0 */
/*
 * Ticks the "Skip Confirmation Email" boxes in WP Multisite user-new.php.
 */
jQuery( document ).ready( function( $ ) {
	// Tick the box in the Multisite Add Existing User section, if it exists
	if ( $( '#adduser input[id=\'adduser-noconfirmation\']' ).val( ) ) {
		$( '#adduser input[id=\'adduser-noconfirmation\']' ).prop( 'checked', true );
	}
	// Tick the box in the Multisite Add New User section, if it exists
	if ( $( '#createuser input[id=\'noconfirmation\']' ).val( ) ) {
		$( '#createuser input[id=\'noconfirmation\']' ).prop( 'checked', true );
	}
});
