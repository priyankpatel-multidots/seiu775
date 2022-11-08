<?php

/**
 * Custom Authentication
 *
 * Completely replaces default WordPress authentication pages and adds new ones
 *
 * Pages include login, registration, registration confirmation,
 * forgot password, reset password, and logout.
 *
 * Benefits over wp-login.php:
 * - Custom templates for authentication
 * - Custom validation
 * - Ability to add our own fields
 * - Ability to verify users' email addresses
 * - "Login wall" functionality
 */

class Authentication {

	use Messages;

	//
	// Messages.
	//
	static $message_text = array(
		'notices' => array(
			'register_intro'       => 'Register for a SEIU account to receive full access to our Membership content.',
			'login_intro'          => 'Log in to your SEIU account for full access to our content.',
			'password_reset_intro' => 'Please enter your email address. You will receive a link to create a new password via email',
		),
		'success' => array(
			'confirmation_resent' => 'The confirmation email has been resent.',
			'account_confirmed'   => 'Your account has been confirmed. You may now log in below.',
			'password_reset_sent' => 'A password reset link has been sent to your email address.',
			'password_changed'    => 'Your password has been changed successfully.',
			'OK'                  => 'OK',
		),
		'errors'  => array(
			'first_name_empty'               => 'Please enter your first name.',
			'last_name_empty'                => 'Please enter your last name.',
			'job_title_empty'                => 'Please enter your job title.',
			'email_invalid'                  => 'Please enter a valid email address.',
			'email_taken'                    => 'This email address is already in use.',
			'email_not_in_network'           => 'You must use an official email address from a SEIU member.',
			'registration_password_empty'    => 'Please enter a password.',
			'password_too_short'             => 'Your password must be at least six characters.',
			'focus_empty'                    => 'Please select an area of focus.',
			'password_confirmation_mismatch' => 'The password confirmation did not match.',
			'email_empty'                    => 'Please enter your email address.',
			'login_password_empty'           => 'Please enter your password.',
			'no_account_found'               => 'We could not find an account associated with that email address.',
			'already_confirmed'              => 'This account has already been confirmed.',
			'confirmation_invalid'           => 'Your account confirmation key was invalid. Please contact the site administrator for assistance.',
			'account_pending'                => 'Your account is still pending. Please check your email for a confirmation link.<br><br>Lost your link?<br><a href="%s">Click here to re-send the confirmation email.</a>',
			'credentials_invalid'            => 'The email address or password was invalid. <br><br>Trouble logging in? Please call the Member Resource Center: <a href="tel:18663713200">1(866)371-3200</a>',
			'password_reset_invalid'         => 'Your password reset key was invalid. Please reset your password again.',
			'member_invalid'                 => 'We could not find a member under that ID and email address.<br><br>Trouble registering? Please call the Member Resource Center: <a href="tel:18663713200">1(866)371-3200</a>',
			'member_register_error'          => 'Trouble registering? Please call the Member Resource Center: <a href="tel:18663713200">1(866)371-3200</a>',
		),
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		// fm_register_submenu_page('authentication', 'options-general.php', 'User Authentication Settings', 'User Authentication ', 'edit_posts');
		add_action( 'wp', array( $this, 'controllers' ) );

		// Handle member related cookies on user login/logout.
		add_action( 'wp_login', array( $this, 'retrieve_member_info_and_store_into_cookie' ), 10, 2 );
		add_action( 'wp_logout', array( $this, 'delete_cookie_for_current_user' ), 10, 1 );

		// Log user information (i.e. IP, DateTime, etc.) to Salesforce on Login.
		add_action( 'wp_login', array( $this, 'log_user_login_info_to_salesforce' ), 15, 2 );

		// Log user information (i.e. IP, DateTime, etc.) to Salesforce on Registration.
		add_action( 'user_register', array( $this, 'log_user_registration_info_to_salesforce' ), 15, 1 );

		// add_action('wp', array($this, 'restrict_content_access'));
		// add_action('init', array($this, 'disable_wp_login'));
		// add_filter('login_url', array($this, 'login_url'), 10, 3);
		// add_filter( 'logout_url', array( $this, 'logout_url' ), 10, 3 );
		add_filter( 'register_url', array( $this, 'register_url' ), 10, 3 );
		// add_filter('lostpassword_url', array($this, 'lostpassword_url'), 10, 3);
		add_filter( 'retrieve_password_message', array( $this, 'retrieve_password_message' ), 10, 4 );
		add_filter( 'wp_mail_content_type', array( $this, 'mail_content_type' ) );
	}

