<?php
/**
 * seiu functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package seiu
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '2.0.9' );
}

if ( ! function_exists( 'seiu_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function seiu_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on seiu, use a find and replace
		 * to change 'seiu' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'seiu', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'main-menu'              => esc_html__( 'Main Menu', 'seiu' ),
				'main-menu-logged-out'              => esc_html__( 'Main Menu Logged Out', 'seiu' ),
				'members-main-menu'      => esc_html__( 'Members - Main Menu', 'seiu' ),
				'secondary-menu'         => esc_html__( 'Secondary Menu', 'seiu' ),
				'members-secondary-menu' => esc_html__( 'Members - Secondary Menu', 'seiu' ),
				'news-sidebar' => esc_html__( 'News - sidebar', 'seiu' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'seiu_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add support for default styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for block widths.
		add_theme_support( 'align-wide' );

	}
endif;
add_action( 'after_setup_theme', 'seiu_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function seiu_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'seiu_content_width', 640 );
}

add_action( 'after_setup_theme', 'seiu_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function seiu_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'seiu' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'seiu' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'seiu_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function seiu_scripts() {

	$localize_array = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	);

	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();

		require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
		$memberinfo_obj = new MemberInfo( $user );

		$cookie_key = $memberinfo_obj->get_cookie_key_for_current_user();
		if ( ! empty( $_COOKIE[ $cookie_key ] ) ) {
			$member_cookie                  = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );
			$localize_array['memberObject'] = array(
				'memberId'  => $member_cookie['memberId'],
				'firstName' => get_user_meta( $user->ID, 'first_name', true ),
				'lastName'  => get_user_meta( $user->ID, 'last_name', true ),
				'email'     => $member_cookie['email'],
				'phone'     => str_replace( ' ', '-', str_replace( ')', '', str_replace( '(', '', $member_cookie['mobilePhone'] ) ) ),
				'language'  => $member_cookie['language'],
			);
		}
	}

	wp_enqueue_style( 'seiu-style', get_template_directory_uri() . '/build/css/style.css', array(), time() );
	wp_style_add_data( 'seiu-style', 'rtl', 'replace' );

	wp_enqueue_script( 'seiu-navigation', get_template_directory_uri() . '/build/app.js', array(), _S_VERSION, true );
	wp_localize_script(
		'seiu-navigation',
		'seiuAjax',
		$localize_array
	);

	// wp_enqueue_script( 'seiu-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function update_member_info() {

	$response = null;

	// Proceed only if user is logged in.
	if ( is_user_logged_in() ) {

		$data = $_POST['formData'];

		if ( ! empty( $data ) ) {
			// Fetch Staging API credentials by default from Theme General Settings.
			$api_key = sanitize_text_field( get_field( 'members_api_staging_api_key', 'option' ) );
			$api_url = sanitize_text_field( get_field( 'members_api_staging_membersinfo_api_url', 'option' ) );

			// Load Production API credentials if API Environment is set to 'production' at Theme Settings.
			if ( ! empty( get_field( 'members_api_environment', 'option' ) && 'production' === get_field( 'members_api_environment', 'option' ) ) ) {
				$api_key = sanitize_text_field( get_field( 'members_api_production_api_key', 'option' ) );
				$api_url = sanitize_text_field( get_field( 'members_api_production_memberinfo_api_url', 'option' ) );
			}

			// Merge updated info into original response.
			$user = wp_get_current_user();

			require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
			$memberinfo_obj = new MemberInfo( $user );

			$cookie_key = $memberinfo_obj->get_cookie_key_for_current_user();
			if ( ! empty( $_COOKIE[ $cookie_key ] ) ) {
				$member_cookie = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );
			}

			$events_cookie_key = $memberinfo_obj->get_events_cookie_key_for_current_user();
			if ( ! empty( $_COOKIE[ $events_cookie_key ] ) ) {
				$member_cookie['events'] = json_decode( wp_unslash( $_COOKIE[ $events_cookie_key ] ) );
			}

			$merged_obj = array_replace( $member_cookie, $data );

			// Prepare request body.
			$request_body = array(
				'API_Key' => sanitize_text_field( $api_key ),
				'result'  => 'update',
				'members' => array( $merged_obj ),
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

			// Make an API call to update info.
			$api_response = wp_remote_post( $api_url, $request_array );
			$response     = $api_response['response'];

			if ( 200 === $response['code'] ) {
				// success - User info updated in API, clear existing cookies and make an API call again to set cookies with updated info.
				$memberinfo_obj->retrieve_member_info_and_store_into_cookie();
			}
		}
	}
	echo wp_json_encode( $response );
	exit;
}

function register_member_for_event() {

	$response = null;

	// Proceed only if user is logged in.
	if ( is_user_logged_in() ) {

		$event_id = $_POST['event_id'];

		if ( ! empty( $event_id ) ) {
			// Fetch Staging API credentials by default from Theme General Settings.
			$api_key = sanitize_text_field( get_field( 'members_api_staging_api_key', 'option' ) );
			$api_url = sanitize_text_field( get_field( 'members_api_staging_membersinfo_api_url', 'option' ) );

			// Load Production API credentials if API Environment is set to 'production' at Theme Settings.
			if ( ! empty( get_field( 'members_api_environment', 'option' ) && 'production' === get_field( 'members_api_environment', 'option' ) ) ) {
				$api_key = sanitize_text_field( get_field( 'members_api_production_api_key', 'option' ) );
				$api_url = sanitize_text_field( get_field( 'members_api_production_memberinfo_api_url', 'option' ) );
			}

			// Merge updated info into original response.
			$user = wp_get_current_user();

			require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
			$memberinfo_obj = new MemberInfo( $user );

			$cookie_key = $memberinfo_obj->get_cookie_key_for_current_user();
			if ( ! empty( $_COOKIE[ $cookie_key ] ) ) {
				$member_cookie = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );
			}

			$events_cookie_key = $memberinfo_obj->get_events_cookie_key_for_current_user();
			if ( ! empty( $_COOKIE[ $events_cookie_key ] ) ) {
				$member_cookie['events'] = json_decode( wp_unslash( $_COOKIE[ $events_cookie_key ] ) );
			}

			$event_index             = array_search( $event_id, array_column( $member_cookie['events'], 'Id' ), true );
			$member_cookie['status'] = 'Update';
			if( $member_cookie['events'][ $event_index ]->currentStage == "" && $member_cookie['events'][ $event_index ]->nextStage == "RSVP" ) {
				$member_cookie['events'][ $event_index ]->currentStage = 'RSVP';
			} else if( $member_cookie['events'][ $event_index ]->currentStage == "" && $member_cookie['events'][ $event_index ]->nextStage == "Register" ) {
				$member_cookie['events'][ $event_index ]->currentStage = 'Register';
			} else if( $member_cookie['events'][ $event_index ]->currentStage == "RSVP" && $member_cookie['events'][ $event_index ]->nextStage == "Register" ) {
				$member_cookie['events'][ $event_index ]->currentStage = 'Register';
			} else if( $member_cookie['events'][ $event_index ]->currentStage == "RSVP" && $member_cookie['events'][ $event_index ]->nextStage == "" ) {
				$member_cookie['events'][ $event_index ]->currentStage = 'N/A';
			} else if( $member_cookie['events'][ $event_index ]->currentStage == "Register" && $member_cookie['events'][ $event_index ]->nextStage == "" ) {
				$member_cookie['events'][ $event_index ]->currentStage = 'N/A';
			} 
			

			// Prepare request body.
			$request_body = array(
				'API_Key' => sanitize_text_field( $api_key ),
				'result'  => 'update',
				'members' => array( $member_cookie ),
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

			// Make an API call to update info.
			$api_response = wp_remote_post( $api_url, $request_array );
			$response     = $api_response['response'];

			if ( 200 === $response['code'] ) {
				// success - User info updated in API, clear existing cookies and make an API call again to set cookies with updated info.
				$memberinfo_obj->retrieve_member_info_and_store_into_cookie();
			}
		}
	}
	echo wp_json_encode( $response );
	exit;
}

/**
 * Load Gutenberg stylesheet.
 */
