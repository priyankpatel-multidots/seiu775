<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package seiu
 */
  $post_id = get_the_ID();
  $post_title = get_the_title();
  $post_url = get_permalink( $post_id );
  $post_type = get_post_type();
  $post_date = get_the_date();
  
  $post_image = get_the_post_thumbnail_url($post_id, 'medium_large');
  $excerpt = get_the_excerpt();
  $description_part = get_the_content($post_id);
  $news_source = get_field('news_source', $post_id);
  $category = get_category( get_query_var( 'cat' ) );
  if( is_category() ) {
    if($category) {
      $cat_id = $category->slug;
    }
  }
  
?>

<figure class="cards--list-item card card--post card--default-post card--post-index-<?= $post_id ?> <?php if (!empty($post_image)) : ?>card--has-image<?php endif; ?>"
  <?php if(!empty($has_animation) && $has_animation) : ?>
  data-aos="fade-top" data-aos-duration="<?= $i ?>000"
  <?php endif; ?>
  >
  <?php if (!empty($post_image)) {?>
	<?php echo the_post_thumbnail( 'full', ['class'=>'card-featured-image'] )?>
  <?php }  ?>

  <div class="card__content">
    <?php if($news_source) { ?>
    <p
      class="card__date"><?php if ($news_source['source_name']): ?><?php if ($news_source['source_link']): ?><a href="<?php echo $news_source['source_link']; ?>"><?php endif; ?><?php echo $news_source['source_name']; ?><?php if ($news_source['source_link']): ?></a><?php endif; ?><?php if ($news_source['show_post_date']): ?> | <?php endif; ?><?php endif; ?><?php if ($news_source['show_post_date']): ?><?= $post_date; ?><?php endif; ?>
    </p>    <?php } if ($post_title) : ?>
      <h4 class="card__title"><a href="<?= $post_url ?>"><?= $post_title; ?></a></h4>
    <?php endif; ?>

    <?php if( is_tag() && !empty($excerpt) ): ?>
      <div class="card__excerpt"><?= $excerpt; ?></div>
    <?php endif; ?>
  </div>


</figure>

