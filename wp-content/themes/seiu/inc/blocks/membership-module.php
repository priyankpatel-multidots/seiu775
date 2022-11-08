<!-- Section Membership Plus Module-->
<?php
  $section_title = get_field('membership_plus_title');
  $section_description = get_field('membership_plus_description');
  $membership_features = get_field('membership_features') ?: [];
  $section_bg_color = get_field('section_background_color');

  $enable_slider = get_field('enable_slider') ?: false;
  $items_per_view = get_field('items_per_view') ?: 4;

  $button_position = get_field('button_position') ?: '';
  $button_link = get_field('button_link') ?: '';
  $button_label = get_field('button_label') ?: '';
  $button_label = get_field('button_label') ?: '';
?>

<section class="section section--membership-plus"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?>
  >
  <div class="container container--sm">
    <?php if ($section_title) : ?>
      <h2 class="section__title" data-aos="fade-top" data-aos-duration="1000"><?= $section_title; ?></h2>
    <?php endif; ?>

    <?php if ($section_description) : ?>
      <div class="section__description copy-large" data-aos="fade-top" data-aos-duration="2000"><?= $section_description; ?></div>
    <?php endif; ?>

    <?php if ($button_position == 'under_desc') : ?>
      <?php if ($button_label && $button_link) : ?>
        <div class="btn-wrapper">
          <a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if( $membership_features ): ?>
      <div class="membership-plus__list-wrapper" <?php if($enable_slider): ?>data-membership-plus-slider-wrapper<?php endif; ?>>
        <div class="membership-plus__list membership-plus__list--<?= $items_per_view; ?>" <?php if($enable_slider): ?>data-membership-plus-slider<?php endif; ?>>
          <?php
            // Loop through rows.
            foreach($membership_features as $i => $row) :
              $label = $row['label'];
              $image = $row['image'];
              $link = $row['link'];

          ?>
              <div class="membership-plus__item">
                <?php if (!empty ($link)): ?>
                  <a class="membership-plus__item-link"
                     href="<?php echo $link; ?><?php if (!empty($label)): ?>?category=<?= sanitize_title_with_dashes($label); ?><?php endif; ?>"></a>
                <?php endif; ?>
                <?php if (!empty($label)): ?>
                  <label><?= $label; ?></label>
                <?php endif; ?>


                <?php if (!empty($image)): ?>
                  <img data-aos="zoom-in" data-aos-duration="1000" src="<?php echo esc_url($image['url']); ?>"
                       alt="<?php echo esc_attr($image['alt']); ?>"/>
                <?php endif; ?>

              </div>
            <?php endforeach; ?>
        </div>

        <!--<div class="slider-buttons">
          <button class="slider-button previous" type="button" aria-label="Previous" data-ol-has-click-handler="">
            <svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg>
          </button>
          <button class="slider-button next" type="button" aria-label="Next" data-ol-has-click-handler="">
            <svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg>
          </button>
        </div>-->
      </div>

    <?php endif; ?>

    <?php if (!$button_position || $button_position == 'last_part') : ?>
      <?php if ($button_label && $button_link) : ?>
        <div class="btn-wrapper">
          <a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
<!--/ Section Membership Plus Module-->