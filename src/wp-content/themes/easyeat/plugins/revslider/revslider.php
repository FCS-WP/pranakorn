<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'easyeat_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'easyeat_revslider_theme_setup9', 9 );
	function easyeat_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'easyeat_filter_tgmpa_required_plugins', 'easyeat_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'easyeat_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('easyeat_filter_tgmpa_required_plugins',	'easyeat_revslider_tgmpa_required_plugins');
	function easyeat_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( easyeat_storage_isset( 'required_plugins', 'revslider' ) && easyeat_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && easyeat_is_theme_activated() ) {
			$path = easyeat_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || easyeat_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => easyeat_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.4.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'easyeat_exists_revslider' ) ) {
	function easyeat_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' ) || class_exists( 'RevSliderData' );
	}
}


// Allow loading RevSlider scripts and styles
// if it present in the content of the current page
if (!function_exists('easyeat_revslider_check_revslider_in_content')) {
	add_filter( 'revslider_include_libraries', 'easyeat_revslider_check_revslider_in_content' );
	function easyeat_revslider_check_revslider_in_content( $load ) {
		if ( ! $load && function_exists( 'trx_addons_check_revslider_in_content' ) && easyeat_is_layouts_available() ) {
			// Check slider in the page header
			if ( apply_filters( 'easyeat_filter_check_revslider_in_header', true ) ) {
				$header_type = easyeat_get_theme_option( 'header_type' );
				if ( 'custom' == $header_type ) {
					$header_id = easyeat_get_custom_header_id();
					if ( $header_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $header_id );
					}
				}
			}
			// Check slider in the page footer
			if ( apply_filters( 'easyeat_filter_check_revslider_in_footer', false ) ) {
				$footer_type = easyeat_get_theme_option( 'footer_type' );
				if ( 'custom' == $footer_type ) {
					$footer_id = easyeat_get_custom_footer_id();
					if ( $footer_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $footer_id );
					}
				}
			}
		}
		return $load;
	}
}
