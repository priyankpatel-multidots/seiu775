<?php
/**
 * Block Name: Cards Grid
 * Description: 2-Column Grid - shows title, description, CTA, etc. in cards grid.
 */

$title         = get_field( 'block_cards_grid_title' );
$cards_per_row = get_field( 'block_cards_grid_cards_per_row' ) ? get_field( 'block_cards_grid_cards_per_row' ) : 2;
$cards         = get_field( 'block_cards_grid_cards' );
$class_name    = '';
if ( ! empty( $block['className'] ) ) {
	$class_name = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

?>
<section class="cards-grid <?php echo esc_attr( $class_name ); ?>">
	<?php if ( $title ) { ?>
		<h2 class="h3 text-center"><?php esc_attr_e( $title ); ?></h2>
	<?php } ?>

	<?php
	if ( is_array( $cards ) && count( $cards ) > 0 ) {
		?>
		<div class="cards-grid--list" style="grid-template-columns: repeat(<?php echo esc_attr( $cards_per_row ); ?>, 1fr)">
			<?php
			foreach ( $cards as $card ) {
				$html_anchor			= $card['html_anchor'];
				$styles                  = $card['styles'];
				$bg_color                = $styles['background_color'];
				$text_color              = $styles['text_color'];
				$image                   = $card['image'];
				$title                   = $card['title'];
				$description             = $card['description'];
				$call_to_action          = $card['call_to_action'];
				$button_background_color = $call_to_action['button_background_color'];
				?>
				<div id="<?php echo esc_html($html_anchor); ?>" class="cards-grid--list--item <?php echo isset( $image ) && ! empty( $image ) ? 'card-has-image' : false; ?>" style="<?php printf( 'color: %s; background-color: %s', esc_attr( $text_color ), esc_attr( $bg_color ) ); ?>">
					<?php
					if ( isset( $image ) && ! empty( $image ) ) {
						?>
						<div class="image" style="<?php printf( 'background: transparent url(%s) no-repeat center/cover', esc_url( $image ) ); ?>"></div>
					<?php } ?>
					<?php if ( $title ) { ?>
						<h3 class="title"><?php echo esc_attr__( $title, 'seiu' ); ?></h3>
					<?php } ?>
					<?php if ( $description ) { ?>
						<div class="description">
						<?php
						printf(
							esc_attr__( '%s', 'seiu' ),
							wp_kses(
								$description,
								array(
									'p'      => array(),
									'br'     => array(),
									'strong' => array(),
									'a'      => array(
										'href' => array(),
									),
								)
							)
						);
						?>
							</div>
					<?php } ?>
					<?php
					if ( $cta = $call_to_action['link'] ) {
						if ( 'link' === $call_to_action['cta_type'] ) {
							printf( '<a class="rc-box-link" style="color: %s" href="%s" target="%s"><strong>%s</strong></a>', esc_attr( $text_color ), esc_url( $cta['url'] ), esc_attr( $cta['target'] ), esc_attr__( $cta['title'], 'seiu' ) );
						} else {
							if(is_user_logged_in()) {
								?>
								<div class="btn-wrapper wp-block-button" style="<?php printf( 'text-align: %s', esc_attr( $call_to_action['cta_alignment'] ) ); ?>">
									<a style="<?php printf( 'background-color: %s', esc_attr( $button_background_color ) ); ?>" class="wp-block-button__link btn" target="<?php echo esc_attr( $cta['target'] ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>" ><?php echo esc_attr__( $cta['title'], 'seiu' ); ?></a>
								</div>
								<?php
							}
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>

</section>

