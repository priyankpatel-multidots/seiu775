<?php
// CREATE CUSTOM BLOCK CATEGORY
function custom_block_category( $categories, $post ) {
	//custom category array
	$custom_block = array(
		'slug'  => 'seiu-blocks',
		'title' => __( 'Seiu Blocks', 'seiu-blocks' ),
	);

	$categories_sorted    = array();
	$categories_sorted[0] = $custom_block;

	foreach ( $categories as $category ) {
		$categories_sorted[] = $category;
	}

	return $categories_sorted;
}

add_filter( 'block_categories', 'custom_block_category', 10, 2 );


function register_acf_block_types() {
	if ( function_exists( 'acf_register_block' ) ) {
		/**
		 * ACF Blocks
		 */
		acf_register_block_type( array(
			'name'            => 'hero',
			'title'           => __( 'Hero Module' ),
			'description'     => __( 'Hero Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'format-gallery',
			'keywords'        => array( 'block', 'custom', 'hero', 'header' ),
			'render_template' => '/inc/blocks/hero.php',
		) );

		acf_register_block_type( array(
			'name'            => 'slider',
			'title'           => __( 'Slider Module' ),
			'description'     => __( 'Slider Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'layout',
			'keywords'        => array( 'block', 'custom', 'slider-module', 'Slider', 'Carousel' ),
			'render_template' => '/inc/blocks/slider-module.php',
		) );

		acf_register_block_type( array(
			'name'            => 'intro-module',
			'title'           => __( 'Intro Module' ),
			'description'     => __( 'Intro Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'align-left',
			'keywords'        => array( 'block', 'custom', 'intro-module', 'text' ),
			'render_template' => '/inc/blocks/intro-module.php',
		) );

		acf_register_block_type( array(
			'name'            => 'events-module',
			'title'           => __( 'Events Module' ),
			'description'     => __( 'Events Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'images-alt',
			'keywords'        => array( 'block', 'custom', 'event' ),
			'render_template' => '/inc/blocks/events-module.php',
		) );


		acf_register_block_type( array(
			'name'            => 'faq',
			'title'           => __( 'Faq Module' ),
			'description'     => __( 'Faq Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'images-alt',
			'keywords'        => array( 'block', 'custom', 'faq' ),
			'render_template' => '/inc/blocks/faq-module.php',
		) );


		acf_register_block_type( array(
			'name'            => 'featured-posts-grid',
			'title'           => __( 'Featured Posts Grid' ),
			'description'     => __( 'Featured Posts Grid' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'grid-view',
			'keywords'        => array( 'block', 'custom', 'featured-posts-grid' ),
			'render_template' => '/inc/blocks/featured-posts-grid.php',
		) );

		acf_register_block_type( array(
			'name'            => 'featured-posts-grid-masonry',
			'title'           => __( 'Featured Posts Grid Masonry' ),
			'description'     => __( 'Featured Posts Grid Masonry' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'grid-view',
			'keywords'        => array( 'block', 'custom', 'featured-posts-grid-masonry' ),
			'render_template' => '/inc/blocks/featured-posts-grid-masonry.php',
		) );

		acf_register_block_type( array(
			'name'            => 'featured-instagrams',
			'title'           => __( 'Featured Instagrams' ),
			'description'     => __( 'Featured Instagrams' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'media-document',
			'keywords'        => array( 'block', 'custom', 'featured-instagrams', 'social' ),
			'render_template' => '/inc/blocks/featured-instagrams.php',
		) );

		acf_register_block_type( array(
			'name'            => 'featured-contents',
			'title'           => __( 'Featured Contents' ),
			'description'     => __( 'Featured Contents' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'align-left',
			'keywords'        => array( 'block', 'custom', 'featured-contents' ),
			'render_template' => '/inc/blocks/featured-contents.php',
		) );

		acf_register_block_type( array(
			'name'            => 'featured-icons',
			'title'           => __( 'Featured Icons' ),
			'description'     => __( 'Featured Icons' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'layout',
			'keywords'        => array( 'block', 'custom', 'featured-icons' ),
			'render_template' => '/inc/blocks/featured-icons.php',
		) );


		acf_register_block_type( array(
			'name'            => 'membership-module',
			'title'           => __( 'Membership Module' ),
			'description'     => __( 'Membership Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'awards',
			'keywords'        => array( 'block', 'custom', 'membership-module', 'membership' ),
			'render_template' => '/inc/blocks/membership-module.php',
		) );

		acf_register_block_type( array(
			'name'            => 'membership-plus-events-module',
			'title'           => __( 'Membership Module & Events Module' ),
			'description'     => __( 'Membership Module & Events Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'images-alt',
			'keywords'        => array( 'block', 'custom', 'membership', 'event' ),
			'render_template' => '/inc/blocks/membership-plus-events-module.php',
		) );


		acf_register_block_type( array(
			'name'            => 'member-testimonials',
			'title'           => __( 'Member Testimonials' ),
			'description'     => __( 'Member Testimonials' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'awards',
			'keywords'        => array( 'block', 'custom', 'member-testimonials' ),
			'render_template' => '/inc/blocks/member-testimonials.php',
		) );


		acf_register_block_type( array(
			'name'            => 'member-offerings',
			'title'           => __( 'Member offerings Module' ),
			'description'     => __( 'Member offerings Module' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'images-alt',
			'keywords'        => array( 'block', 'custom', 'member-offerings' ),
			'render_template' => '/inc/blocks/member-offerings.php',
		) );

		acf_register_block_type( array(
			'name'            => 'text-list-cards-grid',
			'title'           => __( 'Text & List Cards grid' ),
			'description'     => __( 'Text & List Cards grid' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'grid-view',
			'keywords'        => array( 'block', 'custom', 'text-list-cards-grid' ),
			'render_template' => '/inc/blocks/text-list-cards-grid.php',
		) );

		acf_register_block_type( array(
			'name'            => 'card-member-resource-center',
			'title'           => __( 'Member Resource Center' ),
			'description'     => __( 'Member Resource Center' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'layout',
			'keywords'        => array( 'block', 'custom', 'card-member-resource-center' ),
			'render_template' => '/inc/blocks/card-member-resource-center.php',
		) );

		acf_register_block_type( array(
			'name'            => 'membership-events',
			'title'           => __( 'Membership Events' ),
			'description'     => __( 'Membership Events' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'tickets-alt',
			'keywords'        => array( 'block', 'custom', 'membership', 'event' ),
			'render_template' => '/inc/blocks/membership-events.php',
		) );

		acf_register_block_type( array(
			'name'            => 'more-info',
			'title'           => __( 'More Info' ),
			'description'     => __( 'More Info' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'info',
			'keywords'        => array( 'block', 'custom', 'more', 'info' ),
			'render_template' => '/inc/blocks/more-info.php',
		) );

		acf_register_block_type( array(
			'name'            => 'cards-grid',
			'title'           => __( 'Cards Grid' ),
			'description'     => __( 'Cards Grid' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'block', 'custom', 'cards', 'grid' ),
			'render_template' => '/inc/blocks/cards-grid.php',
		) );

		acf_register_block_type( array(
			'name'            => 'action-alert',
			'title'           => __( 'Action Alert' ),
			'description'     => __( 'Action Alert' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'bell',
			'keywords'        => array( 'block', 'custom', 'action', 'alert' ),
			'render_template' => '/inc/blocks/action-alert.php',
		) );

		acf_register_block_type( array(
			'name'            => 'animated-image',
			'title'           => __( 'Animated Image' ),
			'description'     => __( 'Animated Image' ),
			'category'        => 'seiu-blocks',
			'icon'            => 'format-image',
			'keywords'        => array( 'block', 'custom', 'animated', 'image' ),
			'render_template' => '/inc/blocks/animated-image.php',
		) );
	}
}

/*
* ADD BLOCKS CALLS
*/

add_action( 'acf/init', 'register_acf_block_types' );
