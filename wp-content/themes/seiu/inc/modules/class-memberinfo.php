<?php
/**
 * MemberInfo class.
 *
 * @package SEIU
 */

/**
 * MemberInfo Class.
 *
 * Handles member information received from an API response.
 */
class MemberInfo {

	use Messages;

	/**
	 * Email address.
	 *
	 * @var string $email_address Email Address.
	 */
	private string $email_address;

	/**
	 * Member ID
	 *
	 * @var string $member_id Member ID.
	 */
	private string $member_id;

	/**
	 * User ID
	 *
	 * @var string $user_id User ID.
	 */
	private string $user_id;

	/**
	 * Constructor with parameters.
	 *
	 * @param WP_User $user WP_User instance.
	 */
	public function __construct( WP_User $user ) {

		// Get $user email address.
		// @todo Used static Email Address for development purpose now - it should be removed before production launch.
		//$email_address = 'wouter.vanwageningen@seiu775.org';
		$email_address = $user->user_email;

		// Get $user member_id.
		// @todo Used static Member ID for development purpose now - it should be removed before production launch.
		//$member_id = '181835';
		$member_id = get_user_meta( $user->ID, 'member_id', true );

		$this->email_address = $email_address;
		$this->member_id     = $member_id;
		$this->user_id       = $user->ID;
	}

	/**
	 * Retrieve member information via API call.
	 *
	 * @return void
	 */
	public function retrieve_member_info_and_store_into_cookie() {

		// Double check both email_address and member_id is not empty.
		if ( ! empty( $this->email_address ) && ! empty( $this->member_id ) ) {

			// Proceed only if email_address is valid email.
			if ( is_email( $this->email_address ) ) {

				// Fetch Staging API credentials by default from Theme General Settings.
				$api_key = sanitize_text_field( get_field( 'members_api_staging_api_key', 'option' ) );
				$api_url = sanitize_text_field( get_field( 'members_api_staging_membersinfo_api_url', 'option' ) );

				// Load Production API credentials if API Environment is set to 'production' at Theme Settings.
				if ( ! empty( get_field( 'members_api_environment', 'option' ) && 'production' === get_field( 'members_api_environment', 'option' ) ) ) {
					$api_key = sanitize_text_field( get_field( 'members_api_production_api_key', 'option' ) );
					$api_url = sanitize_text_field( get_field( 'members_api_production_memberinfo_api_url', 'option' ) );
				}

				// Prepare request body.
				$request_body = array(
					'API_Key' => sanitize_text_field( $api_key ),
					'members' => array(
						array(
							'email'    => sanitize_email( $this->email_address ),
							'memberId' => sanitize_text_field( $this->member_id ),
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
					if ( 200 === $response['code'] ) {
						// Success - Delete existing cookies first before setting a fresh one.
						$this->delete_cookie_for_current_user();
						$this->delete_events_cookie_for_current_user();

						// Separate out events from API response to set events in separate cookie.
						$response_body = $api_response['body'];
						$json_to_array = json_decode( $response_body );

						if ( isset( $json_to_array->members[0]->language ) ) {
							$redirect_to = site_url( '/events-and-actions/' );
							if ( 'Spanish' === $json_to_array->members[0]->language ) {
								$redirect_to = apply_filters( 'wpml_permalink', site_url( '/events-and-actions/' ), 'es' );
							} elseif ( 'Russian' === $json_to_array->members[0]->language ) {
								$redirect_to = apply_filters( 'wpml_permalink', site_url( '/events-and-actions/' ), 'ru' );
							}
							update_user_meta( $this->user_id, 'redirect_to', $redirect_to );
						}

						$event_array         = $json_to_array->members[0]->events;
						$event_array_to_json = wp_json_encode( $event_array );
						$this->set_events_cookie_for_current_user( $event_array_to_json );

						// Unset events from API response since we've already stored events in events cookie and store rest response in main cookie.
						unset( $json_to_array->members[0]->events );
						unset( $json_to_array->result );
						if ( is_array( $json_to_array->members ) ) {
							$other_info_array_to_json = wp_json_encode( $json_to_array->members[0] );
						} else {
							$other_info_array_to_json = wp_json_encode( $json_to_array->members );
						}
						$this->set_cookie_for_current_user( $other_info_array_to_json );
					} else {
						// Failed - log detailed error message.
						self::messageString( $response['message'] );
					}
				}
			} else {
				self::messageString( 'Looks like Email Address is invalid' );
			}
		} else {
			self::messageString( 'Missing MemberID or Email Address' );
		}
	}

	/**
	 * Get cookie key for current user.
	 *
	 * @return string
	 */
	public function get_cookie_key_for_current_user():string {
		return 'seiu_member_' . $this->member_id;
	}

	/**
	 * Get events cookie key for current user.
	 *
	 * @return string
	 */
	public function get_events_cookie_key_for_current_user():string {
		return 'seiu_member_' . $this->member_id . '_events';
	}

	/**
	 * Set cookie for current user.
	 *
	 * @param string $value_to_store Cookie Value.
	 *
	 * @return void
	 */
	public function set_cookie_for_current_user( string $value_to_store ) {
		$cookie_key = $this->get_cookie_key_for_current_user();
		if ( ! isset( $_COOKIE[ $cookie_key ] ) ) {
			// Set cookie to expire automatically in 15 minutes.
			// @todo Set cookie expire after a week for development purpose now - it should be removed before production launch.
			// setcookie( $cookie_key, $value_to_store, time() + ( 60 * 15 ), '/' ); .
			setcookie( $cookie_key, $value_to_store, time() + ( 60 * 60 * 24 * 7 ), '/', null, true, true );
		}
	}

	/**
	 * Set events cookie for current user - solves browser limitation to store only 4096.
	 *
	 * @param string $events_to_store Cookie Value.
	 *
	 * @return void
	 */
	public function set_events_cookie_for_current_user( string $events_to_store ) {
		$events_cookie_key = $this->get_events_cookie_key_for_current_user();
		if ( ! isset( $_COOKIE[ $events_cookie_key ] ) ) {
			// Set cookie to expire automatically in 15 minutes.
			// @todo Set cookie expire after a week for development purpose now - it should be removed before production launch.
			// setcookie( $events_cookie_key, $events_to_store, time() + ( 60 * 15 ), '/' ); .
			setcookie( $events_cookie_key, $events_to_store, time() + ( 60 * 60 * 24 * 7 ), '/', null, true, true );
		}
	}

	/**
	 * Delete cookie for current user.
	 *
	 * @return void
	 */
	public function delete_cookie_for_current_user() {
		$cookie_key = $this->get_cookie_key_for_current_user();
		if ( isset( $_COOKIE[ $cookie_key ] ) ) {
			unset( $_COOKIE[ $cookie_key ] );
			setcookie( $cookie_key, null, -1, '/', null, true, true );
		}
	}

	/**
	 * Delete events cookie for current user.
	 *
	 * @return void
	 */
	public function delete_events_cookie_for_current_user() {
		$events_cookie_key = $this->get_events_cookie_key_for_current_user();
		if ( isset( $_COOKIE[ $events_cookie_key ] ) ) {
			unset( $_COOKIE[ $events_cookie_key ] );
			setcookie( $events_cookie_key, null, -1, '/', null, true, true );
		}
	}
}
