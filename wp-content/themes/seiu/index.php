<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();
$sidebar = get_field('news_post_sidebar', 'option');
?>

	<main id="primary" class="site-main">
		<div class="page-header">
			<div class="container container--md">
				<h1 class="page-title">
				<?php
					echo apply_filters( 'the_title', get_the_title( get_option( 'page_for_posts' ) ) );
				?>
				</h1>
			</div>
		</div>
		<div class="category-filter container">
			<div class="categories-list">
				<div>
					<span class="label"><?php _e( 'Filter Articles:', 'seiu' ); ?></span>
					<?php echo do_shortcode( '[facetwp facet="tags"]' ); ?>
				</div>
			</div>
			<div class="mobile-categories-list" style="display:none;">
				<div>
					<span class="label"><?php _e( 'Filter Articles:', 'seiu' ); ?></span>
					<?php echo do_shortcode( '[facetwp facet="tags_dropdown"]' ); ?>
				</div>
			</div> 
		</div>
		<div class="wp-container-2 wp-block-group alignfull has-gray-background-color has-background news-main-container">
			<?php if ( $sidebar ) : ?>
				<div class="topbar__widget media-contact">
					<h3><?php echo $sidebar['news_sidebar_heading']; ?></h3>
					<?php echo $sidebar['media_contact']; ?>
				</div>
			<?php endif; ?>
			<section class="cards">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;
					?>
					<div class="cards--list">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							* Include the Post-Type-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Type name) and that will be used instead.
							*/
							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;
						?>
					</div>
					<?php
					/**
					 * Pagination
					 */
					//the_posts_navigation();
					?>
					
				<?php
				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				<div class="pagination">
					<?php echo do_shortcode( '[facetwp pager="true"]' ); ?>
				</div>
			</section>
		</div>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
