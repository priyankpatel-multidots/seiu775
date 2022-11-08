<!-- Section Featured posts Grid Masonry -->
<?php
  $section_title = get_field('featured_posts_grid_title') ?: '';
  $section_description = get_field('featured_posts_grid_description') ?: '';
  $featured_posts = get_field('featured_posts') ?: [];
  $section_bg_color = get_field('section_background_color') ?: '';
  $button_link = get_field('button_link') ?: '';
  $button_label = get_field('button_label') ?: '';
  $has_animation = true;
?>

<section class="section section--featured-posts"
  <?php if ($section_bg_color) : ?>
    style="background-color: <?= $section_bg_color; ?>"
  <?php endif; ?>
  >
  <div class="container container--md">
    <div class="featured-posts--grid-masonry">
      <div class="masonry-column">
        <div class="section__header">
          <?php if ($section_title) : ?>
            <h2 class="section__title" data-aos="fade-top" data-aos-duration="4000"><?= $section_title; ?></h2>
          <?php endif; ?>

          <?php if ($section_description) : ?>
            <div class="section__description" data-aos="fade-top" data-aos-duration="4000"><?= $section_description; ?></div>
          <?php endif; ?>
        </div>

        <?php 
          if (!empty($featured_posts)):
            foreach($featured_posts as $i => $card_post):
              $modulo = $i % 2;
              if ($modulo == 0): 
                continue;
              endif;
              include( locate_template( 'template-parts/components/card-post-masonry.php'));
            endforeach;
          endif;
        ?>
      </div>
      <div class="masonry-column">
        <?php 
          if (!empty($featured_posts)):
            foreach($featured_posts as $i => $card_post):
              $modulo = $i % 2;
              if ($modulo == 1): 
                continue;
              endif;
              include( locate_template( 'template-parts/components/card-post-masonry.php'));
            endforeach;
          endif;
        ?>
      </div>
    </div>

    <?php if($button_link && $button_label) :?>
      <div class="btn-wrapper">
        <a class="btn btn--primary" href="<?= $button_link['url']; ?>" target="<?= $button_link['target']; ?>"><?= $button_label; ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
<!--/ Section Featured posts Grid Masonry -->