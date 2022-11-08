<?php
/**
 * The template enables default block layout support.
 *
 * Template Name: Blocks Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();
?>

<main id="primary" class="site-main page">
	<div class="page-header">
		<div class="container container--md">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
	</div>

	<div class="page__content">
		<article id="post-<?php the_ID(); ?>">
			<div class="entry-content">
					<?php
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile; // End of the loop.
					?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	</div>
	
</main><!-- #main -->

<?php
get_footer();
