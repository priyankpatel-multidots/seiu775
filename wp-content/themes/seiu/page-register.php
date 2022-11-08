<?php
/**
 * The template for Register Page
 * Template Name: Register Page
 *
 * @package seiu
 */

get_header();
?>

    
<main id="primary" class="site-main page-register">
	<div class="page-header">
		<div class="container container--md">
			<h1><?php echo get_the_title(); ?></h1>
		</div>
	</div>

  <div class="container container--md auth-wrap">
		<?php get_template_part('template-parts/register-form') ?>
	</div>
</main><!-- #main -->


<?php get_footer(); ?>