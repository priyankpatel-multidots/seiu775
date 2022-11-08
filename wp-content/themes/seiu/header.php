<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package seiu
 */

$nav_preference = 'public-nav';

if ( ! isset( $_COOKIE['nav-preference'] ) ) {
	setcookie( 'nav-preference', 'public-nav', time() + ( 60 * 60 * 24 ), '/' );
}

if ( isset( $_COOKIE['nav-preference'] ) ) {

	if ( is_page( 'events-and-actions' ) ) {
		setcookie( 'nav-preference', 'members-nav', time() + ( 60 * 60 * 24 ), '/' );
		$_COOKIE['nav-preference'] = 'members-nav';
	} elseif ( is_front_page() ) {
		setcookie( 'nav-preference', 'public-nav', time() + ( 60 * 60 * 24 ), '/' );
		$_COOKIE['nav-preference'] = 'public-nav';
	}

	if ( is_user_logged_in() && 'members-nav' === $_COOKIE['nav-preference'] ) {
		$nav_preference = 'members-nav';
	}
}

$remove_padding = get_field( 'remove_content_padding' ) && 'none' !== get_field( 'remove_content_padding' ) ? ' remove-padding-' . get_field( 'remove_content_padding' ) : false;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0"/>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-150824887-1', 'auto');
		ga('send', 'pageview');
	</script>
	<script src="https://kit.fontawesome.com/70f3723c13.js" crossorigin="anonymous"></script>
	<?php wp_head(); ?>

	<?php the_field( 'tracking_codes', 'option' ); ?>

</head>

<body <?php body_class( $nav_preference . $remove_padding ); ?>>

<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'seiu' ); ?></a>

<?php
if(is_user_logged_in()) {
	$primary_menu_items = wp_get_nav_menu_items( 'main-menu' );
} else {
	$primary_menu_items = wp_get_nav_menu_items( 'main-menu-logged-out' );
}

