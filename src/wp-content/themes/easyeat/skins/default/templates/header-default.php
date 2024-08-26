<?php
/**
 * The template to display default site header
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

$easyeat_header_css   = '';
$easyeat_header_image = get_header_image();
$easyeat_header_video = easyeat_get_header_video();
if ( ! empty( $easyeat_header_image ) && easyeat_trx_addons_featured_image_override( is_singular() || easyeat_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$easyeat_header_image = easyeat_get_current_mode_image( $easyeat_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $easyeat_header_image ) || ! empty( $easyeat_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( easyeat_is_on( easyeat_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
