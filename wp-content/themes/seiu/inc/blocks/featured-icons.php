<!-- Section Featured Icons -->
<?php
  $section_title = get_field('featured_icons_title') ?: '';
  $section_description = get_field('featured_icons_description') ?: '';
  $featured_icons = get_field('featured_icons') ?: [];
  $section_bg_color = get_field('section_background_color') ?: '';
  $icons_per_row = get_field('icons_per_row') ?: 2;
?>

<section class="section section--featured-icons"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?>
  >
  <div class="container">
    <?php if ($section_title) : ?>
      <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
    <?php endif; ?>

    <?php if ($section_description) : ?>
      <div class="section__description" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
    <?php endif; ?>

    <?php if( $featured_icons ): ?>
      <div class="featured-icons__list featured-icons__list--<?= $icons_per_row; ?>">
        <?php
          // Loop through rows.
          foreach($featured_icons as $i => $row) :
            $feature_image = $row['image'];
        ?>
          <div class="featured-icons__item">
            <?php if( !empty( $feature_image ) ): ?>
              <img data-aos="zoom-in" data-aos-duration="<?= $i ?>000" src="<?php echo esc_url($feature_image['url']); ?>" alt="<?php echo esc_attr($feature_image['alt']); ?>" />
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>
  </div>
</section>
<!--/ Section Featured Icons -->