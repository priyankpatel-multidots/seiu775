<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package seiu
 */

get_header();


$post_id = get_the_ID();
wpb_set_post_views($post_id); //set meta key for post view.

$category = get_the_terms($post_id, 'category')[0];
$post_date = get_the_date();
$sidebar = get_field('news_post_sidebar', 'option');
?>

	<main id="primary" class="site-main page-sidebar">
		<header class="page-header">
			<div class="container container--md">
        <?php
        if ( is_singular() ) :
        //   echo '<h1 class="entry-title">'.$category->name.'</h1>';
		  the_title( '<h1 class="entry-title">', '</h1>' );
        else :
          the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
        endif;
        ?>
			</div>
		</header><!-- .entry-header -->

		<div class="page-sidebar__content detail-container single-detail-page">
			<div class="container container--md">
	    	<div class="main-content">

	    		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php $news_source = get_field('news_source');  
            //the_title( '<h2 class="entry-title">','</h2>');

								seiu_post_thumbnail();
						?>

						<div class="entry-content">
							<?php
								while ( have_posts() ) :
									the_post();
									the_content();
								endwhile; // End of the loop.
							?>
						</div>
					</article>
					<?php
						$post_tags = get_the_tags( $post_id );
						
						if( $post_tags ):?>
							<div class="tag-section">
								<ul class="tag-lists">
									<li>
										<span>
											<?php esc_html_e('Posted in: ', 'seiu'); ?>
										</span>
									</li>
									<?php foreach( $post_tags as $tag ): ?>
										<li>
											<a href="<?php echo esc_url( get_term_link($tag->term_id) );?>">
												<?php echo esc_html( $tag->name ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif;
					?>
					<div class="topbar">
						<div class="topbar__widget media-contact">
							<h3><?php echo $sidebar['news_sidebar_heading']; ?></h3>
							<?php echo $sidebar['media_contact']; ?>
					  	</div>
					</div>
				</div>

				<?php
					include( locate_template( 'template-parts/sidebar.php'));
		   		?>
			</div>
		</div>

<!--
		<div class="post-navigation-wrapper">
			<div class="container container--md">
				<?php
					// the_post_navigation(
					// 	array(
					// 		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'seiu' ) . '</span> <span class="nav-title">%title</span>',
					// 		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'seiu' ) . '</span> <span class="nav-title">%title</span>',
					// 	)
					// );
				?>		
			</div>
		</div>
		-->
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();