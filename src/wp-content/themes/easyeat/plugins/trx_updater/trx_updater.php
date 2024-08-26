<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'easyeat_trx_updater_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'easyeat_trx_updater_theme_setup9', 9 );
	function easyeat_trx_updater_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'easyeat_filter_tgmpa_required_plugins', 'easyeat_trx_updater_tgmpa_required_plugins', 8 );
			add_filter( 'trx_updater_filter_original_theme_slug', 'easyeat_trx_updater_original_theme_slug' );
		}
	}
}

// Filter to add in the required plugins list
// Priority 8 is used to add this plugin before all other plugins
if ( ! function_exists( 'easyeat_trx_updater_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter( 'easyeat_filter_tgmpa_required_plugins',	'easyeat_trx_updater_tgmpa_required_plugins', 8 );
	function easyeat_trx_updater_tgmpa_required_plugins( $list = array() ) {
		if ( easyeat_storage_isset( 'required_plugins', 'trx_updater' ) && easyeat_storage_get_array( 'required_plugins', 'trx_updater', 'install' ) !== false && easyeat_is_theme_activated() ) {
			$path = easyeat_get_plugin_source_path( 'plugins/trx_updater/trx_updater.zip' );
			if ( ! empty( $path ) || easyeat_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => easyeat_storage_get_array( 'required_plugins', 'trx_updater', 'title' ),
					'slug'     => 'trx_updater',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
					'version'  => '1.5.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'easyeat_exists_trx_updater' ) ) {
	function easyeat_exists_trx_updater() {
		return defined( 'TRX_UPDATER_VERSION' );
	}
}

// Return original theme slug
if ( ! function_exists( 'easyeat_trx_updater_original_theme_slug' ) ) {
	//Handler of the add_filter( 'trx_updater_filter_original_theme_slug', 'easyeat_trx_updater_original_theme_slug' );
	function easyeat_trx_updater_original_theme_slug( $theme_slug ) {
		return apply_filters( 'easyeat_filter_original_theme_slug', $theme_slug );
	}
}