function add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	// css (with timestamp)
	wp_enqueue_style( 'gutenberg-style', get_template_directory_uri() . '/admin-editor.css', array(), _S_VERSION );
	// wp_enqueue_script('gutenberg-js', get_template_directory_uri() . '/build/admin-editor.js', null, filemtime(get_stylesheet_directory() . '/src/js/admin-editor.js'), false);
}


add_action( 'wp_enqueue_scripts', 'seiu_scripts' );
add_action( 'wp_ajax_update_member_info', 'update_member_info' );
add_action( 'wp_ajax_nopriv_update_member_info', 'update_member_info' );
add_action( 'wp_ajax_register_member_for_event', 'register_member_for_event' );
add_action( 'wp_ajax_nopriv_register_member_for_event', 'register_member_for_event' );
add_action( 'enqueue_block_editor_assets', 'add_gutenberg_assets' );

add_action( 'init', 'user_role' );

//
// Add Event Check-In User role with read_membership capabilities
// Add read_membership capabilities to admin role
//
function user_role() {
	if ( ! wp_roles()->is_role( 'read_membership' ) ) {
		add_role(
			'read_membership',
			__( 'Member' ),
			array(
				'read_membership' => true,
			)
		);
	}
	$role = get_role( 'administrator' );
	if ( ! $role->has_cap( 'read_membership' ) ) {
		$role->add_cap( 'read_membership' );
	}
}

