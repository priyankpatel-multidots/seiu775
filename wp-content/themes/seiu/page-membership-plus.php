<?php
/**
 * The template for Membership Plus
 * Template Name: Membership Plus
 *
 * @package seiu
 */

get_header();
?>

    
<main id="primary" class="site-main page-membership-plus">
	<div class="page-header">
		<div class="container container--md">
			<h1><?php echo get_the_title(); ?></h1>
		</div>
	</div>

  <?php
    if ( have_posts() ) {
      while ( have_posts() ) { 
        the_post();
        the_content();
      }
    }
  ?>
</main><!-- #main -->


<?php get_footer(); ?>