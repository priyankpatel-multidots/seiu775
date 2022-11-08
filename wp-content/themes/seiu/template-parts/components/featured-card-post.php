<?php
  // Note: this component expects a variable called
  // $card_post to be available on the same scope.
  $post_id = $card_post->ID;
  $post_title = $card_post->post_title;
  $post_url = get_permalink( $post_id );
  $post_type = get_post_type($card_post);
  $post_date = get_the_date('', $card_post);

  $post_image = get_the_post_thumbnail_url($post_id, 'medium_large');
  // $excerpt = get_the_excerpt($post_id);
  $excerpt = $card_post->post_excerpt;
  $description_part = get_the_content($post_id);
?>

<figure class="card card--post card--default-post card--post-index-<?= $i ?>"
  <?php if(!empty($has_animation) && $has_animation) : ?>
  data-aos="fade-up" data-aos-duration="<?= $i+1 ?>000"
  <?php endif; ?>
  >
  <?php if ($i < 2) : ?>
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
    <p class="card__date"><?= $post_date; ?></p>
    <?php if ($post_title) : ?>
      <h4 class="card__title"><?= $post_title; ?></h4>
    <?php endif; ?>

    <?php if (!empty($excerpt)) : ?>
      <div class="card__excerpt"><?= $excerpt; ?></div>
    <?php endif; ?>

    <a class="btn btn--text" href="<?= $post_url ?>">Read more</a>
  </div>

</figure>
