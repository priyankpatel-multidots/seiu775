<?php
/**
 * The template for displaying the news
 * Template Name: News Template
 *
 * @package seiu
 */

get_header();
$sidebar = get_field('news_post_sidebar', 'option');
$articles = array();

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args  = array(
	// 'post_type' => ['article'],
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'posts_per_page' => 12,
	'paged'          => $paged,
	'category_name'  => 'news, press',
	'facetwp' => true,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	$articles            = $query->posts;
	$articles_page_count = $query->max_num_pages;
}

$section_title = 'News';

?>

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
<div class="wp-container-2 wp-block-group alignfull has-gray-background-color has-background">
	<div class="topbar">
		<div class="topbar__widget media-contact">
			<h3><?php echo $sidebar['news_sidebar_heading']; ?></h3>
		<?php echo $sidebar['media_contact']; ?>
	  </div>
	</div>

	<section class="cards">
		
			<?php if ( ! empty( $articles ) ) : ?>
					<div class="cards--list">
					<?php
					foreach ( $articles as $i => $card_post ) :
						include locate_template( 'template-parts/components/card-post.php' );
					  endforeach; ?>
					</div>
					<div class="pagination">
					<?php
					echo paginate_links(
						array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $articles_page_count,
							'current'      => max( 1, get_query_var( 'paged' ) ),
							'format'       => '?paged=%#%',
							'show_all'     => false,
							'type'         => 'plain',
							'end_size'     => 4,
							'mid_size'     => 1,
							'prev_next'    => true,
							'prev_text'    => sprintf( '<i class="pagination--prev" title="%1$s"></i>', __( 'Newer Posts', 'text-domain' ) ),
							'next_text'    => sprintf( '<i class="pagination--next" title="%1$s"></i>', __( 'Older Posts', 'text-domain' ) ),
							'add_args'     => false,
							'add_fragment' => '',
						)
					);
					?>
				</div>
			<?php endif; ?>

		</div>
	</section>
</div>
	


<?php
	get_footer();
?>
