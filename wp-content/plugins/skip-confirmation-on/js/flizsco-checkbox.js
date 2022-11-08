/* Version 1.0 */
/*
 * Unticks the "Send User Notification" box in standard WP user-new.php.
 */
jQuery( document ).ready( function( $ ) {
	// Untick the box in the standard Add New User form, if it exists
	if ( $( '#createuser input[id=\'send_user_notification\']' ).val( ) ) {
		$( '#createuser input[id=\'send_user_notification\']' ).prop( 'checked', false );
	}
});