function remove_admin_bar() {
	// if (current_user_can('read_membership') && !is_admin()) {
	// show_admin_bar(false);
	// }

	$user = wp_get_current_user();
	if ( in_array( 'read_membership', (array) $user->roles ) && ! is_admin() ) {
		// The user has the "member" role
		show_admin_bar( false );
	}
}

add_action( 'after_setup_theme', 'remove_admin_bar' );


// Add specific CSS class by filter.

add_filter(
	'body_class',
	function ( $classes ) {
		return array_merge( $classes, array( 'class-name' ) );
	}
);


function wpb_set_post_views( $postID ) {
	$count_key = 'wpb_post_views_count';
	$count     = get_post_meta( $postID, $count_key, true );
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count ++;
		update_post_meta( $postID, $count_key, $count );
	}
}

// To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// function wpb_track_post_views ($post_id) {
// if ( !is_single() ) return;
// if ( empty ( $post_id) ) {
// global $post;
// $post_id = $post->ID;
// }
// wpb_set_post_views($post_id);
// }
// add_action( 'wp_head', 'wpb_track_post_views');

function my_login_logo() {
	?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(/wp-content/themes/seiu/images/logo.png);
			padding-bottom: 30px;
		}

		body.login #login_error, body.login .message, body.login .success {
			border-left: 4px solid #582b81;
		}

		body.wp-core-ui .button-primary {
			background: #582b81;
			border-color: #582b81;
		}

		body.wp-core-ui .button-primary.focus, body.wp-core-ui .button-primary.hover,
		body.wp-core-ui .button-primary:focus, body.wp-core-ui .button-primary:hover {
			background: #6c4889;
			border-color: #6c4889;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * ACF Color Palette
 */
add_action( 'acf/input/admin_footer', 'seiu_acf_color_palette' );
function seiu_acf_color_palette() {
	?>
	<script type="text/javascript">
		(function($) {
			acf.add_filter('color_picker_args', function (args, field) {
				args.palettes = [ '#582B81', "#6C4889", '#AB93CB', "#f2f2f2", "#f2edf7", "#FEE479", "#FEEA99", "#FEF4C9", "#000000", "#FFFFFF" ];
				return args;
			});
		})(jQuery);
	</script>
	<?php
}

/*
add_action( 'wp_enqueue_scripts', 'seiu_enqueue_assets' );
function seiu_enqueue_assets() {
	if ( is_page( 'events-and-actions' ) ) {
		wp_enqueue_script( 'seiu-jquery-modal', get_template_directory_uri() . '/js/library/jquery.modal.min.js', array( 'jquery' ), '', false );
		wp_enqueue_style( 'seiu-jquery-modal', get_template_directory_uri() . '/sass/ivycat/library/jquery.modal.min.css' );
	}
}*/
