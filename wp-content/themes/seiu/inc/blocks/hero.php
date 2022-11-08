<!-- Hero Module -->
<?php
  $hero_contents = get_field('hero_contents') ?: [];
  $hero_contents_count = count($hero_contents);
?>

<section class="hero">
    <?php if( $hero_contents ): ?>
      <div class="hero-slider" <?php if($hero_contents_count > 1): ?> data-hero-slider <?php endif; ?>>
        <?php
          // Loop through rows.
          foreach($hero_contents as $i => $row) :
            $image = $row['image'];
            $mobile_image = $row['mobile_image'] ?: $image;
            $heading = $row['heading'];
            $sub_heading = $row['sub_heading'];
            $button_label = $row['button_label'];
            $button_link = $row['button_link'];
        ?>
          <div class="hero__slide">
            <?php if( !empty( $image ) ): ?>
              <picture>
                <source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile_image['url']); ?>">
                <source media="(min-width: 768px)" srcset="<?php echo esc_url($image['url']); ?>">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
              </picture>
            <?php endif; ?>

            <div class="hero__slide__content">
              <?php if ($heading) : ?>
                <div class="h1"><?= $heading; ?></div>
              <?php endif; ?>

              <?php if ($sub_heading) : ?>
                <div class="h3"><?= $sub_heading; ?></div>
              <?php endif; ?>

              <?php if ($button_label && $button_link) : ?>
                <a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

    <?php endif; ?>
</section>
<!--/ Hero Module -->