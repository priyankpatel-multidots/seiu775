<?php
/**
 * * The template for New Member Page
 * Template Name: New Members Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();

$show_card_member_resource = get_field('show_member_resource_center') ?: '';

// if (current_user_can('read_membership')) :
?>

	<main id="primary" class="site-main page page--new-members">
		<div class="page-header">
			<div class="container container--md">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</div>

		<div class="page__content">
				<article id="post-<?php the_ID(); ?>" class="">
					<div class="entry-content">
						<?php
			        while ( have_posts() ) :
		            the_post();
		            the_content();
			        endwhile; // End of the loop.
			        ?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<!-- <div class="page__content__right">
					<?php //seiu_post_thumbnail(); ?>
					<?php //include( locate_template( 'template-parts/components/card-member-resource-center.php')); ?>
				</div> -->

		</div>
	</main><!-- #main -->

<?php
// endif;
// get_sidebar();
get_footer();
?>