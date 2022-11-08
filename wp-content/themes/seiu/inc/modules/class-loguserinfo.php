<?php
/**
 * LogUserInfo Class.
 *
 * @package SEIU.
 */

/**
 * LogUserInfo Class.
 *
 * Logs user signup/login information to an API.
 */
class LogUserInfo {

	use Messages;

	/**
	 * Log Type (Signup/Login).
	 *
	 * @var string $log_type Log type.
	 */
	private string $log_type;

	/**
	 * Member ID
	 *
	 * @var string $member_id Member ID.
	 */
	private string $member_id;

	/**
	 * Constructor with parameters.
	 *
	 * @param WP_User $user WP_User instance.
	 * @param string  $log_type Log type (login/signup).
	 */
	public function __construct( WP_User $user, string $log_type = 'login' ) {

		// Get $user member_id.
		// @todo Used static Member ID for development purpose now - should be replaced by "get_user_meta( $user->ID, 'member_id', true )" once development done.
		//$member_id = '181835';
		$member_id = get_user_meta( $user->ID, 'member_id', true );

		$this->log_type  = $log_type;
		$this->member_id = $member_id;
	}

	/**
	 * Get user IP address.
	 *
	 * @return mixed
	 */
	public function get_user_ip_address():string {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			// Check ip from share internet.
			$ip = filter_var( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ), FILTER_VALIDATE_IP );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			// To check ip is pass from proxy.
			$ip = filter_var( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ), FILTER_VALIDATE_IP );
		} else {
			$ip = filter_var( isset( $_SERVER['REMOTE_ADDR'] ) ? wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '', FILTER_VALIDATE_IP );
		}
		return $ip;
	}

	/**
	 * Retrieve member information via API call.
	 *
	 * @return void
	 */
	public function send_user_info_to_api() {

		// Check if member_id is not empty.
		if ( ! empty( $this->member_id ) ) {

			// Fetch Staging API credentials by default from Theme General Settings.
			$api_key = sanitize_text_field( get_field( 'members_api_staging_api_key', 'option' ) );
			$api_url = sanitize_text_field( get_field( 'members_api_staging_login_api_url', 'option' ) );

			// Load Production API credentials if API Environment is set to 'production' at Theme Settings.
			if ( ! empty( get_field( 'members_api_environment', 'option' ) && 'production' === get_field( 'members_api_environment', 'option' ) ) ) {
				$api_key = sanitize_text_field( get_field( 'members_api_production_api_key', 'option' ) );
				$api_url = sanitize_text_field( get_field( 'members_api_production_login_api_url', 'option' ) );
			}

			// Prepare request body.
			$request_body = array(
				'API_Key' => sanitize_text_field( $api_key ),
				'members' => array(
					array(
						'type'         => sanitize_text_field( $this->log_type ),
						'memberId'     => sanitize_text_field( $this->member_id ),
						'dateTimeCode' => str_replace( '+00:00', 'Z', gmdate( 'c' ) ),
						// @todo Check IP address on live site.
						'ip'           => $this->get_user_ip_address(),
					),
				),
			);

			// Prepare request array.
			$request_array = array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => wp_json_encode( $request_body ),
				'headers' => array(
					'Content-Type' => 'application/json',
				),
			);

			// Make an API call.
			$api_response = wp_remote_post( $api_url, $request_array );

			if ( is_wp_error( $api_response ) ) {
				// Log detailed error message.
				$error_message = $api_response->get_error_message();
				self::messageString( 'Something went wrong: ' . $error_message );
			} else {
				$response = $api_response['response'];
				self::messageString( $response['message'] );
			}
		} else {
			self::messageString( 'MemberID is not found in our database.' );
		}
	}
}
