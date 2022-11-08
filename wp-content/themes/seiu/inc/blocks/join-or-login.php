<?php if ( ! is_user_logged_in() ) : ?>
	<?php if ($button_position == 'left') : ?>
		<?php if ($button_label && $button_link) : ?>
			<div class="cta-wrapper">
				<div class="section__primary-cta">
					<?php if ($button_intro) : ?>
						<h3 class=""><?= $button_intro; ?></h3>
					<?php endif; ?>
					<a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>" <?php if($is_login_trigger): ?>data-login-nav-open-trigger<?php endif; ?>><?= $button_label; ?></a>
				</div>
				<div class="section__secondary-cta">
					<h3 class=""><?= "Already a Member?"; ?></h3>
					<a class="btn btn--primary" href="<?= '/login/'; ?>"><?= 'Login Now'; ?></a>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>