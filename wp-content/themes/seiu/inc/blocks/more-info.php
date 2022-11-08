<?php
/**
 * Block Name: More Info
 * Description: 3-Column Grid - shows more information about member in cards grid.
 */

$title = get_field( 'block_mmbr_info_title' );
$cards = get_field( 'block_mmbr_info_cards' );

$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

?>
<section class="membership-info <?php echo esc_attr( $class_name ); ?>">
	<?php if ( $title ) { ?>
		<h2 class="h3 text-center"><?php esc_attr_e( $title ); ?></h2>
	<?php } ?>

	<?php
	if ( is_array( $cards ) && count( $cards ) > 0 ) {
		?>
		<div class="membership-info--list">
			<?php
			foreach ( $cards as $card ) {
				$styles     = $card['styles'];
				$bg_color   = $styles['background_color'];
				$icon_color = $styles['icon_color'];
				$text_color = $styles['text_color'];
				$icon       = $card['icon'];
				$title      = $card['title'];
				$cta        = $card['cta'];
				?>
				<div class="membership-info--list-item" style="<?php printf( 'color: %s; background-color: %s', esc_attr( $text_color ), esc_attr( $bg_color ) ); ?>">
					<?php if ( $icon ) { ?>
						<div class="icon" style="<?php printf( 'fill: %s', esc_attr( $icon_color ) ); ?>">
							<img width="50" src="<?php echo esc_url( $icon ); ?>" class="style-svg" />
						</div>
					<?php } ?>
					<?php if ( $title ) { ?>
						<h3 class="title h4"><?php echo esc_attr__( $title, 'seiu' ); ?></h3>
					<?php } ?>
					<?php if ( $cta ) { ?>
						<div class="btn-wrapper wp-block-button">
							<a class="wp-block-button__link" target="<?php echo esc_attr( $cta['target'] ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>" ><?php echo esc_attr__( $cta['title'], 'seiu' ); ?></a>
						</div>
					<?php } ?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>

</section>

