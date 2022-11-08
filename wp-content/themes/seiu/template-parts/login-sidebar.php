<aside class="auth-sidebar auth-sidebar--register">
	<div class="auth-sidebar__wrap">
		<h2 class="auth-sidebar__header"><?php the_field('register_header'); ?></h2>
		<p class="auth-sidebar__body"><?php the_field('register_text'); ?></p>
    <?php $button_link = get_field('register_button_link'); ?>
		<a role="button" class="button auth-sidebar__button" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?php the_field('register_button_text'); ?></a>
		<div class="auth-sidebar__background"></div>
	</div>
</aside>
