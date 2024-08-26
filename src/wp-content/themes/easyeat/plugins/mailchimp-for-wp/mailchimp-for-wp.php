<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'easyeat_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'easyeat_mailchimp_theme_setup9', 9 );
	function easyeat_mailchimp_theme_setup9() {
		if ( easyeat_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'easyeat_mailchimp_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'easyeat_mailchimp_frontend_scripts', 10, 1 );
			add_filter( 'easyeat_filter_merge_styles', 'easyeat_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'easyeat_filter_tgmpa_required_plugins', 'easyeat_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'easyeat_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('easyeat_filter_tgmpa_required_plugins',	'easyeat_mailchimp_tgmpa_required_plugins');
	function easyeat_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( easyeat_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && easyeat_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => easyeat_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'easyeat_exists_mailchimp' ) ) {
	function easyeat_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'easyeat_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'easyeat_mailchimp_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'easyeat_mailchimp_frontend_scripts', 10, 1 );
	function easyeat_mailchimp_frontend_scripts( $force = false ) {
		easyeat_enqueue_optimized( 'mailchimp', $force, array(
			'css' => array(
				'easyeat-mailchimp-for-wp' => array( 'src' => 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'easyeat_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'easyeat_filter_merge_styles', 'easyeat_mailchimp_merge_styles');
	function easyeat_mailchimp_merge_styles( $list ) {
		$list[ 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( easyeat_exists_mailchimp() ) {
	$easyeat_fdir = easyeat_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
	if ( ! empty( $easyeat_fdir ) ) {
		require_once $easyeat_fdir;
	}
}

