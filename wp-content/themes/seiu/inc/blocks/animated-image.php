<?php
/**
 * ACF Block - Membership Events.
 *
 * @package SEIU
 */

/**
 * Block Name: Animated Image
 * Description: Display image animating upward.
 */

$block_title = get_field( 'block_mmbr_events_title' );

$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

if ( $section_featured_image = get_field( 'block_bai_image' ) ) {
	?>
    <section class="animated-image" data-aos="slide-up" data-aos-duration="3000">
        <?php echo wp_get_attachment_image( $section_featured_image, 'large' ); ?>
    </section>
	<?php
}
?>
