<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */

get_header();
if( is_category() ) {
	$category = get_category( get_query_var( 'cat' ) );
	$cat_id = $category->slug;
}

$sidebar = get_field('news_post_sidebar', 'option');
global $wp_query;
$articles_page_count = $wp_query->max_num_pages;
?>
	<div class="page-header">
		<div class="container container--md">
			<?php if( is_category() ) { 
						echo '<h1 class="page-title">'.$category->name.'</h1>'; 
				} elseif(is_tag() ) {
					 $tag = get_queried_object();
    				
					echo '<h1 class="page-title">Topic: '.$tag->name.'</h1>'; 
					
				}
				else {
					the_archive_title( '<h1 class="page-title">', '</h1>' ); 
				} ?>
			
		</div>
	</div>
	<?php if( is_category() ) {
		if($cat_id == 'news'){ ?>
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
		<?php 
		} 
	}
	?>

	<div class="wp-container-2 wp-block-group alignfull has-gray-background-color has-background news-main-container">
		<?php if( is_category() ): ?>
			<?php if($cat_id == 'news'): ?>
				<div class="topbar news-category-topbar">
					<div class="topbar__widget media-contact">
						<h3><?php echo $sidebar['news_sidebar_heading']; ?></h3>
						<?php echo $sidebar['media_contact']; ?>
					</div>
					<div class="topbar__widget tag_filter" style="opacity:0;">
						<div>
							<span class="label"><?php _e( 'View by TOPIC:', 'seiu' ); ?></span>
							<?php echo do_shortcode( '[facetwp facet="tags"]' ); ?>
						</div>
					</div>
					<div class="mobile_tag_filter tag_filter" style="display:none !important;">
						<div>
							<span class="label"><?php _e( 'View by TOPIC:', 'seiu' ); ?></span>
							<?php echo do_shortcode( '[facetwp facet="tags_dropdown"]' ); ?>
							
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<section class="cards">
			<?php if ( have_posts() ) : ?>
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
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
			<div class="pagination">
				<?php echo do_shortcode( '[facetwp pager="true"]' ); ?>
			</div>
		</section><!-- #main -->
	</div>
	<?php  if( is_category() ) { ?>
		<div class="bottom_media_bar wp-container-2 wp-block-group alignfull has-white-background-color has-background">
			<div class="topbar__widget media-contact">
				<h3><?php echo $sidebar['news_sidebar_heading']; ?></h3>
			<?php echo $sidebar['media_contact']; ?>
		</div>
		</div>
	<?php } ?>
<?php
//get_sidebar();
get_footer();
