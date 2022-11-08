<?php
// function user_last_login($user_login, $user) {  
//    update_user_meta($user->ID, 'last_login', time());
// }
// add_action('wp_login', 'user_last_login', 10, 2);

// add_action('get_header', 'processOnPageLoad', 1 );
// add_action('admin_init', 'processOnPageLoad', 1 );
// function processOnPageLoad() {
// if( is_user_logged_in() ) {
//    $user_id = get_current_user_id();
//       $last_login_time = get_user_meta($user_id, 'last_login', true);
//       $allowed_time = 2 * 60; // This will be 5 minutes in seconds
//         echo 'test1233'.$allowed_time;
//         echo '<br>';
//         echo time();
//         echo '<br>';
//         echo $last_login_time + $allowed_time;
//         if ( time() > ( $last_login_time + $allowed_time ) ){
//             wp_logout();
//             wp_redirect( home_url() );
//         }
//    }
// }
?>