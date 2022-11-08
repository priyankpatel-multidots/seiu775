<?php
/**
 * The template for displaying Member offering Post type.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package seiu
 */

get_header();

wpb_set_post_views(get_the_ID()); //set meta key for post view.

$category = get_the_category();
$category_link = get_category_link($category[0]);
$signup_box_title = get_field('signup_box_title') ?: '';
$signup_box_description = get_field('signup_box_description') ?: '';
?>

	<main id="primary" class="site-main">
		<header class="page-header">
			<div class="container container--md">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<?php
						seiu_posted_on();
						seiu_posted_by();
						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</div>
		</header><!-- .entry-header -->

		<section class="post__content post__content--member-offering">
			<div class="container container--md breadcrumb">
				<a href="/membership-plus?category=<?= sanitize_title_with_dashes($category[0]->slug); ?>">Membership Plus-<?= $category[0]->name; ?></a> &gt;
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</div>

			<div class="container container--md">
        <?php if (is_user_logged_in()) : ?>
          <div class="post__content__left">
            <?php
            while ( have_posts() ) :
              the_post();

              get_template_part( 'template-parts/content', get_post_type() );

            endwhile; // End of the loop.
            ?>
          </div>
          <div class="post__content__right">
            <?php seiu_post_thumbnail(); ?>
            <?php if($signup_box_title || $signup_box_description): ?>
              <div class="sign-up-box">
                <?php if ($signup_box_title) : ?>
                  <h3><?= $signup_box_title; ?></h3>
                <?php endif; ?>

                <?php if ($signup_box_description) : ?>
                  <div><?= $signup_box_description; ?></div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php else : ?>
        <div>
          <div class="member-offering__login-warning"><?php the_field('member_offering_login_text','option'); ?></div>
          <a class="btn btn--primary" href="/login" data-login-nav-open-trigger>Log In</a>
        </div>
        <?php endif; ?>

			</div>
		</section>

		<div class="post-navigation-wrapper">
			<div class="container container--md">
				<?php
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( '', 'seiu' ) . '</span> <span class="nav-title">&lt; Previous Membership Plus Offer</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( '', 'seiu' ) . '</span> <span class="nav-title">Next Membership Plus Offer &gt;</span>',
						)
					);
				?>
			</div>
		</div>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
