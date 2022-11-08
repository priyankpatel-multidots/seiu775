<div class="auth-form">
	<form class="form form--with-validation auth-form__form" action="<?php echo site_url('/login/') ?>" method="post">
		<?php get_template_part('template-parts/form-messages') ?>
		<?php if (!empty($_REQUEST['redirect_to'])): ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr($_REQUEST['redirect_to']) ?>" />
		<?php endif ?>
		<div class="form__row">
			<label class="form__label" for="user_login"><?php the_field('email_address_label'); ?></label>
			<input class="input-text" type="email" name="user_login" id="user_login" value="<?php if (!empty($_POST['user_login'])) echo sanitize_text_field($_POST['user_login']) ?>"
				data-parsley-required-message="Please enter your email address." data-parsley-type-message="Please enter a valid email address." required>
		</div>
		<div class="form__row">
			<label class="form__label" for="user_password"><?php the_field('password_label'); ?></label>
			<input class="input-text" type="password" name="user_password" id="user_password"
				data-parsley-required-message="Please enter your password." required>
		</div>
		<div class="form__row form__row--checkbox-wrapper">
			<input class="input-checkbox" name="remember" id="remember" type="checkbox" value="forever"><label class="form__label" for="remember"><?php the_field('keep_me_logged_in_label'); ?></label>
		</div>
    <a class="btn btn--text btn--forgot-password" href="/wp-login.php?action=lostpassword"><?php the_field('forgot_password_label'); ?></a>
		<div class="auth-form__buttons">
			<input class="button button--large-desktop auth-form__submit" type="submit" name="wp-submit" value="<?php the_field('log_in_button_label'); ?>">
			
		</div>
	</form>
</div>
