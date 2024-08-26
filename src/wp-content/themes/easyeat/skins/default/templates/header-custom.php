<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.06
 */

$easyeat_header_css   = '';
$easyeat_header_image = get_header_image();
$easyeat_header_video = easyeat_get_header_video();
if ( ! empty( $easyeat_header_image ) && easyeat_trx_addons_featured_image_override( is_singular() || easyeat_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$easyeat_header_image = easyeat_get_current_mode_image( $easyeat_header_image );
}

$easyeat_header_id = easyeat_get_custom_header_id();
$easyeat_header_meta = get_post_meta( $easyeat_header_id, 'trx_addons_options', true );
if ( ! empty( $easyeat_header_meta['margin'] ) ) {
	easyeat_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( easyeat_prepare_css_value( $easyeat_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $easyeat_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $easyeat_header_id ) ) ); ?>
				<?php
				echo ! empty( $easyeat_header_image ) || ! empty( $easyeat_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $easyeat_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $easyeat_header_image ) {
					echo ' ' . esc_attr( easyeat_add_inline_css_class( 'background-image: url(' . esc_url( $easyeat_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( easyeat_is_on( easyeat_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight easyeat-full-height';
				}
				$easyeat_header_scheme = easyeat_get_theme_option( 'header_scheme' );
				if ( ! empty( $easyeat_header_scheme ) && ! easyeat_is_inherit( $easyeat_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $easyeat_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $easyeat_header_video ) ) {
		get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'easyeat_action_show_layout', $easyeat_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
