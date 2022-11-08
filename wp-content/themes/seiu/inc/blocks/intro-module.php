<!-- Intro Module -->
<?php
  $layout = get_field('intro_module_layout') ?: 'default';
  $section_title = get_field('intro_module_title') ?: '';
  $section_description = get_field('intro_module_description') ?: '';

  $section_featured_image = get_field('section_featured_image') ?: '';

  $button_position = get_field('button_position') ?: '';
  $button_intro = get_field('button_intro') ?: '';
  $button_label = get_field('button_label') ?: '';
  $button_link = get_field('button_link') ?: '';
  $button_label = get_field('button_label') ?: '';
  $is_login_trigger = get_field('is_login_trigger_button') ?: '';

  $second_cta_intro = get_field('second_cta_intro') ?: '';
  $second_cta_label = get_field('second_cta_label') ?: '';
  $second_cta_link = get_field('second_cta_link') ?: '';
  $section_bg_color = get_field('section_background_color') ?: '';
  $section_text_color = get_field('section_text_color') ?: '';

  $first_cta_intro = get_field('first_cta_intro') ?: '';
  $first_cta_button = get_field('first_cta_button') ?: '';
  $second_cta_intro = get_field('second_cta_intro') ?: '';
  $second_cta_button = get_field('second_cta_button') ?: '';
?>

<section class="intro-module section--<?= $layout; ?>"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>; color: <?= $section_text_color; ?>"
  <?php endif; ?>
  >

  <div class="container container--md">
    <div class="section__inner">
      <div class="section__info">
        <?php if ($section_title) : ?>
          <h2 class="section__title"><?= $section_title; ?></h2>
        <?php endif; ?>
        <!-- description -->
        <?php if ($section_description) : ?>
          <div class="label section__description"><?= $section_description; ?></div>
        <?php endif; ?>

        <!-- primary cta button -->
        <?php if (!$button_position || $button_position == 'left') : ?>
            <div class="login-cta-wrapper button-position-<?php echo $button_position; ?>">  
                <?php if ($first_cta_intro && $first_cta_button) : ?>
                    <?php if(!$is_login_trigger ||  !(is_user_logged_in())): ?>
                        <div class="section__primary-cta">
                            <?php if ($first_cta_intro) : ?>
                                <h3 class=""><?= $first_cta_intro; ?></h3>
                            <?php endif; ?>
                            <a class="btn btn--primary" href="<?= $first_cta_button['url']; ?>" target="<?= $first_cta_button['target']; ?>" <?php if($is_login_trigger): ?>data-login-nav-open-trigger<?php endif; ?>><?= $first_cta_button['title']; ?></a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- secondary cta button -->
                <?php if ($second_cta_intro && $second_cta_button) : ?>
                    <?php if(!$is_login_trigger ||  !(is_user_logged_in())): ?>
                        <div class="section__secondary-cta">
                            <h3><?= $second_cta_intro; ?></h3>
                            <a class="btn btn--primary" target="<?= $second_cta_button['target']; ?>" href="<?= $second_cta_button['url']; ?>"><?= $second_cta_button['title']; ?></a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
      </div>

      <div class="section__right">
        <?php if (!empty($section_featured_image)) : ?>
        <div class="section__featured-image" data-aos="slide-up" data-aos-duration="3000">
          <img src="<?= $section_featured_image['url']?>" alt="<?= $section_title ?>">
        </div>
        <?php endif; ?>

        <?php if (!$button_position || $button_position == 'right') : ?>
            <div class="login-cta-wrapper button-position-<?php echo $button_position; ?>">  
                <?php if ($first_cta_intro && $first_cta_button) : ?>
                    <?php if(!$is_login_trigger ||  !(is_user_logged_in())): ?>
                        <div class="section__primary-cta">
                        <?php if ($first_cta_intro) : ?>
                            <h4 class=""><?= $first_cta_intro; ?></h3>
                        <?php endif; ?>
                        <a class="btn btn--primary" href="<?= $first_cta_button['url']; ?>" target="<?= $first_cta_button['target']; ?>" <?php if($is_login_trigger): ?>data-login-nav-open-trigger<?php endif; ?>><?= $first_cta_button['title']; ?></a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($second_cta_intro && $second_cta_button) : ?>
                    <?php if(!$is_login_trigger ||  !(is_user_logged_in())): ?>
                        <div class="section__secondary-cta">
                        <h4><?= $second_cta_intro; ?></h4>
                        <a class="btn btn--primary" target="<?= $second_cta_button['target']; ?>" href="<?= $second_cta_button['url']; ?>"><?= $second_cta_button['title']; ?></a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div> 
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!--/ Intro Module -->