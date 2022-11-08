<?php
/**
 * * The template for Bio Page
 * Template Name: Bio Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();

$show_card_member_resource = get_field('show_member_resource_center') ?: '';
$social_profiles = get_field('social_profiles') ?: '';
$social_block_title = get_field('block_title') ?: '';
?>

	<main id="primary" class="site-main page page--bio">
		<div class="page-header">
			<div class="container container--md">
				<h1 class="entry-title"><?php echo get_field('leadership_page_title'); ?></h1>
			</div>
		</div>

		<div class="page__content">
			<div class="container">
				<article id="post-<?php the_ID(); ?>" class="page__content__left">
					<div class="entry-content">
						<?php
			        while ( have_posts() ) :
		            the_post();
		            the_content();
			        endwhile; // End of the loop.
			        ?>
					</div><!-- .entry-content -->

					<?php
						if (!empty($social_profiles)) :
	          	include( locate_template( 'template-parts/components/block-social-profiles.php'));
	        	endif;
	        ?>

				</article><!-- #post-<?php the_ID(); ?> -->

				<div class="page__content__right">
					<?php seiu_post_thumbnail(); ?>

					<?php 
						if(!empty($show_card_member_resource)) :
							include( locate_template( 'template-parts/components/card-member-resource-center.php'));
						endif;
					?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
