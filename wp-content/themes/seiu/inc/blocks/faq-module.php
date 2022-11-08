<!-- Faq Module-->
<?php
  $layout = get_field('faq_module_layout') ?: 'default';
  $section_title = get_field('section_title') ?: '';
  $faq_contents = get_field('faq_contents') ?: [];
  $section_bg_color = get_field('section_background_color') ?: '';
?>

<section class="faq-module  section--<?= $layout; ?>"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>;"
  <?php endif; ?>
  >
  <div class="container container--md">
    <div class="section__inner">
      <?php if ($section_title) : ?>
        <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
      <?php endif; ?>

      <?php if( $faq_contents ): ?>
        <div class="faq__list" data-accordion-selector>
          <?php
            // Loop through rows.
            foreach($faq_contents as $i => $row) :
              $question = $row['question'];
              $answer = $row['answer'];
          ?>
            <div class="faq__item" data-accordion-item>
              <div class="faq__item__heading" data-accordion-heading>
                <svg viewBox='0 0 20 20' class='icon icon-plus' width='1em' height='1em'>
                  <use xlink:href='#icon-plus'></use>
                </svg>
                <svg viewBox='0 0 20 20' class='icon icon-minus-sign' width='1em' height='1em'>
                  <use xlink:href='#icon-minus-sign'></use>
                </svg>
                <?php if ($question) : ?>
                  <?= $question; ?>
                <?php endif; ?>
              </div>
              <div class="faq__item__content" data-accordion-content>
                <?php if ($answer) : ?>
                  <div><?= $answer; ?></div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<!--/ Faq Module-->