<?php

namespace Codemanas\InactiveLogout;

/**
 * All ajax calls are kept here.
 *
 * Class Ajax
 * @package Codemanas\InactiveLogout
 */
class Ajax {

	public function __construct() {
		//Acutually Logging out here
		add_action( 'wp_ajax_ina_logout_session', array( $this, 'logoutSession' ) );

		// Ajax for resetting.
		add_action( 'wp_ajax_ina_reset_adv_settings', array( $this, 'ina_reset_adv_settings' ) );

		//Ajax for dismissal of like notice
		add_action( 'wp_ajax_ina_dismiss_like_notice', [ $this, 'dismissLikeNotice' ] );
	}

	/**
	 * Reset Advanced Settings
	 *
	 * @since  1.3.0
	 * @author Deepen
	 */
	public function ina_reset_adv_settings() {
		delete_option( '__ina_roles' );
		delete_option( '__ina_enable_timeout_multiusers' );
		delete_option( '__ina_multiusers_settings' );

		if ( is_network_admin() && is_multisite() ) {
			delete_site_option( '__ina_roles' );
			delete_site_option( '__ina_enable_timeout_multiusers' );
			delete_site_option( '__ina_multiusers_settings' );
		}

		wp_send_json( array(
			'code' => 1,
			'msg'  => esc_html__( 'Reset advanced settings successful.', 'inactive-logout' ),
		) );
		wp_die();
	}

	/**
	 * Logout the actual session from here
	 *
	 * @since 3.0.0
	 * @author Deepen
	 */
	public function logoutSession() {
		check_ajax_referer( '_inaajax', 'security' );

		//Logout Now
		wp_logout();
		wp_send_json( array(
			'isLoggedIn' => is_user_logged_in() ? true : false
		) );

		wp_die();
	}

	public function dismissLikeNotice() {
		Helpers::update_option( 'ina_dismiss_like_notice', true );
	}

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}