?>
<header id="masthead" class="site-header">
	<?php if ( get_field( 'show_alert_banner', 'option' ) ) : ?>
		<div class="site-header__alert-banner">
			<div class="container container--md">
				<div class="alert-banner__text">
					<?php the_field( 'alert_banner_text', 'option' ); ?>
				</div>
				<span class="alert-banner__exit">&times;</span>
			</div>
		</div>
	<?php endif; ?>
	<div class="site-header--top top-menu">
		<div class="container container--md">
			<nav class="top-menu__list">
				<div id="wpml_dropdown_wrap" onmouseleave="document.getElementById('wpml_dropdown_wrap').classList.remove('open')">
					<ul id="wpml_dropdown"></ul>
					<button role="button"
							onclick="document.getElementById('wpml_dropdown_wrap').classList.toggle('open')">
						<svg viewBox="0 0 32 32" class="icon icon-chevron-bottom" viewBox="0 0 32 32" fill="#ffffff" aria-hidden="true">
							<path d="M16.003 18.626l7.081-7.081L25 13.46l-8.997 8.998-9.003-9 1.917-1.916z"/>
						</svg>
					</button>
				</div>
				<?php
				// if ( is_user_logged_in() && ( isset( $_COOKIE['nav-preference'] ) && 'members-nav' === $_COOKIE['nav-preference'] ) ) {
				// 	wp_nav_menu(
				// 		array(
				// 			'theme_location'  => 'members-secondary-menu',
				// 			'container_class' => 'top-menu-container',
				// 		)
				// 	);
				// } else {
				// 	wp_nav_menu(
				// 		array(
				// 			'theme_location'  => 'secondary-menu',
				// 			'container_class' => 'top-menu-container',
				// 		)
				// 	);
				// }
					wp_nav_menu(
						array(
							'theme_location'  => 'secondary-menu',
							'container_class' => 'top-menu-container',
						)
					);
				?>
				<div class="top-menu__login">
					<?php
					if ( is_user_logged_in() ) :
						$current_user = wp_get_current_user();
						$first_name   = get_user_meta( $current_user->ID, 'first_name', true );
						$display_name = '';
						if ( ! empty( $first_name ) ) {
							$display_name = $first_name;
						} else {
							if ( ! empty( $current_user->display_name ) ) {
								$display_name = $current_user->display_name;
							}
						}
						?>
						<div class="btn btn--login" data-logout-nav-open>
							<div class="member-quick-links-toggle">
								<span><?php echo esc_attr__( 'Hello, ', 'seiu' ) . esc_attr( $display_name ); ?></span>
								<!-- <svg viewBox='0 0 20 20' class='icon' width='1em' height='1em'>
									<use xlink:href='#icon-down'></use>
								</svg> -->
								<svg viewBox="0 0 32 32" class="icon login-arrow icon-chevron-bottom" viewBox="0 0 32 32" fill="#ffffff" aria-hidden="true">
							<path d="M16.003 18.626l7.081-7.081L25 13.46l-8.997 8.998-9.003-9 1.917-1.916z"/>
						</svg>
							</div>
							<ul class="member-quick-links">
								<li><a href="<?php echo bloginfo( 'url' ) . '/events-and-actions/'; ?>"><?php echo esc_attr__( 'Members Home', 'seiu' ); ?></a></li>
								<li><a href="<?php the_field( 'membership_plus_logout_link', 'option' ); ?>"><?php echo esc_attr__( 'Logout', 'seiu' ); ?></a></li>
							</ul>
						</div>
					<?php else : ?>
						<a href="javascript:void(0);" class="btn btn--login" data-login-nav-open>
							<span><?php the_field( 'membership_plus_login_text', 'option' ); ?></span>
							<!-- <svg viewBox='0 0 20 20' class='icon' width='1em' height='1em'>
								<use xlink:href='#icon-down'></use>
							</svg> -->
							<svg viewBox="0 0 32 32" class="icon login-arrow icon-chevron-bottom" viewBox="0 0 32 32" fill="#ffffff" aria-hidden="true">
							<path d="M16.003 18.626l7.081-7.081L25 13.46l-8.997 8.998-9.003-9 1.917-1.916z"/>
						</svg>
						</a>
					<?php endif; ?>
					<div class="top-menu__login-nav">
						<div class="container container--md">
							<div class="panel panel--login">
								<h3><?php the_field( 'membership_plus_login_text', 'option' ); ?></h3>
								<div class="panel__inner">
									<form class="panel__left form--with-validation auth-form__form" action="<?php the_field( 'membership_plus_login_link', 'option' ); ?>" method="post">
										<?php get_template_part( 'template-parts/form-messages' ); ?>
										<div class="form__row">
											<label for="user_login"><?php the_field( 'email_field_label', 'option' ); ?></label>
											<input class="input-text" type="email" name="user_login" id="user_login" value="
											<?php
											if ( ! empty( $_POST['user_login'] ) ) {
												echo sanitize_text_field( $_POST['user_login'] ); }
											?>
													" placeholder="janecaregiver@gmail.com" data-parsley-required-message="Please enter your email address." data-parsley-type-message="Please enter a valid email address." required>
										</div>
										<div class="form__row password-row">
											<label for="user_password"><?php the_field( 'password_field_label', 'option' ); ?></label>
											<input class="input-text" type="password" name="user_password" id="user_password" placeholder="myPassword123%" data-parsley-required-message="Please enter your password." required>
										</div>
										<div class="header-login__forgot-password">
											<a class="btn btn--text" href="/wp-login.php?action=lostpassword"><?php the_field( 'forgot_password_text', 'option' ); ?></a>
										</div>
										<input class="btn btn--primary-outline auth-form__submit" type="submit" name="wp-submit" value="<?php the_field( 'login_button_text', 'option' ); ?>">
									</form>
									<div class="panel__right">
										<?php the_field( 'login_panel_text', 'option' ); ?>
									</div>
								</div>
							</div>
							<a class="btn-top-menu__login-nav__close" data-login-nav-close>
								<svg viewBox='0 0 20 20' class='icon' width='1em' height='1em'>
									<use xlink:href='#icon-close-circle'></use>
								</svg>
							</a>
						</div>
					</div>
				</div>
			</nav><!-- #site-navigation -->
		</div>
	</div>

	<div class="site-header__inner">
		<div class="container container--md">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<a href="/" class="custom-logo-link" rel="home">
						<!-- <img width="626" height="120" src="/wp-content/themes/seiu/images/logo.svg" class="custom-logo" alt="seiu"> -->
					</a>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->
			<div class="mobile-login">
				<?php
				if ( is_user_logged_in() ) :
					$current_user = wp_get_current_user();
					$first_name   = get_user_meta( $current_user->ID, 'first_name', true );
					$display_name = '';
					if ( ! empty( $first_name ) ) {
						$display_name = $first_name;
					} else {
						if ( ! empty( $current_user->display_name ) ) {
							$display_name = $current_user->display_name;
						}
					}
					?>
					<a href="/logout" class="btn btn--yellow-outline header-logout-button">
						<?php esc_html_e('Logout', 'seiu');?>
					</a>
					<div class="btn btn--login" data-logout-nav-open>
						<div class="member-quick-links-toggle">
							<span><?php echo esc_attr__( 'Hello, ', 'seiu' ) . esc_attr( $display_name ); ?></span>
							<svg viewBox='0 0 20 20' class='icon' width='1em' height='1em'>
								<use xlink:href='#icon-down'></use>
							</svg>
						</div>
						<ul class="member-quick-links">
							<li><a href="<?php echo bloginfo( 'url' ) . '/events-and-actions/'; ?>"><?php echo esc_attr__( 'Members Home', 'seiu' ); ?></a></li>
							<li><a href="<?php the_field( 'membership_plus_logout_link', 'option' ); ?>"><?php echo esc_attr__( 'Logout', 'seiu' ); ?></a></li>
						</ul>
					</div>
				<?php else : ?>
					<a href="javascript:void(0);" class="btn btn--yellow-outline" data-login-nav-open>
						<span><?php the_field( 'membership_plus_login_text', 'option' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<button type="button" class="site-header__btn site-header__btn--mobile-menu" data-toggle="openPanel"
					data-open-classname="panel-open--mobile-menu">
				<svg viewBox='0 0 20 20' class='icon' width='1em' height='1em'>
					<use xlink:href='#icon-menu'></use>
				</svg>
			</button>

			<?php
			// if ( is_user_logged_in() && ( isset( $_COOKIE['nav-preference'] ) && 'members-nav' === $_COOKIE['nav-preference'] ) ) {
			// 	wp_nav_menu(
			// 		array(
			// 			'theme_location'  => 'members-main-menu',
			// 			'container_class' => 'top-menu-container',
			// 		)
			// 	);
			// } else {
				?>
				<div class="main-navigation top-menu-container">
					<ul id="primary-menu" class="menu">
						<?php
						for ( $i = 0; $i < sizeof( $primary_menu_items ); $i ++ ) {
							$menu_item = $primary_menu_items[ $i ];
							if ( $menu_item->menu_item_parent == 0 ) {
								echo "<li id='menu-item-" . esc_attr( $menu_item->ID ) . "' class='menu-item menu-item-type-post_type menu-item-object-page menu-item-" . esc_attr( $menu_item->ID ) . "'>";
								echo "<a href='" . esc_url( $menu_item->url ) . "' target='" . esc_attr( $menu_item->target ) . "'>" . esc_attr__( $menu_item->title, 'seiu' ) . '</a>';
								echo '</li>';
							}
						}
						?>
					</ul>

					<div id="primary-menu-content" class="menu menu--primary-content">
						<div class="container container--md">
							<div></div>
							<div class="sub-menu-wrapper">
								<?php
								for ( $i = 0; $i < sizeof( $primary_menu_items ); $i ++ ) {
									$menu_item = $primary_menu_items[ $i ];
									$parent_id = $menu_item->menu_item_parent;

									if ( $parent_id != 0 ) {
										$prev_menu_item = $primary_menu_items[ $i - 1 ];
										$prev_parent_id = $prev_menu_item->menu_item_parent;

										if ( $parent_id != $prev_parent_id ) {
											echo '</ul>';
											echo '<ul class="sub-menu">';
										}

										echo "<li id='menu-item-" . esc_attr( $menu_item->ID ) . "' class='menu-item menu-item-type-post_type menu-item-object-page menu-item-" . esc_attr( $menu_item->ID ) . "'>";
										echo "<a href='" . esc_url( $menu_item->url ) . "' target='" . esc_attr( $menu_item->target ) . "'>" . esc_attr( $menu_item->title ) . '</a>';
										echo '</li>';
									}
								}
								?>
							</div>
							<?php
							// Global Component: Member resource center
							// This card settings are in Theme General settings.
							$title             = get_field( 'block_title', 'option' ) ?: '';
							$block_description = get_field( 'block_description', 'option' ) ?: '';

							$phone_number         = get_field( 'phone_number', 'option' ) ?: '';
							$phone_number_updated = phone_number_format( $phone_number );
							$email                = get_field( 'email', 'option' ) ?: '';
							?>
							<div class="card__inner">
								<h4 class="card__title"><?php the_field( 'member_resource_center_heading', 'option' ); ?></h4>

								<?php if ( ! empty( $phone_number ) ) : ?>
									<a class="card__contact card__contact--phone" href="tel:<?php echo $phone_number_updated; ?>">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/icon-phone.svg" alt="">
										<h3><?php echo $phone_number; ?></h3>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $email ) ) : ?>
									<a class="card__contact card__contact--email" href="mailto:<?php echo $email; ?>" target="_blank">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/Icon-email.svg" alt="">
										<h3><?php echo $email; ?></h3>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $block_description ) ) : ?>
									<div class="card__description"><?php echo $block_description; ?></div>
								<?php endif; ?>
							</div>
						</div>

					</div>
				</div><!-- #site-navigation -->
			<?php //} ?>

			<div class="header-search">
				<span class="header-search__toggle-icon">
					<svg focusable="false" aria-label="Search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px">
						<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
					</svg> </span>
				<?php echo do_shortcode( '[ivory-search id="9554" title="Default Search Form"]' ); ?>
			</div>
		</div>
	</div>
