<?php
/**
 * The template enables default blocks layout but without header.
 * Template Name: Blocks Template (without Header)
 *
 * @package seiu
 */

get_header();
?>

    <main id="primary" class="site-main page-membership-plus-new">
        <div class="block-editor-content">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					the_content();
				}
			}
			?>
        </div>
    </main><!-- #main -->

<?php get_footer(); ?>