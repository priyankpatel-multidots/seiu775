<?php
/**
 * * The template for Contact Page
 * Template Name: Contact Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();

$show_card_member_resource = get_field('show_member_resource_center') ?: '';
?>

	<main id="primary" class="site-main page page--contact page--new-members">
		<div class="page-header">
			<div class="container container--md">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
			<div class="outer_container">
			<div class="container">
				<?php if ( is_user_logged_in() ) : ?>
				<?php else : ?>
					<?php $joinCta = get_field('join_now_cta', 'option'); ?>
					<div class="btn-wrapper">
			          <div class="btn-wrapper--join">
			            <h3 class="intro-label"><?= $joinCta['join_now_header'];  ?></h3>
			            <a href="<?= $joinCta['join_now_link']['url'];  ?>" target="<?= $joinCta['join_now_link']['target'];  ?>" class="btn btn--primary"><?= $joinCta['join_now_button_text'];  ?></a>
			          </div>
			          <div class="btn-wrapper--join">
			            <h3 class="intro-label"><?= $joinCta['login_header'];  ?></h3>
			            <a href="<?= $joinCta['login_link']['url'];  ?>" target="<?= $joinCta['login_link']['target'];  ?>" class="btn btn--primary"><?= $joinCta['login_button_text'];  ?></a>
			          </div>
			        </div>
			        <?php endif; ?>
			</div>
		</div>
		</div>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
