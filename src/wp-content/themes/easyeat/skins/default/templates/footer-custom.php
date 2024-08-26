<?php
/**
 * The template to display default site footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */

$easyeat_footer_id = easyeat_get_custom_footer_id();
$easyeat_footer_meta = get_post_meta( $easyeat_footer_id, 'trx_addons_options', true );
if ( ! empty( $easyeat_footer_meta['margin'] ) ) {
	easyeat_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( easyeat_prepare_css_value( $easyeat_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $easyeat_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $easyeat_footer_id ) ) ); ?>
						<?php
						$easyeat_footer_scheme = easyeat_get_theme_option( 'footer_scheme' );
						if ( ! empty( $easyeat_footer_scheme ) && ! easyeat_is_inherit( $easyeat_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $easyeat_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'easyeat_action_show_layout', $easyeat_footer_id );
	?>
</footer><!-- /.footer_wrap -->
