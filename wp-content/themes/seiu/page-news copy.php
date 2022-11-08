<?php
/**
 * The template for displaying the news
 * Template Name: News Template
 *
 * @package seiu
 */

get_header();

$articles = array();

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args  = array(
	// 'post_type' => ['article'],
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'posts_per_page' => 6,
	'paged'          => $paged,
	'category_name'  => 'news, press',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	$articles            = $query->posts;
	$articles_page_count = $query->max_num_pages;
}

$section_title = 'News';

?>
	
<main id="primary" class="site-main page-news page-sidebar">
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

	<div class="page-sidebar__content section--featured-posts">
		<div class="container container--md">
			<div class="main-content featured-posts--list-view">
				<?php
				if ( ! empty( $articles ) ) :
					foreach ( $articles as $i => $card_post ) :
						include locate_template( 'template-parts/components/card-post.php' );
					  endforeach;
					endif;
				?>

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
			</div>
			<?php
				require locate_template( 'template-parts/sidebar.php' );
			?>
		</div>
	</div>
</main><!-- #main -->


<?php
	get_footer();
?>
