<!-- Section Text & List Cards Grid -->
<?php
  $section_title = get_field('section_title') ?: '';
  $section_description = get_field('section_description') ?: '';
  $section_background_image = get_field('section_background_image') ?: [];
?>

<section class="section section--text-list-grid">
  <?php if( !empty( $section_background_image ) ): ?>
    <figure class="section-bg">
      <img src="<?php echo esc_url($section_background_image['url']); ?>" alt="<?php echo esc_attr($section_background_image['alt']); ?>" />
    </figure>
  <?php endif; ?>

  <div class="container container--md">
    <?php if ($section_title) : ?>
      <h2 class="section__title" data-aos="fade-top" data-aos-duration="2000"><?= $section_title; ?></h2>
    <?php endif; ?>

    <?php if ($section_description) : ?>
      <div class="section__description" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
    <?php endif; ?>

    <?php if( have_rows('contents') ): ?>
      <div class="text-list-grid__list">
        <?php while( have_rows('contents') ): the_row(); ?>
          <div class="text-list-grid__item" data-aos="fade-up" data-aos-duration="<?php echo (get_row_index()); ?>000">

            <?php if( get_row_layout() == 'text_block' ): 
              $button_label = get_sub_field('button_label');
              $button_link = get_sub_field('button_link');
              ?>
              <h2><?php the_sub_field('title'); ?></h2>
              <p class="text-list-grid__item__desc"><?php the_sub_field('description'); ?></p>

              <?php if ($button_link && $button_label) : ?>
                <div class="btn-wrapper"><a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a></div>
              <?php endif; ?>

            <?php elseif( get_row_layout() == 'lists_block' ): ?>
              <h2><?php the_sub_field('title'); ?></h2>
              <?php
                // check if the nested repeater field has rows of data
                if( have_rows('lists') ):
                  echo '<ul>';
                  // loop through the rows of data
                  while ( have_rows('lists') ) : the_row();
                    $list_item_label = get_sub_field('list_item');
                    $list_item_link = get_sub_field('list_item_link');
                    echo '<li><a class="h4" href="' . $list_item_link . '">' . $list_item_label . '</a></li>';
                  endwhile;
                  echo '</ul>';
                endif; ?>
            <?php endif; ?>

          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
<!--/ Section Text & List Cards Grid -->