<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package seiu
 */
$footer_logo = get_field( 'footer_logo', 'option' );
$social      = get_field( 'social_profiles', 'option' );
$address     = get_field( 'address', 'option' );
$about_us    = get_field( 'about_us', 'option' );
?>

<?php
if ( is_user_logged_in() && is_page( 'events-and-actions' ) ) {
	$user = wp_get_current_user();
	require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
	$member_info_obj = new MemberInfo( $user );
	$cookie_key      = $member_info_obj->get_cookie_key_for_current_user();

	// Check if cookie exist for current logged-in user.
	if ( isset( $_COOKIE[ $cookie_key ] ) ) {

		// Member information stored in json format - decode json.
		$member_info = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );
		?>
		<div id="member-info-modal" class="d-none">
			<div class="close-panel">
				<div class="container--md">
					<div class="close-panel--inner">
						<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 464c-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216 0 118.7-96.1 216-216 216zm94.8-285.3L281.5 256l69.3 69.3c4.7 4.7 4.7 12.3 0 17l-8.5 8.5c-4.7 4.7-12.3 4.7-17 0L256 281.5l-69.3 69.3c-4.7 4.7-12.3 4.7-17 0l-8.5-8.5c-4.7-4.7-4.7-12.3 0-17l69.3-69.3-69.3-69.3c-4.7-4.7-4.7-12.3 0-17l8.5-8.5c4.7-4.7 12.3-4.7 17 0l69.3 69.3 69.3-69.3c4.7-4.7 12.3-4.7 17 0l8.5 8.5c4.6 4.7 4.6 12.3 0 17z"></path></svg>
					</div>
				</div>
			</div>
			<div class="member-info-panel">
				<div class="container--md">
					<h3><?php esc_attr_e( 'My SEIU 775 Contact Info', 'seiu' ); ?></h3>
					<div class="member-info-panel--container">
						<form id="member-info--update">
							
							<div class="name">
								<label for="member-name" class="label"><?php esc_attr_e( 'Name', 'seiu' ); ?></label>
								<span class="placeholder"><?php echo esc_attr( $user->first_name . ' ' . $user->last_name ); ?></span>
							</div>
							<div class="input-control address">
								<label for="member-address" class="label"><?php esc_attr_e( 'Address', 'seiu' ); ?></label>
								<textarea class="input" name="address" id="member-address"><?php echo esc_attr( $member_info['address'] ); ?></textarea>
								<span class="placeholder"><?php echo esc_attr( $member_info['address'] ); ?></span>
								<span class="edit-icon"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" class="svg-inline--fa fa-pen fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path></svg></span>
							</div>
							<div class="input-control city">
								<label for="member-city" class="label"><?php esc_attr_e( 'City', 'seiu' ); ?></label>
								<input class="input" name="city" type="text" id="member-city" value="<?php echo esc_attr( $member_info['city'] ); ?>" />
								<span class="placeholder"><?php echo esc_attr( $member_info['city'] ); ?></span>
								<span class="edit-icon"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" class="svg-inline--fa fa-pen fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path></svg></span>
							</div>
							<div class="input-control state">
								<label for="member-state" class="label"><?php esc_attr_e( 'State', 'seiu' ); ?></label>
								<input class="input" name="state" type="text" id="member-state" value="<?php echo esc_attr( $member_info['state'] ); ?>" />
								<span class="placeholder"><?php echo esc_attr( $member_info['state'] ); ?></span>
								<span class="edit-icon"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" class="svg-inline--fa fa-pen fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path></svg></span>
							</div>
							<div class="input-control phone">
								<label for="member-phone" class="label"><?php esc_attr_e( 'Phone', 'seiu' ); ?> Number</label>
								<input class="input" name="mobilePhone" type="tel" id="member-phone" value="<?php echo esc_attr( $member_info['mobilePhone'] ); ?>" />
								<span class="placeholder"><?php echo esc_attr( $member_info['mobilePhone'] ); ?></span>
								<span class="edit-icon"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" class="svg-inline--fa fa-pen fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path></svg></span>
							</div>
							<div class="btn-wrapper">
							<span class="btn btn--primary is-icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; display: block; shape-rendering: auto;" width="22px" height="22px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
									<circle cx="50" cy="50" fill="none" stroke="#582b81" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
										<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="2.8571428571428568s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
									</circle>
								</svg>
							</span>
								<input type="submit" class="btn btn--primary" value="<?php esc_attr_e( 'Update My Info', 'seiu' ); ?>" />
							</div>
							<input type="hidden" name="memberId" value="<?php echo esc_attr( $member_info['memberId'] ); ?>" />
						</form>
						<div class="alert success" style="display: none;"><?php esc_attr_e( 'Your contact information changed successfully!', 'seiu' ); ?></div>
							<div class="alert error" style="display: none;"><?php esc_attr_e( 'Something went wrong, please try again later.', 'seiu' ); ?></div>
						<div class="more-info-update">
							<?php echo '<p>' . esc_attr_e( 'If you\'d like to update your email address or other information, please contact the Member Resource Center at', 'seiu' ) . '<br><a href="tel:1-866-371-3200">1-866-371-3200</a>.</p>'; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>

<footer class="footer" role="contentinfo">
	<div class="footer--main">
		<div class="container container--md footer__grid">
			<div class="footer__column">
				<?php if ( ! empty( $footer_logo ) ) : ?>
					<figure class="footer__logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img width="100" src="<?php echo esc_url( $footer_logo['url'] ); ?>"
								 alt="<?php echo esc_attr( $footer_logo['alt'] ); ?>"/>
						</a>
					</figure>
				<?php endif; ?>

				<?php if ( ! empty( $address ) ) : ?>
					<div class="footer__address">
						<?php the_field( 'address', 'option' ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $about_us ) ) : ?>
				<div class="footer__column footer__about-us">
					<?php the_field( 'about_us', 'option' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $social ) ) : ?>
				<div class="footer__column footer__social">
					<ul>
						<?php
						foreach ( $social as $item ) :
							$user = get_field( $item . '_link', 'option' );
							if ( $user ) :
								?>
								<li>
									<!-- <?php echo $item . '_link'; ?> -->
									<a href="<?php the_field( $item . '_link', 'option' ); ?>"
									   target="_blank" rel="noopener noreferrer"
									   class="social_link <?php echo $item; ?>">
										<span class="icon icon-<?php echo $item; ?>"></span>
										<span class="text visually-hidden"><?php echo $item; ?></span>
									</a>
								</li>
								<?php
							endif;
						endforeach;
						?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="footer--bottom">
		<div class="footer__copyright">
			<p><?php the_field( 'copyright', 'option' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
