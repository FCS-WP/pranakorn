<?php
/**
 * Required plugins
 *
 * @package EASYEAT
 * @since EASYEAT 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$easyeat_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'easyeat' ),
	'page_builders' => esc_html__( 'Page Builders', 'easyeat' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'easyeat' ),
	'socials'       => esc_html__( 'Socials and Communities', 'easyeat' ),
	'events'        => esc_html__( 'Events and Appointments', 'easyeat' ),
	'content'       => esc_html__( 'Content', 'easyeat' ),
	'other'         => esc_html__( 'Other', 'easyeat' ),
);
$easyeat_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'easyeat' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'easyeat' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $easyeat_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'easyeat' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'easyeat' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $easyeat_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'easyeat' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'easyeat' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $easyeat_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'easyeat' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'easyeat' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $easyeat_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'easyeat' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'easyeat' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $easyeat_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'easyeat' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'easyeat' ),
		'required'    => false,
		'install'     => false, // TRX_addons has marked the "Elegro Crypto Payment" plugin as obsolete and no longer recommends it for installation, even if it had been previously recommended by the theme
		'logo'        => 'elegro-payment.png',
		'group'       => $easyeat_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'easyeat' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'easyeat' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $easyeat_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'easyeat' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'easyeat' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $easyeat_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $easyeat_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $easyeat_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $easyeat_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'easyeat' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'easyeat' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => easyeat_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $easyeat_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'logo'        => easyeat_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => easyeat_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => easyeat_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $easyeat_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => easyeat_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $easyeat_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => easyeat_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'easyeat' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'easyeat' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'easyeat' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $easyeat_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'easyeat' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'easyeat' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $easyeat_theme_required_plugins_groups['other'],
	),
	'gdpr-framework'         => array(
		'title'       => esc_html__( 'The GDPR Framework', 'easyeat' ),
		'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'easyeat' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'gdpr-framework.png',
		'group'       => $easyeat_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'easyeat' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'easyeat' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $easyeat_theme_required_plugins_groups['other'],
	),
);

if ( EASYEAT_THEME_FREE ) {
	unset( $easyeat_theme_required_plugins['js_composer'] );
	unset( $easyeat_theme_required_plugins['booked'] );
	unset( $easyeat_theme_required_plugins['quickcal'] );
	unset( $easyeat_theme_required_plugins['the-events-calendar'] );
	unset( $easyeat_theme_required_plugins['calculated-fields-form'] );
	unset( $easyeat_theme_required_plugins['essential-grid'] );
	unset( $easyeat_theme_required_plugins['revslider'] );
	unset( $easyeat_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $easyeat_theme_required_plugins['trx_updater'] );
	unset( $easyeat_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
easyeat_storage_set( 'required_plugins', $easyeat_theme_required_plugins );
