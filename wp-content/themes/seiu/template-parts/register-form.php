<div class="auth-form">
	<form class="form form--with-validation auth-form__form" action="<?php echo site_url('/register/') ?>" method="post">
		<input type="hidden" name="submitted" value="true" />
		<?php get_template_part('template-parts/form-messages') ?>
		<?php if (!empty($_REQUEST['redirect_to'])): ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr($_REQUEST['redirect_to']) ?>" />
		<?php endif ?>
		<div class="form__row-wrapper">
			<div class="form__row">
				<label class="form__label" for="first_name"><?php the_field('first_name_label'); ?></label>
				<input class="input-text" type="text" name="first_name" id="first_name" value="<?php if (isset($_POST['first_name'])) echo sanitize_text_field($_POST['first_name']) ?>"
				 data-parsley-required-message="Please enter your first name.">
			</div>
			<div class="form__row">
				<label class="form__label" for="last_name"><?php the_field('last_name_label'); ?></label>
				<input class="input-text" type="text" name="last_name" id="last_name" value="<?php if (isset($_POST['last_name'])) echo sanitize_text_field($_POST['last_name']) ?>"
				>
			</div>
		</div>
		<div class="form__row-wrapper">
			<div class="form__row">
				<label class="form__label" for="email"><?php the_field('email_label'); ?></label>
				<input class="input-text" type="email" name="email" id="email" value="<?php if (isset($_POST['email'])) echo sanitize_text_field($_POST['email']) ?>"
				 required>
			</div>
			<div class="form__row">
				<label class="form__label" for="member_id"><?php the_field('member_id_number_label'); ?></label>
				<input class="input-text" type="text" name="member_id" id="member_id" value="<?php if (isset($_POST['member_id'])) echo sanitize_text_field($_POST['member_id']) ?>"
				>
			</div>
		</div>

		<div class="form__row-wrapper">
			<div class="form__row">
				<label class="form__label" for="phone"><?php the_field('phone_number_label'); ?></label>
				<input class="input-text" type="tel" name="phone" id="phone" value="<?php if (isset($_POST['phone'])) echo sanitize_text_field($_POST['phone']) ?>"
				>
			</div>
		</div>

    <!-- <div class="form-messages form-messages--notices">
      <p class="form-messages__message">Please create a unique password that is not the same as your hospital or health system password.</p>
    </div> -->

    <div class="form__row-wrapper">
			<div class="form__row">
				<label class="form__label" for="password"><?php the_field('choose_a_password_label'); ?></label>
				<input class="input-text" type="password" name="password" id="password"
					data-parsley-required-message="Please enter a password." minlength="6" data-parsley-minlength-message="Your password must be at least six characters." required>
			</div>
		</div>
		<div class="form__row-wrapper">
			<div class="form__row">
				<label class="form__label" for="password_confirmation"><?php the_field('retype_password_label'); ?></label>
				<input class="input-text" type="password" name="password_confirmation" id="password_confirmation"
					data-parsley-required-message="Please confirm your password." data-parsley-equalto="#password" data-parsley-equalto-message="The password confirmation does not match." required>
			</div>
		</div>
		<div class="auth-form__buttons">
			<input class="btn btn--primary auth-form__submit" type="submit" name="wp-submit" value="<?php the_field('register_submit_button'); ?>" />
		</div>
	</form>
</div>

<div class="auth-sidebar">
  <?php $ctaLink = get_field('sidebar_cta_button_link'); ?>
  <h3><?php the_field('sidebar_header'); ?></h3>
  <div class="copy-large"><?php the_field('sidebar_text'); ?></div>
  <div class="label join-link"><?php the_field('sidebar_cta_header'); ?><br><a href="<?= $ctaLink['url']; ?>" target="<?= $ctaLink['target']; ?>"><?php the_field('sidebar_cta_button_text'); ?></a></div>
</div>