	/**
	 * Hooks
	 */

	/**
	 * Log user login information to Salesforce.
	 *
	 * @param string  $user_login Username.
	 * @param WP_User $user WP_User object.
	 *
	 * @return void
	 */
	public function log_user_login_info_to_salesforce( $user_login, $user ) {
		$log_user_info_obj = new LogUserInfo( $user );
		$log_user_info_obj->send_user_info_to_api();
	}

	/**
	 * Log user login infomation to Salesforce.
	 *
	 * @param int $user_id User ID.
	 *
	 * @return void
	 */
	public function log_user_registration_info_to_salesforce( $user_id ) {
		$user              = get_user_by( 'id', $user_id );
		$log_user_info_obj = new LogUserInfo( $user, 'signup' );
		$log_user_info_obj->send_user_info_to_api();
	}

	/**
	 * Access MemberInfo class to retrieve member information from Salesforce and store it into a cookie.
	 *
	 * @param string  $user_login User Login.
	 * @param WP_User $user User instance.
	 *
	 * @return void
	 */
	public function retrieve_member_info_and_store_into_cookie( $user_login, $user ) {

		if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true ) ) {

			// Instantiate MemberInfo with Email Address and Member ID.
			$member_info = new MemberInfo( $user );

			// Retrieve member additional information by making an API call and store it into a cookie.
			$member_info->retrieve_member_info_and_store_into_cookie();
		}
	}

	/**
	 * Delete cookie for given member_id.
	 *
	 * @param int $user_id User ID.
	 *
	 * @return void
	 */
	public function delete_cookie_for_current_user( $user_id ) {

		if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true ) ) {

			$user = get_user_by( 'id', $user_id );

			$member_info = new MemberInfo( $user );
			$member_info->delete_cookie_for_current_user();
			$member_info->delete_events_cookie_for_current_user();
		}
	}

	//
	// Authentication page controllers.
	// Hook is registered in SEIU_Module.
	//
	function controllers() {

		if ( is_page( 'login' ) ) {
			self::page_login();
		}

		if ( is_page( 'register' ) ) {
			self::page_register();
		}

		/*
		Commented code
		if (is_page('forgot-password')) {
			self::page_forgot_password();
		}
		*/

		if ( is_page( 'reset-password' ) ) {
			self::page_reset_password();
		}
		if ( is_page( 'email-confirmation' ) ) {
			self::page_email_confirmation();
		}
		if ( is_page( 'confirm-account' ) ) {
			self::page_confirm_account();
		}
		if ( is_page( 'logout' ) ) {
			self::page_logout();
		}
	}

	//
	// Restrict content access
	//
	function restrict_content_access() {
		$public = GNYHA_Post::get_meta( 'public', url_to_postid( $_SERVER['REQUEST_URI'] ) );

		// If a post is single, non-public content, and not GNYHA Staff
		// Restrict access
		if ( is_single() && ! GNYHA_Directory::is_staff() && ! $public ) {
			self::restrict_access();
		}
	}

	//
	// Redirect wp-login.php to /login/
	//
	function disable_wp_login() {
		global $pagenow;
		if ( $pagenow == 'wp-login.php' ) {
			wp_safe_redirect( site_url( '/login/' ) );
			exit;
		}
	}

	//
	// URL overrides
	//
	static function login_url( $login_url, $redirect_to, $force_reauth ) {
		$url = site_url( '/login/' );
		if ( ! empty( $redirect_to ) ) {
			$url = add_query_arg( 'redirect_to', $redirect_to, $url );
		}
		// TODO: Figure out if we need to do something with $force_reauth
		return $url;
	}
	static function logout_url() {
		// return site_url( '/logout/' );
	}
	static function register_url( $redirect_to ) {
		$url = site_url( '/register/' );
		if ( ! empty( $redirect_to ) ) {
			$url = add_query_arg( 'redirect_to', $redirect_to, $url );
		}
		return $url;
	}
	/*
	static function lostpassword_url($lostpassword_url, $redirect_to) {
	$url = site_url('/forgot-password/');
	if (!empty($redirect_to)) {
	  $url = add_query_arg('redirect_to', $redirect_to, $url);
	}
	return $url;
	}*/

	//
	// Password reset email text override
	//
	function retrieve_password_message( $msg, $key, $user_login, $user_data ) {
		$url  = site_url( '/wp-login.php?action=rp&key=' . rawurlencode( $key ) . '&login=' . rawurlencode( $user_login ) );
		$msg  = self::email_header();
		$msg .= self::reset_password_email( $url );
		$msg .= self::email_footer();
		return $msg;
	}

	//
	// Enables HTML in WordPress emails
	//
	function mail_content_type() {
		return 'text/html';
	}

	/**
	 * Helpers
	 */

	//
	// Restrict access to the current page
	//
	static function restrict_access() {
		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( self::login_url_with_redirect() );
			exit;
		}
	}

	//
	// Email Styles
	//
	static $styles = array(
		'logo'          => 'margin-top: 20px; margin-bottom: 50px',
		'row'           => 'margin-bottom: 20px; max-width: 600px',
		'row_no_margin' => 'max-width: 600px',
		'text'          => 'font-family: serif; font-size: 16px; letter-spacing: 1px; color: #666666 !important',
		'footer'        => 'margin-top: 50px; margin-bottom: 20px',
		'footer_row'    => 'margin-top: 5px',
		'footer_text'   => 'font-family: sans-serif; font-size: 13px; letter-spacing: 1px; color: #999999 !important',
		'address_link'  => 'text-decoration: none; color: #999999 !important',
		'hidden'        => 'font-size: 0 !important',
	);

	//
	// Email Header
	//
	function email_header() {
		ob_start() ?>
	<div style="<?php echo self::$styles['logo']; ?>"><a href="<?php echo site_url( '/' ); ?>" target="_blank"><img src="<?php echo site_url( '/wp-content/uploads/2020/07/logo.png' ); ?>" border="0"></a></div>
		<?php
		return ob_get_clean();
	}

	//
	// Email Footer
	//
	function email_footer() {
		ob_start()
		?>
	<div style="<?php echo self::$styles['footer']; ?>">
	  <div style="<?php echo self::$styles['footer_row']; ?>"><span style="<?php echo self::$styles['footer_text']; ?>">SEIU 775</span></div>
	</div>
		<?php
		return ob_get_clean();
	}

	//
	// Confirmation Email Body
	//
	function confirmation_email( $url ) {
		ob_start()
		?>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">To access your new SEIU775 account, you must first verify your identity.</span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">If this was a mistake, or you didn't sign up for a SEIU775 account, just ignore this email and nothing will happen.<span></div>
	<div style="<?php echo self::$styles['row_no_margin']; ?>"><span style="<?php echo self::$styles['text']; ?>">To confirm and activate your account, please visit the following address:</span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>"><a href="<?php echo $url; ?>"><?php echo $url; ?></a></span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">Thank you!</span></div>
		<?php
		return ob_get_clean();
	}

	//
	// Reset Password Email Body
	//
	function reset_password_email( $url ) {
		ob_start()
		?>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">A password reset was requested for the SEIU775 account registered to this email address.</span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.<span></div>
	<div style="<?php echo self::$styles['row_no_margin']; ?>"><span style="<?php echo self::$styles['text']; ?>">To reset your password, please visit the following address:</span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>"><a href="<?php echo $url; ?>"><?php echo $url; ?></a></span></div>
	<div style="<?php echo self::$styles['row']; ?>"><span style="<?php echo self::$styles['text']; ?>">Thank you!</span></div>
		<?php
		return ob_get_clean();
	}

	//
	// Send a confirmation email
	//
	function send_confirmation_email( $email ) {
		$user = get_user_by( 'email', $email );
		$key  = get_user_meta( $user->ID, 'confirmation_key', true );
		$url  = site_url( '/confirm-account/?key=' . rawurlencode( $key ) );
		$msg  = self::email_header();
		$msg .= self::confirmation_email( $url );
		$msg .= self::email_footer();
		wp_mail( $email, 'SEIU Account Confirmation', $msg );
	}

	//
	// Check if an account is pending
	//
	function is_pending( $email ) {
		$query = new WP_User_Query(
			array(
				'meta_key'       => 'pending',
				'meta_value'     => 1,
				'search'         => $email,
				'search_columns' => array( 'user_login', 'user_email' ),
			)
		);
		return $query->get_total() == 1;
	}

	//
	// Get a login url that includes a redirect back to the current page
	//
	static function login_url_with_redirect() {
		$url         = site_url( '/login/' );
		$http_host   = $_SERVER['HTTP_HOST'];
		$request_uri = $_SERVER['REQUEST_URI'];

		// Disallow redirects on certain pages
		$no_redirect_pages = array(
			'login',
			'logout',
			'email-confirmation',
			'register',
			'forgot-password',
			'reset-password',
		);

		// Add the redirect param if applicable
		if ( ! is_front_page() && ! is_page( $no_redirect_pages ) ) {
			$url = add_query_arg( 'redirect_to', '//' . $http_host . $request_uri, $url );
		}
		return $url;
	}

	//
	// Get an array of valid email domains
	//
	static function valid_domains() {
		$options = get_option( 'authentication' );
		if ( is_array( $options ) && isset( $options['valid_domains_group']['valid_domains'] ) ) {
			return $options['valid_domains_group']['valid_domains'];
		}
		return array();
	}

	//
	// Get the domain name of a given email address
	//
	static function email_domain( $email ) {
		$parts = explode( '@', $email );
		return strtolower( array_pop( $parts ) );
	}

	//
	// Get the hospital network that an email address corresponds to
	//
	static function email_network( $email ) {
		foreach ( self::valid_domains() as $valid_domain ) {
			if ( $valid_domain['domain'] == self::email_domain( $email ) ) {
				return $valid_domain['network'];
			}
		}
	}

	//
	// Check is an email address has a valid domain
	//
	function email_domain_valid( $email ) {
		return in_array(
			self::email_domain( $email ),
			array_map(
				function( $domain ) {
					return $domain['domain']; },
				self::valid_domains()
			)
		);
	}

	/**
	 * Controllers
	 */

	//
	// Registration form
	//
	function page_register() {

		// Process form
		if ( $_POST ) {

			// Sanitize input
			$first_name = esc_sql( $_POST['first_name'] );
			$last_name  = esc_sql( $_POST['last_name'] );

			$member_id = esc_sql( $_POST['member_id'] );
			$phone     = esc_sql( $_POST['phone'] );

			$email = esc_sql( $_POST['email'] );

			$password              = $_POST['password'];
			$password_confirmation = $_POST['password_confirmation'];
			$focus                 = esc_sql( $_POST['focus'] );

			// Validate first name
			if ( empty( $first_name ) ) {
				self::message( 'errors', 'first_name_empty' );
			}

			// Validate last name
			if ( empty( $last_name ) ) {
				self::message( 'errors', 'last_name_empty' );
			}

			// Validate job title
			// if (empty($job_title)) {
			// self::message('errors', 'job_title_empty');
			// }

			// Validate email
			if ( empty( $email ) || ! is_email( $email ) ) {
				self::message( 'errors', 'email_invalid' );
			} elseif ( email_exists( $email ) || username_exists( $email ) ) {
				self::message( 'errors', 'email_taken' );
			} elseif ( ! self::email_domain_valid( $email ) ) {
				// self::message('errors', 'email_not_in_network');
			}

			// Validate password
			if ( empty( $password ) ) {
				self::message( 'errors', 'registration_password_empty' );
			} elseif ( strlen( $password ) < 6 ) {
				self::message( 'errors', 'password_too_short' );
			}

			// Validate password confirmation
			if ( $password != $password_confirmation ) {
				self::message( 'errors', 'password_confirmation_mismatch' );
			}

			// Validate Member info

			$member_verify = member_verify_curl( $email, $member_id );
			if ( $member_verify === 'Curl Error' ) {
				self::message( 'errors', 'member_register_error' );
			} elseif ( ! $member_verify ) {
				self::message( 'errors', 'member_invalid' );
			}

			// Validate topic selection
			// if (empty($focus)) {
			// self::message('errors', 'focus_empty');
			// }

			// If there are no validation errors
			if ( ! self::has_messages( 'errors' ) ) {
				// Try to create user
				$user_id = wp_create_user( $email, $password, $email );

				// Get current user object
				$user = get_user_by( 'id', $user_id );

				// Remove role
				$user->remove_role( 'subscriber' );

				// Add role
				$user->add_role( 'read_membership' );

				// Check for WordPress errors
				if ( is_wp_error( $user_id ) || empty( $user_id ) ) {
					self::message( 'errors', 'registration_error' );

					// If we successfully created a new user...
				} else {

					// Generate a unique confirmation key
					$key = wp_generate_password( 20, false );

					// Set user metadata
					wp_update_user(
						array(
							'ID'         => $user_id,
							'first_name' => $first_name,
							'last_name'  => $last_name,
						)
					);
					add_user_meta( $user_id, 'confirmation_key', $key, true );
					// add_user_meta($user_id, 'job_title', $job_title, true);
					// add_user_meta($user_id, 'focus', $focus, true);
					add_user_meta( $user_id, 'member_id', $member_id, true );
					add_user_meta( $user_id, 'phone', $phone, true );

					if ( ! empty( $_REQUEST['redirect_to'] ) ) {
						add_user_meta( $user_id, 'redirect_to', $_REQUEST['redirect_to'], true );
					}

					// Redirect to email home
					wp_safe_redirect( site_url( '/events-and-actions/' ) );
					exit;
				}
			}
		}

		// Show intro message
		// self::message('notices', 'register_intro');
	}

	//
	// Login form
	//
	function page_login() {

		// Process form
		if ( $_POST ) {
			global $wpdb;

			// Sanitize input
			$user_login    = isset( $_POST['user_login'] ) ? esc_sql( $_POST['user_login'] ) : '';
			$user_password = isset( $_POST['user_password'] ) ? $_POST['user_password'] : '';
			$redirect_to   = isset( $_POST['redirect_to'] ) ? esc_sql( $_POST['redirect_to'] ) : '';
			$remember      = ! empty( $_POST['remember'] ) ? 'true' : 'false';

			// Log in using native WP function.
			$user = wp_signon(
				array(
					'user_login'    => $user_login,
					'user_password' => $user_password,
					'remember'      => $remember,
				),
				false
			);

			// Check for errors.
			if ( is_wp_error( $user ) ) {
				if ( $user_login && $user_password ) {

					// Credentials are incorrect.
					self::message( 'errors', 'credentials_invalid' );

				}

				// Login was left blank.
				if ( ! $user_login ) {
					self::message( 'errors', 'email_empty' );
				}

				// Password was left blank.
				if ( ! $user_password ) {
					  self::message( 'errors', 'login_password_empty' );
				}

				// Login successful.
			} else {

				// Ensure that the user has a valid auth cookie.
				if ( wp_validate_auth_cookie() == false ) {
					wp_set_auth_cookie( $user->ID, true );
				}

				// If we stored a redirect for this user, retrieve it.
				$user_redirect = get_user_meta( $user->ID, 'redirect_to', true );

				// If there is a URL-based redirect URL, go there.
				if ( ! empty( $_POST['redirect_to'] ) ) {
					wp_safe_redirect( $_POST['redirect_to'] );

					// If there is a meta-based redirect URL, go there.
					// Also clear the meta value.
				} elseif ( ! empty( $user_redirect ) ) {
					wp_safe_redirect( $user_redirect );
					delete_user_meta( $user->ID, 'redirect_to' );

					// Otherwise, go home.
				} else {
					wp_safe_redirect( site_url( '/events-and-actions/' ) );
				}
				exit;
			}
		}

		// Show status messages based on the GET query
		if ( ! empty( $_GET['status'] ) ) {
			$status = $_GET['status'];

			// Show password change success message
			if ( $status == 'changed' ) {
				self::message( 'success', 'password_changed' );

				// Show account creation success message
			} elseif ( $status == 'confirmed' ) {
				self::message( 'success', 'account_confirmed' );

				// Show account confirmation error
			} elseif ( $status == 'invalid' ) {
				self::message( 'errors', 'confirmation_invalid' );
			}
		}
	}

	//
	// Forgot password form
	//
	/*
	  function page_forgot_password() {

	  // We need to get the retrieve_password() function from wp-login.php
	  // Use an output buffer to prevent wp-login.php from rendering
	  ob_start();
	  include('wp-login.php');
	  ob_end_clean();

	  // Process form
	  if ($_POST) {
		$result = retrieve_password();

		// Check for errors
		if (is_wp_error($result)) {

		  // Empty username
		  if (in_array('empty_username', array_keys($result->errors))) {
			self::message('errors', 'email_empty');

		  // Invalid email address
		  } else {
			self::message('errors', 'no_account_found');
		  }

		// Email sent successfully
		} else {
		  self::message('success', 'password_reset_sent');
		}
	  }

	  // Show invalid password reset key error
	  if (isset($_GET['status']) && $_GET['status'] == 'invalid') {
		self::message('errors', 'password_reset_invalid');
	  }

	  // Show intro message, unless we just successfully sent an email
	  if (!self::has_messages('success')) {
		self::message('notices', 'password_reset_intro');
	  }
	}*/

	//
	// Reset password form
	//
	function page_reset_password() {

		// Validate password reset key, redirect to forgot password page if invalid
		$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		if ( ! $user || is_wp_error( $user ) ) {
			wp_safe_redirect( site_url( '/forgot-password/?status=invalid' ) );
			exit;
		}

		// Process form
		if ( $_POST ) {

			// Password is empty
			if ( empty( $_POST['password'] ) ) {
				self::message( 'errors', 'registration_password_empty' );

				// Passwords don't match
			} elseif ( $_POST['password'] != $_POST['password_confirmation'] ) {
				self::message( 'errors', 'password_confirmation_mismatch' );

				// Reset the password
			} else {
				reset_password( $user, $_POST['password'] );
				wp_safe_redirect( site_url( '/login/?status=changed' ) );
				exit;
			}
		}
	}

	//
	// Email Confirmation Page
	//
	/*
	  function page_email_confirmation() {

	  // Process form
	  if ($_REQUEST) {

		// Empty email address
		if (empty($_REQUEST['email'])) {
		  self::message('errors', 'email_empty');

		// No account exists for that email address
		} else if (!email_exists($_REQUEST['email'])) {
		  self::message('errors', 'no_account_found');

		// The account is not pending
		} else if (!self::is_pending($_REQUEST['email'])) {
		  self::message('errors', 'already_confirmed');

		// The account exists and is pending
		// Re-send the confirmation email
		} else {
		  self::send_confirmation_email($_REQUEST['email']);
		  self::message('success', 'confirmation_resent');
		}
	  }
	}*/

	//
	// Account confirmation
	//
	/*
	function page_confirm_account() {

	// Validate account confirmation key
	$user_query = new WP_User_Query(array(
	  'meta_key' => 'confirmation_key',
	  'meta_value' => $_REQUEST['key']
	));
	$url = site_url('/login/');

	// Invalid confirmation key
	if ($user_query->get_total() != 1 || empty($_REQUEST['key'])) {
	  $url = add_query_arg('status', 'invalid', $url);

	// Valid key, confirm user
	} else {
	  $results = $user_query->get_results();
	  $user = $results[0];
	  update_user_meta($user->ID, 'pending', 0);
	  $url = add_query_arg('status', 'confirmed', $url);
	}

	// Redirect back to login page
	wp_safe_redirect($url);
	exit;
	}*/

	//
	// Logout
	//
	function page_logout() {

		// If user is logged in, log them out and refresh
		if ( is_user_logged_in() ) {
			wp_logout();
			wp_safe_redirect( site_url( '/logout/' ) );
			exit;
		}
	}
}

new Authentication();

?>
