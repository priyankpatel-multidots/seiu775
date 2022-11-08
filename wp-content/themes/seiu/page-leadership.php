<?php
/**
 * The template for Leadership Page
 * Template Name: Leadership Page
 *
 * @package seiu
 */

get_header();
?>


  <main id="primary" class="site-main page--leadership">
    <div class="page-header">
      <div class="container container--md">
        <h1><?php echo get_the_title(); ?></h1>
      </div>
    </div>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="container container--md leadership-page">
        <?php the_content();

        $cardsSection = get_field('leadership_images_section');
        $cardLoop = $cardsSection['info_cards'];
        ?>
        <div class="leadership-page__cards">
          <?php if ($cardsSection['header']): ?>
            <h2 class="leadership-page__cards-header"><?php echo $cardsSection['header']; ?></h2>
          <?php endif; ?>
          <?php if ($cardLoop): ?>
            <div class="leadership-page__cards-container">
              <?php foreach ($cardLoop as $card):
                $image = $card['image'];
                $name = $card['name'];
                $bioUrl = $card['bio_url'];
                $title = $card['title'];
                $email = $card['email_address'];
                ?>
                <div class="leadership-page__card">
                  <?php if (!empty($image)): ?>
                    <img class="leadership-page__card-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                    <div class="leadership-page__card-name-and-email"><span class="leadership-page__name"><a
                          href="<?php echo $bioUrl; ?>"><?php echo $name; ?></a></span><?php if($email){?><span
                        class="leadership-page__email"><a href="mailto:<?php echo $email; ?>" target="_blank"><i
                            class="fas fa-envelope"></i></a></span><?php } ?></div>
                  <div class="leadership-page__title"><?php echo $title; ?></div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>


        </div>
      </div>
      <div class="container--md container leadership-page-bottom">
        <?php $columns = get_field('leadership_columns_section'); ?>
        <?php if ($columns['header']): ?>
          <h2 class="leadership-page-bottom__header"><?php echo $columns['header']; ?></h2>
        <?php endif; ?>
        <div class="leadership-page-bottom__columns">
          <?php if ($columns['column_one']): ?>
            <div class="leadership-page-bottom__column leadership-page-bottom__column-one">
              <?php echo $columns['column_one']; ?>
            </div>
          <?php endif; ?>
          <?php if ($columns['column_two']): ?>
            <div class="leadership-page-bottom__column leadership-page-bottom__column-two">
              <?php echo $columns['column_two']; ?>
            </div>
          <?php endif; ?>
          <?php if ($columns['column_three']): ?>
            <div class="leadership-page-bottom__column leadership-page-bottom__column-three">
              <?php echo $columns['column_three']; ?>
            </div>
          <?php endif; ?>
          <?php if ($columns['column_four']): ?>
            <div class="leadership-page-bottom__column leadership-page-bottom__column-four">
              <?php echo $columns['column_four']; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; else : ?>
      <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
  </main><!-- #main -->


<?php get_footer(); ?>