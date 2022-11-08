<!-- Section Featured instagrams -->
<?php
  $section_title = get_field('featured_instagrams_title');
  $section_description = get_field('featured_instagrams_description');
  $instagram_info = get_field('instagram_info') ?: [];
  $section_bg_color = get_field('section_background_color');
  $instagrams_per_row = get_field('instagrams_per_row') ?: 3;
  $instagram_access_token = get_field('instagram_access_token');
?>

<section class="section section--featured-instagrams"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?>
  >
  <div class="container container--md">
    <?php if ($section_title) : ?>
      <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
    <?php endif; ?>

    <?php if ($section_description) : ?>
      <div class="section__description" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
    <?php endif; ?>

      <div class="featured-instagrams__list featured-instagrams__list--<?= $instagrams_per_row; ?>">
        <?php if( $instagram_info ): ?>
          <div class="featured-instagrams__item featured-instagrams__item--info">
            <?php include( locate_template( 'inc/svg-icons/icon-instagram.php')); ?> 
            <?= $instagram_info ?>
          </div>
        <?php endif; ?>
        <div id="instafeed" data-instagram-token="<?= $instagram_access_token; ?>" data-limit="<?= $instagrams_per_row; ?>"></div>
      </div>
  </div>
</section>
<!--/ Section Featured instagrams -->