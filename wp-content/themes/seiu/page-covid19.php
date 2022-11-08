<?php
/**
 * The template enables default block layout support along with Gray background aside of content.
 *
 * Template Name: Blocks Template Covid 19
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */
get_header();
$show_card_member_resource = get_field( 'show_member_resource_center' ) ? get_field( 'show_member_resource_center' ) : '';
?>

<main id="primary" class="site-main page page--new-members">
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
				if ( empty( $show_card_member_resource ) ) :
					include locate_template( 'template-parts/components/card-member-resource-center.php' );
				endif;
				?>
			</div>
			
			
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
