<!-- Membership Plus & Events Module-->
<?php
if( have_rows('membership_plus_and_events_module') ) {
  while ( have_rows('membership_plus_and_events_module') ) {
    the_row();
    $membership_plus_title = get_sub_field('membership_plus_title');
    $section_description = get_sub_field('membership_plus_description');
    $membership_features = get_sub_field('membership_features') ?: [];
    $section_bg_color = get_sub_field('section_background_color');

    $enable_slider = get_sub_field('enable_slider') ?: false;
    $items_per_view = get_sub_field('items_per_view') ?: 4;

    $button_position = get_sub_field('button_position') ?: '';
    $button_link = get_sub_field('button_link') ?: '';
    $button_label = get_sub_field('button_label') ?: '';
    $button_label = get_sub_field('button_label') ?: '';

    $events_section_title = get_sub_field('events_section_title');
    $events = get_sub_field('events') ?: [];
  }
}
?>

<div class="membership-plus-events-module">
  <div class="container container--md main-container">
    <section class="section section--membership-plus"
      <?php if ($section_bg_color) : ?>
        style="background-color: <?= $section_bg_color; ?>"
      <?php endif; ?>
      >
      <div class="container container--sm">
        <?php if ($membership_plus_title) : ?>
          <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $membership_plus_title; ?></h2>
        <?php endif; ?>

        <?php if ($section_description) : ?>
          <div class="section__description copy-large" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
        <?php endif; ?>

        <?php if ($button_position == 'under_desc') : ?>
          <?php if ($button_label && $button_link) : ?>
            <div class="btn-wrapper">
              <a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <?php if( $membership_features ): ?>
          <div class="membership-plus__list-wrapper">
            <div class="membership-plus__list membership-plus__list--<?= $items_per_view; ?>" <?php if($enable_slider): ?>data-membership-plus-slider<?php endif; ?>>
              <?php
                // Loop through rows.
                foreach($membership_features as $i => $row) :
                  $label = $row['label'];
                  $image = $row['image'];
              ?>
                <div class="membership-plus__item">
                  <?php if( !empty( $label ) ): ?>
                    <label><?= $label; ?></label>
                  <?php endif; ?>

                  <?php if( !empty( $image ) ): ?>
                    <img data-aos="zoom-in" data-aos-duration="<?= $i ?>000" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="slider-buttons">
              <button class="slider-button previous" type="button" aria-label="Previous" data-ol-has-click-handler="">
                <svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg>
              </button>
              <button class="slider-button next" type="button" aria-label="Next" data-ol-has-click-handler="">
                <svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg>
              </button>
            </div>
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
    <!--/Membership Plus Block-->
    <section class="events-module">
      <div class="container container--md">
        <?php if ($events_section_title) : ?>
          <h4 class="section__title"><?= $events_section_title; ?></h4>
        <?php endif; ?>

        <?php if( $events ): ?>
          <div class="events-module__list">
            <?php
              // Loop through rows.
              foreach($events as $i => $event) :
                $event_title        = $event['event_title'] ?: "";
                $event_date         = $event['event_date'] ?: "";
                $event_description  = $event['event_description'] ?: "";
                $event_button_link  = $event['event_button_link'] ?: "";
                $event_button_label = $event['event_button_label'] ?: "";
            ?>
              <div class="event">
                <?php if ($event_title) : ?>
                  <h2 class="event__title"><?= $event_title ?></h2>
                <?php endif; ?>

                <?php if ($event_date) : ?>
                  <h4 class="event__date"><?= $event_date ?></h4>
                <?php endif; ?>

                <?php if ($event_description) : ?>
                  <div class="event__description"><?= $event_description ?></div>
                <?php endif; ?>

                <?php if ($event_button_label && $event_button_link) : ?>
                  <a class="btn btn--primary" href="<?= $event_button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $event_button_label; ?></a>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>

          </div>
        <?php endif; ?>
      </div>
    </section>
  </div>
<!--/ Events Block-->
</div>