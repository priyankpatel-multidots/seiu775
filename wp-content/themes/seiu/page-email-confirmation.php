<?php
/**
 * The template for Email Confirmation Page
 * Template Name: Email Confirmation Page
 *
 * @package seiu
 */

get_header();
?>

    
<main id="primary" class="site-main page-email-confirmation">
	<div class="page-header">
		<div class="container container--md">
			<h1><?php echo get_the_title(); ?></h1>
		</div>
	</div>

  <div class="container container--md auth-wrap">
		<div class="email-confirmation">
			<h2 class="page-header__title">Your account has been created successfully.</h2>
			<div class="general-message">
				<p class="general-message__title copy-large">You may now <a href="/login" data-login-nav-open-trigger>log in</a> to Membership Plus.</p>
			</div>
		</div>
	</div>
</main><!-- #main -->


<?php get_footer(); ?>