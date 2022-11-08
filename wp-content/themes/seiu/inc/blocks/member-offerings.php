<!-- Section Member Offerings -->
<?php
  $user = wp_get_current_user();
  $section_title = get_field('section_title') ?: '';
  $categries = get_field('member_offerings') ?: '';
  $section_bg_color = get_field('section_background_color') ?: '';
?>

<section class="section section--member-offerings" data-accordion-selector>
  <div class="container" 
    <?php if ($section_bg_color) : ?>
      style="background-color: <?= $section_bg_color; ?>"
    <?php endif; ?>
    >
    
    <?php if ($section_title) : ?>
      <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
    <?php endif; ?>

    <?php if( !empty($categries )): ?>
      <div class="section__category">
        <div><i>Click on tile to see offer details</i></div>
        <div>
          <p class="label">Category</p>
          <select name="offering_category" data-accordion-category>
            <option selected disabled>None</option>
            <option value="all">All</option>
          <?php
            // Loop through rows.
            foreach($categries as $i => $category) :
              $args = array(
                'numberposts' => -1,
                'posts_per_page' => -1,
                'post_type'   => 'member_offering',
                'category'    => $category
              );
              $term = get_term($category);
              $offerings = get_posts( $args );
              $class = $i == 0 ? 'active' : '';
            ?>
            <option value="<?= $term->slug ?>"><?= $term->name ?></option>
          <?php endforeach; ?>
          </select>
        </div>
      </div>
    <?php endif; ?>

    <?php if( !empty($categries )): ?>
      <div class="member-offerings-wrapper">
      <?php
          // Loop through rows.
          foreach($categries as $i => $category) :
            $args = array(
              'numberposts' => -1,
              'posts_per_page' => -1,
              'post_type'   => 'member_offering',
              'category'    => $category,
              'orderby' => 'title',
              'order' => 'ASC'
            );
            $term = get_term($category);
            $offerings = get_posts( $args );
            // $class = $i == 0 ? 'active' : '';
          ?>
          <div class="member-offerings" data-accordion-item data-category-slug="<?= $term->slug; ?>" data-aos="fade-top" data-aos-duration="<?= $i+1 ?>000">
            <div class="h3 member-offerings__heading" data-accordion-heading>
              <?php echo $term->name; ?>

              <svg viewBox='0 0 20 20' class='icon icon-plus' width='1em' height='1em'>
                <use xlink:href='#icon-plus'></use>
              </svg>
              <svg viewBox='0 0 20 20' class='icon icon-minus' width='1em' height='1em'>
                <use xlink:href='#icon-minus'></use>
              </svg>
            </div>
            <div class="member-offerings__inner" data-accordion-content>
              <div class="member-offerings__list">
                <?php
                  // echo '<pre>';
                  // print_r($offerings);
                  // echo '</pre>';
                  foreach ($offerings as $j => $offer) :
                    $post_id = $offer->ID;
                    $post_url = get_permalink($post_id);
                    $image_url = get_the_post_thumbnail_url($post_id, 'medium');
                  ?>
                    <div class="member-offerings__card">
                      <!-- test -->
                      <?php if ( is_user_logged_in()): ?>
                        <a href="<?= $post_url ?>" class="card__link"></a>
                      <?php endif ;?>

                      <div class="card__info">
                        <h4><?php echo $offer->post_excerpt; ?></h4>
                        <p><?php echo $offer->post_title; ?></p>
                      </div>
                      <div class="login-wrapper">
                        <p>For details, please<br><a href="/login">LOGIN</a><p>
                      </div>
                      <?php if( !empty( $image_url ) ): ?>
                        <img src="<?php echo esc_url($image_url); ?>"
                          alt="<?= esc_attr(get_post_meta(get_post_thumbnail_id($post_id, 'medium'), '_wp_attachment_image_alt', true)); ?>" />
                      <?php endif; ?>
                    </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<!--/ Section Member Offerings -->