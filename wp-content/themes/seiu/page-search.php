<?php
/**
 * The template for displaying the news
 * Template Name: Search Page
 *
 * @package seiu
 */

get_header();

?>

    
<main id="primary" class="site-main page page--search">
	<div class="page-header">
		<div class="container container--md">
			<h1><?php echo get_the_title(); ?></h1>
		</div>
	</div>
	<section>
		<div class="container container--md">
      <?php echo do_shortcode( '[ivory-search id="9554" title="Default Search Form"]' ); ?>
		</div>
	</section>
</main><!-- #main -->

<?php get_footer(); ?>
