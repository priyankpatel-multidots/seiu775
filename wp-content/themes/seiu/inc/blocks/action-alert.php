<?php
/**
 * ACF Block - Action Alert
 *
 * @package SEIU
 */

/**
 * Block Name: Action Alert
 * Description: Display take action alert block.
 */

$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Check whether block should be visible to all.
$show_to_all = get_field( 'block_action_alert_visibility_show_to_all' );

if ( ! $show_to_all ) { // Block is not set to visible to all - check if user is eligible to view the block.

	// is_block_visible flag.
	$is_block_visible = false;

	// Retrieve API response from user cookie to check if user is eligible to view the block.
	$user = wp_get_current_user();
	require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
	$member_info_obj = new MemberInfo( $user );
	$cookie_key      = $member_info_obj->get_cookie_key_for_current_user();
	
	// Check if cookie exist for current logged-in user.
	if ( isset( $_COOKIE[ $cookie_key ] ) ) {

		// Member information stored in json format - decode json.
		$member_info = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );

		$needsCard = $member_info['needsCard'];

		// Prepare an array of ACF field values for further use.
		$visibility_acf_key_value = array(
			'turf'      => get_field( 'block_action_alert_visibility_turf' ),
			'city'      => get_field( 'block_action_alert_visibility_city' ),
			'state'     => get_field( 'block_action_alert_visibility_state' ),
			'needsCard' => get_field( 'block_action_alert_visibility_needs_card' ) ? 'true' : 'false',
			'language'  => get_field( 'block_action_alert_visibility_language' ) ? implode( ',', get_field( 'block_action_alert_visibility_language' ) ) : false,
			'jobs'      => array(
				'type'     => get_field( 'block_action_alert_visibility_job_type' ),
				'employer' => get_field( 'block_action_alert_visibility_employer' ),
			),
		);
		
		// Let's get the array of only ACF fields having values (remove empty fields to reduce execution overhead).
		$acf_fields_array_to_compare_with_api_array = array();
		foreach ( $visibility_acf_key_value as $key => $value ) {
			
			if ( is_array( $value ) ) {
				foreach ( $value as $inner_key => $inner_value ) {
					if ( ! empty( $inner_value ) ) {
						$acf_fields_array_to_compare_with_api_array[ $key ][ $inner_key ] = $inner_value;
					}
				}
			} elseif ( ! empty( $value ) ) {
				$acf_fields_array_to_compare_with_api_array[ $key ] = $value;
			}
		}
		


		// Let's traverse each key-value pair of ACF field array to prepare the list of fields not matching with API response.
		$fields_not_matching = array();
		foreach ( $acf_fields_array_to_compare_with_api_array as $key => $value ) {
			if(is_array($value)) {
				$value = array_map('strtolower',$value);
			}
			else
			{
				$value = strtolower($value);
			}

			// Check if ACF key is matching with API response.
			if ( array_key_exists( $key, $member_info ) ) {
				if ( is_array( $value ) && count( $value ) > 0 ) { // Value for given key is array (i.e. jobs). Drill down into inner array for field match.
					$job_matching = array();
					foreach ( $value as $job_key => $job_value ) {
				
						if ( strpos( $job_value, ',' ) !== false ) { // Value contains multiple values separated by comma.
							// Trim extra spaces before and after comma.
							$job_value       = preg_replace( '/\s*,\s*/', ',', $job_value );

							$job_value_array = explode( ',', $job_value );
							if ( is_array( $member_info[ $key ] ) && count( $member_info[ $key ] ) > 0 ) {
								foreach ( $member_info[ $key ] as $api_job ) {
									$api_job = (array) $api_job;
									if ( array_key_exists( $job_key, $api_job ) && in_array( $api_job[ $job_key ], $job_value_array ) ) {
										$job_matching[] = 'true';
									} else {
										$job_matching[] = 'false';
									}
								}
							}
						} else { // Values contains single value.
							foreach ( $member_info[ $key ] as $api_job ) {
								$api_job = (array) $api_job;
								if(is_array($api_job)) {
									$api_job = array_map('strtolower',$api_job);
								}
								else
								{
									$api_job = strtolower($value);
								}

								if ( array_key_exists( $job_key, $api_job ) && $value[ $job_key ] == $api_job[ $job_key ] ) {
									$job_matching[] = 'true';
								} else {
									$job_matching[] = 'false';
								}
							}
						}
					}
					
					if ( ! in_array( 'true', $job_matching, true ) ) {
						$fields_not_matching[] = $key;
					}
				} elseif ( 'needsCard' == $key ) { // Boolean is treated separately because empty(false) returns 'true'.
					

					$api_needs_card = strtolower($member_info[ $key ]) ? 'true' : 'false';
					if ( $value != $api_needs_card ) {
						$fields_not_matching[] = $key;
					}
				} else { // Match values directly to API key.
					// Check for multiple values separated by comma(,).
					
					if ( strpos( $value, ',' ) !== false ) { // Value contains multiple values separated by comma.
						// Trim extra spaces before and after comma.
						$value       = preg_replace( '/\s*,\s*/', ',', $value );
						$value_array = explode( ',', $value );
						if ( ! in_array( strtolower($member_info[ $key ]), $value_array, true ) ) {
							$fields_not_matching[] = $key;
						}
					} else { // Values contains single value.
						if ( $value !== strtolower($member_info[ $key ] )) {
							$fields_not_matching[] = $key;
						}
					}
				}
			}
		}
		
		if ( empty( $fields_not_matching ) ) {
			$is_block_visible = true;
		}
	}
}
$user = wp_get_current_user();
require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
$member_info_obj = new MemberInfo( $user );
$cookie_key      = $member_info_obj->get_cookie_key_for_current_user();
if ( isset( $_COOKIE[ $cookie_key ] )  && ( is_page(14529) || is_page(14548) || is_page(14552) ) ) {

	// Member information stored in json format - decode json.
	$member_info = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );

	$needsCard = $member_info['needsCard'];
	if( $needsCard == 'true' ){
	?>
	<div class="site-header-needs-card alignfull">
		<div class="site-header__alert-banner">
				<div class="container container--md">
					<div class="alert-banner__text">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/view_list_black_24dp.png">
						<p><?php esc_attr_e( 'It’s time to update your card!', 'seiu' ); ?></p><a href="https://join775.org/members/new?source=newweb" class="wp-block-button__link" target="_blank" rel="noopener"><?php esc_attr_e( 'Update Now', 'seiu' ); ?></a>
					</div>
				</div>
		</div>
	</div>
	<?php
	}
}
if ( $show_to_all || $is_block_visible ) {
	?>

	<section class="action-alert <?php echo esc_attr( $class_name ); ?>">
		<div class="action-alert--wrapper">
			<?php
			if ( get_field( 'block_action_alert_heading_title' ) ) {
				$block_title = get_field( 'block_action_alert_heading_title' );
				?>
				<div class="action-alert--heading-wrapper" style="<?php printf( 'color: %s; background-color: %s', esc_attr( get_field( 'block_action_alert_heading_text_color' ) ), esc_attr( get_field( 'block_action_alert_heading_background_color' ) ) ); ?>">
					<h2 class="text-center"><?php esc_attr_e( $block_title, 'seiu' ); ?></h2>
				</div>
			<?php } ?>

			<?php
			if ( ! empty( get_field( 'block_action_alert_content_title' ) ) || ! empty( get_field( 'block_action_alert_content_description' ) ) ) {
				?>
				<div class="action-alert--content-wrapper <?php printf( 'has-bg-%s', esc_attr( get_field( 'block_action_alert_background_type' ) ) ); ?>" style="<?php echo ( get_field( 'block_action_alert_background_color' ) && 'color' === get_field( 'block_action_alert_background_type' ) ) ? sprintf( 'background-color: %s', esc_attr( get_field( 'block_action_alert_background_color' ) ) ) : ''; ?>">
					<?php
					if ( get_field( 'block_action_alert_background_image' ) && 'image' === get_field( 'block_action_alert_background_type' ) ) {
						echo wp_get_attachment_image( get_field( 'block_action_alert_background_image' ), 'full' );
					}

					$content_position   = get_field( 'block_action_alert_content_position' );
					$content_alignment  = get_field( 'block_action_alert_content_alignment' );
					$content_bg_overlay = get_field( 'block_action_alert_content_background_overlay' );
					$content_text_color = get_field( 'block_action_alert_content_text_color' );
					$alert_title        = get_field( 'block_action_alert_content_title' );
					$description        = get_field( 'block_action_alert_content_description' );
					$cta                = get_field( 'block_action_alert_content_cta' );
					?>
					<div class="action-alert--container <?php echo 'content-on-' . esc_attr( $content_position ); ?> <?php echo 'bg-overlay-' . esc_attr( $content_bg_overlay ); ?>" style="<?php printf( 'color: %s; text-align: %s;', esc_attr( $content_text_color ), esc_attr( $content_alignment ) ); ?>">
						<div class="action-alert--content">
							<?php if ( $alert_title ) { ?>
								<h3 class="title">
									<?php
									echo wp_kses(
										$alert_title,
										array(
											'p'      => array(),
											'br'     => array(),
											'strong' => array(),
										)
									);
									?>
								</h3>
							<?php } ?>
							<?php if ( $description ) { ?>
								<div class="description">
									<?php
									echo wp_kses(
										$description,
										array(
											'br'     => array(),
											'p'      => array(),
											'strong' => array(),
										)
									);
									?>
								</div>
							<?php } ?>
							<?php if ( $cta ) { ?>
								<div class="btn-wrapper wp-block-button">
									<a class="wp-block-button__link btn" target="<?php echo esc_attr( $cta['target'] ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>"><?php echo esc_attr__( $cta['title'], 'seiu' ); ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
	<?php
}
