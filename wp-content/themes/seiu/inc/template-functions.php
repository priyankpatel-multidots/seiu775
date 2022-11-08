<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package seiu
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function seiu_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

  $user = wp_get_current_user();
  if (is_user_logged_in()) {
    //The user has the "member" role
    $classes[] = 'member-logged-in';
  }

	return $classes;
}

add_filter( 'body_class', 'seiu_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function seiu_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'seiu_pingback_header' );


/* Convert hexdec color string to rgb(a) string */
function hex2rgba($color, $opacity = false) {
 
  $default = 'rgb(0,0,0)';
 
  //Return default if no color provided
  if(empty($color))
    return $default; 
 
  //Sanitize $color if "#" is provided 
  if ($color[0] == '#' ) {
    $color = substr( $color, 1 );
  }

  //Check if color has 6 or 3 characters and get values
  if (strlen($color) == 6) {
          $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
  } elseif ( strlen( $color ) == 3 ) {
          $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
  } else {
          return $default;
  }

  //Convert hexadec to rgb
  $rgb =  array_map('hexdec', $hex);

  //Check if opacity is set(rgba or rgb)
  if($opacity){
    if(abs($opacity) > 1)
      $opacity = 1.0;
    $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
  } else {
    $output = 'rgb('.implode(",",$rgb).')';
  }

  //Return rgb(a) color string
  return $output;
}

// Changing excerpt more
// function new_excerpt_more($more) {
//  global $post;
//  return '… <a href="'. get_permalink($post->ID) . '">' . 'Read More' . '</a>';
// }
// add_filter('excerpt_more', 'new_excerpt_more');

// function modify_read_more_link() {
//   return '<a class="more-link" href="' . get_permalink() . '">Read More</a>';
// }
// add_filter( 'the_content_more_link', 'modify_read_more_link' );

function news_list() {
  $args = array( 'posts_per_page' => 6, 'offset'=> 0, 'category_name' => 'news');
  $query = new WP_Query( $args );
  $articles  = $query->posts;

  if ( ! empty( $articles ) ) {
      $html = '<div class="wp-container-12 wp-block-query news-listing-compaign">
        <ul class="wp-block-post-template">';
          foreach ( $articles as $i => $card_post ) :
            $post_id = $card_post->ID;
            $content = get_the_excerpt($post_id);
            
            $html .= '<li class="wp-block-post post-'.$post_id.' post type-post status-publish format-standard hentry category-news">
                <h4 class="wp-container-8 has-text-color has-purple-color wp-block-post-title">
                  <a href="'.get_permalink( $post_id ).'" target="_self" rel="">'.$card_post->post_title.'</a></h4>

                <div class="wp-block-post-excerpt"><p class="wp-block-post-excerpt__excerpt">'. substr($content, 0, 100)  .'...</p></div>
                
              </li>';
            endforeach;
          }
        $html .= '</ul>
      </div>';
      return $html;
}
add_shortcode( 'news_list', 'news_list' );

//shortcode to add login logout links below page
function login_logout_links() {
  $html = '<div class="container">';
      if ( is_user_logged_in() ): 
      else :
        $joinCta = get_field('join_now_cta', 'option');
        $html .= '<div class="btn-wrapper">
              <div class="btn-wrapper--join">
                <h3 class="intro-label">'.$joinCta['join_now_header'].'</h3>
                <a href="'.$joinCta['join_now_link']['url'].'" target="'.$joinCta['join_now_link']['target'].'" class="btn btn--primary">'.$joinCta['join_now_button_text'].'</a>
              </div>
              <div class="btn-wrapper--join">
                <h3 class="intro-label">'.$joinCta['login_header'].'</h3>
                <a href="'.$joinCta['login_link']['url'].'" target="'. $joinCta['login_link']['target'].'" class="btn btn--primary">'.$joinCta['login_button_text'].'</a>
              </div>
            </div>';
            endif;
      $html .= '</div>';
      return $html;
}
add_shortcode( 'login_logout_links', 'login_logout_links' );


//shortcode to add contact_modal update link
function contact_modal() {
  if ( is_user_logged_in() && is_page( 'events-and-actions' ) ) {
      $user = wp_get_current_user();
      require_once get_template_directory() . '/inc/modules/class-memberinfo.php';
      $member_info_obj = new MemberInfo( $user );
      $cookie_key      = $member_info_obj->get_cookie_key_for_current_user();

      // Check if cookie exist for current logged-in user.
      if ( isset( $_COOKIE[ $cookie_key ] ) ) {

        // Member information stored in json format - decode json.
      $member_info = (array) json_decode( wp_unslash( $_COOKIE[ $cookie_key ] ) );
      $html = '<div class="cta-wrap">
      <div class="wp-block-columns are-vertically-aligned-center">
          <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%">
          <h2 class="h3" id="has-your-contact-info-changed">'.__('Has Your Contact Info Changed?','seiu').'</h2>
          </div>



          <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%">
          <div class="wp-container-4 wp-block-buttons">
          <div class="wp-block-button"><a class="wp-block-button__link" href="#member-info-modal" rel="modal:member-info-modal">'.__('See My Current Info','seiu').'</a></div>
          </div>
          </div>
      </div>
      </div>';
      return $html;
    }
  }
}
add_shortcode( 'contact_modal', 'contact_modal' );

//pagination scroll top
add_action( 'wp_head', function() { ?>
    <script>
      (function($) {
        $(document).on('facetwp-refresh', function() {
          if (FWP.soft_refresh == true) {
            FWP.enable_scroll = true;
          } else {
            FWP.enable_scroll = false;
          }
        });
        $(document).on('facetwp-loaded', function() {
          if (FWP.enable_scroll == true) {
            $('html, body').animate({
              scrollTop: 0
            }, 500);
          }
        });
      })(jQuery);
    </script>
    <script>
	(function($) {
		$(document).on("click", ".page--new-members .page__content .content-with-video .wp-block-columns .wp-block-column .inline-links li a", function (e) {
			e.preventDefault();
			var $section = $($(this).attr('href'));
			var topOffsetVal = $section.offset().top
			var headerHeight = $('.site-header').outerHeight();
			var paddingVal = 90;
			$('html, body').animate({
				scrollTop: topOffsetVal - paddingVal - headerHeight
			}, 500);
		});
	})(jQuery);
    </script>
<?php } );