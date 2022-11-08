<!-- Section Featured Contents -->
<?php
  $section_title = get_field('featured_contents_title') ?: '';
  $section_description = get_field('featured_contents_description') ?: '';
  $featured_contents = get_field('featured_contents') ?: '';
  $section_bg_color = get_field('section_background_color') ?: '';
?>

<section class="section section--featured-contents"
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

    <?php if( $featured_contents ): ?>
      <div class="featured-contents__list">
        <?php
          // Loop through rows.
          foreach($featured_contents as $i => $row) :
            $svg_img_handle = $row['svg_img_handle'] ?: 'design-creative';
            $feature_title = $row['title'];
            $feature_description = $row['description'];
            $icon_path = "inc/svg-icons/icon-{$svg_img_handle}.php";
        ?>
          <div class="featured-contents__item" data-aos="fade-top" data-aos-duration="<?= $i ?>000">
            <?php include( locate_template($icon_path)); ?>

            <?php if ($feature_title) : ?>
              <h5><?= $feature_title; ?></h5>
            <?php endif; ?>

            <?php if ($feature_description) : ?>
              <p><?= $feature_description; ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      </div>

    <?php endif; ?>

  </div>
</section>
<!--/ Section Featured Contents -->