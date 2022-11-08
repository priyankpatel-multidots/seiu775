<!-- slider-module -->
<?php
  $slider_contents = get_field('slider_contents' ) ?: [];
  $slider_contents_count = count($slider_contents);
  $section_bg_color = get_field('section_background_color') ?: '';
?>

<section class="slider-module"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?> >
  
    <?php if( $slider_contents ): ?>
      <div class="slider-module__list" <?php if($slider_contents_count > 1): ?>data-slider-module-carousel <?php endif; ?>>
        <?php
          // Loop through rows.
          foreach($slider_contents as $i => $row) :
            $image = $row['image'];
            $mobile_image = $row['mobile_image'] ?: $image;
            //$heading = $row['heading'];
            //$sub_heading = $row['sub_heading'];
            //$button_label = $row['button_label'];
            $button_link = $row['button_link'];
        ?>
          <div class="slider-module__slide">
            <?php if( !empty( $image ) ): ?>
            <?php if($button_link): ?>
              <a href="<?= $button_link['url'] ?>" target="<?= $button_link['target'] ?>">
            <?php endif; ?>
              <picture>
                <source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile_image['url']); ?>">
                <source media="(min-width: 768px)" srcset="<?php echo esc_url($image['url']); ?>">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
              </picture>
              <?php if($button_link): ?>
                </a>
              <?php endif; ?>
            <?php endif; ?>


          </div>
        <?php endforeach; ?>

      </div>

    <?php endif; ?>
</section>
<!--/ slider-module -->