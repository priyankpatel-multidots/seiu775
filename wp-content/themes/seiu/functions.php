<?php

/**
 * Includes
 *
 * The $includes array determines the code library included.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 */

$includes = array(
	'inc/setup.php',
	'inc/post-types.php',
	'inc/custom-header.php',    // Implement the Custom Header feature.
	'inc/template-tags.php',    // Custom template tags for this theme.
	'inc/template-functions.php', // Functions which enhance the theme by hooking into WordPress.
	'inc/customizer.php', // Customizer additions.
	'inc/blocks.php', // ACF Blocks.
	'inc/acf.php',
	'inc/methods.php',
	'inc/inactivelogout.php',
);

foreach ( $includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion' ), $file ), E_USER_ERROR );
	}

	require_once $filepath;
}
unset( $file, $filepath );



function member_verify_curl( $email, $member_id ) {
	$curl   = curl_init();

	/*$api_key = get_field( 'api_key', 'option' );
	$api_url = get_field( 'api_url', 'option' );*/

	// Fetch Staging API credentials by default from Theme General Settings.
	$api_key = sanitize_text_field( get_field( 'members_api_staging_api_key', 'option' ) );
	$api_url = sanitize_text_field( get_field( 'members_api_staging_register_api_url', 'option' ) );

	// Load Production API credentials if API Environment is set to 'production' at Theme Settings.
	if ( ! empty( get_field( 'members_api_environment', 'option' ) && 'production' === get_field( 'members_api_environment', 'option' ) ) ) {
		$api_key = sanitize_text_field( get_field( 'members_api_production_api_key', 'option' ) );
		$api_url = sanitize_text_field( get_field( 'members_api_production_register_api_url', 'option' ) );
	}

	curl_setopt_array(
		$curl,
		array(
			CURLOPT_URL            => "$api_url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => "{\"API_Key\":\"$api_key\",\r\n\"tests\":[\r\n{\"email\" : \"$email\", \"memberId\" : \"$member_id\" }\r\n]}",
			CURLOPT_HTTPHEADER     => array(
				'Content-Type: application/json',
				'Cookie: BrowserId=wFF1Eg2EEeu-Vp3rPfIJGg',
			),
		)
	);

	$response = curl_exec( $curl );

	$curlHasErrors = false;
	if ( $response === false ) {
		$error    = 'Curl error: ' . curl_error( $curl );
		$log_path = __DIR__ . '/error-logs/curl-errors.log';
		error_log( $error, 3, $log_path );
		$curlHasErrors = true;
	}

	curl_close( $curl );
	if ( $curlHasErrors ) {
		return 'Curl Error';
	} else {
		$responseObject = json_decode( $response );
		return $responseObject->tests[0]->valid;
	}

}

add_filter( 'wpmu_signup_user_notification', '__return_false' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function load_scripts() {
	global $post;

	if ( is_page() || is_single() ) {
		switch ( $post->post_name ) {
			case 'documents':
				wp_enqueue_script( 'documents', get_template_directory_uri() . '/js/secure_documents.js', array( 'jquery' ), '', false );
				break;
		}
	}
}

add_action( 'wp_enqueue_scripts', 'load_scripts' );
// Traits.
require_once 'inc/modules/Messages.php';

// Classes.
require_once 'inc/modules/class-memberinfo.php';
require_once 'inc/modules/class-loguserinfo.php';
require_once 'inc/modules/Authentication.php';
