<!-- Section Member Testimonials -->
<?php
  $section_title = get_field('section_title');
  $section_description = get_field('section_description');

  $share_story_panel_title = get_field('share_story_panel_title');
  $share_story_panel_desc = get_field('share_story_panel_desc');

  $share_story_panel_link = get_field('share_story_panel_link');
  $share_story_panel_link_label = get_field('share_story_panel_link_label');

  $testimonials = get_field('testimonials');
  $section_bg_color = get_field('section_background_color');
  $panel_bg_color = get_field('panel_background_color');
?>
<style type="text/css">
  <?php if ($panel_bg_color) : ?>
  .section--member-testimonials .section__right:before {
    background-color: <?= $panel_bg_color; ?>;
  }
  <?php endif; ?>
</style>

<section class="section section--member-testimonials"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?>
  >
  <div class="container container--md">
    <div class="section__left">
      <?php if ($share_story_panel_title) : ?>
        <h3 data-aos="fade-top" data-aos-duration="2000"><?= $share_story_panel_title; ?></h3>
      <?php endif; ?>

      <?php if ($share_story_panel_desc) : ?>
        <p class="copy-large" data-aos="fade-top" data-aos-duration="4000"><?= $share_story_panel_desc; ?></p>
      <?php endif; ?>

      <?php if ($share_story_panel_link && $share_story_panel_link_label) : ?>
        <div class="btn-wrapper"><a class="btn btn--primary" href="<?= $share_story_panel_link; ?>"><?= $share_story_panel_link_label; ?></a></div>
      <?php endif; ?>
    </div>

    <div class="section__right">
      <?php if ($section_title) : ?>
        <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
      <?php endif; ?>

      <?php if ($section_description) : ?>
        <div class="section__description" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
      <?php endif; ?>

      <?php if( $testimonials ): ?>
        <div class="member-testimonial__list" data-member-testimonials-slider>
          <?php
            // Loop through rows.
            foreach($testimonials as $i => $row) :
              $quote = $row['quote'];
              $author_name = $row['author_name'];
              $author_title = $row['author_title'];
              $author_image = $row['author_image'];
          ?>
            <div class="member-testimonial__item" data-aos="fade-top" data-aos-duration="<?= $i ?>000">
              <?php if ($quote) : ?>
                <div class="member-testimonial__item__quote"><?= $quote; ?></div>
              <?php endif; ?>

              <?php if ($author_name) : ?>
                <p class="member-testimonial__item__author-name"><?= $author_name; ?></p>
              <?php endif; ?>
              <?php if ($author_title) : ?>
                <p class="member-testimonial__item__author-title"><?= $author_title; ?></p>
              <?php endif; ?>

              <?php if( !empty( $author_image ) ): ?>
                <figure data-aos="fade-up" data-aos-duration="5000">
                  <img src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr($author_image['alt']); ?>" />
                </figure>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- /Section Member Testimonials -->