</header><!-- #masthead -->

<!-- MOBILE MENU -->
<section id="PanelMobileMenu" class="offcanvas-panel offcanvas-panel--mobile-menu panel-mobile-menu" data-section-type="panel-mobile-menu">
	<header class="offcanvas-panel-header">
		<h2 class="offcanvas-panel-header__heading">
			<?php
			if ( has_custom_logo() ) :
				the_custom_logo();
			else :
				?>
				<a href="/" class="custom-logo-link" rel="home">
					<img width="626" height="120" src="/wp-content/themes/seiu/images/logo.svg" class="custom-logo" alt="seiu">
				</a>
			<?php endif; ?>
		</h2>
		<button type="button" data-toggle="closePanel"
				class="offcanvas-panel-header__btn offcanvas-panel-header__btn--right">
			<svg viewBox='0 0 20 20' class='icon icon-close' width='1em' height='1em'>
				<use xlink:href='#icon-close'></use>
			</svg>
		</button>
	</header>
	<div class="offcanvas-panel-body panel-mobile-menu__items ">
		<ul class="menu header-search">
			<li class="menu-item">
				<?php echo do_shortcode( '[ivory-search id="9554" title="Default Search Form"]' ); ?>
			</li>
		</ul>
		<?php
		if ( is_user_logged_in() && ( isset( $_COOKIE['nav-preference'] ) && 'members-nav' === $_COOKIE['nav-preference'] ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'members-main-menu',
					'container_class' => 'top-menu-container',
					'link_after'      => '<span class="menu-toggle"></span>',
				)
			);
		} else {
			wp_nav_menu(
				array(
					'theme_location'  => 'main-menu',
					'container_class' => 'top-menu-container',
					'link_after'      => '<span class="menu-toggle"></span>',
				)
			);
			wp_nav_menu(
				array(
					'theme_location' => 'secondary-menu',
					'link_after'     => '<span class="menu-toggle"></span>',
				)
			);
		}
		?>
		<!-- <a href="/" class="panel-mobile-menu__link">Get in Touch</a> -->
	</div>
</section>

<div id="Overlay" class="overlay" data-toggle="closePanel" data-ol-has-click-handler=""></div>

<script>
	const dropdownList = document.getElementById("wpml_dropdown");
	document.querySelectorAll('[id*=-secondary-menu] > .wpml-ls-item').forEach(function (node) {
		let IsContained = false;

		document.querySelectorAll('#wpml_dropdown > .wpml-ls-item').forEach(function (child) {
			if (child.className == node.className) {
				IsContained = true;
			}
		})

		if (!IsContained) {
			dropdownList.appendChild(node);
		}
	})
</script>
