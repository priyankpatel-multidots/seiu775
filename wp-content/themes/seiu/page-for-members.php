<?php
/**
 * The template for For Members Page
 * Template Name: For Members Page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();

// if (current_user_can('read_membership')) :
?>

  <main id="primary" class="site-main page page--for-members">
    <div class="page-header">
      <div class="container container--md">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      </div>
    </div>
      <?php
      while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'page' );

      endwhile; // End of the loop.
      ?>
  </main><!-- #main -->

<?php
// endif;
// get_sidebar();
get_footer();
