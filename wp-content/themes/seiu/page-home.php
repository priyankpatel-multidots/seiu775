<?php
/**
 * The template for displaying the home page
 * Template Name: Home Page
 *
 * @package seiu
 */

get_header();

?>

    
<main id="primary" class="site-main page-home">
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