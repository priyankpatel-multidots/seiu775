<?php
  // Note: this component expects a variable called
  // $card_post to be available on the same scope.
  $post_id = $card_post->ID;
  $post_title = $card_post->post_title;
  $post_url = get_permalink( $post_id );
  $post_type = get_post_type($card_post);
  $post_date = get_the_date('', $card_post);

  $button_link = get_field('button_link') ?: '';
  $button_label = get_field('button_label') ?: '';
  
  $post_image = get_the_post_thumbnail_url($post_id, 'medium_large');
  $excerpt = $card_post->post_excerpt;
  $description_part = get_the_content($post_id);
?>

<figure class="card card--post card--post--masonry card--post-index-<?= $i ?> <?php if (!empty($post_image)) : ?>card--has-image<?php endif; ?>"
  <?php if(!empty($has_animation) && $has_animation) : ?>
  data-aos="fade-top" data-aos-duration="<?= $i ?>000"
  <?php endif; ?>
  >
  <?php if (!empty($post_image)) : ?>
  <div class="card__img-wrapper">
    <img
      class="card__img lazy"
      src="<?= $post_image; ?>"
      data-src="<?= $post_image; ?>"
      data-srcset="<?= $post_image; ?>"
      alt="<?= esc_attr(get_post_meta(get_post_thumbnail_id($post_id, 'medium_large'), '_wp_attachment_image_alt', true)); ?>"
    />
  </div>
  <?php endif; ?>

  <div class="card__content">
    <?php if ($post_title) : ?>
      <h4 class="card__title"><?= $post_title; ?></h4>
    <?php endif; ?>

    <?php if (!empty($excerpt)) : ?>
      <div class="card__excerpt"><?= $excerpt; ?></div>
    <?php endif; ?>

    <a class="btn btn--primary" href="<?= $post_url ?>"><?= $button_label ?></a>
  </div>

</figure>
