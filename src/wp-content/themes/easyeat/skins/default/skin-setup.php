<?php
/**
 * Skin Setup
 *
 * @package EASYEAT
 * @since EASYEAT 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'easyeat_theme_defaults' ) ) {
	function easyeat_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'easyeat_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'easyeat_filter_load_woocommerce_extensions', 'easyeat_skin_woocommerce_allow_extensions' );
	function easyeat_skin_woocommerce_allow_extensions( $allow ) {
		return false;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'easyeat_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'easyeat_skin_setup', 1 );
	function easyeat_skin_setup() {

		$GLOBALS['EASYEAT_STORAGE'] = array_merge( $GLOBALS['EASYEAT_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-ancora',

			'theme_doc_url'       => '//easyeat.ancorathemes.com/doc',

			'theme_demofiles_url' => '//demofiles.ancorathemes.com/easyeat/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Ancora

			'theme_privacy_url'   => '//ancorathemes.com/privacy-policy/',                   // Ancora

			'portfolio_url'       => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'easyeat_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'easyeat_skin_setup_settings', 1 );
	function easyeat_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		easyeat_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		easyeat_storage_set_array2( 'required_plugins', 'woocommerce', 'install', true);
        easyeat_storage_set_array2( 'required_plugins', 'ti-woocommerce-wishlist', 'install', true);
        easyeat_storage_set_array2( 'required_plugins', 'elegro-payment', 'install', true);
	}
}

// Add/remove/change Theme Options
if ( ! function_exists( 'easyeat_skin_setup_options' ) ) {
    add_action( 'after_setup_theme', 'easyeat_skin_setup_options', 3 );
    function easyeat_skin_setup_options()  {
        easyeat_storage_set_array2( 'options', 'footer_scheme', 'std', 'dark' );
    }
}


// Enqueue extra styles for frontend
if ( ! function_exists( 'easyeat_trx_addons_extra_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'easyeat_trx_addons_extra_styles', 2060 );
    function easyeat_trx_addons_extra_styles() {
        $easyeat_url = easyeat_get_file_url( 'extra-styles.css' );
        if ( '' != $easyeat_url ) {
            wp_enqueue_style( 'easyeat-trx-addons-extra-styles', $easyeat_url, array(), null );
        }
    }
}

// Custom styles
$easyeat_skin_path = easyeat_get_file_dir( easyeat_skins_get_current_skin_dir() . 'extra-styles.php' );
if ( ! empty( $easyeat_skin_path ) ) {
    require_once $easyeat_skin_path;
}

// Add new output types (layouts) in the shortcodes
if ( ! function_exists( 'easyeat_skin_setup_trx_addons_sc_type' ) ) {
    add_filter('trx_addons_sc_type', 'easyeat_skin_setup_trx_addons_sc_type', 11, 2);
    function easyeat_skin_setup_trx_addons_sc_type($list, $sc) {
        if ('trx_sc_layouts_menu' == $sc ) {
            $list['modern'] = 'Modern Burger';
        }
        return $list;
    }
}


//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'easyeat_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'easyeat_skin_setup_fonts', 1 );
	function easyeat_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		easyeat_storage_set(
			'load_fonts', array(
				array(
                    'name'   => 'Roboto',
                    'family' => 'sans-serif',
                    'link'   => '',
                    'styles' => 'ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900',
                ),
				array(
                    'name'   => 'Bebas Neue',
                    'family' => 'cursive',
                    'link'   => '',
                    'styles' => 'ital,wght@0,400;1,400',
                ),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		easyeat_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => easyeat_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'easyeat' );

		easyeat_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'easyeat' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.7em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.8em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'easyeat' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'easyeat' ) ),
					'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '3.353em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.14em',
					'margin-bottom'   => '0.38em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '2.765em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.75px',
					'margin-top'      => '0.84em',
					'margin-bottom'   => '0.4em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '2.059em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.5px',
					'margin-top'      => '1.18em',
					'margin-bottom'   => '0.55em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '1.647em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.55px',
					'margin-top'      => '1.45em',
					'margin-bottom'   => '0.58em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '1.412em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.208em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.58px',
					'margin-top'      => '1.57em',
					'margin-bottom'   => '0.75em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '1.118em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.35px',
					'margin-top'      => '2.4em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '1.5em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '18px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '22px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'easyeat' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'easyeat' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '13px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'easyeat' ) ),
                    'font-family'     => '"Bebas Neue",cursive',
					'font-size'       => '18px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'easyeat' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'easyeat' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'easyeat' ) ),
					'font-family'     => 'Roboto,sans-serif',
				),
			)
		);

		// Font presets
		easyeat_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'easyeat' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'easyeat' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'easyeat' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'easyeat_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'easyeat_skin_setup_schemes', 1 );
	function easyeat_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		easyeat_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'easyeat' ),
					'description' => esc_html__( 'Colors of the main content area', 'easyeat' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'easyeat' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'easyeat' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'easyeat' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'easyeat' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'easyeat' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'easyeat' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'easyeat' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'easyeat' ),
				),
			)
		);

		easyeat_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'easyeat' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'easyeat' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'easyeat' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'easyeat' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'easyeat' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'easyeat' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'easyeat' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'easyeat' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'easyeat' ),
					'description' => esc_html__( 'Color of the text inside this block', 'easyeat' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'easyeat' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'easyeat' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'easyeat' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'easyeat' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'easyeat' ),
					'description' => esc_html__( 'Color of the links inside this block', 'easyeat' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'easyeat' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'easyeat' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'easyeat' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'easyeat' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'easyeat' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'easyeat' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'easyeat' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'easyeat' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'easyeat' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'easyeat' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFB936', //ok
					'bd_color'         => '#323641', //ok

					// Text and links colors
					'text'             => '#1F242E', //ok
					'text_light'       => '#1F242E', //ok
					'text_dark'        => '#0C0F26', //ok
					'text_link'        => '#EC3D08', //ok
					'text_hover'       => '#D83707', //ok
					'text_link2'       => '#43A420', //ok 
					'text_hover2'      => '#3B8E1D', //ok 
					'text_link3'       => '#994303', //ok
					'text_hover3'      => '#823801', //ok 

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok
					'alter_bg_hover'   => '#FFB936', //ok
					'alter_bd_color'   => '#DDDDDD', //ok
					'alter_bd_hover'   => '#BBBBBB', //ok
					'alter_text'       => '#1F242E', //ok
					'alter_light'      => '#1F242E', //ok
					'alter_dark'       => '#0C0F26', //ok
					'alter_link'       => '#EC3D08', //ok
					'alter_hover'      => '#D83707', //ok
					'alter_link2'      => '#43A420', //ok
					'alter_hover2'     => '#3B8E1D', //ok
					'alter_link3'      => '#994303', //ok
					'alter_hover3'     => '#823801', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#04060B', //ok
					'extra_bg_hover'   => '#2C313D', 
					'extra_bd_color'   => '#323641', 
					'extra_bd_hover'   => '#53535C', 
					'extra_text'       => '#ADAEAE', //ok
					'extra_light'      => '#D2D3D5', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC3D08', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#43A420', 
					'extra_hover2'     => '#3B8E1D',
					'extra_link3'      => '#994303',
					'extra_hover3'     => '#823801',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#323641', //ok
					'input_bd_hover'   => '#323641', //ok
					'input_text'       => '#1F242E', //ok
					'input_light'      => '#1F242E', //ok
					'input_dark'       => '#0C0F26', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#0C0F26', //ok
					'inverse_light'    => '#1F242E', 
					'inverse_dark'     => '#0C0F26', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#0D1017', //ok
					'bd_color'         => '#2D2F35', //ok

					// Text and links colors
					'text'             => '#BDBDBD', //ok
					'text_light'       => '#AEAEAE', //ok
					'text_dark'        => '#FFFFFF', //ok
					'text_link'        => '#EC3D08', //ok
					'text_hover'       => '#D83707', //ok
					'text_link2'       => '#FFB936', //ok
					'text_hover2'      => '#DDA232', //ok
					'text_link3'       => '#43A420', //ok
					'text_hover3'      => '#3B8E1D', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#171A21', //ok
					'alter_bg_hover'   => '#252931', //ok
					'alter_bd_color'   => '#2D2F35', //ok
					'alter_bd_hover'   => '#3C3F47', //ok
					'alter_text'       => '#BDBDBD', //ok
					'alter_light'      => '#AEAEAE', //ok
					'alter_dark'       => '#FFFFFF', //ok
					'alter_link'       => '#EC3D08', //ok
					'alter_hover'      => '#D83707', //ok
					'alter_link2'      => '#FFB936', //ok
					'alter_hover2'     => '#DDA232', //ok
					'alter_link3'      => '#43A420', //ok
					'alter_hover3'     => '#3B8E1D', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#04060B', //ok
					'extra_bg_hover'   => '#2C313D', 
					'extra_bd_color'   => '#323641', 
					'extra_bd_hover'   => '#53535C', 
					'extra_text'       => '#ADAEAE', //ok
					'extra_light'      => '#D2D3D5', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC3D08', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#43A420',
					'extra_hover2'     => '#3B8E1D',
					'extra_link3'      => '#994303',
					'extra_hover3'     => '#823801',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent',
					'input_bg_hover'   => '#transparent',
					'input_bd_color'   => '#2D2F35', //ok
					'input_bd_hover'   => '#3C3F47', //ok
					'input_text'       => '#BDBDBD', //ok
					'input_light'      => '#AEAEAE', //ok
					'input_dark'       => '#FFFFFF', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#0C0F26', //ok
					'inverse_light'    => '#1F242E', 
					'inverse_dark'     => '#0C0F26', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#0C0F26', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok
					'bd_color'         => '#DDDDDD', //ok

					// Text and links colors
					'text'             => '#797C7F', //ok
					'text_light'       => '#A5A6AA', //ok
					'text_dark'        => '#0C0F26', //ok
					'text_link'        => '#EC3D08', //ok
					'text_hover'       => '#D83707', //ok
					'text_link2'       => '#FFB936', //ok
					'text_hover2'      => '#DDA232', //ok
					'text_link3'       => '#43A420', //ok
					'text_hover3'      => '#3B8E1D', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F4F4F4', //ok
					'alter_bg_hover'   => '#DFDEDE', //ok
					'alter_bd_color'   => '#DDDDDD', //ok
					'alter_bd_hover'   => '#C8C8C8', //ok
					'alter_text'       => '#797C7F', //ok
					'alter_light'      => '#A5A6AA', //ok
					'alter_dark'       => '#0C0F26', //ok
					'alter_link'       => '#EC3D08', //ok
					'alter_hover'      => '#D83707', //ok
					'alter_link2'      => '#FFB936', //ok
					'alter_hover2'     => '#DDA232', //ok
					'alter_link3'      => '#43A420', //ok
					'alter_hover3'     => '#3B8E1D', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#04060B', //ok
					'extra_bg_hover'   => '#2C313D', 
					'extra_bd_color'   => '#323641', 
					'extra_bd_hover'   => '#53535C', 
					'extra_text'       => '#ADAEAE', //ok
					'extra_light'      => '#D2D3D5', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC3D08', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#FFB936',
					'extra_hover2'     => '#DDA232',
					'extra_link3'      => '#43A420',
					'extra_hover3'     => '#3B8E1D',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#DDDDDD', //ok
					'input_bd_hover'   => '#C8C8C8', //ok
					'input_text'       => '#797C7F', //ok
					'input_light'      => '#A5A6AA', //ok
					'input_dark'       => '#0C0F26', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#0C0F26', //ok
					'inverse_light'    => '#1F242E', 
					'inverse_dark'     => '#0C0F26', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'coffee_default'
			'coffee_default' => array(
				'title'    => esc_html__( 'Coffee Default', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F8F6F2', //ok
					'bd_color'         => '#DEDBD4', //ok

					// Text and links colors
					'text'             => '#72716E', //ok
					'text_light'       => '#918D88', //ok
					'text_dark'        => '#1A1A1C', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D34E08', //ok
					'text_link2'       => '#C58044', //ok
					'text_hover2'      => '#B46B2C', //ok
					'text_link3'       => '#ECC008', //ok
					'text_hover3'      => '#D3AB03', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok
					'alter_bg_hover'   => '#EDEAE4', //ok
					'alter_bd_color'   => '#DEDBD4', //ok
					'alter_bd_hover'   => '#CECBC5', //ok
					'alter_text'       => '#72716E', //ok
					'alter_light'      => '#918D88', //ok
					'alter_dark'       => '#1A1A1C', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D34E08', //ok
					'alter_link2'      => '#C58044', //ok
					'alter_hover2'     => '#B46B2C', //ok
					'alter_link3'      => '#ECC008', //ok
					'alter_hover3'     => '#D3AB03', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B0A', //ok
					'extra_bg_hover'   => '#1C1C1C', 
					'extra_bd_color'   => '#242320', 
					'extra_bd_hover'   => '#ADABA7', 
					'extra_text'       => '#9D9D9D', //ok
					'extra_light'      => '#B4B2AD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#C58044',
					'extra_hover2'     => '#B46B2C',
					'extra_link3'      => '#ECC008',
					'extra_hover3'     => '#D3AB03',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#DEDBD4', //ok
					'input_bd_hover'   => '#CECBC5', //ok
					'input_text'       => '#72716E', //ok
					'input_light'      => '#918D88', //ok
					'input_dark'       => '#1A1A1C', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1A1A1C', //ok
					'inverse_light'    => '#B4B2AD', 
					'inverse_dark'     => '#1A1A1C', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'coffee_dark'
			'coffee_dark'    => array(
				'title'    => esc_html__( 'Coffee Dark', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#0F0F0F', //ok
					'bd_color'         => '#333333', //ok

					// Text and links colors
					'text'             => '#716F6B', //ok
					'text_light'       => '#B4B2AD', //ok
					'text_dark'        => '#F7F4F2', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D34E08', //ok
					'text_link2'       => '#C58044', //ok
					'text_hover2'      => '#B46B2C', //ok
					'text_link3'       => '#ECC008', //ok
					'text_hover3'      => '#D3AB03', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#141414', //ok
					'alter_bg_hover'   => '#1C1C1C', //ok
					'alter_bd_color'   => '#333333', //ok
					'alter_bd_hover'   => '#404040', //ok
					'alter_text'       => '#716F6B', //ok
					'alter_light'      => '#B4B2AD', //ok
					'alter_dark'       => '#F7F4F2', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D34E08', //ok
					'alter_link2'      => '#C58044', //ok
					'alter_hover2'     => '#B46B2C', //ok
					'alter_link3'      => '#ECC008', //ok
					'alter_hover3'     => '#D3AB03', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B0A', //ok
					'extra_bg_hover'   => '#1C1C1C', 
					'extra_bd_color'   => '#242320', 
					'extra_bd_hover'   => '#ADABA7', 
					'extra_text'       => '#9D9D9D', //ok
					'extra_light'      => '#B4B2AD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#C58044',
					'extra_hover2'     => '#B46B2C',
					'extra_link3'      => '#ECC008',
					'extra_hover3'     => '#D3AB03',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#333333', //ok
					'input_bd_hover'   => '#404040', //ok
					'input_text'       => '#716F6B', //ok
					'input_light'      => '#B4B2AD', //ok
					'input_dark'       => '#FFFFFF', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#1A1A1C', //ok
					'inverse_light'    => '#B4B2AD',
					'inverse_dark'     => '#1A1A1C', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#1A1A1C', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'coffee_light'
			'coffee_light' => array(
				'title'    => esc_html__( 'Coffee Light', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok
					'bd_color'         => '#DEDBD4', //ok

					// Text and links colors
					'text'             => '#72716E', //ok
					'text_light'       => '#918D88', //ok
					'text_dark'        => '#1A1A1C', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D34E08', //ok
					'text_link2'       => '#C58044', //ok
					'text_hover2'      => '#B46B2C', //ok
					'text_link3'       => '#ECC008', //ok
					'text_hover3'      => '#D3AB03', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F8F6F2', //ok
					'alter_bg_hover'   => '#E3E0D8', //ok
					'alter_bd_color'   => '#DEDBD4', //ok
					'alter_bd_hover'   => '#CECBC5', //ok
					'alter_text'       => '#72716E', //ok
					'alter_light'      => '#918D88', //ok
					'alter_dark'       => '#1A1A1C', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D34E08', //ok
					'alter_link2'      => '#C58044', //ok
					'alter_hover2'     => '#B46B2C', //ok
					'alter_link3'      => '#ECC008', //ok
					'alter_hover3'     => '#D3AB03', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B0A', //ok
					'extra_bg_hover'   => '#1C1C1C', 
					'extra_bd_color'   => '#242320', 
					'extra_bd_hover'   => '#ADABA7', 
					'extra_text'       => '#9D9D9D', //ok
					'extra_light'      => '#B4B2AD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#C58044',
					'extra_hover2'     => '#B46B2C',
					'extra_link3'      => '#ECC008',
					'extra_hover3'     => '#D3AB03',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#DEDBD4', //ok
					'input_bd_hover'   => '#CECBC5', //ok
					'input_text'       => '#72716E', //ok
					'input_light'      => '#918D88', //ok
					'input_dark'       => '#1A1A1C', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1A1A1C', //ok
					'inverse_light'    => '#B4B2AD', 
					'inverse_dark'     => '#1A1A1C', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'thai_default'
			'thai_default' => array(
				'title'    => esc_html__( 'Thai Default', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F9F5EF', //ok
					'bd_color'         => '#D9D4D1', //ok

					// Text and links colors
					'text'             => '#7F7C79', //ok
					'text_light'       => '#979390', //ok
					'text_dark'        => '#171615', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D04A03', //ok
					'text_link2'       => '#EE8814', //ok
					'text_hover2'      => '#D2760D', //ok
					'text_link3'       => '#E8C36E', //ok
					'text_hover3'      => '#D9B76A', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok
					'alter_bg_hover'   => '#F0E9E3', //ok
					'alter_bd_color'   => '#D9D4D1', //ok
					'alter_bd_hover'   => '#C6C0BD', //ok
					'alter_text'       => '#7F7C79', //ok
					'alter_light'      => '#979390', //ok
					'alter_dark'       => '#171615', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D04A03', //ok
					'alter_link2'      => '#EE8814', //ok
					'alter_hover2'     => '#D2760D', //ok
					'alter_link3'      => '#E8C36E', //ok
					'alter_hover3'     => '#D9B76A', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B09', //ok
					'extra_bg_hover'   => '#252524', 
					'extra_bd_color'   => '#30302F', 
					'extra_bd_hover'   => '#4C4C4B', 
					'extra_text'       => '#9B9B9B', //ok
					'extra_light'      => '#CECECD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#EE8814',
					'extra_hover2'     => '#D2760D',
					'extra_link3'      => '#E8C36E',
					'extra_hover3'     => '#D9B76A',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D9D4D1', //ok
					'input_bd_hover'   => '#C6C0BD', //ok
					'input_text'       => '#7F7C79', //ok
					'input_light'      => '#979390', //ok
					'input_dark'       => '#171615', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#171615', //ok
					'inverse_light'    => '#CECECD', 
					'inverse_dark'     => '#171615', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'thai_dark'
			'thai_dark'    => array(
				'title'    => esc_html__( 'Thai Dark', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#10100F', //ok
					'bd_color'         => '#30302F', //ok

					// Text and links colors
					'text'             => '#AAA9A5', //ok
					'text_light'       => '#B5B5A6', //ok
					'text_dark'        => '#FCFAF4', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D04A03', //ok
					'text_link2'       => '#EE8814', //ok
					'text_hover2'      => '#D2760D', //ok
					'text_link3'       => '#E8C36E', //ok
					'text_hover3'      => '#D9B76A', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1A1A19', //ok
					'alter_bg_hover'   => '#252524', //ok
					'alter_bd_color'   => '#30302F', //ok
					'alter_bd_hover'   => '#4C4C4B', //ok
					'alter_text'       => '#AAA9A5', //ok
					'alter_light'      => '#B5B5A6', //ok
					'alter_dark'       => '#FCFAF4', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D04A03', //ok
					'alter_link2'      => '#EE8814', //ok
					'alter_hover2'     => '#D2760D', //ok
					'alter_link3'      => '#E8C36E', //ok
					'alter_hover3'     => '#D9B76A', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B09', //ok
					'extra_bg_hover'   => '#252524', 
					'extra_bd_color'   => '#30302F', 
					'extra_bd_hover'   => '#4C4C4B', 
					'extra_text'       => '#9B9B9B', //ok
					'extra_light'      => '#CECECD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#EE8814',
					'extra_hover2'     => '#D2760D',
					'extra_link3'      => '#E8C36E',
					'extra_hover3'     => '#D9B76A',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#30302F', //ok
					'input_bd_hover'   => '#4C4C4B', //ok
					'input_text'       => '#AAA9A5', //ok
					'input_light'      => '#B5B5A6', //ok
					'input_dark'       => '#FFFFFF', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#171615', //ok
					'inverse_light'    => '#CECECD', 
					'inverse_dark'     => '#171615', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#171615', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),


			// Color scheme: 'thai_light'
			'thai_light' => array(
				'title'    => esc_html__( 'Thai Light', 'easyeat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok
					'bd_color'         => '#D9D4D1', //ok

					// Text and links colors
					'text'             => '#7F7C79', //ok
					'text_light'       => '#979390', //ok
					'text_dark'        => '#171615', //ok
					'text_link'        => '#EC5708', //ok
					'text_hover'       => '#D04A03', //ok
					'text_link2'       => '#EE8814', //ok
					'text_hover2'      => '#D2760D', //ok
					'text_link3'       => '#E8C36E', //ok
					'text_hover3'      => '#D9B76A', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F5EF', //ok
					'alter_bg_hover'   => '#E3DBD4', //ok
					'alter_bd_color'   => '#D9D4D1', //ok
					'alter_bd_hover'   => '#C6C0BD', //ok
					'alter_text'       => '#7F7C79', //ok
					'alter_light'      => '#979390', //ok
					'alter_dark'       => '#171615', //ok
					'alter_link'       => '#EC5708', //ok
					'alter_hover'      => '#D04A03', //ok
					'alter_link2'      => '#EE8814', //ok
					'alter_hover2'     => '#D2760D', //ok
					'alter_link3'      => '#E8C36E', //ok
					'alter_hover3'     => '#D9B76A', //ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0D0B09', //ok
					'extra_bg_hover'   => '#252524', 
					'extra_bd_color'   => '#30302F', 
					'extra_bd_hover'   => '#4C4C4B', 
					'extra_text'       => '#9B9B9B', //ok
					'extra_light'      => '#CECECD', 
					'extra_dark'       => '#FFFFFF', //ok
					'extra_link'       => '#EC5708', //ok
					'extra_hover'      => '#FFFFFF', //ok
					'extra_link2'      => '#EE8814',
					'extra_hover2'     => '#D2760D',
					'extra_link3'      => '#E8C36E',
					'extra_hover3'     => '#D9B76A',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D9D4D1', //ok
					'input_bd_hover'   => '#C6C0BD', //ok
					'input_text'       => '#7F7C79', //ok
					'input_light'      => '#979390', //ok
					'input_dark'       => '#171615', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#171615', //ok
					'inverse_light'    => '#CECECD', 
					'inverse_dark'     => '#171615', //ok
					'inverse_link'     => '#FFFFFF', //ok
					'inverse_hover'    => '#FFFFFF', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		easyeat_storage_set( 'schemes', $schemes );
		easyeat_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> easyeat_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'easyeat' ),
		//---> 	'description' => __( 'Description of the new color 1', 'easyeat' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		easyeat_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_05'      => array(
					'color' => 'text_link',
					'alpha' => 0.5,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		easyeat_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		easyeat_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		easyeat_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'easyeat' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'easyeat' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}

// Activation methods
if ( ! function_exists( 'easyeat_clone_activation_methods' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'easyeat_clone_activation_methods', 11, 1 );
    function easyeat_clone_activation_methods( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}

