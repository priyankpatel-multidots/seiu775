<?php
/**
 * ACF Block - Membership Events.
 *
 * @package SEIU
 */

/**
 * Block Name: Membership Events
 * Description: List of events will be pulled automatically from Members API. This block won't display on frontend at all if there is no events to display.
 */

$block_title = get_field( 'block_mmbr_events_title' );

$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

if ( ! is_admin() && is_user_logged_in() ) {
	require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
	$user = wp_get_current_user();

	// Instantiate MemberInfo with Email Address and Member ID.
	$member_info       = new MemberInfo( $user );
	$events_cookie_key = $member_info->get_events_cookie_key_for_current_user();

	// Proceed only if member info available in cookie.
	if ( isset( $_COOKIE[ $events_cookie_key ] ) && ! empty( $_COOKIE[ $events_cookie_key ] ) ) {
		$events = json_decode( wp_unslash( $_COOKIE[ $events_cookie_key ] ) );
		
		if ( is_array( $events ) && count( $events ) > 0 ) {
			?>

			<section class="membership-events <?php echo esc_attr( $class_name ); ?>">
				<?php if ( $block_title ) { ?>
					<h2 class="h3 text-center"><?php echo esc_attr( $block_title ); ?></h2>
				<?php } ?>

				<div class="membership-events--list">
					<?php
					foreach ( $events as $event ) {
						
						?>
						<div class="membership-events--list-item <?php echo isset( $event->image ) && ! empty( $event->image ) ? 'event-has-image' : false; ?>">
							<?php
							if ( ! empty( $event->image ) ) {
								?>
								<div class="image" style="<?php printf( 'background: transparent url(%s) no-repeat center/cover', esc_url( $event->image ) ); ?>"></div>
								<?php
							}
							?>

							<?php
							if ( ! empty( $event->name ) ) {
								printf( '<h3 class="title h4">%s</h3>', esc_attr( $event->name ) );
							}
							?>

							<?php
							if ( ! empty( $event->startDate ) ) {
								if ( ! empty( $event->endDate ) ) {

									// If event start datetime and end datetime is equal then show start datetime only.
									if ( $event->startDate === $event->endDate ) {
										$date       = new DateTime( $event->startDate );
										$event_day  = $date->format( 'l, F d, Y' );
										$event_time = $date->format( 'g:i a' );
									} else {
										// If event start datetime and end datetime is different then show datetime range.
										$start_date       = new DateTime( $event->startDate );
										$event_start_day  = $start_date->format( 'l, F d, Y' );
										$event_start_time = $start_date->format( 'g:i a' );
										$end_date         = new DateTime( $event->endDate );
										$event_end_day    = $end_date->format( 'l, F d, Y' );
										$event_end_time   = $end_date->format( 'g:i a' );

										// if start date and end date is equal then show start time only.
										if ( $event_start_day === $event_end_day ) {
											$event_day = $event_start_day;
										} else {
											// if start date and end date is different then show start and end date range.
											$event_day = $event_start_day . ' - ' . $event_end_day;
										}

										// if start date and end time is equal then show start time only.
										if ( $event_start_time === $event_end_time ) {
											$event_time = $event_start_time;
										} else {
											// if start time and end time is different then show start and end time range.
											$event_time = $event_start_time . ' - ' . $event_end_time;
										}
									}
								}
							}

							if ( ! empty( $event_day ) ) {
								printf( '<div class="event-date">%s</div>', esc_attr( $event_day ) );
							}

							if ( ! empty( $event_time ) ) {
								printf( '<div class="event-time">%s</div>', esc_attr( $event_time ) );
							}

							if ( ! empty( $event->venue ) ) {
								printf( '<div class="event-venue">%s</div>', esc_attr( $event->venue ) );
							}

							$address = '';
							if ( ! empty( $event->address ) ) {
								$address .= esc_attr( $event->address ) . '<br />';
							}
							if ( ! empty( $event->city ) ) {
								$address .= esc_attr( $event->city ) . ', ';
							}
							if ( ! empty( $event->state ) ) {
								$address .= esc_attr( $event->state ) . ' ';
							}
							if ( ! empty( $event->zip ) ) {
								$address .= esc_attr( $event->zip );
							}

							if ( ! empty( $address ) ) {
								printf(
									'<div class="event-address">%s</div>',
									wp_kses(
										$address,
										array(
											'p'      => array(),
											'br'     => array(),
											'strong' => array(),
										)
									)
								);
							}

							if ( ! empty( $event->description ) ) {
								printf( '<div class="description">%s</div>', esc_attr( $event->description ) );
							}


							// if ( in_array( $event->currentStage, array( 'RSVP', 'Registration' ), true ) ) {
       //                   printf('<p style="margin-top: 2rem;color: var(--wp--preset--color--purple)">You\'ve already registered for this event.</p>');
							// } else {
								?>
								<div class="wp-block-button">
                                    <span class="btn btn--primary is-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; display: block; shape-rendering: auto;" width="22px" height="22px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                            <circle cx="50" cy="50" fill="none" stroke="#582b81" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                                                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="2.8571428571428568s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                            </circle>
                                        </svg>
                                    </span>
									<?php
									$link_url    = '#';
									$link_text   = 'Register';
									$link_target = '_self';
									if ( ! empty( $event->linkURL ) ) {
										$link_url    = $event->linkURL;
										$link_target = '_blank';
									}
									if ( ! empty( $event->linkText ) ) {
										$link_text = $event->linkText;
									}
									// echo $event->currentStage;
									// echo $event->nextStage;
									$style = '';
									if( $event->currentStage == "" && $event->nextStage == "RSVP" ) {
										$link_text = "RSVP";
										$message = "";
										$style = 'style="display:block"';
									} else if( $event->currentStage == "" && $event->nextStage == "Register" ) {
										$link_text = 'Register';
										$message = "";
										$style = 'style="display:block"';
									} else if( $event->currentStage == "RSVP" && $event->nextStage == "Register" ) {
										$link_text = "Register";
										$message = "";
										$style = 'style="display:block"';
									} else if( $event->currentStage == "RSVP" && $event->nextStage == "" ) {
										$link_text = "N/A";
										$message = "You're RSVPed";
										$style = 'style="display:none"';
									} else if( $event->currentStage == "Register" && $event->nextStage == "" ) {
										$link_text = "N/A";
										$message = "You are registered for this event. An organizer will contact you with more details.";
										$style = 'style="display:none"';
									} 
									printf( '<a data-event-id="%s" data-event-cstage="'.$event->currentStage.'" data-event-nstage="'.$event->nextStage.'" class="wp-block-button__link" href="%s" target="%s" '.$style.'>%s</a>', esc_attr( $event->Id ), esc_url( $link_url ), esc_attr( $link_target ), esc_attr( $link_text ) );
									
									if ( ! empty( $message ) ) {
										printf( '<div class="message">%s</div>', esc_attr( $message ) );
									}	
									?>
									<p class="event-alert" style="display: none;margin-top: 2rem;color: var(--wp--preset--color--purple)"><?php esc_attr_e( 'Something went wrong, please try again later.', 'seiu' ); ?></p>

								</div>
								<?php
							// }
							?>
						</div>
					<?php } ?>
				</div>
			</section>
			<?php
		}
	}
}
