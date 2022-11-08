<?php
  // Global Component: Member resource center
  // This card settings are in Theme General settings.
  $title        = get_field('block_title') ?: '';
  $block_description = get_field('block_description') ?: '';

  $phone_number = get_field('phone_number') ?: '';
  $phone_number_updated = phone_number_format($phone_number);
  $email        = get_field('email') ?: '';
?>
<!-- Member Resource center -->
<div class="card-member-resource-center" data-aos="fade-top" data-aos-duration="500">
  <div class="container container--md">
    <div class="card__inner" >
      <?php if (!empty($title)) : ?>
        <h2 class="card__title"><?= $title; ?></h2>
      <?php endif; ?>

      <?php if (!empty($phone_number)) : ?>
        <a class="card__contact card__contact--phone" href="tel:<?= $phone_number_updated; ?>">
          <?php include( locate_template( 'inc/svg-icons/icon-phone.php')); ?> 
          <h3><?= $phone_number; ?></h3>
        </a>
      <?php endif; ?>

      <?php if (!empty($email)) : ?>
        <a class="card__contact card__contact--email" href="mailto:<?= $email; ?>" target="_blank">
          <?php include( locate_template( 'inc/svg-icons/icon-email.php')); ?> 
          <h3><?= $email; ?></h3>
        </a>
      <?php endif; ?>

      <?php if (!empty($block_description)) : ?>
        <div class="card__description copy-large"><?= $block_description; ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>
<!-- /Member Resource center -->