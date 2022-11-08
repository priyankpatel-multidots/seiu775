<div class="logout">
	<h2 class="page-header__title"><?php the_field('logout_page_header'); ?></h2>
	
	<div class="general-message">
		<h3 class="general-message__title"><?php the_field('logout_h3_message'); ?></h3>
		<p class="general-message__content"><?php the_field('logout_general_message'); ?></p>
		<a role="button" class="button btn btn--primary button--large-desktop general-message__button" href="<?php the_field('login_link'); ?>"><?php the_field('login_button_text'); ?></a>
	</div>
</div>
