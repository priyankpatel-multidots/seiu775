<?php
$menu_name = 'news-sidebar';
?>

<div class="sidebar">
	<div class="news-navigation">
		<?php
			// 	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			//     $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			// 		$menu_items = wp_get_nav_menu_items( $menu->term_id );
					
			// 		$title = $menu->name;
			// 		$menu_list = '<div class="side_menu post-compaigns"><h3>'.$title.'</h3><ul id="menu-' . $menu_name . '">';
			
			//     foreach ( (array) $menu_items as $key => $menu_item ) {
			//         $title = $menu_item->title;
			//         $url = $menu_item->url;
			//         $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
			//     }
			//     $menu_list .= '</ul></div>';
			//     echo $menu_list;
			//   }

		$topics    = get_field( 'topics', 'option' );
		if( $topics ){
			$html = '<div class="side_menu post_tags"><h3>'.__('Topics').'</h3><ul id="menu-tags">';
			foreach( $topics as $topic ) {
			
				$html .= "<li><a href=".esc_url( get_category_link( $topic->term_id ) )." title=".esc_html( $topic->name )." class='{$topic->name }'>";
				$html .= "{$topic->name }</a></li> ";
			} 
			$html .= '</ul></div>';
			echo $html;
		}
		?>
	</div>
	

	<?php if(!empty($most_popular_posts)) : ?>
		<div class="sidebar__widget most-popuplar-posts">
			<h3><?php the_field('popular_articles_header'); ?></h3>
			<ul>
				<?php foreach($featured_post_repeater as $post) {
					$post_id = $post['post']->ID;
					$title = $post['post']->post_title;
					$post_url = get_permalink( $post_id );

					echo '<li><a href="' . $post_url . '" class="sidebar__widget__link">' . $title . '</a><li>';
				}
				?>
			</ul>
		</div>
	<?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>