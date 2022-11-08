<!-- Events Module-->
<?php
  $section_title = get_field('events_section_title') ?: '';
  $events = get_field('events') ?: [];
?>

<section class="events-module">
  <div class="container container--md">
    <?php if ($section_title) : ?>
      <h4 class="section__title"><?= $section_title; ?></h4>
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
              <a class="btn btn--primary" href="<?= $event_button_link ?>"><?= $event_button_label; ?></a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>
  </div>
</section>
<!--/ Faq Module-->